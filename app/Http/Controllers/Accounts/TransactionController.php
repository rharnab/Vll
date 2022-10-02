<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
      
    
         $accounts= DB::table('gl_accounts as gl')
                    ->leftJoin('contra_mapping as  cm', 'gl.acc_no', '=', 'cm.acc_no')
                    ->select('gl.acc_name', 'gl.acc_no as gl_account_no')
                    ->where('cm.status', 1)
                    ->orderBy('gl.acc_no', 'asc')->get();

        $users = DB::table('users')->select(['id', 'name'])->where('role_id', '!=', 6)->get();
    
        $data = [
            'accounts' => $accounts,
            'users' => $users
        ];
        return view('accounts.transaction.create', $data);
    }


    public function store(Request $request)
    {
        die("no");
       return json_encode($request->all());
        
         $account_number = $request->account_name;
         $tran_type      = $request->tran_type;
         $amount         = $request->amount;
         $user           = $request->user;
         $remarks        = $request->remarks;
         $payment_type   = $request->payment_type;
         $entry_date     = date('Y-m-d h:i:s', strtotime($request->entry_date));

         if($payment_type ==2)
         {
            $chq_number = $request->chq_number;
         }else{
             $chq_number = '';
         }

           $last_row = DB::table('transaction')->select('id')->orderBy('id', 'desc')->first();
        
           if(empty($last_row))
           {
               $last_id = 1;
           }else{
                $last_id = $last_row->id + 1;
           }
           
        //    $batch_no = "VLL".$last_id;
        //    $dr_tracer_no = "VLL-Dr-".date('Ymdhis').$last_id;
        //    $cr_tracer_no = "VLL-Cr-".date('Ymdhis').$last_id;

         $sql = " SELECT gl.acc_name, gl.dr_cr_permission,
                cm.*
                FROM   `contra_mapping` cm
                        INNER JOIN gl_accounts  gl
                                ON cm.acc_no = gl.acc_no 
                where gl.acc_no='$account_number'";

        $result = DB::select($sql);
        if(count($result) > 0 )
        {
            $account_result = $result[0];

           

            if($tran_type == 1)
            {
               
                /*-----------------trntp deposit-----------------------*/
                $dr_result = response()->json($this->DebitPermission($account_result->acc_no));
                $cr_resule = response()->json($this->CreditPermission($account_result->contra_acc_no));
                $dr_result->getData()->is_error; 
                $cr_resule->getData()->is_error;
                 
                /* -----------------------balance check ------------------------*/
                // $balance_info_data =  $this->balanceCheck($account_result->acc_no, $amount);
                // if($balance_info_data['is_error'] =='Y')
                // {
                //     return response()->json($balance_info_data);
                // }
                /* -----------------------balance check ------------------------*/

                if(($dr_result->getData()->is_error == 'N') && ($cr_resule->getData()->is_error =='N'))
                {
   
                   try{

                        /*-------------------track code----------------*/
                        $batch_no     = substr($account_result->acc_no, 0, 3).substr($account_result->contra_acc_no, 0, 3).$last_id;  // first 3 debit last 3 for credit
                        $dr_tracer_no = substr($account_result->acc_no, 0, 3).date('Ymdhis').$last_id;
                        $cr_tracer_no = substr($account_result->contra_acc_no, 0, 3).date('Ymdhis').$last_id;
                          /*-----------------end track code----------------*/

                          /*-----------------------------------------------------debit data insert----------------------*/
                          $trn_dr = DB::table('transaction')->insert([
                            'transaction_date' => $entry_date,
                            'batch_no'         => $batch_no,
                            'tracer_no'        => $dr_tracer_no,
                            'acc_no'           => $account_result->acc_no,
                            'user'             => $user,
                            'amount'           => $amount,
                            'status'           => 0,
                            'remarks'          => $remarks,
                            'created_at'       => date('Y-m-d h:i:s'),
                            'created_by'       => Auth::user()->id,
                            'trnTp'            => 1,
                            'instrument_no'    => $chq_number,
                            'process_type'     => $tran_type,
                            

                        ]);
                        /*-----------------------------------------------------debit data insert----------------------*/
                        /*-----------------------------------------------------credit data insert----------------------*/

                            $trn_cr = DB::table('transaction')->insert([
                            'transaction_date' => $entry_date,
                            'batch_no'         => $batch_no,
                            'tracer_no'        => $cr_tracer_no,
                            'acc_no'           => $account_result->contra_acc_no,
                            'user'             => $user,
                            'amount'           => $amount,
                            'status'           => 0,
                            'remarks'          => $remarks,
                            'created_at'       => date('Y-m-d h:i:s'),
                            'created_by'       => Auth::user()->id,
                            'trnTp'            => 2,
                            'instrument_no'    => $chq_number,
                            'process_type'     => $tran_type,

                        ]);
                        /*-----------------------------------------------------credit data insert----------------------*/


                        $data = [
                            "status"   => 200,
                            "is_error" => 'N',
                            "message"  => 'Transaction Create successfull'
            
                        ];
                        return response()->json($data);
                            

                       }catch(Exception $e)
                       {
                       
                           $data = [
                                   "status"=>400,
                                   "is_error" =>'Y',
                                   "message" =>'Sorry Transaction not create'
                   
                               ];
                               return response()->json($data);
                       }
   
   
                   }else{
   
                       $data = [
                           "status"=>400,
                           "is_error" =>'Y',
                           "message" =>'Sorry Dr/Cr. Permission not allowed'
           
                       ];
                       return response()->json($data);
                    }

            }else if($tran_type == 2){
                /*---------------------------trntp withdraw-----------------*/
                $dr_result = response()->json($this->DebitPermission($account_result->contra_acc_no));
                $cr_resule = response()->json($this->CreditPermission($account_result->acc_no));
                 $dr_result->getData()->is_error;
                 $cr_resule->getData()->is_error; 


                  /* -----------------------balance check ------------------------*/
                  $balance_info_data =  $this->balanceCheck($account_result->contra_acc_no, $amount);
                  if($balance_info_data['is_error'] =='Y')
                  {
                      return response()->json($balance_info_data);
                  }
                  /* -----------------------balance check ------------------------*/

                 
                if(($dr_result->getData()->is_error == 'N') && ($cr_resule->getData()->is_error =='N'))
                {
   
                   try{


                         /*-------------------track code----------------*/

                         $batch_no = substr($account_result->contra_acc_no, 0, 3).substr($account_result->acc_no, 0, 3).$last_id; // first 3 debit last 3 for credit
                         $dr_tracer_no = substr($account_result->contra_acc_no, 0, 3).date('Ymdhis').$last_id;
                         $cr_tracer_no = substr($account_result->acc_no, 0, 3).date('Ymdhis').$last_id;
 
                           /*-----------------end track code----------------*/
                            /*-----------------------------------------------------debit data insert----------------------*/
                            DB::table('transaction')->insert([
                                'transaction_date' => $entry_date,
                                'batch_no'         => $batch_no,
                                'tracer_no'        => $dr_tracer_no,
                                'acc_no'           => $account_result->contra_acc_no,
                                'user'             => $user,
                                'amount'           => $amount,
                                'status'           => 0,
                                'remarks'          => $remarks,
                                'created_at'       => date('Y-m-d h:i:s'),
                                'created_by'       => Auth::user()->id,
                                'trnTp'            => 1,
                                'instrument_no'    => $chq_number,
                                'process_type'     => $tran_type,
    
                            ]);
                            /*-----------------------------------------------------debit data insert----------------------*/
                            /*-----------------------------------------------------credit data insert----------------------*/
    
                            DB::table('transaction')->insert([
                                'transaction_date' => $entry_date,
                                'batch_no'         => $batch_no,
                                'tracer_no'        => $cr_tracer_no,
                                'acc_no'           => $account_result->acc_no,
                                'user'             => $user,
                                'amount'           => $amount,
                                'status'           => 0,
                                'remarks'          => $remarks,
                                'created_at'       => date('Y-m-d h:i:s'),
                                'created_by'       => Auth::user()->id,
                                'trnTp'            => 2,
                                'instrument_no'    => $chq_number,
                                'process_type'     => $tran_type,
    
                            ]);
    
                            /*-----------------------------------------------------credit data insert----------------------*/
                            $data = [
                                "status"=>200,
                                "is_error" =>'N',
                                "message" =>'Transaction Create successfull'
                
                            ];
                            return response()->json($data);

                       }catch(Exception $e)
                       {
                       
                           $data = [
                                   "status"=>400,
                                   "is_error" =>'Y',
                                   "message" =>'Sorry Transaction not create'
                   
                               ];
                               return response()->json($data);
                       }
   
   
                   }else{
   
                       $data = [
                           "status"=>400,
                           "is_error" =>'Y',
                           "message" =>'Sorry Dr/Cr. Permission not allowed'
           
                       ];
                       return response()->json($data);
                    }


            }else{


            }
                

        }else{
            $data = [
                "status"=>400,
                "is_error" =>'Y',
                "message" =>'Data not found'

            ];
            
            return response()->json($data);
        }

        
    }


    /*----------------debit permission --------------------*/
    public function DebitPermission($account_no)
    {
        $result  = DB::select("select dr_cr_permission from gl_accounts where acc_no = '$account_no' and (dr_cr_permission =0 or dr_cr_permission=2)");
        
        if(!empty($result))
        {
            $data = [
                'status' =>200,
                'is_error' =>'N',
                'message' =>'Dr. allow'
            ];
           
            return $data;
            
        }else{

            $data = [
                'status' =>400,
                'is_error' =>'Y',
                'message' =>'Sorry Permission not allowed'
            ];

            return $data;

        }
    }

     /*------------------ credit permission --------------------*/
    public function CreditPermission($account_no)
    {
        $result  = DB::select("select dr_cr_permission from gl_accounts where acc_no = '$account_no' and (dr_cr_permission =1 or dr_cr_permission=2)");
        
        if(!empty($result))
        {
            $data = [
                'status' =>200,
                'is_error' =>'N',
                'message' =>'CR. allow'
            ];
           
            return $data;
            
        }else{

            $data = [
                'status' =>400,
                'is_error' =>'Y',
                'message' =>'Sorry Permission not allowed'
            ];

            return $data;

        }
    }



    public function balanceCheck($account_no, $amount)
    {
       $balance_info  =  DB::table('gl_accounts')->select('balance', 'acc_no')->where('acc_no', $account_no)->first();

       if(!empty($balance_info))
       {
            if(($balance_info->balance > 0) && ($balance_info->balance >= $amount) )
            {
                $data = [
                    'status' => 200,
                    'is_error' =>'N',
                    'balance' =>$balance_info->balance,
                ];

                return $data;

            }else if($balance_info->balance >= 0) {
                $data = [
                    'status' => 400,
                    'is_error' =>'Y',
                    'message' => 'Sorry ! Insufficient balance ',
                ];
                return $data;
            }else{

                $data = [
                    'status' => 400,
                    'is_error' =>'Y',
                    'message' => 'Sorry blance not match',
                ];
                return $data;

            }

       }else{
            $data = [
                'status' => 400,
                'is_error' =>'Y',
                'message' => 'data not found',
            ];
            return $data;
       }
   
    }


    public function balanceUpdate($debit_account, $credit_account, $amount)
    {
        
        /*------------------------------- debit gl account ----------------------*/
        $debit_gl_balance  = DB::table('gl_accounts')->select('balance', 'acc_no')->where('acc_no', $debit_account)->first();
        
        if(!empty($debit_gl_balance))
        {
            $debit_update_balance  = $debit_gl_balance->balance - $amount; 
            
        }else{

            $data = [
                'status' => 400,
                'is_error' =>'Y',
                'message' => 'data not found',
            ];
            return $data;

        }
    

        /*------------------------------- debit gl account ----------------------*/

        /*------------------------------- Credit gl account ----------------------*/
        $credit_gl_balance  = DB::table('gl_accounts')->select('balance', 'acc_no')->where('acc_no', $credit_account)->first();

        if(!empty($credit_gl_balance))
        {
            $credit_update_balance  = $credit_gl_balance->balance + $amount;
        
        }else{

            $data = [
                'status' => 400,
                'is_error' =>'Y',
                'message' => 'data not found',
            ];
            return $data;

        }

       

        /*------------------------------- Credit gl account ----------------------*/

       
        if(isset($debit_update_balance) && isset($credit_update_balance) )
        {
            $data = [
                'status' => 200,
                'is_error' =>'N',
                'debit_update_balance' => $debit_update_balance,
                'credit_update_balance' => $credit_update_balance,
            ];

           return $data;

       
               
        }
              
       
       


    }



    public function transaction_auth()
    {
        $sql = "SELECT ga.acc_name                 AS dr_ac,
        tr.trntp                    AS dr_tp,
        ga.acc_no                   AS dr_acc,
        tr.batch_no,
        tr.amount                   AS dr_amount,
        tr.transaction_date         AS dr_trn_date,
        tr.status                   AS dr_status,
        tr.remarks,
        us.name,
        (SELECT Concat(t.acc_no, '-', g.acc_name)
         FROM   transaction t
                LEFT JOIN gl_accounts g
                       ON t.acc_no = g.acc_no
         WHERE  t.batch_no = tr.batch_no
                AND t.trntp = 'cr') AS cr_transaction_info
        FROM   `transaction` tr
                LEFT JOIN gl_accounts ga
                    ON tr.acc_no = ga.acc_no
                LEFT JOIN users us
                    ON tr.user = us.id
        WHERE   tr.status = 0 AND tr.trntp ='dr' order by tr.id desc";

        $data = DB::select($sql);
       
        return view('accounts.transaction.index', compact('data'));
    }

    public function auth_process(Request $request)
    {
        $batch_no = $request->batch_no;
        $authorize_by = Auth::user()->id; 
        $authorized_at = date('Y-m-d h:i:s');

      
        if(!empty($batch_no))
        {
            
            foreach($batch_no as $single_batch_no)
            {
                if($single_batch_no !='on')
                {
                    
                   
                    /* ---------find out transaction info for debit account--------------------  */
                    $single_dr_tran_info = DB::table('transaction')->select(['acc_no', 'amount', 'process_type'])->where('batch_no', $single_batch_no)->where('status', 0)->where('trnTp', 1)->first();
                    $dr_acc_no = $single_dr_tran_info->acc_no;
                    $dr_amount = $single_dr_tran_info->amount;
                    $dr_process_type = $single_dr_tran_info->process_type;
                     /* --------- end transaction info for debit account--------------------  */


                    /* ---------  transaction info for credot account--------------------  */
                    $single_Cr_tran_info = DB::table('transaction')->select(['acc_no', 'amount', 'process_type'])->where('batch_no', $single_batch_no)->where('status', 0)->where('trnTp', 2)->first();
                    $cr_acc_no = $single_Cr_tran_info->acc_no;
                    $cr_process_type = $single_Cr_tran_info->process_type;
                     /* --------- end transaction info for credit account--------------------  */

                    if($dr_process_type == 1)
                    {
                        $balance_update_info = $this->balanceUpdate($dr_acc_no, $cr_acc_no, $dr_amount);
                        if($balance_update_info['is_error'] == 'N')
                        {

                            /*--------------------------- debit transaction update -------------------------*/
                             $debit_trn_update= DB::table('transaction')->where('batch_no', $single_batch_no)
                            ->where('status', 0)->where('trnTp', 1)->where('acc_no', $dr_acc_no)->update([
                                'bal_update'=> str_replace('-', '',$balance_update_info['debit_update_balance']),
                                'status' =>1,
                                'authorized_by' => $authorize_by,
                                'authorized_at' => $authorized_at,
                            ]);

                            /*---------------------debit gl_balance_update-------------*/
                            if($debit_trn_update)
                            {
                                DB::table('gl_accounts')->where('acc_no', $dr_acc_no)->update([
                                    'balance' => str_replace(',', '', $balance_update_info['debit_update_balance']),
    
                                ]);
                            }else{

                                $data = [
                                    "status"=>400,
                                    "is_error" =>'Y',
                                    "message" =>'Debit Transaction  balance not update '
                    
                                ];

                                return response()->json($data);

                            }
                            


                             /*--------------------------- Credit transaction update -------------------------*/
                             $credit_trn_update = DB::table('transaction')->where('batch_no', $single_batch_no)
                             ->where('status', 0)->where('trnTp', 2)->where('acc_no', $cr_acc_no)->update([
                                 'bal_update'=> str_replace('-', '',$balance_update_info['credit_update_balance']),
                                 'status' =>1,
                                 'authorized_by' => $authorize_by,
                                 'authorized_at' => $authorized_at,
                             ]);


                             /*---------------------credit gl_balance_update-------------*/
                             if($credit_trn_update)
                             {
                                DB::table('gl_accounts')->where('acc_no', $cr_acc_no)->update([
                                    'balance' => str_replace(',', '', $balance_update_info['credit_update_balance']),
                                ]);
                             }else{

                                $data = [
                                    "status"=>400,
                                    "is_error" =>'Y',
                                    "message" =>'Credit Transaction  balance not update '
                    
                                ];

                                return response()->json($data);

                            }
            
                            // $data = [
                            //     "status"=>200,
                            //     "is_error" =>'N',
                            //     "message" =>'Transaction  successfully authorized'
                
                            // ];
                            // return response()->json($data);

                        }else{
                            return response()->json($balance_update_info);
                        }

                    }else if($dr_process_type == 2)
                    {
                         $balance_chk_info = $this->balanceCheck($dr_acc_no, $dr_amount);
                         if($balance_chk_info['is_error'] == 'N')
                         {
                         
                            $balance_update_info = $this->balanceUpdate($dr_acc_no, $cr_acc_no, $dr_amount);
                            if($balance_update_info['is_error'] == 'N')
                            {

                                /*--------------------------- debit transaction update -------------------------*/
                                $debit_trn_update= DB::table('transaction')->where('batch_no', $single_batch_no)
                                ->where('status', 0)->where('trnTp', 1)->where('acc_no', $dr_acc_no)->update([
                                    'bal_update'=> str_replace('-', '',$balance_update_info['debit_update_balance']),
                                    'status' =>1,
                                    'authorized_by' => $authorize_by,
                                    'authorized_at' => $authorized_at,
                                ]);

                                /*---------------------debit gl_balance_update-------------*/
                                if($debit_trn_update)
                                {
                                    DB::table('gl_accounts')->where('acc_no', $dr_acc_no)->update([
                                        'balance' => str_replace(',', '', $balance_update_info['debit_update_balance']),
        
                                    ]);
                                }else{

                                    $data = [
                                        "status"=>400,
                                        "is_error" =>'Y',
                                        "message" =>'Debit Transaction  balance not update '
                        
                                    ];

                                    return response()->json($data);

                                }
                                


                                /*--------------------------- Credit transaction update -------------------------*/
                                $credit_trn_update = DB::table('transaction')->where('batch_no', $single_batch_no)
                                ->where('status', 0)->where('trnTp', 2)->where('acc_no', $cr_acc_no)->update([
                                    'bal_update'=> str_replace('-', '',$balance_update_info['credit_update_balance']),
                                    'status' =>1,
                                    'authorized_by' => $authorize_by,
                                    'authorized_at' => $authorized_at,
                                ]);


                                /*---------------------credit gl_balance_update-------------*/
                                if($credit_trn_update)
                                {
                                    DB::table('gl_accounts')->where('acc_no', $cr_acc_no)->update([
                                        'balance' => str_replace(',', '', $balance_update_info['credit_update_balance']),
                                    ]);
                                }else{

                                    $data = [
                                        "status"=>400,
                                        "is_error" =>'Y',
                                        "message" =>'Credit Transaction  balance not update '
                        
                                    ];

                                    return response()->json($data);

                                }
 
                            }else{

                                return response()->json($balance_update_info);

                            }

                        }else{

                            return response()->json($balance_chk_info);

                        } 

                    }
                }
            }

            $data = [
                "status"=>200,
                "is_error" =>'N',
                "message" =>'Transaction  successfully authorized'

            ];
            return response()->json($data);
    
        }else{
            $data = [
                'status'   =>400,
                'is_error' =>'Y',
                'message'  =>'Sorry transaction not found'
            ];

            return response()->json($data);
        }
        
    }



    public function decline(Request $request)
    {

        $batch_no = $request->batch_no;
        $authorize_by = Auth::user()->id; 
        $authorized_at = date('Y-m-d h:i:s');

      
        if(!empty($batch_no))
        {
            
            foreach($batch_no as $single_batch_no)
            {
                if($single_batch_no !='on')
                {
                    try{

                        $declint =  DB::table('transaction')->where('batch_no', $single_batch_no)
                        ->where('status', 0)->update([
                            'status' =>5,
                            'authorized_by' => $authorize_by,
                            'authorized_at' => $authorized_at,
                        ]);

                        if($declint)
                        {
                            $data = [
                                'status'   =>200,
                                'is_error' =>'N',
                                'message'  =>'Transaction Decline Successfull'
                            ];
            
                        }else{

                            $data = [
                                'status'   =>400,
                                'is_error' =>'Y',
                                'message'  =>'Sorry Transaction Decline fail'
                            ];

                            //return response()->json($data);
                        } 
                        
                    }catch (Exception $e){

                        $data = [
                            'status'   =>400,
                            'is_error' =>'Y',
                            'message'  =>'Sorry Transaction Decline fail'
                        ];

                        //return response()->json($data);  
                    }
                      

                }
                
                
            }

            return response()->json($data);
        }

    }




}
