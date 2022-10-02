<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopActivityController extends Controller
{
     /**
     * Shop Activity Log
	 * @group Voucher
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Shop activity fetching success",
	 *		"data": {
	 *			"shop_activity": [
	 *				{
	 *					"message": "SOCKS_BILL_COLLECTION_BY_AGENT",
	 *					"operation_date": "2022-04-02"
	 *				},
	 *				{
	 *					"message": "SOCKS_SOLD_BY_SHOPKEEPER",
	 *					"operation_date": "2022-03-31"
	 *				},
	 *				{
	 *					"message": "SOCKS_SOLD_BY_SHOPKEEPER",
	 *					"operation_date": "2022-03-23"
	 *				},
	 *			]
	 *		}
	 *	}
    */
    public function activityLog(){
        $shop_id = Auth::user()->shop_id;
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code    = $rack_mapping->rack_code;
            $shop_activity_array = [];

            $shop_activity = DB::select(DB::raw("select sl.id,message,date(operation_datetime) as operation_date  from socks_log sl 
                            left join rack_products rp on sl.socks_code = rp.id 
                            where rp.rack_code = '$rack_code' 
                            group  by message, date(operation_datetime) 
                            order by operation_datetime desc"));
            
            foreach($shop_activity as $activity){
                $data = [
                    "id" => $activity->id,
                    "message" => $activity->message,
                    "operation_date" => date('jS F, Y', strtotime($activity->operation_date)),
                ];
                array_push($shop_activity_array, $data);
            }
            
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "Shop activity fetching success",
                "data" => [
                    "shop_activity" => $shop_activity_array
                ]
            ];
            return response()->json($data);



        }else{
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => "Your rack didn't mapping yet"
            ];
            return response()->json($data);
        }
    }


}
