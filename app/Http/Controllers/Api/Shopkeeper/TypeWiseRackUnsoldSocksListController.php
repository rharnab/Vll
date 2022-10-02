<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TypeWiseRackUnsoldSocksListController extends Controller
{
    /**
     * Single Category Type-wise Un-Sold Product List
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  category_id integer required . Example: 1
     * @bodyParam  type_id integer required . Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response{
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "product fetching success",
	 *		"data": {
	 *			"socks": [
	 *				{
	 *					"printed_socks_code": "LN22202221",
	 *					"shop_socks_no": 1,
	 *					"selling_price": 120,
	 *					"shop_socks_code": "LN-41"
	 *				},
	 *				{
	 *					"printed_socks_code": "LN22202222",
	 *					"shop_socks_no": 2,
	 *					"selling_price": 120,
	 *					"shop_socks_code": "LN-42"
	 *				}
	 *			]
	 *		}
	 *	}
     */
    public function singleTypeRackUnsoldSocks(Request $request){
        $validator = Validator::make($request->all(), [ 
            'category_id'      => 'required',
            'type_id'      => 'required'
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

        $type_id = $request->input('type_id');

        $shop_id =  Auth::user()->shop_id;
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code = $rack_mapping->rack_code;
            $sql = "SELECT printed_socks_code,shop_socks_no,selling_price,shop_socks_code,c.font_awesome_5_icon  FROM rack_products rp
                    left join stocks st on rp.style_code = st.style_code 
                    left join category c on st.cat_id = c.id 
                    WHERE rp.rack_code='$rack_code' and rp.type_id='$type_id' and (rp.status =0 or rp.status = 2)";
            $socks = DB::select(DB::raw($sql));
            if(count($socks) > 0){
                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "product fetching success",
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
