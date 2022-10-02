<?php

namespace App\Http\Controllers\Finance\Rack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class FinaceRackBillCollectionController extends Controller
{
    public function search(){

        return view('finance.bill_collection');
    }


    public function search_result(Request $request){

        $shocks_bill_no = $request->shocks_bill_no;

       $get_data = DB::select(DB::raw("SELECT au.name as agent_name, sh.name as shop_name ,sb.rack_code, sb.collect_amount,sb.shocks_bill_no, sb.voucher_link, rp.rack_code,rp.style_code,rp.shocks_code, rp.printed_socks_code, com.quantity,com.total_amount,com.shop_commission_percentage,com.shop_commission_amount,com.agent_commission_percentage,com.venture_amount   FROM `shock_bills` sb left join rack_products rp on sb.shocks_bill_no=rp.shocks_bill_no LEFT join  commissions com on sb.shocks_bill_no=com.shoks_bill_no LEFT JOIN agent_users au on sb.agent_id=au.id LEFT JOIN shops sh on sb.shop_id=sh.id WHERE sb.shocks_bill_no='$shocks_bill_no' and sb.status='0' "));


       return view('finance.bill_collection', compact('get_data'));

    }

    public function approved_amount(Request $request){
        $socks_bill_no = $request->socks_bill_no;

       $bill_collect_update1 = DB::table('shock_bills')->where('shocks_bill_no',$socks_bill_no)->update([
            "status"=>1
        ]);

     $bill_collect_update2 =  DB::table('rack_products')->where('shocks_bill_no', $socks_bill_no)->update([
        "status"=>6
       ]);


         if ($bill_collect_update1 && $bill_collect_update2) {
             
             return 1;

         }else{

            return 0;
         }



    }
}
