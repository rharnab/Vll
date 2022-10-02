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
            $shop_id = $product_info->shop_id;
            $sold_date =  date('Y-m-d');

            
            if($product_info->status == 0 or $product_info->status == 2){
                try{
                    DB::table('rack_products')->where('printed_socks_code', $product_code)->update([
                        "status"              => 1,
                        "sold_mark_date_time" => date('Y-m-d H:i:s'),
                        "is_shopkeeper_sold"  => 1,
                        "sold_date"           => date('Y-m-d'),
                        "sold_mark_user_id"   => Auth::user()->id,
                    ]);

                    $shocks_info = DB::table('rack_products')->where('printed_socks_code', $product_code)->first();
                    $this->socksLog($shocks_info->id, "SOCKS_SOLD_BY_SHOPKEEPER");

                }catch(Exception $e){
                    $data = [
                        "status"  => 400,
                        "success" => false,
                        "message" => $e->getMessage()
                    ];
                    return response()->json($data);
                }


             /*--------------shocks commission ------------------------*/
             $cat_month= date('m', strtotime($sold_date));
             $cat_year= date('Y', strtotime($sold_date));
     
             $sql                       = "SELECT rp.rack_code, st.style_code, st.cat_id, rp.sold_date from rack_products rp 
             left JOIN stocks st on st.style_code = rp.style_code
             where rp.rack_code = '$rack_code' and rp.status in (1,3,7) and month(rp.sold_date)='$cat_month' and year(rp.sold_date) = '$cat_year'
             GROUP by st.cat_id";
             $total_sold                = DB::select(DB::raw($sql));
             //$total_monthly_sales_count = $total_sold[0]->total;
 
             foreach($total_sold as $single_category) // update commission
             {
                 $socks_commission_updated = $this->updateScoksCommission($rack_code, $shop_id, $sold_date, $single_category->cat_id);
             }

             if($socks_commission_updated['is_error'] === false){
                $monthly_bill_calculate = $this->monthlyBillCollection($rack_code, $shop_id, $sold_date); // update monthly rack bill 
             }

             if($monthly_bill_calculate['is_error'] === false){

                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "socks sold successfully"
                ];

                return response()->json($data);
             }else{

                $data = [
                    "status"  => 400,
                    "success" => false,
                    "message" => "Monthly update bill fail"
                ];
                
                return response()->json($data);
             }

             
                    
                    
                    //return response()->json($data);
                
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


    //update shop commission 

    public function updateScoksCommission($rack_code, $shop_id, $bill_date, $cat_id)
    {
        $month = date('m', strtotime($bill_date));
        $year = date('Y', strtotime($bill_date));

        $total_monthly_sales_count = DB::table('rack_products')->where([
            'shop_id' => $shop_id,
            'rack_code' => $rack_code,
        ])
        ->whereIn('status', [1,3,7])
        ->whereMonth('sold_date', $month)
        ->whereYear('sold_date', $year)
        ->count('*');


        $commissions      = $this->getTotalShocksCommissions($total_monthly_sales_count, $shop_id, $cat_id);
        $agent_commission_parcent = $commissions['agent_commission_persentage'];
        $shop_commission_parcent  = $commissions['shop_commission_persentage'];
        $is_officer = $this->getOfficer($rack_code);
        if( (string) $is_officer !='')
        {
            if($is_officer == 1) // if rack registered for officer
            {
                $venture_commission_parcent  = 100 - $shop_commission_parcent;

                $sql = "UPDATE rack_products rp
                        left join stocks st on st.style_code = rp.style_code
                        set
                        rp.shop_commission = (rp.selling_price / 100)* $shop_commission_parcent, 
                        rp.venture_amount = (rp.selling_price / 100)* $venture_commission_parcent,
                        rp.agent_commission = 0            
                        where
                        rp.rack_code = '$rack_code' 
                        and rp.shop_id = '$shop_id' 
                        and rp.status in   (1,3,7)
                        and month(rp.sold_date)='$month' 
                        and year(rp.sold_date)='$year'
                        and st.cat_id= '$cat_id' ";

            }else{ // if rack registered for agent

                $venture_commission_parcent  = 100 - ($agent_commission_parcent + $shop_commission_parcent);

                $sql = "UPDATE rack_products rp
                left join stocks st on st.style_code = rp.style_code
                 set
                 rp.shop_commission = (rp.selling_price / 100)* $shop_commission_parcent, 
                 rp.venture_amount = (rp.selling_price / 100)* $venture_commission_parcent,
                 rp.agent_commission = (rp.selling_price / 100)* $agent_commission_parcent            
               where
               rp.rack_code = '$rack_code' 
                  and rp.shop_id = '$shop_id' 
                  and rp.status in   (1,3,7)
                  and month(rp.sold_date)='$month' 
                  and year(rp.sold_date)='$year'
                  and st.cat_id= '$cat_id' ";

            }

        }else{
            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => "Shop agent not found",
            ];
            return $data;
        }
        
        $query = DB::statement($sql);

      


        if($query)
        {
           $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => "commission calculate success",
            ];

            return $data;
        }else{

              $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Rack Procucts update not found",
                ];

              return $data;

        }
    }


    public function getOfficer($rack_code)
    {
        $result = DB::select("SELECT u.is_officer
        FROM   rack_products rp
               LEFT JOIN users u
                      ON u.agent_id = rp.agent_id
        WHERE  rp.rack_code = '$rack_code'
        GROUP  BY rp.rack_code ");

        if(count($result) > 0)
        {
            $result =  $result[0];
            return $result->is_officer;
        }else{
            return '';
        }
    }

     /* -------------------Update monthly bill collection------------------------  */

     public function monthlyBillCollection($rack_code, $shop_id, $bill_date)
     {
 
           $month = date('m', strtotime($bill_date));
           $year = date('Y', strtotime($bill_date));
 
           $year_month = $year."-".$month;
 
 
         $sql= "SELECT 
                 sum(selling_price) as total_amount,
                 sum(shop_commission) as shop_commission,
                 sum(agent_commission) as agent_commission,
                 sum(venture_amount) as venture_amount,
                 count(*) as total_sock_pair 
             FROM `rack_products` 
             WHERE  rack_code='$rack_code' and shop_id = '$shop_id' 
             and status in (1,3,7) 
             and month(sold_date)='$month' and year(sold_date)='$year'";
 
             
 
         //$commissions      = $this->getTotalShocksCommissions($total_sock_pair, $shop_id);
 
 
         $bill_info = DB::select($sql);
         $bill_info = $bill_info[0];
         $sold_socks_pair = $bill_info->total_sock_pair;
         $total_amount = $bill_info->total_amount;
         $total_shopkeeper_amount = $bill_info->shop_commission;
         $total_agent_amount = $bill_info->agent_commission;
         $total_venture_amount = $bill_info->venture_amount;
 
         // check duplicate 
         $duplicate = DB::table('rack_monthly_bill')
         ->where([
             ['shop_id', '=', $shop_id],
             ['rack_code', '=', $rack_code],
         ])
         ->where('billing_year_month', $year_month)
         ->count('*');
 
         if( $duplicate > 0 ) { // already exits thats why update
             try{
                 DB::table('rack_monthly_bill')
                 ->where([
                     ['shop_id', '=', $shop_id],
                     ['rack_code', '=', $rack_code],
                 ])
                 ->where('billing_year_month', $year_month)
                 ->update([
                     'sold_socks_pair' =>$sold_socks_pair,
                     'total_amount' => $total_amount,
                     'total_shopkeeper_amount' => $total_shopkeeper_amount,
                     'total_agent_amount' => $total_agent_amount,
                     'total_venture_amount' => $total_venture_amount
                 ]);
 
                 $response = [
                     "status" => 200,
                     "is_error" => false,
                     "message" => "Monthly bill table updated"
                 ];
                 return $response;
             }catch(Exception $e){
                 $response = [
                     "status" => 400,
                     "is_error" => true,
                     "message" => $e->getMessage()
                 ];
                 return $response;
             }
             
 
         }else{ // not found = insert
             try{
                 DB::table('rack_monthly_bill')->insert([
                     'shop_id' => $shop_id,
                     'rack_code' =>$rack_code,
                     'billing_year_month' => date('Y-m', strtotime($bill_date)),
                     'sold_socks_pair' =>$sold_socks_pair,
                     'total_amount' => $total_amount,
                     'total_shopkeeper_amount' => $total_shopkeeper_amount,
                     'total_agent_amount' => $total_agent_amount,
                     'total_venture_amount' => $total_venture_amount
                 ]);
                  $response = [
                     "status" => 200,
                     "is_error" => false,
                     "message" => "Monthly bill table updated"
                 ];
                 return $response;
             }catch(Exception $e){
                 $response = [
                     "status" => 400,
                     "is_error" => true,
                     "message" => $e->getMessage()
                 ];
                 return $response;
             }
             
         }
 
     }
 
 /* -------------------Update monthly bill collection------------------------  */



}
