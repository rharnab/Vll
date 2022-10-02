<?php

namespace App\Http\Controllers\ParameterSetup\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class BrandController extends Controller
{
     public function index(){

     $get_data = DB::table('brands as b')
                ->select('b.*', 'c.name as category_name', 'co.name as company_name')
               ->leftJoin('category as c', 'c.id', 'b.cat_id')
               ->leftJoin('company as co', 'co.id', 'b.com_id')
               ->orderBy('b.id','DESC')->get();
     $data = [
               'get_data' => $get_data,
          
     ];

     return view('parameter-setup.brand.index', $data);
   }


   public function create(){

     $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
     $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

     $data =[
          'categories'=> $categories,
          'company' => $company
     ];

     return view('parameter-setup.brand.create', $data);
   }


   public function store(Request $request){

        $name = $request->name;
        $brand_short_code = strtoupper($request->brand_short_code);
        $com_id = $request->com_id;
        $cat_id = $request->cat_id;
       
       $data_count = DB::table('brands')->where('name', $name)->count();

       if ($data_count > 0) {

            return redirect('parameter-setup/brand/index')->with('warning_msg', 'This brand Already Exists ! ');
       }
        DB::table('brands')->insert([
            "name"=>$name,
            "short_code"=>$brand_short_code,
            "entry_by"=>Auth::user()->id,
            "com_id" => $com_id,
            "cat_id" => $cat_id
        ]);

        return redirect('parameter-setup/brand/index')->with('message', 'Data Inserted Successfully ');

   } //end store function


   public function edit(Request $request){

     $id = $request->id;
     $get_data = DB::table('brands as b')
               ->select('b.*', 'c.name as category_name', 'co.name as company_name')
               ->leftJoin('category as c', 'c.id', 'b.cat_id')
               ->leftJoin('company as co', 'co.id', 'b.com_id')
               ->where('b.id',$id)->first();
     $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
     $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

     $data =[
          'get_data' => $get_data,
          'company' => $company,
          'categories' => $categories
     ];


     return view('parameter-setup.brand.edit', $data);

   }


   public function update(Request $request){
    
    $id = $request->hidden_id;
    $name = $request->name;
    $brand_short_code = strtoupper($request->brand_short_code);
    $com_id = $request->com_id;
    $cat_id = $request->cat_id;

    $data_count = DB::table('brands')->where('name', $name)->where('id', '!=', $id)->count();

       if ($data_count > 0) {

            return redirect('parameter-setup/brand/index')->with('warning_msg', 'This brand Already Exists ! ');
       }
       
     DB::table('brands')->where('id', $id)->update([
          "name"=>$name,
          "short_code"=>$brand_short_code,
          "com_id" => $com_id,
          "cat_id" => $cat_id
     ]);

      return redirect('parameter-setup/brand/index')->with('message', 'Data Updated Successfully ');

      
   } // end update function

}
