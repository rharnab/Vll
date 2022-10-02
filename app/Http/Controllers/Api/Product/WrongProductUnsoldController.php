<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

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
                    //"sold_date"        => '0000-00-00',
                    "venture_amount"   => 0,
                    "agent_commission" => 0,
                    "shop_commission"  => 0
                ]);

            }else{
                $data = [
                    "status"  => 400,
                    "success" => false,
                    "message" => "product are not available for unsold"
                ];
                return response()->json($data);
            }


            $sold_date_info = DB::table('rack_products')
                                ->select(['sold_date', 'rack_code', 'shop_id'])
                                ->where('printed_socks_code', $product_code)
                                ->groupBy('sold_date')->get();

            

                foreach($sold_date_info as $single_sold_date_info)
                {
                    $bill_date = $single_sold_date_info->sold_date;
                    $rack_code = $single_sold_date_info->rack_code;
                    $shop_id = $single_sold_date_info->shop_id;
                    
                    $cat_month= date('m', strtotime($bill_date));
                    $cat_year= date('Y', strtotime($bill_date));

                    $all_category =DB::select("SELECT rp.rack_code, st.style_code, st.cat_id, rp.sold_date from rack_products rp 
                    left JOIN stocks st on st.style_code = rp.style_code
                    where rp.rack_code = '$rack_code' and rp.status in (1,3,7) and month(rp.sold_date)='$cat_month' and year(rp.sold_date) = '$cat_year'
                    GROUP by st.cat_id");
                    foreach($all_category as $single_category)
                    {
                        $this->updateScoksCommission($rack_code, $shop_id, $bill_date, $single_category->cat_id); //update commmission
                    }

                    $rackBillUpdate= $this->monthlyBillCollection($rack_code, $shop_id, $bill_date);//update monthly bill

                    if($rackBillUpdate['status'] ==200){
                        $data = [
                            "status"  => 200,
                            "success" => true,
                            "message" => "$product_code product unsold mark successfully"
                        ];
                        
                    }
                }

                return response()->json($data);
            

          

            return response()->json($rackBillUpdate); 

                 if($rackBillUpdate['status'] ==200){

                        $data = [
                            "status"  => 200,
                            "success" => true,
                            "message" => "$product_code product unsold mark successfully"
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
                $this->DeleteMonthlyBill($rack_code, $shop_id, $year_month);
                return $response;
            }catch(Exception $e){
                $response = [
                    "status" => 400,
                    "is_error" => true,
                    "message" => $e->getMessage()
                ];
                return $response;
            }
            

        }else{
                
            $this->DeleteMonthlyBill($rack_code, $shop_id, $year_month);
        }






    }


    public function updateScoksCommission($rack_code, $shop_id, $bill_date, $cat_id)
    {
        $month = date('m', strtotime($bill_date));
        $year = date('Y', strtotime($bill_date));

        $total_monthly_sales_count = DB::table('rack_products as rp')
        ->leftJoin('stocks as st', 'st.style_code', 'rp.style_code')
        ->where([
            'rp.shop_id' => $shop_id,
            'rp.rack_code' => $rack_code,
        ])
        ->whereIn('rp.status', [1,3,7])
        ->whereMonth('rp.sold_date', $month)
        ->whereYear('rp.sold_date', $year)
        ->where('st.cat_id', $cat_id)
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



    public function DeleteMonthlyBill($rack_code, $shop_id, $year_month)
    {
          
          

           $rack_monthly_bill = DB::table('rack_monthly_bill')
                ->select('sold_socks_pair')
                ->where([
                    ['shop_id', '=', $shop_id],
                    ['rack_code', '=', $rack_code],
                ])
                ->where('billing_year_month', $year_month)
                ->first();

         if($rack_monthly_bill->sold_socks_pair ==0)
         {
             $rack_monthly_bill = DB::table('rack_monthly_bill')
                ->where([
                    ['shop_id', '=', $shop_id],
                    ['rack_code', '=', $rack_code],
                ])
                ->where('billing_year_month', $year_month)
                ->delete();
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
}
