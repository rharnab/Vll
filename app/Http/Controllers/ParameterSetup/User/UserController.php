<?php

namespace App\Http\Controllers\ParameterSetup\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Image;

class UserController extends Controller
{
   public function index(){

         $get_data = DB::table('users')->orderBy('id','DESC')->get();

        return view('parameter-setup.user.index', compact('get_data'));

   }

     public function create(){

         return view('parameter-setup.user.create');

     }


        public function store(Request $request){

        $name = $request->name;
        $nid = $request->nid;
        $mobile = $request->mobile;
        $present_address = $request->present_address;
        $permanent_address = $request->permanent_address;
        $email = $request->email;
        $role = $request->role;
        $image = $request->image;

       $last_inserted_id = DB::table('users')->insertGetId([

                "role_id"=>$role,
                "name"=>$name,
                "nid_number"=>$nid,
                "mobile_number"=>$mobile,
                "present_address"=>$present_address,
                "permanent_address"=>$permanent_address,
                "email"=>$email,
                'password' => Hash::make("123456"),
               
                "created_at"=>date('Y-m-d h:i:s a'),
                "updated_at"=>date('Y-m-d h:i:s a'),

        ]);


       // echo $last_inserted_id;

        if ($request->hasFile('image')) {

            $image = $request->image;
            
            $image_filename_extension = $image->getClientOriginalExtension();
            

             $filename = $last_inserted_id.".".$image_filename_extension;

             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($image)->resize(400,300)->save(base_path('uploads/user_image/'.$filename));

             DB::table('users')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);

        }


       

        return redirect('parameter-setup/user/index')->with('message', 'Data Inserted Successfully ');

   } //end store function  


   public function edit($id){
        // echo $id;die;

        $get_data = DB::table("users")->where('id', $id)->first();

         return view('parameter-setup.user.edit', compact('get_data'));
   }

   public function update(Request $request){

        $id = $request->hidden_id;
        

        $nid = $request->nid;
         $name = $request->name;
        $mobile = $request->mobile;
        $present_address = $request->present_address;
        $permanent_address = $request->permanent_address;
        $email = $request->email;
        $role = $request->role;
        $image = $request->image;


        $single_get_data = DB::table('users')->where('id',$id)->first();

         DB::table('users')->where('id',$id)->update([

                
                "role_id"=>$role,
                "name"=>$name,
                "nid_number"=>$nid,
                "mobile_number"=>$mobile,
                "present_address"=>$present_address,
                "permanent_address"=>$permanent_address,
                "email"=>$email,
                

        ]);



         if ($request->hasFile('image')) {



            $edit_image_fullname = $request->image;
            
            $edit_image_filename_extension = $edit_image_fullname->getClientOriginalExtension();
            

             $filename = $id.".".$edit_image_filename_extension;

             if (!empty($single_get_data)) {
                unlink(base_path('uploads/user_image/'.$single_get_data->image));
             }
             

             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($edit_image_fullname)->resize(400,300)->save(base_path('uploads/user_image/'.$filename));

            DB::table('users')->where('id', $id)->update([
                "image"=>$filename
            ]);

        }


        return redirect('parameter-setup/user/index')->with('message', 'Data Updated Successfully ');

   }


}
