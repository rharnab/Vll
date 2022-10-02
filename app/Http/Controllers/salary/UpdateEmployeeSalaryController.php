<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;
class UpdateEmployeeSalaryController extends Controller
{
    public function index()
    {
       $all_salary = DB::table('employee_salary as es')
       ->select('el.name', 'es.*')
       ->leftJoin('employee_list as el', 'el.id', 'es.employee_id') 
       ->whereNotNull('el.name')->get();
    
       return view('salary.all_salary', compact('all_salary'));

    }


    public function edit($id)
    {
         $employee_id = Crypt::decrypt($id);

         $employee_salary_info = DB::table('employee_salary as es')
         ->select('el.name', 'es.*')
         ->leftJoin('employee_list as el', 'el.id', 'es.employee_id') 
         ->where('es.employee_id', $employee_id)->first();

        return view('salary.edit', compact('employee_salary_info'));
    }

    public function update(Request $request)
    {
        $employee_id = Crypt::decrypt($request->input('employee_id'));
        $present_salary =  $request->input('present_salary');
        $increment_salary =  $request->input('increment_salary');
        $effective_date =  date('Y-m-d', strtotime($request->input('effective_date')));
        $remarks =  $request->input('remarks');
        

       try{
        $store_data =  DB::table('employee_salary')->where('employee_id', $employee_id)->update([
            'present_salary' => $present_salary,
            'increment_salary' => $increment_salary,
            'effective_date' => $effective_date,
            'remarks' => $remarks
        ]);

        $data =[
            'status' => 200,
            'is_error' => false,
            'message' => "Salary Update success"
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




}
