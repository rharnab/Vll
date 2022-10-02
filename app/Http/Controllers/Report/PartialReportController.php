<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PartialReportController extends Controller
{
    public function index()
    {
        return  view('report.partial-bill-report.index');
    }

    public function details(Request $request){
      
        $start_date =date('Y-m-d', strtotime($request->start_date));
        $end_date =date('Y-m-d', strtotime($request->end_date));
        $pay_type  = $request->pay_type;

        if($pay_type =='')
        {
            $pay_type_sql = '';
        }else{
            $pay_type_sql = "and pb.status = $pay_type ";
        }
  
      
        $sql ="SELECT pb.*, au.name as agent_name, u.name,
        (SELECT Sum(quantity) FROM   commissions c WHERE  c.shoks_bill_no = pb.bill_no) AS total_socks
        from partial_bill pb 
        left join rack_mapping rm on rm.rack_code = pb.rack_no 
        left join agent_users au on au.id = rm.agent_id
        left join users u on u.id = pb.auth_by 
        where date(pb.auth_date) between '$start_date' and '$end_date' $pay_type_sql order by pb.bill_no asc";
    
    $get_data =  DB::select(DB::raw($sql));
  
        $data =[
            'get_data' => $get_data,
            'start_date'=> $start_date,
            'end_date'=> $end_date,
        ];
        return view('report.partial-bill-report.details', $data);
  
      } // end bill_authorize_report_details function
    
}
