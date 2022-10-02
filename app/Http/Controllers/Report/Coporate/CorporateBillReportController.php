<?php

namespace App\Http\Controllers\Report\Coporate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
class CorporateBillReportController extends Controller
{
    public function index()
    {

        $all_client = DB::table('corporate_sales_bill as csb')
        ->select('cc.client_name', 'csb.client_id')
        ->leftJoin('corporate_client as cc', 'cc.id', 'csb.client_id')
        ->orderBy('cc.client_name', 'asc')
        ->groupBy('csb.client_id')
        ->get();

        return view('report.corporate.bill-report.index', compact('all_client'));
    }


    public function summary(Request $request)
    {
        $client_id = $request->input('client_id');
        $status = $request->input('status');
        $form_date = date('Y-m-d', strtotime($request->input('frm_date')));
        $end_date = date('Y-m-d', strtotime($request->input('to_date')));

        if(!empty($client_id)){
            $client_sql = "and m.client_id ='$client_id'";
        }else{
            $client_sql = '';
        }

        if(!empty($status)){
            $status_sql = "and m.status = '$status'";
        }else{
            $status_sql = '';
        }


        
       

        $all_corporate_bill = DB::select("SELECT 
        m.client_name , m.order_date , m.order_no , count(m.challan_no) as total_order , sum(m.total_qty) as total_product, sum(m.total_buy_amt) as total_buy_amt, sum(m.total_buy_paid_amt) as total_buy_paid_amt, sum(m.total_buy_due_amt) as total_buy_due_amt , sum(m.total_sale_amt) as total_sale_amt, sum(m.total_sale_paid_amt) as total_sale_paid_amt , sum(m.total_sale_due_amt) as toal_sale_due_amt, 
        m.status, m.client_id
        
        from (SELECT cc.client_name , cs.order_date , cs.order_no , csb.challan_no , csb.total_qty, csb.total_buy_amt, csb.total_buy_paid_amt, csb.total_buy_due_amt , csb.total_sale_amt, csb.total_sale_paid_amt , csb.total_sale_due_amt, 
                cs.status, csb.client_id 
                from corporate_sales_bill csb 
                left join corporate_sale cs on cs.challan_no = csb.challan_no 
                left join corporate_client cc on cc.id  = csb.client_id 
                group by csb.challan_no) m
        where  date(order_date) between '$form_date' and '$end_date'  $client_sql $status_sql
        group by m.client_id");
       
       
      
        if(!empty($client_id)){
            
            $client_info = DB::table('corporate_client')->select('client_name')->where('id', $client_id)->first();
            $client_name = $client_info->client_name;
            
        }else{
            $client_name = '';
        }
        


        switch ($status) {
            case '1':
                $select_status  = 'Pending';
                break;
            case '2':
                $select_status  = 'Production';
                break;
            case '3':
                $select_status  = 'Delivery';
                break;
            case '4':
                $select_status = 'Partial Payment';
            case '5':
                $select_status = 'Full Payment';
            default:
                $select_status = '';
                break;
        }

        $data = [
            'client_name' => $client_name,
            'select_status' => $select_status,
            'all_corporate_bill' => $all_corporate_bill,
            'form_date' => $form_date,
            'end_date' => $end_date,
            'status' => $status
        ];

        return view('report.corporate.bill-report.summary', $data);
    }


    public function details(Request $request)
    {
        $status  = Crypt::decrypt($request->status);
        $client_id  = Crypt::decrypt($request->client_id);
        $start_date = $request->frm_date;
        $end_date = $request->to_date;


        if(!empty($status)){
            $status_sql = "and cs.status = '$status'";
        }else{
            $status_sql = '';
        }


         $sql="SELECT cc.client_name , cs.order_no , csb.challan_no , csb.total_qty, csb.total_buy_amt, csb.total_buy_paid_amt, csb.total_buy_due_amt , csb.total_sale_amt, csb.total_sale_paid_amt , csb.total_sale_due_amt, 
        cs.status, csb.client_id 
        from corporate_sales_bill csb 
        left join corporate_sale cs on cs.challan_no = csb.challan_no 
        left join corporate_client cc on cc.id  = csb.client_id 
        where  date(cs.order_date) between '$start_date' and '$end_date' and csb.client_id='$client_id' $status_sql
        group by cs.challan_no";

        $details_info = DB::select($sql);

        switch ($status) {
            case '2':
                $select_status  = 'Production';
                break;
            case '3':
                $select_status  = 'Delivery';
                break;
            case '4':
                $select_status = 'Partial Payment';
            case '5':
                $select_status = 'Full Payment';
            default:
                $select_status = '';
                break;
        }

        $data= [
            'select_status' => $select_status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'details_info' => $details_info
        ];
        
        return view('report.corporate.bill-report.details', $data);

    }
}
