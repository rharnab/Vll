<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SoldProductSearchController extends Controller
{
    /**
     * Search Sold Product List
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     *
     * @bodyParam  product_code string required . Example: '122'
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Socks seraching successfully",
	 *		"data": {
	 *			"products": [
	 *				{
	 *					"product_code": "LL20412211",
	 *					"printed_socks_code": "LL20412211",
	 *					"shop_socks_no": 0,
	 *					"shop_socks_code": "",
	 *					"selling_price": 75
	 *				},
	 *				{
	 *					"product_code": "LL204122122",
	 *					"printed_socks_code": "LL204122122",
	 *					"shop_socks_no": 0,
	 *					"shop_socks_code": "",
	 *					"selling_price": 75
	 *				}
	 *			]
	 *		}
	 *	}
     */
    public function searchProduct(Request $request){
		$validator = Validator::make($request->all(), [ 
            'product_code'      => 'required',
        ]);        
        /**
         * Validation Failed
         */ 
        if($validator->fails()){
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->errors()->first()
            ];
            return response()->json($data);
        }
		
		$product_code = $request->input('product_code');
		$shop_id = Auth::user()->shop_id;
		$sql = "select product_code,printed_socks_code,shop_socks_no,shop_socks_code,selling_price,font_awesome_5_icon  from (
					select if(shop_socks_code != '', shop_socks_code, printed_socks_code) as product_code,printed_socks_code,shop_socks_no,shop_socks_code,selling_price,c.font_awesome_5_icon  
					from rack_products rp
					left join stocks st on rp.style_code = st.style_code 
					left join category c on st.cat_id  = c.id 
					where shop_id ='$shop_id' and rp.status = 1
				) p where product_code  like '%$product_code%'";
				
		$products = DB::select(DB::raw($sql));
		$response = [
            "status" => 200,
            "success" => true,
            "message" => "Socks seraching successfully",
            "data" => [
                "products" => $products
            ]
        ];
        return response()->json($response);

		
	}
}
