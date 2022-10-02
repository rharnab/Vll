<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
class SalaryDisburseReportController extends Controller
{
    public function index()
    {
       $all_employee= DB::table('employee_list')->select('name', 'id')->orderBy('name', 'asc')->get();
       return view('report.salary_disburse.index', compact('all_employee'));
    }

    //public function summary(Request $request)
    public function summary(Request $request)
    {
        $emp_id = $request->emp_id;
        $frm_date = date('Y-m-d', strtotime($request->frm_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));

        if(!empty($emp_id)){
            $emp_sql = "and es.emp_id ='$emp_id' ";
        }else{
            $emp_sql='';
        }
        
        $summary_info = DB::select("SELECT m.name, m.mobile_no, m.employee_id  ,sum(total_disburse_amt) as total_salary, count(total_salary_month) as total_salary_month   from (select el.name , el.mobile_no, sd.employee_id , sum(disburse_amount) as total_disburse_amt, count(sd.salary_month_year) as total_salary_month
        from salary_disburse sd 
        left join employee_list el on el.id = sd.employee_id 
        where sd.status = 1 and date(sd.auth_date) between '$frm_date' and '$to_date'
        group by  sd.employee_id, sd.salary_month_year ) m
        group by m.employee_id ");

        $data = [
            'summary_info' => $summary_info,
            'frm_date' => $frm_date,
            'to_date' => $to_date,
        ];

        return view('report.salary_disburse.summary', $data);

        
    }


    public function details($emp_id, $frm_date, $to_date)
    {
         $emp_id = Crypt::decrypt($emp_id);

         $details_info = DB::select("SELECT el.name , el.mobile_no, sd.employee_id , sd.disburse_amount, sd.salary_month_year, sd.monthly_salary
         from salary_disburse sd 
         left join employee_list el on el.id = sd.employee_id 
         where sd.status = 1 and date(sd.auth_date) between '$frm_date' and '$to_date' and sd.employee_id= '$emp_id' ");

        $data = [
        'details_info' => $details_info,
        'frm_date' => $frm_date,
        'to_date' => $to_date,
        ];

         return view('report.salary_disburse.emp_details', $data);
    }




}
