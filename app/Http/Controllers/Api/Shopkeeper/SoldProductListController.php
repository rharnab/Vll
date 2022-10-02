<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SoldProductListController extends Controller
{
    /**
     * Sold Product List
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Socks fetching successfully",
	 *		"data": {
	 *			"products": [
	 *				{
	 *					"printed_socks_code": "LO20403222",
	 *					"shop_socks_no": 2,
	 *					"shop_socks_code": "LO-62",
	 *					"selling_price": 80
	 *				},
	 *				{
	 *					"printed_socks_code": "SH217032236",
	 *					"shop_socks_no": 36,
	 *					"shop_socks_code": "SH-736",
	 *					"selling_price": 100
	 *				}
	 *			]
	 *		}
	 *	}
     */
    public function allSoldProductList(){
        $shop_id = Auth::user()->shop_id;
        $sql = "SELECT 
                 rp.printed_socks_code,
                 rp.shop_socks_no,
                 rp.shop_socks_code,
                 rp.selling_price,
                 c.font_awesome_5_icon 
             from rack_products rp 
             left join stocks st on rp.style_code = st.style_code 
             left  join  category c on st.cat_id = c.id 
             where rp.shop_id  = '$shop_id'  and rp.status = 1";
         $products = DB::select(DB::raw($sql));
         $response = [
             "status"  => 200,
             "success" => true,
             "message" => "Socks fetching successfully",
             "data"    => [
                 "products" => $products
             ]
         ];
         return response()->json($response);
     }
     
}
