<?php

namespace App\Http\Controllers\ParameterSetup\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    public function index()
    {
       $companies= DB::table('category  as c')
       ->select('c.*', 'u.name as user_name')
       ->leftJoin('users as u', 'u.id', 'c.create_by')
       ->orderBy('c.name', 'asc')->get();

       return view('parameter-setup.category.index', compact('companies'));
    }

    public function create()
    {
        return view('parameter-setup.category.create');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if($validation->fails()){

            return response()->json($validation);
        };

        $category_name = $request->category_name;
     


        try{

             $duplicate =DB::table('category')->where('name', trim($category_name))->count();

            if($duplicate > 0)
            {

                $data =[
                    'status'=> 400,
                    'message' =>'this name already taken'
                ];
               return response()->json($data);
            }
           

            DB::table('category')->insert([
                'name'=> $category_name,
                'create_by'=> Auth::user()->id,
                'create_datetime'=> date('Y-m-d H:i:s'),

            ]);

            $data =[
                'status'=> 200,
                'message' =>'Category Registered Success'
            ];

            return response()->json($data);

        }catch(Exception $e)
        {
            $data =[
                'status'=> 400,
                'message' =>'Category Registered Fail'
            ];

            return response()->json($data);
        }
       
    }


    public function edit($id)
    {
        $edit_id =  Crypt::decrypt($id);
        $companies= DB::table('category  as c')
       ->select('c.*', 'u.name as user_name')
       ->leftJoin('users as u', 'u.id', 'c.create_by')
       ->where('c.id', $edit_id)
       ->first();

       return view('parameter-setup.category.edit', compact('companies'));
      
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_name' => 'required'
          
        ]);

        if($validation->fails()){

            return response()->json($validation);
        };

        $category_name = $request->category_name;
        $edit_id = Crypt::decrypt($request->edit_id);

        $duplicat = DB::table('category')->select('id')->where('name', '=', $category_name)->where('id', '!=', $edit_id)->count();   
        if($duplicat > 0)
        {
            $data =[
                'status'=> 400,
                'message' =>'Category Update Fail this name already exits'
            ];

            return response()->json($data);
        }else{

            DB::table('category')->where('id', $edit_id)->update([
                'name'=> $category_name,
            ]);

            $data =[
                'status'=> 200,
                'message' =>'Category Update Success'
            ];

            return response()->json($data);
        }

    }
}
