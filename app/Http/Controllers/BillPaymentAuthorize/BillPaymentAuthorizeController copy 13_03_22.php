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

                "status"=>1,
                'auth_dateTime' => date('Y-m-d H:i:s'),
                'auth_user_id' => Auth::user()->id
            ]);

             DB::table('rack_products')->where('shocks_bill_no', "$shocks_bill_no")->update([

                "status"=>7,
                'auth_dateTime' => date('Y-m-d H:i:s'),
                'auth_user_id' => Auth::user()->id

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
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code' and mrb.bill_no='$shocks_bill_no')  "));


        $get_single_commission_data = DB::select(DB::raw("SELECT Count(*)                       AS total_month,
                                            c.id,
                                            au.name                        AS agent_name,
                                            sh.name                        AS shop_name,
                                            c.shoks_bill_no,
                                            c.billing_year_month,
                                            c.rack_code,
                                            c.entry_user_id,
                                            Sum(c.agent_commission_amount) AS agent_commission_amount,
                                            Sum(c.shop_commission_amount) AS shop_commission_amount,
                                            SUM(c.total_amount) as total_bill
                                    FROM   `commissions` c
                                            LEFT JOIN agent_users au
                                                ON c.agent_id = au.id
                                            LEFT JOIN shops sh
                                                ON c.shop_id = sh.id
                                    WHERE  c.`shoks_bill_no` = '$shocks_bill_no'
                                            AND c.billing_year_month NOT IN (SELECT mrb.year_and_month
                                                                            FROM   monthly_rack_conveynce_bill mrb
                                                                            WHERE  mrb.rack_id = '$rack_code'
                                                                                    AND mrb.bill_no =
                                                                                        '$shocks_bill_no') "))[0];

        $entry_user_id = $get_single_commission_data->entry_user_id;
        $get_user_data  = DB::table('users')->where('id', $entry_user_id)->first();

        $single_array=[];
        foreach($get_commission_data as $single_commission_data){
             $single_commission_data->billing_year_month;
            array_push($single_array, $single_commission_data->billing_year_month);

        }


     $billing_month = implode(" -- ", $single_array);

     $conveynce_bill_parameter = DB::table('convence_bill_parameter')->first();
    
     $agent_user = DB::table('users')->whereIn('role_id', [2,8])->get();
    
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
                $get_agent_commission = 0;
            }
            

            $final_amt = $enter_amt/$total_month;

            foreach($conveynce_month_exp as $single_year_month){

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


            } // end foreach 

            try{

                $update = DB::table('shock_bills')->where('shocks_bill_no', "$bill_no")->update([

                    "status"=>1,
                    'auth_dateTime' => date('Y-m-d H:i:s'),
                    'auth_user_id' => Auth::user()->id
                ]);
    
                 DB::table('rack_products')->where('shocks_bill_no', "$bill_no")->update([
                    "status"=>7,
                    'auth_dateTime' => date('Y-m-d H:i:s'),
                    'auth_user_id' => Auth::user()->id
                ]); //status 7=bill authorize
    
                $this->insertSocksLog($bill_no);
               // $this->billAccount($bill_no, $enter_amt, $get_agent_commission);

            }catch(Exception $e){
                $data = [
                    "is_error" => true,
                    "message"  => 'Shocks Bill Update fail'
                ];
                return response()->json($data);

            }


            

    
       
            


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
function billAccount($shocks_bill_no, $convence, $agent_commission)
{
    $retail_bill_amt  = DB::table('commissions')->where('shoks_bill_no' , $shocks_bill_no)
                        ->groupBy('shoks_bill_no')
                        ->sum(DB::raw('total_amount - shop_commission_amount'));

    $retail_acc_no= '900005'; //RETAIL SALES BILL RECEIVE
    $cash_in_hand_acc_no= '100004'; //CASH IN HAND
    $convence_acc_no = '100011'; // CONVEYANCE
    $others_acc_no = '100021'; // other account 

    #################### for retail BIll #####################
    $debit_result= $this->debitGl($retail_acc_no, $retail_bill_amt);
    if($debit_result['is_error'] == false)
    {
        $this->CreditGl($cash_in_hand_acc_no, $retail_bill_amt);
    }else{
        return response()->json($debit_result); 
    } 
    #################### for retail BIll #####################

     #################### for convence  BIll #####################
     $debit_result= $this->debitGl($cash_in_hand_acc_no, $convence);
     if($debit_result['is_error'] == false)
     {
         $this->CreditGl($convence_acc_no, $convence);
     }else{
        return response()->json($debit_result); 
    }  
     #################### for convence BIll #####################


     #################### for commission  BIll #####################
     $debit_result= $this->debitGl($cash_in_hand_acc_no, $agent_commission);
     if($debit_result['is_error'] == false)
     {
         $this->CreditGl($others_acc_no, $agent_commission);
     }else{
        return response()->json($debit_result); 
    }  
     #################### for commission BIll ##################### 
    
}

public function debitGl($account_no, $amount)
{
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

public function CreditGl($account_no, $amount)
{
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
#######################  bill athorize accounting ##################################



    

}
