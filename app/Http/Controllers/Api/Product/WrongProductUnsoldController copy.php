<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WrongProductUnsoldController extends Controller
{
     /**
     * Product Un-Sold
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  product_code string required . Example: SC20412211
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "SC20412211 product unsold mark successfully"
	 *	}
     */
    public function wrongSoldProductUnsold(Request $request){
        $validator = Validator::make($request->all(), [ 
            'product_code'      => 'required'
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
        $product_info = DB::table('rack_products')->select('status')->where('printed_socks_code', $product_code)->get();
        if(count($product_info) > 0){

            if($product_info[0]->status == '1'){
                
                DB::table('rack_products')->where('printed_socks_code', $product_code)->update([
                    "status"           => 0,
                    "sold_date"        => '0000-00-00',
                    "venture_amount"   => 0,
                    "agent_commission" => 0,
                    "shop_commission"  => 0
                ]);
                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "$product_code product unsold mark successfully"
                ];
                return response()->json($data);

            }else{
                $data = [
                    "status"  => 400,
                    "success" => false,
                    "message" => "product are not available for unsold"
                ];
                return response()->json($data);
            }

        }else{
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => "product code not found"
            ];
            return response()->json($data);
        }
        
    }
}
