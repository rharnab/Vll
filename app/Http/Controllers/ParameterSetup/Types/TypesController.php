<?php

namespace App\Http\Controllers\ParameterSetup\Types;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TypesController extends Controller
{
    public function index(){

        //$get_data = DB::select(DB::raw("SELECT t.id, t.types_name,t.short_code, t.entry_date_time, u.name  FROM types t LEFT JOIN users u on t.entry_user_id=u.id"));

        $get_data = DB::table('types as b')
                ->select('b.*', 'c.name as category_name', 'co.name as company_name', 'b.types_name')
               ->leftJoin('category as c', 'c.id', 'b.cat_id')
               ->leftJoin('company as co', 'co.id', 'b.com_id')
               ->orderBy('b.id','DESC')->get();


        $data = [
                'get_data' => $get_data,
            
        ];

        return view('parameter-setup.types.index', compact('get_data'));

    }


    public function create(){

        $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
        $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

        $data = [
            'categories' => $categories,
            'company' => $company
        ];
        return view('parameter-setup.types.create', $data);
    }


    public function store(Request $request){

        $types_name = $request->types_name;
        $short_code = $request->short_code;
        $com_id = $request->com_id;
        $cat_id = $request->cat_id;

        $data_count = DB::table('types')->where('types_name',$types_name)->count();

       if ($data_count > 0) {
           return redirect('parameter-setup/types/index')->with('warning_msg', 'This Type Already Exists ! ');
       }

       $insert = DB::table('types')->insert([

            "types_name"=>$types_name,
            "short_code"=>$short_code,
            "entry_user_id"=>Auth::user()->id,
            "com_id" => $com_id,
            "cat_id" => $cat_id

        ]);


       return redirect('parameter-setup/types/index')->with('message',"Data Inserted Successfully");
        

    }

    public function  edit(Request $request){

        $id = $request->id;
       $get_data = DB::table('types as b')
                    ->select('b.*', 'c.name as category_name', 'co.name as company_name')
                    ->leftJoin('category as c', 'c.id', 'b.cat_id')
                    ->leftJoin('company as co', 'co.id', 'b.com_id')
                    ->where('b.id', $id)->first();

        $categories = DB::table('category')->orderBy('id','DESC')->orderBy('name', 'asc')->get();
        $company = DB::table('company')->orderBy('id','DESC')->orderBy('name', 'asc')->get();

        $data =[
            'get_data' => $get_data,
            'company' => $company,
            'categories' => $categories
       ];

       return view('parameter-setup.types.edit', $data);

    }

    public function update(Request $request){

       $id = $request->hidden_id;
       $types_name = $request->types_name;
       $short_code = $request->short_code;
       $com_id = $request->com_id;
       $cat_id = $request->cat_id;

      $data_count = DB::table('types')->where('types_name', $types_name)->where('id', '!=', $id)->count();
      $short_code_count = DB::table('types')->where('short_code', $short_code)->where('id', '!=', $id)->count();
        
        if($data_count > 0 || $short_code_count > 0){
                return redirect('parameter-setup/types/index')->with('warning_msg', 'This Type Already Exists ! ');
            }

        DB::table('types')->where('id',$id)->update([
            "types_name"=>$types_name,
            "short_code"=>$short_code,
            "com_id" => $com_id,
            "cat_id" => $cat_id
        ]);

        return redirect('parameter-setup/types/index')->with('message',"Data Updated Successfully");
        
    }
}
