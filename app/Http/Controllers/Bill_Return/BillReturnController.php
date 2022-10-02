<?php

namespace App\Http\Controllers\Bill_Return;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillReturnController extends Controller
{
    public function index(){
        
        $get_data = DB::select(DB::raw("SELECT sb.id, au.name as agent_name,sh.name as shop_name,
        sb.agent_id,sb.shop_id,sb.rack_code,
       sb.shocks_bill_no,sb.billing_year_month,
        sum(sb.sales_quantity) total_sales_quantity, SUM(sb.collect_amount) as total_collect_amt 
        FROM `shock_bills` sb LEFT JOIN agent_users au ON sb.agent_id = au.id 
        LEFT JOIN shops sh on sb.shop_id=sh.id 
        
        WHERE sb.status='0'  GROUP BY sb.shocks_bill_no 
        ORDER BY date(sb.entry_datetime) desc
         "));

        $data = [
            "get_data" => $get_data
        ];

        return view('bill_return.index', $data);
    }

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


        $get_single_commission_data = DB::select(DB::raw("SELECT count(*) as total_month, c.id,au.name as agent_name,
        sh.name as shop_name,sh.id as shop_id,c.shoks_bill_no,
        c.billing_year_month,c.rack_code, c.entry_user_id,Sum(c.agent_commission_amount) AS agent_commission_amount,
                                            Sum(c.shop_commission_amount) AS shop_commission_amount,
                                            SUM(c.total_amount) as total_bill 
        FROM `commissions` c LEFT JOIN agent_users au ON c.agent_id=au.id
         LEFT JOIN shops sh on c.shop_id=sh.id WHERE c.`shoks_bill_no`='$shocks_bill_no'
          and c.billing_year_month not in (SELECT mrb.year_and_month 
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code' and mrb.bill_no ='$shocks_bill_no' )"))[0];

        $entry_user_id = $get_single_commission_data->entry_user_id;
        $billing_year_month = $get_single_commission_data->billing_year_month;

        $get_convence= DB::table('monthly_rack_conveynce_bill as mb')
            ->select(['amount', 'is_officer'])
            ->leftJoin('rack_mapping as rm', 'rm.rack_code', '=', 'mb.rack_id')
            ->leftJoin('users as u', 'u.agent_id', '=', 'rm.agent_id')
            ->where([
            ['mb.year_and_month', '=', $billing_year_month],
            ['mb.rack_id', '=', $rack_code],
            ['u.is_officer', '=' , 0]
        ])->get(); 

        if(count($get_convence) > 0)
        {
            $is_agent_convence_pay =1;
        }else{
            $is_agent_convence_pay = 0;
        }
        
        $get_user_data  = DB::table('users')->where('id', $entry_user_id)->first();

        $single_array=[];
        foreach($get_commission_data as $single_commission_data){
             $single_commission_data->billing_year_month;
            array_push($single_array, $single_commission_data->billing_year_month);

        }


     $billing_month = implode(" -- ", $single_array);

     $conveynce_bill_parameter = DB::table('convence_bill_parameter')->first();
    
      $agent_user = DB::table('users')->whereIn('role_id', [2,8])->get();
      
      return view('bill_return.show_details', compact('get_data_shocks_bill','get_single_commission_data', 'billing_month','conveynce_bill_parameter','agent_user', 'get_user_data', 'is_agent_convence_pay'));


    } // end show details fucntion


    public function single_bill_return_submit(Request $request){
        
         $bill_no  = $request->bill_no;
         $conveynce_month  = $request->conveynce_month;
         $conveynce_month_exp = explode('--', $conveynce_month);

         $rack_no  = $request->rack_no;
         $shop_id  = $request->shop_id;

         $total_bill  = $request->total_bill;
        $vll_amount  = $request->vll_amount;
        $shop_commission_amount  = $request->shop_commission_amount;
        $agent_commission_amount  = $request->agent_commission_amount;
         $final_vll_amount = $vll_amount - $agent_commission_amount;

         DB::beginTransaction();

         try{


                $shocks_bill_update = DB::table('shock_bills')->where('shocks_bill_no', $bill_no)->update([
                    "status" => 5,
                    "shocks_bill_no" => "{$bill_no}-x"
                ]); // status 5 = bill return
        
               $commission_update = DB::table('commissions')->where('shoks_bill_no',  $bill_no)->update([
                    'shoks_bill_no' => "{$bill_no}-x"
                ]);
        
                foreach($conveynce_month_exp as $single_conveyance_month){
                    $single_conveyance_month_trim = trim($single_conveyance_month);

                   
                    
                    $get_rack_monthly_bill_update = DB::statement("UPDATE rack_monthly_bill set 
                    total_amount_payment = total_amount_payment - '$total_bill', 
                    total_shopkeeper_amount_payment = total_shopkeeper_amount_payment-'$shop_commission_amount',
                        total_agent_amount_payment = total_agent_amount_payment-'$agent_commission_amount',
                    total_venture_amount_payment = total_venture_amount_payment-'$final_vll_amount' 
                    WHERE billing_year_month ='$single_conveyance_month_trim' and rack_code = '$rack_no' and shop_id = '$shop_id'");
                
                    

                }
                
        
                 $rack_product_update = DB::table('rack_products')->where('shocks_bill_no', $bill_no)->update([
                     "status" => 1
                 ]);
                 
                 $this->insertSocksLog($bill_no);

                 DB::commit();
                return [
                    "is_error" => false,
                    "message"  => "Bill Return Successfully"
                ];
             
         }catch(Exception $e){
            DB::rollback();
            return [
                "is_error" => true,
                "message"  => "Failed"
            ];

           
         }
       

    } // end function sibgle bill return submit

    public function insertSocksLog($bill_no){
        $socks_data = DB::table('rack_products')->select('id')->where('shocks_bill_no',$bill_no)->get();
         foreach($socks_data as $socks){
             $this->socksLog($socks->id, "RETURN BILL");
         }
     }

}
