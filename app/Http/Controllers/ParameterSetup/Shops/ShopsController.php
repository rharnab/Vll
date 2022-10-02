<?php

namespace App\Http\Controllers\ParameterSetup\Shops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;

class ShopsController extends Controller
{


     
    public function index(){

    $get_data =DB::select(DB::raw("SELECT sh.id, sh.name as shops_name,sh.shop_no, sh.shop_type, sh.shoping_place, sh.shop_weekend_day, sh.shop_address,sh.market_name, sh.mail_address, sh.rack_no, sh.rack_type, sh.address,sh.select_contact, sh.contact_no, sh.image,sh.area,sh.owner_name,sh.owner_contact,sh.owner_email, sh.manager_name, divs.name as division_name, dis.name as district_name, up.name as upazila_name, sh.latitude, sh.longitude,rm.rack_code    FROM `shops` sh left join divisions divs on sh.division_id = divs.id left join districts dis on  sh.district_id = dis.id left join upazilas up on sh.upazilla_id = up.id left join rack_mapping rm on rm.shop_id = sh.id order by sh.id desc"));
    
    return view('parameter-setup.shops.index', compact('get_data'));
   }


   public function create(){
       
        $area_list = DB::table('area_list')->get();
        return view('parameter-setup.shops.create', compact('area_list'));
   }


   public function store(Request $request){



        $shops_name = $request->shops_name;
        $shops_no = $request->shops_no;

        $shop_type = $request->shop_type;
        $shoping_place = $request->shoping_place;
        $shoping_weekend_day = $request->shoping_weekend_day;


        $shops_address = $request->shops_address;
        $address = $request->address;

         $select_contact_person = $request->select_contact_person;
        $contact_no = $request->contact_no;
       
        $division = $request->division;
        $district = $request->district;
        $upazila = $request->upazila;
        $area = $request->area;
        $owner_name = $request->owner_name;

        


        $manager_name = $request->manager_name;

        $market_name = $request->market_name;
        $mail_address = $request->mail_address;
        // $rack_id = $request->rack_no;


        $image = $request->image;


        $owner_contact_no = $request->owner_contact_no;
        $owner_email = $request->owner_email;

        $latitude = $request->latitude;
        $longitude = $request->longitude;
       
       //get rack info 
        // $single_racks_info = DB::table('racks')->where('id', $rack_id)->first();
        // $rack_category = $single_racks_info->rack_category;
        // $rack_code = $single_racks_info->rack_code;

        $last_inserted_id = DB::table('shops')->insertGetId([

            "name"=>$shops_name,

            "shop_no"=>$shops_no,

            "shop_type"=>$shop_type,
            "shoping_place"=>$shoping_place,
            "shop_weekend_day"=>$shoping_weekend_day,


            "shop_address"=>$shops_address,
            
            "address"=>$address,
            "select_contact"=>$select_contact_person,
            "contact_no"=>$contact_no,
            "division_id"=>$division,
            "district_id"=>$district,
            "upazilla_id"=>$upazila,
            "area"=>$area,
            "owner_name"=>$owner_name,
            "manager_name"=>$manager_name,

            "market_name"=>$market_name,
            "mail_address"=>$mail_address,
            
           
            "entry_by"=>Auth::user()->id,

            "owner_contact" => $owner_contact_no,
            "owner_email" => $owner_email,
            "latitude" => $latitude,
            "longitude" => $longitude,

        ]);

      
         // echo $last_inserted_id;

        if ($select_contact_person=="owner") {
            
            $contact_no=$owner_contact_no;

        }elseif ($select_contact_person=="manager") {

           $contact_no=$contact_no;

        }else{
            $contact_no="";
        }

        DB::table('users')->insert([
            "role_id"=>6,
            "shop_id"=>$last_inserted_id,
            "name"=>$shops_name,
            "email"=>$mail_address,
            "password"=>Hash::make("123456"),
            "mobile_number"=>$contact_no,
            "status"=>1,
        ]);




        if ($request->hasFile('image')) {

            $image = $request->image;
            
            $image_filename_extension = $image->getClientOriginalExtension();
            

             $filename = $last_inserted_id.".".$image_filename_extension;

             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($image)->resize(400,300)->save(base_path('uploads/shop_images/'.$filename));
             Image::make($image)->resize(400,300)->save(base_path('uploads/user_image/'.$filename));

             DB::table('shops')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);



              DB::table('users')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);


        }
    

        return redirect('parameter-setup/shops/index')->with('message', 'Data Inserted Successfully ');

   } //end store function


   public function edit(Request $request){

        $id = $request->id;

        $get_data = DB::table('shops')->where('id', $id)->first();
         $area_list = DB::table('area_list')->get();
        return view('parameter-setup.shops.edit', compact('get_data', 'area_list'));
   }


   public function update(Request $request){

       $id = $request->hidden_id;
         $get_user_info = DB::table('shops')->find($id);

        $shops_name = $request->shops_name;
        $shops_no = $request->shops_no;

        $shop_type = $request->shop_type;
        $shoping_place = $request->shoping_place;
        $shoping_weekend_day = $request->shoping_weekend_day;


        $shops_address = $request->shops_address;
        $market_name = $request->market_name;
         $owner_name = $request->owner_name;
         $owner_contact_no = $request->owner_contact_no;
          $owner_email = $request->owner_email;
          $manager_name = $request->manager_name;
          $contact_no = $request->contact_no;
          $mail_address = $request->mail_address;

         $select_contact_person = $request->select_contact_person;
        
        $division = $request->division;
        $district = $request->district;
        $upazila = $request->upazila;
        $area = $request->area;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $shop_is_active = $request->shop_is_active;

        if($shop_is_active == 0){
            $due = DB::table('rack_products')->where('shop_id', $id)->whereIn('status', [1,3])->count();
            if($due > 0){
                return redirect('parameter-setup/shops/index')->with('error', 'Sorry !! Please collect due bill first');
            }
           
        }

        
        $image = $request->image;

         $data_update = DB::table('shops')->where('id',$id)->update([

            "name"=>$shops_name,

            "shop_no"=>$shops_no,

            "shop_type"=>$shop_type,
            "shoping_place"=>$shoping_place,
            "shop_weekend_day"=>$shoping_weekend_day,


            "shop_address"=>$shops_address,
            "market_name"=>$market_name,
            "owner_name"=>$owner_name,
             "owner_contact" => $owner_contact_no,
             "owner_email" => $owner_email,
              "manager_name"=>$manager_name,
               "contact_no"=>$contact_no,
                "mail_address"=>$mail_address,

            "select_contact"=>$select_contact_person,
           
            "division_id"=>$division,
            "district_id"=>$district,
            "upazilla_id"=>$upazila,
            "area"=>$area,

                   
            "latitude" => $latitude,
            "longitude" => $longitude,
            
            "is_active" => $shop_is_active

        ]);


         //user image update
        if ($request->hasFile('image')) {


            $image_fullname = $request->image;
            
            $image_filename_extension = $image_fullname->getClientOriginalExtension();
            
             $filename = $id.".".$image_filename_extension;

             if (!empty($get_user_info->image)) {
                unlink(base_path('uploads/shop_images/'.$get_user_info->image));
                unlink(base_path('uploads/user_image/'.$get_user_info->image));
             }

             
             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($image_fullname)->resize(400,300)->save(base_path('uploads/shop_images/'.$filename));
             Image::make($image_fullname)->resize(400,300)->save(base_path('uploads/user_image/'.$filename));

             DB::table('shops')->where('id', $id)->update([
                "image"=>$filename
             ]);


             DB::table('users')->where('shop_id',$id)->update([
                'image'=>$filename
             ]);


        }

        if ($select_contact_person=="owner") {
            
            $contact_no=$owner_contact_no;

        }elseif ($select_contact_person=="manager") {

           $contact_no=$contact_no;

        }else{
            $contact_no="";
        }

        // update contact person
        DB::table('users')->where('shop_id',$id)->update([
            
            "mobile_number"=>$contact_no,
            
        ]);

        


         return redirect('parameter-setup/shops/index')->with('message', 'Data Updated Successfully ');

         
   } // end update function


}
