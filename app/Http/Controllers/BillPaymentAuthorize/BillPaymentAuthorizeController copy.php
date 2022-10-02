<?php

namespace App\Http\Controllers\BillPaymentAuthorize;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillPaymentAuthorizeController extends Controller
{
   public function index(){


        $get_data = DB::select(DB::raw("SELECT sb.id, au.name as agent_name,sh.name as shop_name,
         sb.agent_id,sb.shop_id,sb.rack_code,
        sb.shocks_bill_no,sb.billing_year_month,
         sum(sales_quantity) total_sales_quantity, SUM(collect_amount) as total_collect_amt 
         FROM `shock_bills` sb LEFT JOIN agent_users au ON sb.agent_id = au.id 
         LEFT JOIN shops sh on sb.shop_id=sh.id WHERE sb.status='0' GROUP BY sb.shocks_bill_no 
         ORDER BY date(sb.entry_datetime) desc
         "));

        
       return view('bill_authorize.index', compact('get_data'));

   } // end index function

   public function single_submit(Request $request){
        if ($request->ajax()) {

            $socks_bill_id = $request->socks_bill_id;

            $get_socks_data = DB::table('shock_bills')->where('id',$socks_bill_id)->first();
            $shocks_bill_no = $get_socks_data->shocks_bill_no;

            $update = DB::table('shock_bills')->where('shocks_bill_no', "$shocks_bill_no")->update([

                "status"=>1
            ]);

             DB::table('rack_products')->where('shocks_bill_no', "$shocks_bill_no")->update([

                "status"=>7

            ]); //status 7=bill authorize

        }else{
            echo 'This request is not ajax !';
        }
            
   } // single-submit function

   public function show_details(Request $request){

        $shocks_bill_no = $request->shocks_bill_no;

        $get_data_shocks_bill = DB::table('shock_bills')
        ->where('shocks_bill_no',$shocks_bill_no)->first();

        $rack_code = $get_data_shocks_bill->rack_code;

       $get_commission_data = DB::select(DB::raw("SELECT c.id,au.name as agent_name,
        sh.name as shop_name,
        c.billing_year_month,c.rack_code 
        FROM `commissions` c LEFT JOIN agent_users au ON c.agent_id=au.id
         LEFT JOIN shops sh on c.shop_id=sh.id WHERE c.`shoks_bill_no`='$shocks_bill_no'
          and c.billing_year_month not in (SELECT mrb.year_and_month 
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code')  "));


        $get_single_commission_data = DB::select(DB::raw("SELECT count(*) as total_month, c.id,au.name as agent_name,
        sh.name as shop_name,c.shoks_bill_no,
        c.billing_year_month,c.rack_code, c.entry_user_id, sum(c.agent_commission_amount) as agent_commission_amount 
        FROM `commissions` c LEFT JOIN agent_users au ON c.agent_id=au.id
         LEFT JOIN shops sh on c.shop_id=sh.id WHERE c.`shoks_bill_no`='$shocks_bill_no'
          and c.billing_year_month not in (SELECT mrb.year_and_month 
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code')"))[0];

        $entry_user_id = $get_single_commission_data->entry_user_id;
        $get_user_data  = DB::table('users')->where('id', $entry_user_id)->first();

        $single_array=[];
        foreach($get_commission_data as $single_commission_data){
             $single_commission_data->billing_year_month;
            array_push($single_array, $single_commission_data->billing_year_month);

        }


      $billing_month = implode(" -- ", $single_array);

     $conveynce_bill_parameter = DB::table('convence_bill_parameter')->first();
    
     $agent_user = DB::table('users')->where('role_id',2)->get();
    
       return view('bill_authorize.show_details', compact('get_data_shocks_bill','get_single_commission_data', 'billing_month','conveynce_bill_parameter','agent_user', 'get_user_data'));


   } // end show detaiuls

   public function agent_or_officer_conveynce_bill_submit(Request $request){

        if ($request->ajax()) {

            $conveynce_month = $request->conveynce_month;
            
            $conveynce_month_exp = explode("--", $conveynce_month);
           

            $bill_no = $request->bill_no;
            $shop_name = $request->shop_name;
            $rack_no = $request->rack_no;
            $bill_receive_employee_type = $request->bill_receive_employee_type;
            $select_emp = $request->select_emp;
            $enter_amt = $request->enter_amt;
            $total_month = $request->total_month;

            if($bill_receive_employee_type=="Agent"){
                $get_agent_commission = $request->get_agent_commission;
            }else{
                $get_agent_commission = "";
            }
            

            $final_amt = $enter_amt/$total_month;

            /* foreach($conveynce_month_exp as $single_year_month){

                //################ check if bill already paid ############
              

            $get_data_count = DB::table('monthly_rack_conveynce_bill')
                ->where('year_and_month','LIKE',"%$single_year_month%")
                ->where('bill_no',"$bill_no")
                ->where('rack_id',$rack_no)
                ->count();

              
                if($get_data_count > 0){
                    echo '0';die;
                }

                DB::table('monthly_rack_conveynce_bill')->insert([
                    "year_and_month"=>$single_year_month,
                    "bill_no"   => $bill_no,
                    "auth_by"   => Auth::user()->id,
                    "shop_name"   => $shop_name,
                    "rack_id"   => $rack_no,
                    "amount"   => $final_amt,
                    "auth_date"   => date('Y-m-d h:i:s a'),
                    "bill_receive_emp_type"   => $bill_receive_employee_type,
                    "bill_receive_emp_id"   => $select_emp,
                    "agent_commission"   => $get_agent_commission,
                ]);


            } // end foreach */


           /*  $update = DB::table('shock_bills')->where('shocks_bill_no', "$bill_no")->update([

                "status"=>1
            ]);

             DB::table('rack_products')->where('shocks_bill_no', "$bill_no")->update([
                "status"=>7
            ]); //status 7=bill authorize

            $this->insertSocksLog($bill_no); */

           
                $this->billAccounting($bill_no, $enter_amt, $get_agent_commission);
                
            

            


        }else{
            echo "This is not ajax request";
        }
    
   } //end agent_or_officer_conveynce_bill_submit function


   public function insertSocksLog($bill_no){
       $socks_data = DB::table('rack_products')->select('id')->where('shocks_bill_no',$bill_no)->get();
        foreach($socks_data as $socks){
            $this->socksLog($socks->id, "SOCKS_BILL_VOUCHER_AUTHORIZE");
        }
    }






 #######################  bill athorize accounting ##################################

   public  function billAccounting($shocks_bill_no, $convence_amt, $agent_commission)
    {
        $shocks_bill_no = $shocks_bill_no;
        $convence_amt = $convence_amt;
        $agent_commission = $agent_commission;
        
        ####################### credit function ###############################
        $this->creditBalance($shocks_bill_no, $convence_amt, $agent_commission);
        ####################### credit function ###############################
    }

    public function creditBalance($shocks_bill_no, $convence_amt, $agent_commission)
    {
         $sql = "SELECT c.net_amount
                FROM   (SELECT ( Sum(total_amount) - Sum(shop_commission_amount) ) AS net_amount
                                ,
                                shoks_bill_no
                        FROM   `commissions`
                        WHERE  shoks_bill_no = '$shocks_bill_no'
                        GROUP  BY shoks_bill_no) c
                        LEFT JOIN shock_bills sb
                            ON sb.shocks_bill_no = c.shoks_bill_no
                WHERE  sb.status = 0
                GROUP  BY sb.shocks_bill_no; ";

         $result  = DB::Select($sql);
         if(!empty($result))
         {
             $net_amount  = $result[0]->net_amount;

            if($net_amount > 0){
                
                 $gl_update_balance  = $net_amount -  $agent_commission;
                ################ process Credit balance ########################
                $this->UpdateGlBalance($gl_update_balance, $acc_no =900003);
                ################ process Credit balance ########################
                

                
            }else{

                $data =[
                    'status' =>400,
                    'is_error' => true,
                    'message' => "Net balance not found"
                 ];
                 return response()->json($data);

            }

           

         }else{
             $net_amount = 0;
             $data =[
                'status' =>400,
                'is_error' => true,
                'message' => "Sorry balance found ".$net_amount
             ];
             return response()->json($data);
         }

         
    }

   


    public function UpdateGlBalance($update_blance, $acc_no)
    {
        $sql = " SELECT gl.acc_name, gl.dr_cr_permission,
        cm.*
        FROM   `contra_mapping` cm
                INNER JOIN gl_accounts  gl
                        ON cm.acc_no = gl.acc_no 
        where gl.acc_no='$acc_no' and cm.status = 1";

        $result_info   = DB::select($sql);
        if(count($result_info) > 0)
        {
            $result_info = $result_info[0];
            $debit_account  = $result_info->acc_no;
            $credit_account  = $result_info->contra_acc_no;
            
            ######################### debit account ###########################
             $debitResult= $this->debitGlBalance($debit_account, $update_blance);
            ######################### debit account ###########################

            if($debitResult['is_error'] == false)
            {
                ######################### credit account ###########################
                $debitResult= $this->creditGlBalance($credit_account, $update_blance);
                 ######################### credit account ###########################
            }
            
            
        }else{

            $data =[
                'status' =>400,
                'is_error' => true,
                'message' => 'contra not found',
             ];
             return $data;

        }
    }


    //debit netamount 
    public function debitGlBalance($debit_acc_no, $amount)
    {

        $retail_balance = DB::table('gl_accounts')->select('acc_no', 'balance')->where('acc_no', $debit_acc_no)->first();

            try{

                DB::table('gl_accounts')->where('acc_no', $debit_acc_no)->update([

                    'balance' => $retail_balance->balance - $amount,
                ]);

                $data =[
                    'status' =>200,
                    'is_error' => false,
                 ];
                 return $data;

            }catch(Exception $e ){
                $data =[
                    'status' =>400,
                    'is_error' => true,
                    'message' => "GL balance Update fial"
                 ];
                 return response()->json($data);
            }


    }


    public function creditGlBalance($credit_acc, $amount)
    {

        $cahsIn_balance = DB::table('gl_accounts')->where('acc_no', $credit_acc)->first();

            try{

                DB::table('gl_accounts')->where('acc_no', $credit_acc)->update([

                    'balance' => $cahsIn_balance->balance + $amount,
                ]);

                $data =[
                    'status' =>200,
                    'is_error' => false,
                 ];
                 return $data;

            }catch(Exception $e ){
                $data =[
                    'status' =>400,
                    'is_error' => true,
                    'message' => "GL balance Update fial"
                 ];
                 return response()->json($data);
            }

    }
    
    
    
    #######################  bill athorize accounting ##################################



    

}
