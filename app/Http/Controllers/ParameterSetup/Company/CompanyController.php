<?php

namespace App\Http\Controllers\ParameterSetup\Company;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CompanyController extends Controller
{
    public function index()
    {
       $companies= DB::table('company  as c')
       ->select('c.*', 'u.name as user_name')
       ->leftJoin('users as u', 'u.id', 'c.entry_by')
       ->orderBy('c.name', 'asc')->get();

       return view('parameter-setup.company.index', compact('companies'));
    }

    public function create()
    {
        return view('parameter-setup.company.create');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'company_name' => 'required',
            'owner_name' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
        ]);

        if($validation->fails()){

            return response()->json($validation);
        };

        $company_name = $request->company_name;
        $owner_name = $request->owner_name;
        $contact_no = $request->contact_no;
        $address = $request->address;


        try{

             $duplicate =DB::table('company')->where('name', trim($company_name))->count();

            if($duplicate > 0)
            {

                $data =[
                    'status'=> 400,
                    'message' =>'this name already taken'
                ];
               return response()->json($data);
            }
           

            DB::table('company')->insert([
                'name'=> $company_name,
                'owner_name'=> $owner_name,
                'contact_no'=> $contact_no,
                'address'=> $address,
                'entry_by'=> Auth::user()->id,
                'entry_datetime'=> date('Y-m-d H:i:s'),

            ]);

            $data =[
                'status'=> 200,
                'message' =>'Company Registered Success'
            ];

            return response()->json($data);

        }catch(Exception $e)
        {
            $data =[
                'status'=> 400,
                'message' =>'Company Registered Fail'
            ];

            return response()->json($data);
        }
       
    }


    public function edit($id)
    {
        $edit_id =  Crypt::decrypt($id);
        $companies= DB::table('company  as c')
       ->select('c.*', 'u.name as user_name')
       ->leftJoin('users as u', 'u.id', 'c.entry_by')
       ->where('c.id', $edit_id)
       ->first();

       return view('parameter-setup.company.edit', compact('companies'));
      
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'company_name' => 'required',
            'owner_name' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
        ]);

        if($validation->fails()){

            return response()->json($validation);
        };

        $company_name = $request->company_name;
        $owner_name = $request->owner_name;
        $contact_no = $request->contact_no;
        $address = $request->address;
        $edit_id = Crypt::decrypt($request->edit_id);

        $duplicat = DB::table('company')->select('id')->where('name', '=', $company_name)->where('id', '!=', $edit_id)->count();   
        if($duplicat > 0)
        {
            $data =[
                'status'=> 400,
                'message' =>'Company Update Fail this name already exits'
            ];

            return response()->json($data);
        }else{

            DB::table('company')->where('id', $edit_id)->update([
                'name'=> $company_name,
                'owner_name'=> $owner_name,
                'contact_no'=> $contact_no,
                'address'=> $address,

            ]);

            $data =[
                'status'=> 200,
                'message' =>'Company Update Success'
            ];

            return response()->json($data);
        }

    }
}
