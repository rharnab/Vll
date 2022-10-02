<?php

namespace App\Http\Controllers\ParameterSetup\Employee;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class EmployeeSetupController extends Controller
{
    public function index()
    {
       $employess =  DB::table('employee_list as e')
       ->select(['e.*', 'd.name as designation_name'])
       ->leftJoin('designation as d', 'd.id', 'e.designation')
       ->where('e.name', '<>', '')->orderBy('id', 'desc')->get();
       return view('parameter-setup.employee.index', compact('employess'));
    }

    public function create()
    {
        $designations = DB::table('designation')->orderby('name', 'asc')->get();
        return view('parameter-setup.employee.create', compact('designations'));
    }

    public function store(Request $request)
    {
        $validation  = Validator::make($request->all(),[
            'employee_name' => 'required',
            'designation' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'mobile_no' => 'required',
            'nid_no' => 'required',
            'present_add' => 'required',
            'parmanent_add' => 'required',
            'join_date' => 'required',
            'employee_img' => 'image',
        ]);

        if($validation->fails()){
             $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $validation->errors()->first()
             ];

             return redirect('parameter-setup/employee/index')->with("warning", $data['message']);
        }

         $employee_name = $request->employee_name;
         $designation = $request->designation;
         $father_name = $request->father_name;
         $mother_name = $request->mother_name;
         $spouse_name = $request->spouse_name;
         $nominee_name = $request->nominee_name;
         $mobile_no = $request->mobile_no;
         $nid_no = $request->nid_no;
         $account_no = $request->account_no;
         $present_add = $request->present_add;
         $parmanent_add = $request->parmanent_add;
         $join_date = date('Y-m-d', strtotime($request->join_date));

         $employee_img  = $request->file('employee_img');

         if($request->hasFile('employee_img'))
         {
             $path= $request->file('employee_img')->path();
             $base_64_image = base64_encode(file_get_contents($path));
         }else{
            $base_64_image= '';
         }

         $duplicate = DB::table('employee_list')->where('mobile_no', $mobile_no)->get();
         if(count($duplicate) > 0){
            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => "This Employee already registered on this contact number"
             ];

             return redirect('parameter-setup/employee/index')->with("warning", "This Employee already registered on this contact number");
         }

         $data = [
             'name' => $employee_name,
             'designation' => $designation,
             'father_name' => $father_name,
             'mobile_no' => $mobile_no,
             'mother_name' => $mother_name,
             'spouse_name' => $spouse_name,
             'nominee_name' => $nominee_name,
             'nid_no' => $nid_no,
             'account_no' => $account_no,
             'present_address' => $present_add,
             'parmanent_address' => $parmanent_add,
             'join_date' => $join_date,
             'employee_img' => $base_64_image,
             'created_at' => Auth::user()->id,
             'created_by' => date('Y-m-d H:i:s'),
             'status' => 1,
         ];

        try{
            DB::table('employee_list')->insert($data);

            $data = [
                'status' => 200,
                'is_error' => false,
                'message' => 'Employee added successful'
             ];

             return redirect('parameter-setup/employee/index')->with("message", "Employee added successful");
            
        }Catch(Exception $e){
            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
             ];

             return redirect('parameter-setup/employee/index')->with("warning", $data['message']);
        }
        
    }

    public function edit($id)
    {
        $employee_id = Crypt::decrypt($id);

        $employee =  DB::table('employee_list as e')
       ->select(['e.*', 'd.name as designation_name'])
       ->leftJoin('designation as d', 'd.id', 'e.designation')
       ->where('e.id', $employee_id)
       ->first();

       $designations = DB::table('designation')->orderby('name', 'asc')->get();

       $data = [
           'employee' => $employee,
           'designations' => $designations
       ];

       return view('parameter-setup.employee.edit', $data);
    }

    public function update(Request $request)
    {
           $edit_id =  Crypt::decrypt($request->edit_id);
            
            $validation  = Validator::make($request->all(),[
                'employee_name' => 'required',
                'designation' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'mobile_no' => 'required',
                'nid_no' => 'required',
                'present_add' => 'required',
                'parmanent_add' => 'required',
                'employee_img' => 'image',
                'emp_status'=> 'required',
            ]);

            if($validation->fails()){
                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => $validation->errors()->first()
                ];

                return redirect('parameter-setup/employee/index')->with("warning", $data['message']);
            }

            $employee_name = $request->employee_name;
            $designation = $request->designation;
            $father_name = $request->father_name;
            $mother_name = $request->mother_name;
            $spouse_name = $request->spouse_name;
            $nominee_name = $request->nominee_name;
            $mobile_no = $request->mobile_no;
            $nid_no = $request->nid_no;
            $account_no = $request->account_no;
            $present_add = $request->present_add;
            $parmanent_add = $request->parmanent_add;
            $employee_img  = $request->file('employee_img');


            $employee_info  = DB::table('employee_list')->select('employee_img', 'join_date')->where('id',  $edit_id)->first();

            if($request->hasFile('employee_img'))
            {
                $path= $request->file('employee_img')->path();
                $base_64_image = base64_encode(file_get_contents($path));
            }else{
                $base_64_image= $employee_info->employee_img;
            }

            if(!empty($request->join_date)){
                $join_date = date('Y-m-d', strtotime($request->join_date));
            }else{
                $join_date = $employee_info->join_date;
            }

            $duplicate = DB::select("SELECT mobile_no from employee_list el where mobile_no ='$mobile_no' and id <> '$edit_id' ");
            if(count($duplicate) > 0){
                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => "This Employee already registered on this contact number"
                ];

                return redirect('parameter-setup/employee/index')->with("warning", "This Employee already registered on this contact number");
            }

            $data = [
                'name' => $employee_name,
                'designation' => $designation,
                'father_name' => $father_name,
                'mobile_no' => $mobile_no,
                'mother_name' => $mother_name,
                'spouse_name' => $spouse_name,
                'nominee_name' => $nominee_name,
                'nid_no' => $nid_no,
                'account_no' => $account_no,
                'present_address' => $present_add,
                'parmanent_address' => $parmanent_add,
                'join_date' => $join_date,
                'employee_img' => $base_64_image,
                'created_at' => Auth::user()->id,
                'created_by' => date('Y-m-d H:i:s'),
                'status' => $request->emp_status,
            ];

            try{
                DB::table('employee_list')->where('id', $edit_id)->update($data);

                $data = [
                    'status' => 200,
                    'is_error' => false,
                    'message' => 'Employee update successful'
                ];

                return redirect('parameter-setup/employee/index')->with("message","Employee update successful");
                
            }Catch(Exception $e){
                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => $e->getMessage()
                ];

                return redirect('parameter-setup/employee/index')->with("warning", $data['message']);
            }
    }


}
