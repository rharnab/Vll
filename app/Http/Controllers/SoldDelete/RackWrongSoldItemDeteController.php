<?php

namespace App\Http\Controllers\Agent\SoldDelete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class RackWrongSoldItemDeteController extends Controller
{
    public function rackList(){
        if(Auth::user()->is_officer ==1)
        {
            $agent_sql = '';
        }else{
            $agent_user_id = Auth::user()->agent_id;
            $agent_sql = "and agent_id = '$agent_user_id' ";
        }
        
        $shop_racks_sql = "SELECT
                        rack.rack_code,
                        s.name as shop_name 
                    FROM
                        (
                        SELECT
                            rack_code,
                            shop_id 
                        from
                            rack_products 
                        where
                              status=1 $agent_sql
                        GROUP by
                            shop_id,
                            rack_code
                        )
                        rack 
                        left join
                        shops s 
                        on rack.shop_id = s.id";
        $shop_racks = DB::select(DB::raw($shop_racks_sql));
        $data = [
            "shop_racks" => $shop_racks
        ];
        return view('agent.sold-delete.rack-list', $data);
    }

    // show rack sold details
    public function rackSoldInformation($rack_code){
        $rack_code = Crypt::decrypt($rack_code);
        $rack_shocks_array = [];

        $sql ="SELECT
                    t.types_name,
                    t.id,
                    sum(rp.total) as socks_pair 
                FROM
                    (
                    SELECT
                        style_code,
                        count(*) as total 
                    FROM
                        rack_products 
                    WHERE
                        rack_code = '$rack_code' 
                        and 
                        (
                            status = 1
                        )
                    GROUP by
                        style_code 
                    )
                    rp 
                    LEFT JOIN
                    stocks st 
                    on rp.style_code = st.style_code 
                    LEFT JOIN
                    types t 
                    on st.type_id = t.id 
                GROUP by
                    t.types_name 
                ORDER by
                t.sl_priority asc";

        $rack_style_sizes = DB::select(DB::raw($sql));

        foreach($rack_style_sizes as $rack_style_size){
            $rack_shocks_array[$rack_style_size->id] = [
                "type_id" => $rack_style_size->id,
                "name"    => $rack_style_size->types_name,
                "total"   => $rack_style_size->socks_pair,
                "shocks"  => []
            ];
        }


        foreach ($rack_style_sizes as $rack_style_size) {
            $type_id = $rack_style_size->id;
            $shocks = DB::select(DB::raw("SELECT
                            rp.shocks_code,
                            rp.printed_socks_code,
                            rp.shop_socks_code,
                            bd.name as brand_name,
                            bz.name as brand_size_name,
                            t.id as type_id 
                        FROM
                            `rack_products` rp 
                            left JOIN
                            stocks st 
                            on rp.style_code = st.style_code 
                            left JOIN
                            brands bd 
                            on st.brand_id = bd.id 
                            LEFT JOIN
                            brand_sizes bz 
                            on st.brand_size_id = bz.id 
                            LEFT JOIN
                            types t 
                            on st.type_id = t.id 
                        where
                            rp.rack_code = '$rack_code' 
                            and t.id = '$type_id' 
                            and rp.status = 1"));
            foreach ($shocks as $shock) {
                $single_shocks = [
                    "shocks_code"       => $shock->shocks_code,
                    "print_shocks_code" => $shock->printed_socks_code,
                    "shop_socks_code"   => $shock->shop_socks_code,
                    "brand_name"        => $shock->brand_name,
                    "brand_size_name"   => $shock->brand_size_name,
                    "shocks_type_id"    => $shock->type_id
                ];
                array_push($rack_shocks_array[$rack_style_size->id]['shocks'], $single_shocks);
            }
        }


        $rack_info = DB::select(DB::raw("SELECT
                        rp.*,
                        s.name as shop_name 
                    FROM
                        (
                        SELECT
                            shop_id,
                            rack_code 
                        from
                            rack_products 
                        WHERE
                            rack_code = '$rack_code' 
                        GROUP by
                            rack_code,shop_id
                        )
                        rp 
                        left join
                        shops s 
                        on rp.shop_id = s.id"));

        $data = [
            "rack_shocks_array" => $rack_shocks_array,
            "rack_info"         => $rack_info
        ];  
        return view('agent.sold-delete.single-rack', $data);
    }


    // calculate delete socks and amount
    public function calculateSocks(Request $request){
        if($request->has('shocks')){
            $shocks           = $request->input('shocks');
            $shop_id          = $request->input('shop_id');
            $total_shocks     = count($shocks);
            $total_amount     = 0;

            for($i=0; $i<$total_shocks; $i++){
                $total_amount += $this->singleShockSellPrice($shocks[$i]);
            }
            $data = [
                "total_shocks" => $total_shocks,
                "total_amount" => $total_amount
            ];
            $html_render = view('agent.sold-delete.commission-calculation', $data);
            return $html_render;
        }else{
            return ' <div class="col-6 ">
            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="selected_shocks" style="font-size: 18px;">0 Pair</span>
                        <small class="m-0 l-h-n">Sales Socks Pair</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-6 ">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                        <small class="m-0 l-h-n">Total Bill</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="button" class="btn  btn-sm btn-danger waves-effect waves-themed w-100" disabled >  
                SELECT SOCKS PAIR
            </button>
        </div>
';
        }
    }



    // unsold mark socks
    public function unsoldSoldItems(Request $request){
        if($request->has('shocks')){
            $shocks                  = $request->input('shocks');
            $rack_code               = $request->input('rack_code');
            $shop_id                 = $request->input('shop_id');
            $total_shocks            = count($shocks);

           

            for($i=0; $i<$total_shocks; $i++){
                $shock_code = $shocks[$i];
                DB::table('rack_products')->where('shocks_code', $shock_code)->update([
                    "status"              => 0,
                    "sold_mark_date_time" => '',
                    "sold_mark_user_id"   => '',
                    "shop_commission"   => 0,
                    "venture_amount"   => 0,
                    "agent_commission"   => 0,
                ]);

                $shocks_info = DB::table('rack_products')->where('shocks_code', $shock_code)->first();
                $this->socksLog($shocks_info->id, "WRONG_SOLD_SOCKS_UNSOLD_MARK_BY_AGENT");
            }


             $sold_date_info = DB::table('rack_products')
                                ->select('sold_date')
                                ->whereIn('shocks_code', $shocks)
                                ->groupBy('sold_date')->get();

            foreach($sold_date_info as $single_sold_date_info)
            {
                 $bill_date = $single_sold_date_info->sold_date;

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
                
                 $this->monthlyBillCollection($rack_code, $shop_id, $bill_date);//update monthly bill

            }

            /*--------------shocks commission ------------------------*/
            


            $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => "$total_shocks pair socks unsold mark successfully"
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
