<?php

namespace App\Http\Controllers\ParameterSetup\BrandSize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BrandSizeController extends Controller
{
    public function index(){

    //$get_data =DB::select(DB::raw("SELECT bs.id, bs.name as brand_sise_name FROM `brand_sizes` bs  order by bs.id desc"));
    $get_data = DB::table('brand_sizes as b')
                ->select('b.*', 'c.name as category_name', 'co.name as company_name', 'b.name as brand_sise_name')
                ->leftJoin('category as c', 'c.id', 'b.cat_id')
                ->leftJoin('company as co', 'co.id', 'b.com_id')
                ->groupBy('b.id')
                ->orderBy('b.id','DESC')->get();

    return view('parameter-setup.brand-size.index', compact('get_data'));
   }


   public function create(){

    $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
    $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

    
    $data =[
        'categories'=> $categories,
        'company' => $company
   ];


   return view('parameter-setup.brand-size.create', $data);
   }


   public function store(Request $request){

        $name = $request->name;
        $com_id = $request->com_id;
        $cat_id = $request->cat_id;
      
       $data_count = DB::table('brand_sizes')->where('name',$name)->count();

       if ($data_count > 0) {
           return redirect('parameter-setup/brandsize/index')->with('warning_msg', 'This Size Already Exists ! ');
       }

        DB::table('brand_sizes')->insert([

            "name"=>$name,
            "com_id" => $com_id,
            "cat_id" => $cat_id,
            "entry_by"=>Auth::user()->id,

        ]);


    

        return redirect('parameter-setup/brandsize/index')->with('message', 'Data Inserted Successfully ');

   } //end store function


   
   public function edit(Request $request){
        $id = $request->id;
        $get_data =  DB::table('brand_sizes as b')
                    ->select('b.*', 'c.name as category_name', 'co.name as company_name')
                    ->leftJoin('category as c', 'c.id', 'b.cat_id')
                    ->leftJoin('company as co', 'co.id', 'b.com_id')
                    ->where('b.id', $id)->first();
        $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
        $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

        $data =[
            'get_data' =>$get_data,
            'categories' => $categories,
            'company'=> $company
        ];

     

        return view('parameter-setup.brand-size.edit', $data);

    } // end edit function

    public function update(Request $request){

        $id = $request->hidden_id;
        $size_name = $request->name;
        $com_id = $request->com_id;
        $cat_id = $request->cat_id;

        $size_data_count =  DB::table('brand_sizes')->where('name', $size_name)->where('id', '!=', $id)->count();


        if($size_data_count>0){
            return redirect('parameter-setup/brandsize/index')->with('warning_msg', 'This Data Already Exist ! ');
        }

        DB::table('brand_sizes')->where('id',$id )->update([
            "name"=>$size_name,
            "com_id" => $com_id,
            "cat_id" => $cat_id,
        ]);

        return redirect('parameter-setup/brandsize/index')->with('message', ' Data Updated Successfully ! ');

    } // end update function

}
