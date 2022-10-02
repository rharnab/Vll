<?php

namespace App\Http\Controllers\Agent\Rack;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductStatusChangeController extends Controller
{
    public function index(){
        return view('agent.rack.product-status-change.index');
    }

    public function findProduct(Request $request){
        if($request->has('socks_code')){
            $socks_code = $request->input('socks_code');
            $sql = "SELECT rp.id as rack_product_id,s.name as shop_name,au.name as agent_name,rp.rack_code,rp.status,rp.entry_date FROM `rack_products` rp 
            LEFT JOIN shops s on rp.shop_id = s.id
            LEFT JOIN agent_users au on rp.agent_id = au.id
            where rp.printed_socks_code='$socks_code' or rp.shop_socks_code='$socks_code'";
            $shocks_info = DB::select(DB::raw($sql));

            if( count($shocks_info) > 0){
                $data = [
                    "shop_name"       => $shocks_info[0]->shop_name,
                    "agent_name"      => $shocks_info[0]->agent_name,
                    "rack_code"       => $shocks_info[0]->rack_code,
                    "entry_date"      => $shocks_info[0]->entry_date,
                    "status"          => $this->getStatusLevel(str_replace(" ","",$shocks_info[0]->status)),
                    "socks_code"      => $socks_code,
                    "rack_product_id" => $shocks_info[0]->rack_product_id,
                    "found"           => true
                ];
                return view('agent.rack.product-status-change.search', $data);
            }else{
                $data = [
                    "found"      => false,
                    "socks_code" => $socks_code
                ];
                return view('agent.rack.product-status-change.search', $data);
            }
            
        }
    }


    public function statusUpdate(Request $request){
        $rack_product_id = $request->input('rack_product_id');
        $rack_level = $request->input('rack_level');

        $socks_info = DB::table('rack_products')->where('id', $rack_product_id)->first();
        if($rack_level == 0){
            $fill_type = 0;
        }elseif($rack_level == 2){
            $fill_type = 2;
        }else{
            $fill_type = $socks_info->fill_type; 
        }

        if($rack_level == 1){
            $sold_mark_date_time = date('Y-m-d H:i:s');
            $sold_date           = date('Y-m-d');
            $sold_mark_user_id   = Auth::user()->id;
        }else{
            $sold_mark_date_time = $socks_info->sold_mark_date_time;
            $sold_date           = $socks_info->sold_date;
            $sold_mark_user_id   = $socks_info->sold_mark_user_id;
        }

        if($rack_level == 3){
            $agent_bill_collection_datetime = date('Y-m-d H:i:s');
            $agent_bill_collection_user_id   = Auth::user()->id;
        }else{
            $agent_bill_collection_datetime = $socks_info->agent_bill_collection_datetime;
            $agent_bill_collection_user_id   = $socks_info->agent_bill_collection_user_id;
        }


        try{
            DB::table('rack_products')->where('id', $rack_product_id)->update([
                "status"                         => $rack_level,
                "fill_type"                      => $fill_type,
                "sold_mark_date_time"            => $sold_mark_date_time,
                "sold_mark_user_id"              => $sold_mark_user_id,
                "agent_bill_collection_datetime" => $agent_bill_collection_datetime,
                "agent_bill_collection_user_id"  => $agent_bill_collection_user_id,
                "sold_date"                      => $sold_date,
                "status_change_datetime"         => date('Y-m-d H:i:s'),
                "status_change_user_id"          => Auth::user()->id
            ]);
            
            // socks log
            if($rack_level == 0){
                $message = "RACK_FILLUP_SOCKS_STATUS_CHANGE";
            }elseif($rack_level == 2){
                $message = "RACK_RE_FILL_SOCKS_STATUS_CHANGE";
            }elseif($rack_level == 1){
                $message = "SHOPKEEPER_SALES_STATUS_CHANGE";
            }elseif($rack_level == 3){
                $message = "AGENT_BILL_COLLECTION_STATUS_CHANGE";
            }	

            $this->socksLog($rack_product_id, $message);

            $data = [
                "status" => 200,
                "message" => "Status updated successfully"
            ];
            return response()->json($data);
        }catch(Exception $e){
            $data = [
                "status" => 400,
                "message" => $e->getMessage()
            ];
            return response()->json($data);
        }
    }


    public function getStatusLevel($status){
        if($status == 0){
            return "RACK-FILL";
        }elseif($status == 1){
            return "SHOPKEPPER SALES";
        }elseif($status == 2){
            return "RACK-REFILL";
        }elseif($status == 3){
            return "AGENT SALES";
        }
        return '';        
    }

}
