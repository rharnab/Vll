<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        if(Auth::user()->role_id == 2){
            return redirect()->route('agent.home');
        }

        //Shopkeeper user
        if(Auth::user()->role_id == 6){
            return redirect()->route('shopkeeper.home');
        }

        //Account Manager
        if(Auth::user()->role_id == 4){
            return 'fddf';
        }
        
        // Super Admin or Stock Manager
        if((Auth::user()->role_id == 1) or (Auth::user()->role_id == 3)){ // admin
            return redirect()->route('admin.home');            
        }
        
         //Super Agent / all agent
        if(Auth::user()->role_id == 8){
           
            return redirect()->route('all_agent.all_agent_home');
        }

         //Limited super Agent
         if(Auth::user()->role_id == 9){
           
            return redirect()->route('all_agent.all_agent_home');
        }


        return view('home');
        
    }
    


    public function password_change()
    {
        return view('auth.passwords.change-password');
    }

    public function password_change_save(Request $request)
    {
            $old_password  = $request->input('old_password');
            $password  = $request->input('password');
            $password_confirmation  = $request->input('password_confirmation');

            $validator = $request->validate([
                    'old_password' => 'required',
                    'password' => 'required',
                    'password_confirmation' =>'required',
                ]);

                

                

            if (Hash::check($request->old_password, Auth::user()->password))
            {
                $new_password = Hash::make($password);
                $update= DB::table('users')->where('id', Auth::user()->id)->update([
                    'password' => $new_password,
                ]);
                
                if($update)
                {
                    //  $data = [
                    //      'status' => 200,
                    //      'is_error' =>'N',
                    //      'message' => 'Password change successuflly'
                    //  ];

                    $request->session()->flush();
                    return redirect()->route('login');
                }

            }else{
                $data = [
                    'status' => 400,
                    'is_error' =>'Y',
                    'message' => 'Sorry ! Current  password not match',
                ];
            }

            return $data;

        
                
            

            //'password' => Hash::make($data['password']),



    } // password change update

    // public function user_profile(Request $request){
    //     $user_id = Auth::user()->id;
       
    //     $get_user_data = DB::table('users')
    //     ->leftJoin('roles','users.role_id','=','roles.id')
    //     ->leftJoin('shops','users.shop_id','=','shops.id')
    //     ->leftJoin('divisions','shops.division_id','=','divisions.id')
    //     ->leftJoin('districts','shops.district_id','=','districts.id')

    //     ->select('users.id','users.image', 'users.name', 'roles.name as role_name', 
    //     'users.email', 'users.mobile_number', 'users.nid_number', 'users.present_address',
    //      'users.permanent_address', 'shops.shop_no', 'shops.shop_address','shops.market_name', 
    //      'shops.area','shops.address', 'shops.owner_name','shops.manager_name','shops.select_contact',
    //       'shops.shop_type','shops.shoping_place','shops.shop_weekend_day', 'divisions.name as division_name',
    //        'districts.name as district_name' )
    //     ->where('users.id',$user_id)->first();

    // //    echo "<pre>";
    // //    print_r($get_user_data);die;

    //     return view('auth.user.profile', compact('get_user_data'));
    // } // end user profile function


    public function monthly_due_bill(){

        $get_data =DB::select(DB::raw("
        SELECT *
FROM   (SELECT rp.shop_id,
               rp.rack_code,
               s.shop_address,
               Sum(rp.selling_price) due_bill,
               s.NAME,
               rp.sold_date
        FROM   shops s
               LEFT JOIN rack_products rp
                      ON rp.shop_id = s.id
        WHERE  rp.status = 1
        GROUP  BY rp.shop_id,
                  Month(rp.sold_date),
                  Year(rp.sold_date)) d
GROUP  BY d.shop_id,
          Month(d.sold_date),
          Year(d.sold_date)
HAVING Count(Month(d.sold_date)) = 1 ORDER BY d.due_bill desc"));

    $refil_less_80 = DB::select(DB::raw("SELECT s.NAME,
        rp.rack_code,
        s.shop_address,
        Count(*) remaining_socks,
        rp.shop_id
        FROM   shops s
        LEFT JOIN rack_products rp
            ON rp.shop_id = s.id
        WHERE  rp.status = 0
        GROUP  BY rp.shop_id
        HAVING Count(*) < 80 ORDER BY remaining_socks DESC"));

        return view('due_bill.index', compact('get_data', 'refil_less_80'));
    }
    
    

    
    
    
    public function user_profile(Request $request){
        $user_id = Auth::user()->id;
       
        $get_user_data = DB::table('users')
        ->leftJoin('roles','users.role_id','=','roles.id')
        ->leftJoin('shops','users.shop_id','=','shops.id')
        ->leftJoin('divisions','shops.division_id','=','divisions.id')
        ->leftJoin('districts','shops.district_id','=','districts.id')

        ->select('users.id','users.image', 'users.name', 'roles.name as role_name', 
        'users.email', 'users.mobile_number', 'users.nid_number', 'users.present_address',
         'users.permanent_address', 'shops.shop_no', 'shops.shop_address','shops.market_name', 
         'shops.area','shops.address', 'shops.owner_name','shops.manager_name','shops.select_contact',
          'shops.shop_type','shops.shoping_place','shops.shop_weekend_day', 'divisions.name as division_name',
           'districts.name as district_name' )
        ->where('users.id',$user_id)->first();

    //    echo "<pre>";
    //    print_r($get_user_data);die;

        return view('auth.user.profile', compact('get_user_data'));
    }
}
