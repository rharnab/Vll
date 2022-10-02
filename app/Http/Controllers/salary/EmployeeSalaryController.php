<?php

namespace App\Http\Controllers\salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Crypt;

class EmployeeSalaryController extends Controller
{
    public function create()
    {
        
        $all_employee = DB::table(DB::raw('employee_list el'))
        ->select('name','id')
        ->whereRaw('id NOT IN (select employee_id  from employee_salary es )')
        ->get();

        return view('salary.create', compact('all_employee'));

    }


    public function store(Request $request)
    {
        $employee_id =  $request->input('employee_id');
        $present_salary =  $request->input('present_salary');
        $increment_salary =  $request->input('increment_salary');
        $effective_date =  date('Y-m-d', strtotime($request->input('effective_date')));
        $remarks =  $request->input('remarks');
        $create_at = date('Y-m-d H:i:s');
        $create_by = Auth::user()->id;

       try{
        $store_data =  DB::table('employee_salary')->insert([
            'employee_id' => $employee_id,
            'present_salary' => $present_salary,
            'increment_salary' => $increment_salary,
            'effective_date' => $effective_date,
            'entry_by' =>$create_by, 
            'entry_date' =>$create_at,
            'status' => 1,
            'remarks' => $remarks
        ]);

        $data =[
            'status' => 200,
            'is_error' => false,
            'message' => "Salary setup success"
        ];

        return response()->json($data);


       }Catch(Exception $e){
            $data =[
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);
       }


    }


    public function disbursement()
    {
       $all_salary = DB::select("SELECT el.name , es.* from employee_salary es 
       left join employee_list el on el.id  = es.employee_id ");

       return view('salary.disburse', compact('all_salary'));
     
    }



    //for get employe sallary info 
    public function getSalaryInfo(Request $request)
    {
        $employee_id = $request->employee_id;
       /*  $salary_info = DB::table("employee_salary as es")
        ->select(['es.present_salary', 'es.increment_salary', 'es.effective_date', 'el.join_date'])
        ->leftJoin('employee_list as el', 'el.id', 'es.employee_id')
        ->where('es.employee_id', $employee_id)
        ->where('es.status', 1)->first(); */
       $old_paid_salary = DB::table('salary_disburse')->select(['salary_month_year', 'disburse_amount'])->where('employee_id', $employee_id)->whereIn('status', [1])->orderBy('salary_month_year', 'desc')->first();
       if(isset($old_paid_salary->disburse_amount) > 0){

            $month_array = explode('-', $old_paid_salary->salary_month_year);
            $month = $month_array[0].'/01/'.$month_array[1];
            echo  date('M-Y', strtotime($month));

       }else{
           echo "";
       }
        
    }


    //get month wise slary info 
    public function getMonthwiseSalary(Request $request)
    {
        $disburse_month_array = explode('/',  $request->disburse_month);
        $disburse_month_date  = $disburse_month_array[0]."/01/".$disburse_month_array[1];
        $disburse_month = date('Ym', strtotime($disburse_month_date));
        $employee_id = $request->employee_id; 

        $salary_info = DB::table("employee_salary as es")
        ->select(['es.present_salary', 'es.increment_salary', 'es.effective_date', 'el.join_date'])
        ->leftJoin('employee_list as el', 'el.id', 'es.employee_id')
        ->where('es.employee_id', $employee_id)
        ->where('es.status', 1)->first();
        
         $effective_month =  date('Ym', strtotime($salary_info->effective_date));
         $current_month_year = date('m-Y');


         $CheckPreviousdisburse = $this->CheckPreviousdisburse($employee_id, $request->disburse_month); //check previous paid salray
         if($CheckPreviousdisburse['status'] == 200){
           $previous_paid_salary  = $CheckPreviousdisburse['disburse_amt'];
         }

         if($disburse_month > $effective_month){
            $salary_amount  = $salary_info->increment_salary - $previous_paid_salary;
            $monthly_salary = $salary_info->increment_salary;
        }else{
           $salary_amount  = $salary_info->present_salary - $previous_paid_salary;
           $monthly_salary = $salary_info->present_salary;
        }
        

        /*  if($current_month_year > $effective_month){
             $salary_amount  = $salary_info->increment_salary;
         }else{
            $salary_amount  = $salary_info->present_salary;
         } */

        $data =[
            'salary_amount' => $salary_amount,
            'monthly_salary' => $monthly_salary
        ]; 
        
        return response()->json($data);
    }


    public function disburse_store(Request $request)
    {
        $employee_id = $request->employee_id;
        $disburse_month_year = $request->disburse_month;
        $salary_amount = $request->salary_amount;
        $disburse_amount = $request->disburse_amount;
        $remarks = $request->remarks;
        $monthly_salary = $request->monthly_salary;


        $pending_check= $this->MonthlyPendingSalary($employee_id, $disburse_month_year); //this month authorize data check

        if($pending_check['status'] == 400 ){
            return response()->json($pending_check);
        }

        try{

            DB::table('salary_disburse')->insert([
                'employee_id' => $employee_id,
                'disburse_amount' => $disburse_amount,
                'salary_month_year' => str_replace('/', '-', $disburse_month_year),
                'due_salary_amount' => $salary_amount,
                'monthly_salary' => $monthly_salary,
                "remarks" => $remarks,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
    
            ]);


            $data =[
                'status' => 200,
                'is_error' => false,
                'message' => "Salary disburse  success"
            ];
    
            return response()->json($data);

        }Catch(Exception $e){

            $data =[
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);
        }

        
    }


    public function CheckPreviousdisburse($employee_id, $disburse_month)
    {
        $salary_month_year = str_replace('/', '-', $disburse_month);
        $result =  DB::select("SELECT sum(disburse_amount) as disburse_amt  from salary_disburse where employee_id ='$employee_id' and salary_month_year='$salary_month_year' and status <> 5 ");

        if(count($result) > 0 ){
            $result = $result[0];
            $data = [ 
                'status' => 200,
                'is_error'=> false,
                'disburse_amt' => $result->disburse_amt
            ];

            return $data;

        }else{

            $data = [ 
                'status' => 200,
                'is_error'=> false,
                'disburse_amt' => 0
            ];

            return $data;
        }


    }

    public function authorize_index()
    {
        $pendig_data = DB::table('salary_disburse as sd')
        ->select(['sd.*', 'el.name'])
        ->leftJoin('employee_list as el', 'el.id', 'sd.employee_id')
        ->where('sd.status', 0)->get();
        return view('salary.pending', compact('pendig_data'));
    }



    public function authorize_salary(Request $request)
    {
         $all_update_id = $request->batch_no;
         $auth_by = Auth::user()->id;
         $auth_dateTime = date('Y-m-d H:i:s');

         if(count($all_update_id) > 0){
             
            foreach($all_update_id as $single_data){
                if($single_data !=''){
                    
                    try{

                        DB::table('salary_disburse')->where('id', $single_data)->update([
                            'status' => 1,
                            'auth_by' => $auth_by,
                            'auth_date' => $auth_dateTime
                        ]);

                    }Catch(Exception $e){
                        $data = [
                            'status' => 400,
                            'is_error'=> true,
                            'message' => 'Salary disburse authorize Fail',
                        ];

                        return response()->json($data);
                    }


                }
            }

            $data = [
                'status' => 200,
                'is_error'=> false,
                'message' => 'Salary disburse authorize successful',
            ];

            return response()->json($data);
         }

    }

    public function decline_salary(Request $request)
    {
        $all_update_id = $request->batch_no;
        $auth_by = Auth::user()->id;
        $auth_dateTime = date('Y-m-d H:i:s');
        $remarks  = $request->remarks;

        if(count($all_update_id) > 0){
            
           foreach($all_update_id as $single_data){
               if($single_data !=''){
                   
                   try{

                       DB::table('salary_disburse')->where('id', $single_data)->update([
                           'status' => 5,
                           'auth_by' => $auth_by,
                           'auth_date' => $auth_dateTime,
                           'remarks' => $remarks,
                       ]);

                   }Catch(Exception $e){
                       $data = [
                           'status' => 400,
                           'is_error'=> true,
                           'message' => 'Salary disburse decline Fail',
                       ];

                       return response()->json($data);
                   }


               }
           }

           $data = [
               'status' => 200,
               'is_error'=> false,
               'message' => 'Salary disburse decline successful',
           ];

           return response()->json($data);
        }

    }


    public function amendment($amendment_id)
    {
        $id = Crypt::decrypt($amendment_id);
        $disburse_info = DB::table('salary_disburse as sd')
        ->select(['sd.*', 'el.name', 'es.present_salary', 'es.increment_salary', 'es.effective_date'])
        ->leftJoin('employee_list as el', 'el.id', 'sd.employee_id')
        ->leftJoin('employee_salary as es', 'es.employee_id', 'sd.employee_id')
        ->where('sd.id', $id)->first();

        /* echo "<pre>";
        print_r($disburse_info); */


        $disburse_month_array = explode('-',  $disburse_info->salary_month_year);
        $disburse_month_date  = $disburse_month_array[0]."/01/".$disburse_month_array[1];
        $disburse_month = date('Ym', strtotime($disburse_month_date));

        $effective_month =  date('Ym', strtotime($disburse_info->effective_date));


        if($disburse_month > $effective_month){
            $monthly_salary  = $disburse_info->increment_salary;
        }else{
           $monthly_salary  = $disburse_info->present_salary;
        }



        $salary_info = [
            'name' => $disburse_info->name,
            'disburse_month' => date('M-Y', strtotime($disburse_month_date)),
            'monthly_salary' => $monthly_salary,
            'due_salary_amount' => $disburse_info->due_salary_amount,
            'disburse_amount' => $disburse_info->disburse_amount,
            'remarks' => $disburse_info->remarks,
            'amendment_id' => $amendment_id
        ];

        


        return view('salary.amendment', compact('salary_info'));
    }


    public function amendment_update(Request $request)
    {
        $id = Crypt::decrypt($request->amendment_id);
        $disburse_amount = $request->disburse_amount;
        $remarks = $request->remarks;
        if(!empty($id))
        {
            try{

                DB::table('salary_disburse')->where('id', $id)->update([
                    'disburse_amount' => $disburse_amount,
                    'remarks' => $remarks,
                    'status' => 1,
                    'auth_by' => Auth::user()->id,
                    'auth_date' => date('Y-m-d H:i:s')
                ]);

                $data = [
                    'status' => 200,
                    'is_error'=> false,
                    'message' => 'Salary disburse Success',
                ];

                return response()->json($data);


            }Catch(Exception $e){

                $data = [
                    'status' => 400,
                    'is_error'=> true,
                    'message' => 'Salary amendment Fail',
                ];

                return response()->json($data);
            }
        }
    }


    public function MonthlyPendingSalary($employee_id, $disburse_month)
    {
        $disburse_month = str_replace('/', '-', $disburse_month);
        $pending_data = DB::table('salary_disburse')->where([
            ['employee_id', '=',  $employee_id],
            ['salary_month_year', '=',  $disburse_month],
            ['status', 0]
        ])->get();

        if(count($pending_data) > 0){
            $data = [
                'status' => 400,
                'is_error'=> true,
                'message' => 'Sorry '.$disburse_month.' salary already pending please authorize before', 
            ];

            return $data;
        }else{

            $data = [
                'status' => 200,
                'is_error'=> false,
                'message' => 'no data found this month', 
            ];

            return $data;

        }


    }


  



}
