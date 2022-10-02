<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatusWiseReportController extends Controller
{
   public function status_wise_report(){
       $get_shop = DB::table('shops')->get();

       $data = [
           "get_shop"   => $get_shop
       ];

       return view('report.status_wise_report.index', $data);
   }

   public function get_shop_id(Request $request){

        $shop_id = $request->shop_id;
        $get_shop_data = DB::table('rack_mapping')->where('shop_id', $shop_id)->get();
        $select_option='';
        $select_option.='<select class="form-control select2 select_rack" name="rack_code" required>';
        
        $select_option.= "<option value=''>--select--</value>";
        foreach($get_shop_data as $single_shop_data){

            $select_option.= "<option value='$single_shop_data->rack_code'>$single_shop_data->rack_code</value>";
        }
        $select_option.="</select>";

        return $select_option;
        
   }

   public function data_show(Request $request){
       
        if(!empty($request->shop_id)){

            $shop_id = $request->shop_id;
            $shop_sql = " and  rp.shop_id='$shop_id'  ";

        }else{
            $shop_sql = "";
        }

        if(!empty($request->rack_code)){

            $rack_code = $request->rack_code;
            $rack_sql = " and rp.rack_code='$rack_code' ";

        }else{
            $rack_sql = "";
        }   
       
        
        if(!empty($request->status) || $request->status=='0'){

            $status = $request->status;
            $status_sql = " and rp.status='$status' ";

        }else{
            $status_sql = "";
        }

        
        if(!empty($request->starting_date) && !empty($request->ending_date) ){
            
            $starting_date = $request->starting_date;
            $ending_date = $request->ending_date;

            $date_sql = " and rp.entry_date BETWEEN '$starting_date' and '$ending_date' ";

        }else{
            $date_sql = "";
        }


       

        $condition = $shop_sql . $rack_sql . $status_sql . $date_sql;

        

      $get_report_data = DB::select(DB::raw("SELECT rp.agent_id,au.name as agent_name,sh.name as shop_name,rp.rack_code, rp.shop_id, st.print_packet_code as packet_code, rp.shocks_code, rp.printed_socks_code, rp.buying_price, rp.selling_price,  t.types_name,rp.entry_date, rp.shop_socks_code FROM `rack_products` rp 
       LEFT JOIN agent_users au on rp.agent_id=au.id
       LEFT JOIN shops sh on rp.shop_id = sh.id
       LEFT JOIN types t on rp.type_id=t.id
       LEFT JOIN stocks st on st.style_code=rp.style_code
       WHERE  rp.id<>''   $condition ")); 
       
       $get_report_data_single = DB::select(DB::raw("SELECT rp.agent_id,au.name as agent_name,sh.name as shop_name,rp.rack_code, rp.shop_id, rp.style_code as packet_code, rp.shocks_code, rp.printed_socks_code, rp.buying_price, rp.selling_price FROM `rack_products` rp 
       LEFT JOIN agent_users au on rp.agent_id=au.id
       LEFT JOIN shops sh on rp.shop_id = sh.id
       WHERE  rp.id<>''   $condition "));


        $summation = DB::select("SELECT sum(rp.buying_price) as total_buy_price,
        sum(rp.selling_price) as total_sale_price FROM `rack_products` rp 
        LEFT JOIN agent_users au on rp.agent_id=au.id
        LEFT JOIN shops sh on rp.shop_id = sh.id
        LEFT JOIN types t on rp.type_id=t.id
        WHERE  rp.id<>''   $condition ");
       
    

     $status = $request->status;

    if($status=='0'){

        $show_status = "Not Sold";

    }elseif($status=='1'){

        $show_status = "Shop Keeper Sold";

    }elseif($status=='2'){

        $show_status = "Refil";

    }elseif($status=='3'){

        $show_status = "Agent Cash";

    }elseif($status=='4'){

        $show_status = "Return";

    }elseif($status=='7'){

        $show_status = "Bill Authorize";

    }else{
        $show_status = "";
    }

      $data = [
          "get_report_data" => $get_report_data,
          "show_status" => $show_status,
          "get_report_data_single" => $get_report_data_single,
          'summation' => $summation
          
      ];  

     // return  $data;

      return view('report.status_wise_report.show', $data);
   }

}
