<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SingleCategoryUnsoldProductSummary extends Controller
{
     /**
     * Single Category Product Un-Sold Summary
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  category_id integer required . Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "sold-information fetching success",
	 *		"data": {
	 *			"socks": [
	 *				{
	 *					"type_id": 6,
	 *					"types_name": "Loafer",
	 *					"total": 21
	 *				},
	 *				{
	 *					"type_id": 1,
	 *					"types_name": "Long",
	 *					"total": 24
	 *				}
	 *			]
	 *		}
	 *	}
     */
    public function rackUnsoldSocksSummary(Request $request){
        $shop_id      = Auth::user()->shop_id;
        $category_id  = $request->input('category_id');
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code = $rack_mapping->rack_code;
            $sql = "SELECT rp.type_id,t.types_name,count(*) as total,if(rp.type_id = 1, 'Pair', 'Pisces') as count_name FROM rack_products rp 
                    LEFT JOIN types t on rp.type_id = t.id
					left  join stocks st on rp.style_code = st.style_code 
                    WHERE rp.rack_code='$rack_code' and (rp.status=0 or rp.status=2)  and st.cat_id  = '$category_id'
                    GROUP by rp.type_id
                    ORDER BY t.sl_priority";
            $socks = DB::select(DB::raw($sql));
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "sold-information fetching success",
                "data"    => [
                    "socks" => $socks
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
