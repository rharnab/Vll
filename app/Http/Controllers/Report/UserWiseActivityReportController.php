<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
class UserWiseActivityReportController extends Controller
{
    public function index()
    {
        $shops = DB::table('shops')->get(); 
        $users = DB::table('users as u')
        ->select(['u.id', 'u.name', 'r.name as role_name'])
        ->leftJoin('roles as r', 'r.id', 'u.role_id')
        ->where('u.role_id', '<>' , 6)->orderBy('u.role_id', 'asc')->get();
        $data = [
            "shops" => $shops,
            "users" => $users
        ]; 
        return view('report.user_wise_activity_report.index', $data);
    }
    public function summary(Request $request)
    {
        $shop_id       = $request->input('shop_id');
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

        $sql = "SELECT  u.name, sl.message , count(sl.message) as total_product
             from socks_log sl 
                left join users u on u.id = sl.operation_user_id
                left join rack_products rp  on rp.id = sl.socks_code 
                where sl.operation_user_id in ($user) and  date(sl.operation_datetime) between '$starting_date' and '$ending_date'  $shop_sql
                group by sl.message ";

      $all_log_summary = DB::select($sql);

      $form_data =[
        'shop_id' => $shop_id,
        'user' => $user,
        'starting_date' => $starting_date,
        'ending_date' => $ending_date,
      ];

      $data = [
        'all_log_summary' => $all_log_summary,
        'form_data' => $form_data,
        'starting_date' => $starting_date,
        'ending_date' => $ending_date,
      ];

     return view('report.user_wise_activity_report.summary', $data);

    }


    public function details($form_data, $activity)
    {
        $form_input = explode(",", Crypt::decrypt($form_data));
        $shop_id = $form_input[0];
        $user_id = $form_input[1];
        $frm_dt = $form_input[2];
        $to_dt = $form_input[3];


        if($shop_id == "all"){
            $shop_sql = "";
        }else{
            $shop_sql = " and rp.shop_id = '$shop_id' ";
        }

        $sql ="SELECT u.name as user_name, s.name as shop_name, rp.sold_date, rp.sold_mark_date_time,
        rp.entry_date, rp.selling_price , rp.venture_amount, t.types_name, rp.printed_socks_code  
               FROM   socks_log sl
               LEFT JOIN users u
                      ON u.id = sl.operation_user_id
               LEFT JOIN rack_products rp
                      ON rp.id = sl.socks_code
               left join shops s on s.id = rp.shop_id 
               left join types t on t.id = rp.type_id 
        WHERE  sl.operation_user_id IN ( $user_id )
               AND Date(sl.operation_datetime) BETWEEN '$frm_dt' AND '$to_dt' and sl.message ='$activity' $shop_sql 
               order by rp.shop_id ";
    
        $details = DB::select($sql);

        $data = [
            'frm_dt' => $frm_dt,
            'to_dt' => $to_dt,
            'details' => $details,
            'activity' => $activity
        ];
       

        return view('report.user_wise_activity_report.details', $data);
        
    }
}
