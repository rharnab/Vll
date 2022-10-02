<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SingleProductDetailsController extends Controller
{
     /**
     * Single Product Details
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  category_id integer required . Example: 1
     * @bodyParam  type_id integer required . Example: 1
     * @bodyParam  socks_search_text string required . Example: 122
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Data fetching successfully",
	 *		"data": {
	 *			"product": {
	 *				"category_name": "Socks",
	 *				"brand_name": "Pegasus Loafer",
	 *				"size_name": "10/11/LF\r\n",
	 *				"types_name": "Loafer",
	 *				"selling_price": "80.00",
	 *				"socks_code": "LO20403221(LO-61)",
	 *				"product_image": "https://cdn.shoplightspeed.com/shops/609731/files/20893344/1500x4000x3/pegasus-retro-stripe-mens-crew-sock-from-sock-it-t.jpg"
	 *			}
	 *		}
	 *	}
     */
    public function singleProductDetails($product_id){
        $sql = "SELECT 
                c.name  as category_name, 
                b.name  as brand_name,
                bs.name as size_name,
                t.types_name,
                rp.selling_price,
				rp.printed_socks_code,
                rp.shop_socks_code 
            from rack_products rp  
            left join stocks st on rp.style_code = st.style_code 
            left join category c on st.cat_id  = c.id 
            left join brands b on st.brand_id = b.id 
            left join brand_sizes bs on st.brand_size_id = bs.id 
            left join types t on rp.type_id  =  t.id 
            where rp.printed_socks_code = '$product_id'";
        $data = DB::select(DB::raw($sql));
        $rowCount = count($data);
        if($rowCount > 0){
            $response = [
                "status" => 200,
                "success" => true,
                "message" => "Data fetching successfully",
                "data" => [
                    "product" => [
						"category_name" => $data[0]->category_name,
						"brand_name"    => $data[0]->brand_name,
						"size_name"     => $data[0]->size_name,
						"types_name"    => $data[0]->types_name,
						"selling_price" => number_format($data[0]->selling_price,2),
						"socks_code"    => $data[0]->shop_socks_code ? $data[0]->printed_socks_code ."(".$data[0]->shop_socks_code.")" : '',
						"product_image" => 'https://cdn.shoplightspeed.com/shops/609731/files/20893344/1500x4000x3/pegasus-retro-stripe-mens-crew-sock-from-sock-it-t.jpg'
					]
                ]
            ];
            return response()->json($response);
        }else{
            $response = [
                "status" => 400,
                "success" => false,
                "message" => "Product not found"
            ];
            return response()->json($response);
        }
    }
}
