<?php

namespace App\Http\Controllers\All_Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AllAgentController extends Controller
{
    public function all_agent_home(){

       $role_id = Auth::user()->role_id;
       $rack_list= DB::table('rack_code_list')->select('rack_codes')->where('role_id', 9)->first();
       if($role_id == 9)
       {
           $rack_list_sql = "where  rack_code in ($rack_list->rack_codes)";
       }else{
            $rack_list_sql = "";
       }

        $agent_user_id = Auth::user()->agent_id;
        $shop_racks_sql = "SELECT
                        rack.rack_code,
                        s.name as shop_name,
                        rack.agent_id 
                    FROM
                        (
                        SELECT
                            rack_code,
                            shop_id,
                            agent_id 
                        from
                            rack_products 
                            $rack_list_sql
                        
                        GROUP by
                            shop_id,
                            rack_code
                        )
                        rack 
                        left join
                        shops s 
                        on rack.shop_id = s.id
                        LEFT Join users u on u.agent_id = rack.agent_id
                        WHERE s.name is not null and u.is_officer =1";
                        
        $shop_racks = DB::select(DB::raw($shop_racks_sql));
        $data = [
            "shop_racks" => $shop_racks
        ];
        return view('agent.home', $data);
        
       
    }
    
    
    public function search_shop(Request $request)
    {
        $shop_name = $request->search_shop;

        $shop_racks_sql = "SELECT
        rack.rack_code,
        s.name as shop_name,
        rack.agent_id 
    FROM
        (
        SELECT
            rack_code,
            shop_id,
            agent_id 
        from
            rack_products 
        
        GROUP by
            shop_id,
            rack_code
        )
        rack 
        left join
        shops s 
        on rack.shop_id = s.id
        LEFT Join users u on u.agent_id = rack.agent_id
        WHERE s.is_active=1 and s.name is not null and u.is_officer =1 and (s.name like '%$shop_name%' or  rack_code='$shop_name');";
                        
        $shop_racks = DB::select(DB::raw($shop_racks_sql));
        if(count($shop_racks) > 0)
        {
            $shop_rack = $shop_racks[0];

        }else{
            $shop_rack ='';
        }

        $output = view('agent.search-shop', compact('shop_rack'));
        echo $output;
        //echo "SDFsdf";
        
    }
}
