<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserWiseSummationController extends Controller
{
    public function index(){
       $shops = DB::table('shops')->get(); 
        $users = DB::table('users as u')
        ->select(['u.id', 'u.name', 'r.name as role_name'])
        ->leftJoin('roles as r', 'r.id', 'u.role_id')
        ->where('u.role_id', '<>' , 6)->orderBy('u.role_id', 'asc')->get();
        $data = [
            "shops" => $shops,
            "users" => $users
        ]; 
        return view('report.user_wise_summation_report.index', $data);
    }



    public function generate(Request $request){
        

        $shop_id       = $request->input('shop_id');
        $status        = $request->input('status');
        $user          =  join(',', $request->input('user'));
        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));

        $condition_sql = "";
        $message = "";

        if($shop_id == "all"){
            $shop_sql = "";
        }else{
            $shop_sql = " and rp.shop_id = '$shop_id' ";
        }

        if($status == '0'){ // unsold condition
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.entry_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' and rp.status in (0,2) and rp.entry_date between '$starting_date' and '$ending_date' 
                and rp.entry_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.entry_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Unsold From ($starting_date To $ending_date) ";
        }

        if($status == '1'){ // total sold
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.sold_mark_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' 
                and rp.status in (1,3,7) and rp.sold_date between '$starting_date' and '$ending_date' 
                and rp.sold_mark_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.sold_mark_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Sold From ($starting_date To $ending_date) ";
        }

        if($status == '2'){ // total refill 
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.entry_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' 
                and rp.status in (2,3,7) and rp.entry_date between '$starting_date' and '$ending_date'
                and rp.entry_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.entry_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Refill From ($starting_date To $ending_date) ";
        }

        if($status == '3'){ // total agent cash 
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.agent_bill_collection_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' 
                and rp.status in (3,7) and date(rp.agent_bill_collection_datetime) between '$starting_date' and '$ending_date'
                and rp.agent_bill_collection_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.agent_bill_collection_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Agent Cash From ($starting_date To $ending_date) ";
        }

        if($status == '5'){ // total return 
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.return_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' 
                and rp.status in (5) and rp.return_date between '$starting_date' and '$ending_date'
                and rp.return_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.return_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Return From ($starting_date To $ending_date) ";
        }

        if($status == '7'){ // total vill authorize 
            $sql = "SELECT r.*,u.name  as operation_user_name from (
                SELECT rp.shop_id,s.name as shop_name, rp.rack_code, sum(selling_price) as total_sell_price, sum(buying_price) as total_buy_price, sum(venture_amount) as total_venture_amt , count(*) as total_product,rp.auth_user_id as operation_user_id  
                from rack_products rp left join shops s on rp.shop_id = s.id where rp.shop_id != '' 
                and rp.status in (7) and date(rp.auth_dateTime) between '$starting_date' and '$ending_date' 
                and rp.auth_user_id in ($user)
                group by rp.shop_id,rp.rack_code,rp.auth_user_id
            ) r
            left join users u on r.operation_user_id = u.id 
            order by r.shop_id asc";
            $message = " Total Bill Authorize From ($starting_date To $ending_date) ";
        }

       /* $sql = "SELECT 
            s.name  as shop_name,
            rp.rack_code,
            sum(selling_price) as total_sell_price, 
            sum(buying_price) as total_buy_price,
            count(*) as total_product 
        from rack_products rp 
        left join shops s on rp.shop_id  = s.id 
        where rp.shop_id  != '' $condition_sql $shop_sql
        group by rp.shop_id,rp.rack_code order by s.id asc";

        return $sql;
        */
        // return $sql;
        $datas = DB::select(DB::raw($sql));
        $response = [
            "datas" => $datas,
            "message" => $message
        ];


        return  view('report.user_wise_summation_report.generate', $response);
    }


}
