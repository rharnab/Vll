<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusWiseSummationController extends Controller
{
    public function index(){
        $shops = DB::table('shops')->get(); 
        $data = [
            "shops"   => $shops
        ]; 
        return view('report.status_wise_summation_report.index', $data);
    }



    public function generate(Request $request){
        // return $request->all();

        $shop_id       = $request->input('shop_id');
        $status        = $request->input('status');
        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));

        if($shop_id == "all"){
            $shop_sql = "";
        }else{
            $shop_sql = " and rp.shop_id = '$shop_id' ";
        }

        $all_result = [];

        foreach($status as $single_status)
        {
            if($single_status == '0'){ // unsold condition
                $condition_sql = " and rp.status in (0,2) and rp.entry_date between '$starting_date' and '$ending_date' ";
                $message = " Total Unsold From ($starting_date To $ending_date) ";
                $select_status = 'unsold';
            }
    
            if($single_status == '1'){ // total sold
                $condition_sql = " and rp.status in (1,3,7) and rp.sold_date between '$starting_date' and '$ending_date' ";
                $message = " Total Sold From ($starting_date To $ending_date) ";
                $select_status = 'sold';
            }
    
            if($single_status == '2'){ // total refill 
                $condition_sql = " and rp.status in (2,3,7) and rp.entry_date between '$starting_date' and '$ending_date' ";
                $message = " Total Refill From ($starting_date To $ending_date) ";
                $select_status = 'refill';
            }
    
            if($single_status == '3'){ // total refill 
                $condition_sql = " and rp.status in (3,7) and date(rp.agent_bill_collection_datetime) between '$starting_date' and '$ending_date' ";
                $message = " Total Agent Cash From ($starting_date To $ending_date) ";
                $select_status = 'agent_cash';
            }
    
            if($single_status == '5'){ // total refill 
                $condition_sql = " and rp.status in (5) and rp.return_date between '$starting_date' and '$ending_date' ";
                $message = " Total Return From ($starting_date To $ending_date) ";
                $select_status = 'Return';
            }
    
            if($single_status == '7'){ // total vill authorize 
                $condition_sql = " and rp.status in (7) and date(rp.auth_dateTime) between '$starting_date' and '$ending_date' ";
                $message = " Total Bill Authorize From ($starting_date To $ending_date) ";
                $select_status = 'bill_authorize';
            }


            $sql = "SELECT 
                 s.name  as shop_name,
                 rp.rack_code,
                sum(selling_price) as total_sell_price, 
                sum(buying_price) as total_buy_price,
                count(*) as total_product 
            from rack_products rp 
            left join shops s on rp.shop_id  = s.id 
            where rp.shop_id  != '' $condition_sql $shop_sql
            group by rp.shop_id,rp.rack_code order by s.id asc";
            $datas = DB::select(DB::raw($sql));

            $all_result[$select_status] = $datas;

        }

        $response = [
            "all_result" => $all_result,
            "message" => '',
            "select_status" => $select_status
        ];

       /*  echo "<pre>";
        print_r($all_result);
        die; */

       

      

        return  view('report.status_wise_summation_report.generate', $response);
    }




}
