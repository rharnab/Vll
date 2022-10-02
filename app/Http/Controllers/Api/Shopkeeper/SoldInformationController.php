<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SoldInformationController extends Controller
{
    /**
     * Single Category Product Sold Summary
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  category_id integer required . Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
     *        "status": 200,
     *        "success": true,
     *        "message": "sold-information fetching success",
     *        "data": {
     *            "category_name": "Socks",
     *            "category_fontawesome_icon": "socks",
     *            "shop_name": "Perfect Footwear Collection",
     *            "total_due": "410.00",
     *            "total_sold": "5  Pair",
     *            "commission": "0.00"
     *        }
     *    }
     */
    public function soldInformation(Request $request){
        $shop_id      = Auth::user()->shop_id;
        $category_id  = $request->input('category_id');
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code = $rack_mapping->rack_code;
            $shop_info = DB::table('shops')->select('name')->where('id', $shop_id)->first();
            $category  = DB::table('category')->where('id', $category_id)->first();
            $rack_info = DB::select(DB::raw("select count(rp.id) as total,sum(rp.selling_price) as total_price, sum(rp.shop_commission) as total_shop_commission from rack_products rp 
						left join stocks st on rp.style_code  = st.style_code 
						where rp.rack_code ='$rack_code' and rp.status = '1' and st.cat_id = $category_id"));
            if($category_id == 1){
				$name = " Pair";
			}else{
				$name = " Pisces";
			}
			$sold_items = $rack_info[0]->total ? $rack_info[0]->total : 0;
			$data = [
                "status" => 200,
                "success" => true,
                "message" => "sold-information fetching success",
                "data" => [
                    "category_name"             => $category->name,
                    "category_fontawesome_icon" => $category->font_awesome_5_icon,
                    "shop_name"                 => $shop_info->name,
                    "total_due"                 => number_format($rack_info[0]->total_price,2),
                    "total_sold"                => $sold_items ." ".$name,
                    "commission"                => number_format($rack_info[0]->total_shop_commission,2)
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
