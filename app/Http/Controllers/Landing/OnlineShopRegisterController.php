<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;

class OnlineShopRegisterController extends Controller
{
    public function store(Request $request)
    {
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
            
           
            "entry_by"=>'',

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
        
       
        

        return redirect('/shop_registration')->with('message', 'দোকান নিবন্ধন  সফল হয়েছে ');

        

    }
}
