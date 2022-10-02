<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRefillVoucher extends Controller
{
    /**
     * Product Re-Fill Voucher
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
    *		"message": "Your product voucher list fetching successfully",
    *		"data": {
    *			"vouchers": [
    *				{
    *					"voucher_name": "2022-03-17-VLS2-Refill",
    *					"voucher_date": "17th March, 2022",
    *					"location": "http://venturelifestylelimited.com/public/voucher/2022-03-17-VLS2-Refill.pdf"
    *				}
    *			]
    *		}
    *	}
    */
    public function refillVoucher(){
        $shop_id      = Auth::user()->shop_id;
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code    = $rack_mapping->rack_code;
            $voucher_list = [];

            $refill_vouchers = DB::select(DB::raw("SELECT id,store_location, voucher_name,voucher_date  from shop_refill_voucher where  rack_code = '$rack_code' order by voucher_date  desc"));
            foreach($refill_vouchers as $voucher){
                $single_voucher = [
                    "id" => $voucher->id,
                    "voucher_name" => str_replace(".pdf", "",$voucher->voucher_name),
                    "voucher_date" => date('jS F, Y', strtotime($voucher->voucher_date)),
                    "location"     => "http://venturelifestylelimited.com/public/".$voucher->store_location,
                ];
                array_push($voucher_list, $single_voucher);
            }
            
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "Your product voucher list fetching successfully",
                "data" => [
                    "vouchers" => $voucher_list
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
