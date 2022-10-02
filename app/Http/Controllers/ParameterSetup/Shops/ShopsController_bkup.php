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

    $get_data =DB::select(DB::raw("SELECT sh.id, sh.name as shops_name,sh.shop_no, sh.shop_type, sh.shoping_place, sh.shop_weekend_day, sh.shop_address,sh.market_name, sh.mail_address, sh.rack_no, sh.rack_type, sh.address,sh.select_contact, sh.contact_no, sh.image,sh.area,sh.owner_name, sh.manager_name, divs.name as division_name, dis.name as district_name, up.name as upazila_name   FROM `shops` sh left join divisions divs on sh.division_id = divs.id left join districts dis on  sh.district_id = dis.id left join upazilas up on sh.upazilla_id = up.id order by sh.id desc"));

    return view('parameter-setup.shops.index', compact('get_data'));
   }


   public function create(){

   return view('parameter-setup.shops.create');
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

        ]);

      
         // echo $last_inserted_id;



        DB::table('users')->insert([
            "role_id"=>6,
            "shop_id"=>$last_inserted_id,
            "name"=>$shops_name,
            "email"=>$mail_address,
            "password"=>Hash::make("12345678"),
            "mobile_number"=>$contact_no,
            "status"=>1,
        ]);




        if ($request->hasFile('image')) {

            $image = $request->image;
            
            $image_filename_extension = $image->getClientOriginalExtension();
            

             $filename = $last_inserted_id.".".$image_filename_extension;

             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($image)->resize(400,300)->save(base_path('uploads/shop_images/'.$filename));

             DB::table('shops')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);



              DB::table('users')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);


        }
    

        return redirect('parameter-setup/shops/index')->with('message', 'Data Inserted Successfully ');

   } //end store function


}
