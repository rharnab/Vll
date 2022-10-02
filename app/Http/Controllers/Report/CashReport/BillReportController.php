<?php

namespace App\Http\Controllers\Report\CashReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillReportController extends Controller
{
    public function index()
    {
        $sql = "SELECT s.name as shop_name, rm.rack_code, s.id as shop_id from shops s
        left JOIN rack_mapping rm on rm.shop_id = s.id
        where s.is_active =1";
        $all_shops= DB::select($sql);

        $agent_sql = "select au.name  as agen_name, rm.agent_id  from agent_users au 
        left join rack_mapping rm  on rm.agent_id  = au.id 
        group by rm.agent_id  ";

        $all_agent= DB::Select($agent_sql);
        $data = [
            'all_shops' => $all_shops,
            'all_agent' => $all_agent
        ];
        return view('report.cash-report.bill-report.index', $data);
    }

    public function details(Request $request)
    {

        $status = $request->status;
        $shop_id = $request->shop_id;
        $agent_id = $request->agent_id;
        $frm_date = date('Y-m-d', strtotime($request->frm_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));

        

        if($shop_id == 0)
        {
            $shop_sql = "  ";
            $shop_name = '';
            $shop_id = '';
        }else{
             $shop_sql = " and rp.shop_id = '$shop_id' ";

             $shop_info = DB::table('shops as s')
             ->select('s.name', 's.id')
             ->leftJoin('rack_mapping as rm', 'rm.shop_id', '=', 's.id')
             ->where('s.is_active', 1)->where('rm.shop_id', $shop_id)
             ->first();
            $shop_name = $shop_info->name;
            $shop_id = $shop_info->id;

            
        }

    
        if($agent_id == 0)
        {
            $agent_sql = "  ";
            $agent_info= '';
        }else{
            $agent_sql = " and rp.agent_id = '$agent_id' ";
            $agent_info = DB::table('agent_users')->select('name', 'id')->where('id', $agent_id)->first();
        }

        switch ($status) {
            case '7':
                $status_type = 'Bill Receive';
                $status_sql = "date(rp.auth_dateTime)";
                $group_month = "Month(rp.auth_dateTime)";
                $group_year = "Year(rp.auth_dateTime)";
                break;

            case '3':
                $status_type = 'Agent Cash';
                $status_sql = "date(rp.sold_date)";
                $group_month = "Month(rp.sold_date)";
                $group_year = "Year(rp.sold_date)";
                break;
            
            case '1':
                $status_type = 'Due Bill';
                $status_sql = "date(rp.sold_date)";
                $group_month = "Month(rp.sold_date)";
                $group_year = "Year(rp.sold_date)";
                
                break;
            
            default:
                $status_type = 'No found';
                break;
        }



          $sql = "SELECT sold_date, rack_code, rp.auth_dateTime,
                Count(*)              AS total_socks,
                Sum(selling_price)    AS total_bill,
                Sum(shop_commission)  AS shop_commission_amt,
                Sum(agent_commission) AS agent_commission_amt,
                Sum(venture_amount) AS venture_commission_amt,
                sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
                FROM   rack_products rp
                left join shops s on s.id = rp.shop_id 
                WHERE  rp.status = '$status' and $status_sql between '$frm_date'  and '$to_date' $shop_sql $agent_sql
                
                GROUP  BY $group_month,
                          $group_year order by date(rp.auth_dateTime) desc ";

        $bill_result = DB::select($sql);

        $summation_sql= "SELECT Sum(b.total_socks)          AS grand_total_socks,
                                Sum(b.total_bill)           grand_total_bill,
                                Sum(b.shop_commission_amt)  AS grand_total_shop_commission,
                                Sum(b.agent_commission_amt)  AS grand_total_agent_commission,
                                Sum(b.venture_commission_amt) AS grand_total_venture_amount,
                                Sum(b.total_profit_amount) AS grand_total_profit_amount
                                
                        FROM   (SELECT sold_date,
                                        Count(*)              AS total_socks,
                                        Sum(selling_price)    AS total_bill,
                                        Sum(shop_commission)  AS shop_commission_amt,
                                        Sum(agent_commission) AS agent_commission_amt,
                                        Sum(venture_amount) AS venture_commission_amt,
                                        sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
                                FROM   rack_products rp
                                WHERE  rp.status = '$status' and $status_sql between '$frm_date'  and '$to_date' $shop_sql $agent_sql
                                GROUP  BY $group_month,
                                        $group_year) b ";
        $sum_result = DB::select($summation_sql);


       
        


        $data = [
            'bill_result' => $bill_result,
            'status_type' => $status_type,
            'sum_result' => $sum_result,
            'status' => $status,
            'frm_date' =>$frm_date,
            'to_date' =>$to_date,
            'agent_info' => $agent_info,
            'shop_name' => $shop_name,
            'shop_id' => $shop_id
            

        ];

        return view('report.cash-report.bill-report.details', $data);


    }

    public function rack_details(Request $request)
    {
    
        
        $sold_date  =  $request->sold_date;
        $month = date('m', strtotime($sold_date));
        $year = date('Y', strtotime($sold_date));
        $rack_status  =  $request->rack_status;
        $agent_id = $request->agent_id;
        $shop_id = $request->shop_id;
        $frm_date = $request->frm_date;
        $to_date = $request->to_date;


        if($shop_id == 0)
        {
            $shop_sql = "  ";
            $shop_name = '';
            $shop_id = '';
        }else{
             $shop_sql = " and rp.shop_id = '$shop_id' ";

             $shop_info = DB::table('shops as s')
             ->select('s.name', 's.id')
             ->leftJoin('rack_mapping as rm', 'rm.shop_id', '=', 's.id')
             ->where('s.is_active', 1)->where('rm.shop_id', $shop_id)
             ->first();
            $shop_name = $shop_info->name;
            $shop_id = $shop_info->id;

            
        }


        if($agent_id == 0)
        {
            $agent_sql = "  ";
            $agent_info= '';
        }else{
            $agent_sql = " and rp.agent_id = '$agent_id' ";
            $agent_info = DB::table('agent_users')->select('name', 'id')->where('id', $agent_id)->first();
        }

        switch ($rack_status) {
            case '7':
                $status_type = 'Bill Receive';
                $status_sql = "date(rp.auth_dateTime)";
                $group_month = "Month(rp.auth_dateTime)";
                $group_year = "Year(rp.auth_dateTime)";
                break;
    
            case '3':
                $status_type = 'Agent Cash';
                $status_sql = "date(rp.sold_date)";
                $group_month = "Month(rp.sold_date)";
                $group_year = "Year(rp.sold_date)";
                break;
            
            case '1':
                $status_type = 'Due Bill';
                $status_sql = "date(rp.sold_date)";
                $group_month = "Month(rp.sold_date)";
                $group_year = "Year(rp.sold_date)";
                break;
            
            default:
                $status_type = 'No found';
                $status_sql = "rp.sold_date";
                break;
        }

        $sql = "SELECT sold_date, rack_code, s.name as shop_name,
        Count(*)              AS total_socks,
        Sum(rp.selling_price)    AS total_bill,
        Sum(rp.shop_commission)  AS shop_commission_amt,
        Sum(rp.agent_commission) AS agent_commission_amt,
        Sum(rp.venture_amount) AS venture_commission_amt,
        sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
        FROM   rack_products rp
        left join shops s on s.id = rp.shop_id 
        WHERE  $group_month='$month' and $group_year='$year' and $status_sql between '$frm_date'  and '$to_date' and status='$rack_status' $agent_sql $shop_sql
        GROUP  BY rack_code  ";
        
       $rack_Bill_details =  DB::select($sql);

      
       
       
       if(count($rack_Bill_details) > 0)
       {
           $data = [
                'rack_Bill_details' => $rack_Bill_details,
                'sold_date' => $sold_date,
                'status_type' => $status_type,
                'agent_info' => $agent_info,
                'shop_name' => $shop_name
           ];
           return  view('report.cash-report.bill-report.rack-info-details', $data);
           //return $output;
       }


    }



}
