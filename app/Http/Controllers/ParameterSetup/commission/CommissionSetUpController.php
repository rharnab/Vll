<?php

namespace App\Http\Controllers\ParameterSetup\commission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionSetUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $shops= DB::table('shops')->select('name', 'area', 'id')->orderBy('name', 'asc')->get();
        return view('parameter-setup.commission.create',compact('shops'));
    }

    public function store(Request $request)
    {
       $shop_id =  $request->input('shop_id');
       $starting_range =  $request->input('starting_range');
       $ending_range =  $request->input('ending_range');
       $agent_commission =  $request->input('agent_commission');
       $shop_commission =  $request->input('shop_commission');


       try{

        DB::table('commission_setups')->insert([

            'shop_id'=> $shop_id,
            'qunatity'=> " ",
            'statring_range'=> $starting_range,
            'ending_range'=> $ending_range,
            'agent_commission_persentage'=> $agent_commission,
            'shop_commission_persentage'=> $shop_commission,
    
           ]);

           $data= [
                "status"   => 200,
                "is_error" => false,
                "message"  => "Commission Create Successful"
            ];
        return response()->json($data);


       }catch(Exception $e)
       {
            $data= [
                "status"   => 400,
                "is_error" => true,
                "message"  => "Commission Create failed"
            ];

            return response()->json($data);
       }

       



    }
}
