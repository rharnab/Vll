<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;

class GlTransactionController extends Controller
{
    /**
    * Show All Account List With
    *
    */
    public function create(){
        $accounts = DB::table('gl_accounts')->select('acc_name', 'acc_no')->whereNotNull('acc_no')->get();
        //$accounts = DB::select(DB::raw($sql));

        // $mother_gl_sql = "SELECT ga.acc_name,ga.acc_no from (select contra_acc_no from contra_mapping group by contra_acc_no) ac 
        // left join gl_accounts ga on ac.contra_acc_no = ga.acc_no 
        // where  ga.acc_no  != ''";
        // $mother_gls = DB::select(DB::raw($mother_gl_sql));
        $users      = DB::table('users')->select(['id', 'name'])->where('role_id', '!=', 6)->get();
        $data       = [
            "accounts" => $accounts,
            "users"      => $users
        ];
        return view('gl.accounts.transaction.create', $data);
    }


    /**
    * Show All Child GL Account List from mother gl
    *
    */
    public function findMotherGl(Request $request){
        $account_no = $request->input('account_no');

        $sql = "SELECT gl1.acc_name,
                gl1.acc_no
                FROM   (SELECT gl.acc_name,
                                cm.contra_acc_no
                        FROM   gl_accounts gl
                                LEFT JOIN contra_mapping cm
                                    ON cm.acc_no = gl.acc_no
                        WHERE  cm.status = 1
                                AND cm.acc_no = '$account_no') con
                        LEFT JOIN gl_accounts gl1
                            ON gl1.acc_no = con.contra_acc_no  ";
                            
        $accounts = DB::select(DB::raw($sql));
        $data = [
            "accounts" => $accounts
        ];
        $output = view('gl.accounts.transaction.account-list', $data);
        return $output;
    }


    /**
    * Transaction Store 
    *
    */
    public function store(Request $request){
        
        $mother_gl    = $request->input('mother_gl');
        $account_no   = $request->input('account_no');
        $tran_type    = $request->input('tran_type');
        $payment_type = $request->input('payment_type');
        $chq_number   = $request->input('chq_number');
        $amount       = $request->input('amount');
        $user         = $request->input('user');
        $entry_date   = date('Y-m-d', strtotime($request->input('entry_date')));
        $remarks      = $request->input('remarks');

        $last_row = DB::table('transaction')->select('id')->orderBy('id', 'desc')->first();
        $last_id = $last_row ? $last_row->id + 1 : 1;

        ################ debit permission check ###########################
        $debit_account_no = $this->getDebitAccountNo($mother_gl, $account_no, $tran_type);
        $debit_permission= $this->DebitPermission($debit_account_no);
        if($debit_permission['status'] == 400){

            return response()->json($debit_permission); 
        }

        $balance_check = $this->balanceCheck($debit_account_no, $amount);
        file_put_contents('bl.txt', $debit_account_no.'-'.$amount);
        if($balance_check['status'] !=200)
        {
            return response()->json($balance_check);
        }
        ################ debit permission check ###########################


        #################### credut permission check ########################
        $credit_account_no = $this->getCreditAccountNo($mother_gl, $account_no, $tran_type);
        $credit_permission = $this->CreditPermission($credit_account_no);
        if($credit_permission['status'] == 400){

            return response()->json($credit_permission); 
        }
        #################### credut permission check ########################



        


       
      

        // trace code generate 
        $batch_no     = substr($debit_account_no, 0, 3).substr($credit_account_no, 0, 3).$last_id;
        $dr_tracer_no = substr($debit_account_no, 0, 3).date('Ymdhis').$last_id;
        $cr_tracer_no = substr($credit_account_no, 0, 3).date('Ymdhis').$last_id;

        try{
            // debit transaction insert 
            DB::table('transaction')->insert([
                'transaction_date' => $entry_date,
                'batch_no'         => $batch_no,
                'tracer_no'        => $dr_tracer_no,
                'acc_no'           => $debit_account_no,
                'user'             => $user,
                'amount'           => $amount,
                'status'           => 0,
                'remarks'          => $remarks,
                'created_at'       => date('Y-m-d h:i:s'),
                'created_by'       => Auth::user()->id,
                'trnTp'            => 'dr',
                'instrument_no'    => $chq_number,
                'process_type'     => $tran_type,
            ]);

            // credit transaction insert 
            DB::table('transaction')->insert([
                'transaction_date' => $entry_date,
                'batch_no'         => $batch_no,
                'tracer_no'        => $cr_tracer_no,
                'acc_no'           => $credit_account_no,
                'user'             => $user,
                'amount'           => $amount,
                'status'           => 0,
                'remarks'          => $remarks,
                'created_at'       => date('Y-m-d h:i:s'),
                'created_by'       => Auth::user()->id,
                'trnTp'            => 'cr',
                'instrument_no'    => $chq_number,
                'process_type'     => $tran_type
            ]);

            $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => 'Transaction Create Success. Please authorize now'

            ];
            return response()->json($data);


        }catch(Exception $e){
            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => $e->getMessage()

            ];
            return response()->json($data);
        }

      
  
    }

    /**
    * Return Debit A/C Number
    *
    */
    public function getDebitAccountNo($mother_gl, $account_no, $tran_type){
        if($tran_type == "dr"){
            return $account_no;
        }else{
            return $mother_gl;
        }
    }

    
    /**
    * Return Credit A/C Number
    *
    */
    private function getCreditAccountNo($mother_gl, $account_no, $tran_type){
        if($tran_type == "cr"){
            return $account_no;
        }else{
            return $mother_gl;
        }
    }


    /**
    * Show all pending authorization transaction
    *
    */
    public function pendingTransaction(){
        $user_id = Auth::user()->id;
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
        WHERE   tr.status = 0 AND tr.trntp ='dr' AND tr.created_by !='$user_id'
        order by tr.id desc";
        
        $transactions = DB::select($sql);

        $data = [
            "transactions" => $transactions
        ];       
        return view('gl.accounts.transaction.pending', $data);

    }



    /**
    * Transaction Authorize
    *
    */
    public function authorizeTransaction(Request $request){
        $batch_no      = $request->input('batch_no');
        $authorize_by  = Auth::user()->id;
        $authorized_at = date('Y-m-d h:i:s');
        foreach($batch_no as $single_batch_no){
            if(!empty($single_batch_no)){ // remove empty batch no
                $dr_transaction = DB::table('transaction')->select('acc_no', 'amount')->where('trnTp', 'dr')->where('batch_no', $single_batch_no)->first();
                $balance_check = $this->checkDebitAccountBalance($dr_transaction->acc_no, $dr_transaction->amount);
                if($balance_check['do_transaction'] === true){

                    // debit balance crop and update
                    $debit_balance_reduce = $this->debitAccountBalanceReduce($dr_transaction->acc_no, $dr_transaction->amount);
                    if($debit_balance_reduce['is_error'] === false){
                        // find out credit transaction 
                        $cr_transaction = DB::table('transaction')->select('acc_no', 'amount')->where('trnTp', 'cr')->where('batch_no', $single_batch_no)->first();

                        // increase credit account balance
                        $credit_balance_increase = $this->creditAccountBalanceIncrease($cr_transaction->acc_no, $cr_transaction->amount);
                        if($credit_balance_increase['is_error'] === false){
                            // update transaction table
                            try{
                                DB::table('transaction')->where('batch_no', $single_batch_no)->update([
                                    'status'        => 1,
                                    'authorized_by' => $authorize_by,
                                    'authorized_at' => $authorized_at,
                                ]);
                                $response = [
                                    "status"   => 200,
                                    "is_error" => false,
                                    "message"  => "Transaction authorize successfully"
                                ];
                                //return response()->json($response);
                            }catch(Exception $e){
                                $response = [
                                    "status"   => 400,
                                    "is_error" => true,
                                    "message"  => $e->getMessage()
                                ];
                                return response()->json($response); die();
                            }

                        }else{
                            $response = [
                                "status"   => 400,
                                "is_error" => true,
                                "message"  => $credit_balance_increase['message']
                            ];
                            return response()->json($response); die();
                        }

                    }else{
                        $response = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => $debit_balance_reduce['message']
                        ];
                        return response()->json($response); die();
                    }


                }else{
                    $response = [
                        "status"   => 400,
                        "is_error" => true,
                        "message"  => $balance_check['message']
                    ];
                    return response()->json($response); die();
                }
            }
        }
        
         return response()->json($response);
    }


    /**
    * Check Debit A/C Balance
    *
    */
    private function checkDebitAccountBalance($account_no, $amount){
        $data = DB::table('gl_accounts')->select('*')->where('acc_no', $account_no)->first();
        if(!empty($data)){

            if($data->asset_liability_status == 1)
            {
                return [
                    "do_transaction" => true,
                    "message"        => "Transaction available for doing transaction"
                ];
            }else if($data->gl_bal >= $amount){
                return [
                    "do_transaction" => true,
                    "message"        => "Transaction available for doing transaction"
                ];

            }else{

                return [
                    "do_transaction" => false,
                    "message"        => "Insufficient Balance in {$account_no} debit account"
                ];

            }

           
        }else{
           
            return [
                "do_transaction" => false,
                "message"        => "Insufficient Balance in {$account_no} debit account"
            ];
        }
    }


    /**
    * Debit Account Balance Reduce
    *
    */
    private function debitAccountBalanceReduce($account_no, $amount){
        $sql = "UPDATE gl_accounts  SET gl_bal = gl_bal - $amount  WHERE acc_no = '$account_no'";
        try{
            DB::update(DB::raw($sql));
            return [
                "is_error" => false,
                "message"  => "Balance reduce successfully"
            ];
        }catch(Exception $e){
            return [
                "is_error" => true,
                "message"  => $e->getMessage()
            ];
        }
    }

    

    private function creditAccountBalanceIncrease($account_no, $amount){
        $sql = "UPDATE gl_accounts  SET gl_bal = gl_bal + $amount  WHERE acc_no = '$account_no'";
        try{
            DB::update(DB::raw($sql));
            return [
                "is_error" => false,
                "message"  => "Balance increased successfully"
            ];
        }catch(Exception $e){
            return [
                "is_error" => true,
                "message"  => $e->getMessage()
            ];
        }
    }


    /**
    * Transaction Declined
    *
    */
    public function declineTransaction(Request $request){
        $batch_no      = $request->input('batch_no');
        $authorize_by  = Auth::user()->id;
        $authorized_at = date('Y-m-d h:i:s');
        foreach($batch_no as $single_batch_no){
            if(!empty($single_batch_no)){
                try{
                    DB::table('transaction')->where('batch_no', $single_batch_no)->where('status', 0)->update([
                        'status'        => 5,
                        'authorized_by' => $authorize_by,
                        'authorized_at' => $authorized_at,
                    ]);
                    $data = [
                        'status'   => 200,
                        'is_error' => false,
                        'message'  => "Transaction declined successfully"
                    ];
                    return response()->json($data);
                }catch(Exception $e){
                    $data = [
                        'status'   => 400,
                        'is_error' => true,
                        'message'  => $e->getMessage()
                    ];
                    return response()->json($data); die();
                }
            }
        }
    }








    ############################################# add validation ###################################

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
       $balance_info  =  DB::table('gl_accounts')->select('gl_bal', 'acc_no', 'asset_liability_status')->where('acc_no', $account_no)->first();

       if(!empty($balance_info))
       {
            if( ( ($balance_info->gl_bal > 0) && ($balance_info->gl_bal >= $amount) || $balance_info->asset_liability_status == 1)  )
            {
                $data = [
                    'status' => 200,
                    'is_error' =>'N',
                    'gl_bal' =>$balance_info->gl_bal,
                ];

                return $data;

            }else if($balance_info->gl_bal >= 0) {
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

    ############################################# add validation ###################################


    public function gl_balance()
    {
        
    }




}
