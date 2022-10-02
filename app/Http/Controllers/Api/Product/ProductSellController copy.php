<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductSellController extends Controller
{
    /**
     * Product Sell
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
	 *		"message": "socks sold successfully"
	 *	}
     */
    public function productSold(Request $request){
		$validator = Validator::make($request->all(), [ 
            'product_code'      => 'required'
        ],[
            'product_code.required' => 'product code not found',
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

				
		$product_info = DB::table('rack_products')->where('printed_socks_code', $product_code)->first();
        if($product_info){

            $current_month = date('m');
            $current_year  = date('Y');
            $rack_code = $product_info->rack_code;
    
            $sql                       = "SELECT count(*) as total from rack_products rp where  rack_code ='$rack_code' and status = 1 and month(sold_date) = '$current_month' and year(sold_date) = '$current_year'";
            $total_sold                = DB::select(DB::raw($sql));
            $total_monthly_sales_count = $total_sold[0]->total;
    
            $commissions              = $this->getTotalShocksCommissions($total_monthly_sales_count, Auth::user()->shop_id, $cat_id=1);
            $shop_commission_parcent  = $commissions['shop_commission_persentage'];

            $shop_commission = ($product_info->selling_price / 100) * $shop_commission_parcent;
            $venture_amount  = ($product_info->selling_price - $shop_commission);

            
            if($product_info->status == 0 or $product_info->status == 2){
                try{
                    DB::table('rack_products')->where('printed_socks_code', $product_code)->update([
                        "status"              => 1,
                        "sold_mark_date_time" => date('Y-m-d H:i:s'),
                        "is_shopkeeper_sold"  => 1,
                        "sold_date"           => date('Y-m-d'),
                        "sold_mark_user_id"   => Auth::user()->id,
                        "shop_commission"     => $shop_commission,
                        "agent_commission"    => '0.00',
                        "venture_amount"      => $venture_amount
                    ]);
                    $data = [
                        "status"  => 200,
                        "success" => true,
                        "message" => "socks sold successfully"
                    ];
                    return response()->json($data);
                }catch(Exception $e){
                    $data = [
                        "status"  => 400,
                        "success" => false,
                        "message" => $e->getMessage()
                    ];
                    return response()->json($data);
                }
            }else{
                $data = [
                    "status"  => 400,
                    "success" => false,
                    "message" => "socks-code not available for sold"
                ];
                return response()->json($data);
            }
        }else{
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => "socks-code not found"
            ];
            return response()->json($data);
        }

	}
}
