<?php

namespace App\Http\Controllers\ParameterSetup\Client;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CorporateClientController extends Controller
{
    public function index()
    {
        $all_client = DB::table('corporate_client')->OrderBy('client_name',  'asc')->get(); 
        return view('parameter-setup.corporate-client.index', compact('all_client'));
    }

    public function create()
    {
        return view('parameter-setup.corporate-client.create');
    }

    

    public function store(Request $request)
    {
        $client_name = trim($request->input('client_name'));
        $contact_number = $request->input('contact_number');
        $address = $request->input('address');

         $validator = Validator::make($request->all(), [
             'client_name' => 'required',
             'contact_number' => 'required|numeric',
             'address' => 'required',
            
         ]);

         if($validator->fails()){
            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> $validator->errors()->first(),
            ];

            return response()->json($response);
         }

         $duplicate_info = DB::table('corporate_client')->where('client_name', $client_name)->get();
         
         if(count($duplicate_info) > 0){

            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> "this name duplicate",
            ];

            return response()->json($response);
         }

        

         try{

            $data = [
                'client_name' => $client_name,
                'contact_no' => $contact_number,
                'address' => $address,
            ];

            DB::table('corporate_client')->insert($data);

            $response =[
                'status' => 200,
                'is_error' => false,
                'message'=> "Client Setup success",
            ];

            return response()->json($response);

         }Catch(Exception $e){

            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> $e->getMessage(),
            ];

            return response()->json($response);
         }


    }

    public function edit($id)
    {
        $edit_id = Crypt::decrypt($id);
        $client_info =  DB::table('corporate_client')->where('id', $edit_id)->first();
        return view('parameter-setup.corporate-client.edit', compact('client_info'));
    }

    public function update(Request $request)
    {
        $client_name = trim($request->input('client_name'));
        $contact_number = $request->input('contact_number');
        $address = $request->input('address');
        $edit_id = Crypt::decrypt($request->input('edit_id'));

         $validator = Validator::make($request->all(), [
             'client_name' => 'required',
             'contact_number' => 'required|numeric',
             'address' => 'required',
            
         ]);

         if($validator->fails()){
            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> $validator->errors()->first(),
            ];

            return response()->json($response);
         }


         $duplicate_info = DB::table('corporate_client')->where('client_name', $client_name)->where('id', '<>', $edit_id)->get();
         
         if(count($duplicate_info) > 0){

            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> "this name duplicate",
            ];

            return response()->json($response);
         }

         $data = [
             'client_name' => $client_name,
             'contact_no' => $contact_number,
             'address' => $address,
         ];

         $client_check = DB::table('corporate_client')->select('id')->where('id', $edit_id)->first();
         try{
            DB::table('corporate_client')->where('id', $client_check->id)->update($data);
            $response =[
                'status' => 200,
                'is_error' => false,
                'message'=> "Client update success",
            ];

            return response()->json($response);

         }Catch(Exception $e){

            $response =[
                'status' => 400,
                'is_error' => true,
                'message'=> $e->getMessage(),
            ];

            return response()->json($response);
         }



    }

}
