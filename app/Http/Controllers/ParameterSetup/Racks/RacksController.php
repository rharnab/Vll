<?php

namespace App\Http\Controllers\ParameterSetup\Racks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RacksController extends Controller
{
    
    public function index(){

    $get_data =DB::select(DB::raw("SELECT r.id,r.rack_code,r.rack_category,r.rack_level,r.per_level_socks,r.total_count,rm.status FROM `racks`  r 
    LEFT JOIN rack_mapping rm on rm.rack_code = r.rack_code"));

    return view('parameter-setup.racks.index', compact('get_data'));
   }


   public function create(){

   return view('parameter-setup.racks.create');
   }


   public function store(Request $request){

        $rack_category = $request->rack_category;
        $rack_level    = $request->rack_level;
        $total_count   = $request->total_count;
        $product_type   = $request->product_type;
       
        $per_level_socks = $total_count/$rack_level;

        $rack_code = DB::table('racks')->count();


      
        if($product_type == 2){
            $stp_count = DB::table('racks')->where('rack_code', 'like', '%VLS-'.$product_type."%")->count();
            if($stp_count ==0)
            {
                 $rack_code = "VLS-".$product_type."-".(100 + 1);
            }else{
                $stp_count = DB::table('racks')->select('rack_code')->where('rack_code', 'like', '%VLS-'.$product_type."%")->orderBy('id', 'desc')->first();
                $rack_replace = "VLS-".$product_type."-";
                 $last_entry = str_replace($rack_replace, '', $stp_count->rack_code);
                $rack_code = "VLS-".$product_type."-".($last_entry + 1);
            }
           
        }else if($product_type == 3){
            $stp_count = DB::table('racks')->where('rack_code', 'like', '%VLS-'.$product_type."%")->count();
            if($stp_count ==0)
            {
                 $rack_code = "VLS-".$product_type."-".(200 + 1);
            }else{
                $stp_count = DB::table('racks')->select('rack_code')->where('rack_code', 'like', '%VLS-'.$product_type."%")->orderBy('id', 'desc')->first();
                $rack_replace = "VLS-".$product_type."-";
                $last_entry = str_replace($rack_replace, '', $stp_count->rack_code);
                $rack_code = "VLS-".$product_type."-".($last_entry + 1);
                
            }
           
        }else{

            $rack_code = "VLS".($rack_code + 1);

        }

        
      


      
        if($product_type == 2){
            $stp_count = DB::table('racks')->where('rack_code', 'like', '%VLS-'.$product_type."%")->count();
            if($stp_count ==0)
            {
                 $rack_code = "VLS-".$product_type."-".(100 + 1);
            }else{
                $stp_count = DB::table('racks')->select('rack_code')->where('rack_code', 'like', '%VLS-'.$product_type."%")->orderBy('id', 'desc')->first();
                $rack_replace = "VLS-".$product_type."-";
                 $last_entry = str_replace($rack_replace, '', $stp_count->rack_code);
                $rack_code = "VLS-".$product_type."-".($last_entry + 1);
            }
           
        }else if($product_type == 3){
            $stp_count = DB::table('racks')->where('rack_code', 'like', '%VLS-'.$product_type."%")->count();
            if($stp_count ==0)
            {
                 $rack_code = "VLS-".$product_type."-".(200 + 1);
            }else{
                $stp_count = DB::table('racks')->select('rack_code')->where('rack_code', 'like', '%VLS-'.$product_type."%")->orderBy('id', 'desc')->first();
                $rack_replace = "VLS-".$product_type."-";
                $last_entry = str_replace($rack_replace, '', $stp_count->rack_code);
                $rack_code = "VLS-".$product_type."-".($last_entry + 1);
                
            }
           
        }else{

            $rack_code = "VLS".($rack_code + 1);

        }

        
        $last_inserted_id = DB::table('racks')->insertGetId([
            "rack_category"   => $rack_category,
            "rack_level"      => $rack_level,
            "total_count"     => $total_count,
            "rack_code"       => $rack_code,
            "status"          => 0,
            "per_level_socks" => $per_level_socks,
            "entry_user_id"   => Auth::user()->id
        ]);

      

        return redirect('parameter-setup/racks/index')->with('message', 'Data Inserted Successfully ');

   } //end store function
   
   
   public function edit($id)
   {
      $edit_id  = Crypt::decrypt($id);
      $rack_info = DB::table('racks')->where('id', $edit_id)->first();

      return view('parameter-setup.racks.edit', compact('rack_info'));

   }

    public function update(Request $request)
   {
      $edit_id  = Crypt::decrypt($request->edit_id);
      $rack_code  = $request->rack_code;
      $total_count  = $request->total_count;


      $duplicate= DB::table('racks')->where('rack_code', $rack_code)->where('id', '!=', $edit_id)->count();

      if($duplicate == 0){
        try{

            $last_inserted_id = DB::table('racks')->where('id', $edit_id)->update([
                "total_count"     => $total_count,
                "rack_code"       => $rack_code,
            ]);
        
            return redirect('parameter-setup/racks/index')->with('message', 'Rack Update success ');
          }Catch(Exception $e){
            return redirect('parameter-setup/racks/index')->with('message', 'Rack Update Fail ');
          }
      }else{
            return redirect('parameter-setup/racks/index')->with('message', 'Rack Update Fail ');
      }

    }

}
