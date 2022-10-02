<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TypewiseProductSearchController extends Controller
{
    /**
     * Type-wise Product Search
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  LO20403221 string required . Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
     *      "status": 200,
     *      "success": true,
     *      "message": "socks fetching success",
     *      "data": {
     *          "socks": [
     *              {
     *                  "printed_socks_code": "LN222022211",
     *                  "shop_socks_no": 11,
     *                  "selling_price": 120
     *                  "shop_socks_code": "LN-411"
     *              }
     *          ]
     *      }
     *  }
     */
    public function singleTypeWiseSearchRackUnsoldSocks(Request $request){
        $validator = Validator::make($request->all(), [ 
            'category_id'       => 'required',
            'type_id'           => 'required',
            'socks_search_text' => 'required'
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

        $type_id           = $request->input('type_id');
        $category_id       = $request->input('category_id');
        $socks_search_text = $request->input('socks_search_text');

        $shop_id      = Auth::user()->shop_id;
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();

        if($rack_mapping){
            $rack_code = $rack_mapping->rack_code;
			$sql = "SELECT 
                        rp.printed_socks_code,
                        rp.shop_socks_no,
                        rp.selling_price,
                        rp.shop_socks_code,
                        c.font_awesome_5_icon 
                    FROM rack_products rp 
                    left join stocks st on rp.style_code = st.style_code 
                    left  join  category c on st.cat_id  = c.id 
                    WHERE rp.rack_code='$rack_code' 
                    and rp.type_id='$type_id' 
                    and st.cat_id = '$category_id' 
                    and (rp.status =0 or rp.status = 2) 
                    and (rp.shop_socks_code like '%$socks_search_text%' or rp.printed_socks_code like '%$socks_search_text%')";
            $socks = DB::select(DB::raw($sql));
            if(count($socks) > 0){
                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "socks fetching success",
                    "data"    => [
                        "socks" => $socks
                    ]
                ];
                return response()->json($data);
            }else{
                $data = [
                    "status"  => 400,
                    "success" => false,
                    "message" => "product not found"
                ];
                return response()->json($data);
            }

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
