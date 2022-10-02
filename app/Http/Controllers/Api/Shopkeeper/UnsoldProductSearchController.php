<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UnsoldProductSearchController extends Controller
{
    /**
     * Unsold Product Search
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  socks_search_text string required . Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response{
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "socks fetching success",
	 *		"data": {
	 *			"socks": [
	 *				{
	 *					"printed_socks_code": "LL204122110",
	 *					"shop_socks_no": 0,
	 *					"selling_price": 75
	 *				},
	 *				{
	 *					"printed_socks_code": "LL204122111",
	 *					"shop_socks_no": 0,
	 *					"selling_price": 75
	 *				}
	 *			]
	 *		}
	 *	}
     */
    public function searchUnsoldSocks(Request $request){
        $validator = Validator::make($request->all(), [ 
            'socks_search_text'      => 'required'
        ],[
            'socks_search_text.required' => 'socks search text  not empty',
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

        $socks_search_text = $request->input('socks_search_text');
        $shop_id           = Auth::user()->shop_id;
        $rack_mapping      = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();

        if($rack_mapping){
            $rack_code = $rack_mapping->rack_code;
            $sql       = "SELECT printed_socks_code,shop_socks_no,selling_price,shop_socks_code,c.font_awesome_5_icon  FROM rack_products rp 
                        left join stocks st on rp.style_code  = st.style_code 
                        left  join category c on st.cat_id = c.id 
                        WHERE rp.rack_code='$rack_code' and (rp.status =0 or rp.status = 2) and (rp.shop_socks_code like '%$socks_search_text%' or rp.printed_socks_code like '%$socks_search_text%')";
            $socks     = DB::select(DB::raw($sql));
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
                    "message" => "socks not found"
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
