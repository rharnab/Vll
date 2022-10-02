<?php

namespace App\Http\Controllers\Agent\Rack;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class RackBillCollectionController extends Controller
{
    public function rackList(){
        $agent_id = Auth::user()->agent_id;
        $racks = DB::select(DB::raw("SELECT r.*,s.name as shop_name FROM (SELECT rack_code,sum(selling_price) as total_due,shop_id FROM `rack_products`  
        WHERE agent_id = $agent_id and status=1 group by rack_code) r 
        left join shops s on r.shop_id = s.id;"));
        $data = [
            "racks" => $racks
        ];
        return view('agent.rack.bill-collection.rack-list', $data);
    }



    public function rackDetails($rack_id){
        $rack_code = Crypt::decrypt($rack_id);
        $agent_id  = Auth::user()->agent_id;
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
                            rp.printed_socks_code,
                            rp.shop_socks_code,
                            rp.shocks_code,
                            bd.name as brand_name,
                            bz.name as brand_size_name,
                            bz.id as brand_size_id,
                            rp.sold_mark_date_time,
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
                            and t.id = '$type_id' and rp.status=1 order by rp.sold_mark_date_time asc"));
             
            foreach ($shocks as $shock) {
                $single_shocks = [
                    "shocks_code"         => $shock->shocks_code,
                    "print_shocks_code"   => $shock->printed_socks_code,
                    "shop_socks_code"     => $shock->shop_socks_code,
                    "brand_name"          => $shock->brand_name,
                    "brand_size_name"     => $shock->brand_size_name,
                    "sold_mark_date_time" => $shock->sold_mark_date_time,
                    "shocks_type_id"      => $shock->type_id
                ];
                array_push($rack_shocks_array[$type_id]['shocks'], $single_shocks);
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

        
        return view('agent.rack.bill-collection.single-rack', $data);
    }



    public function calculateCommission(Request $request){
        if($request->has('shocks')){
            $shocks           = $request->input('shocks');
            $shop_id           = $request->input('shop_id');
            $total_shocks     = count($shocks);
            $total_amount     = 0;
            $commissions      = $this->getTotalShocksCommissions($total_shocks, $shop_id);
            $agent_commission = $commissions['agent_commission_persentage'];
            $shop_commission  = $commissions['shop_commission_persentage'];

            for($i=0; $i<$total_shocks; $i++){
                $total_amount += $this->singleShockSellPrice($shocks[$i]);
            }
            $data = [
                "total_shocks" => $total_shocks,
                "total_amount" => $total_amount,
                "agent_amount" => ($total_amount / 100) * $agent_commission,
                "shop_amount"  => ($total_amount / 100) * $shop_commission
            ];
            $html_render = view('agent.rack.bill-collection.commission-calculate', $data);
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
                <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
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
                <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-6 ">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                        <small class="m-0 l-h-n">Shop Comission</small>
                    </h3>
                </div>
                <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>

        <div class="col-6 ">
            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                        <small class="m-0 l-h-n">Agent Comission</small>
                    </h3>
                </div>
                <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>

        <div class="col-12">
            <button type="button" class="btn  btn-sm btn-danger waves-effect waves-themed w-100" disabled >  
                SELECT SOCKS FOR BILL COLLECTION
            </button>
        </div>
';
        }
    }





    public function socksBillCollection(Request $request){   
        if($request->has('shocks')){
            $shocks                  = $request->input('shocks');
            $rack_code               = $request->input('rack_code');
            $shop_id                 = $request->input('shop_id');
            $total_shocks            = count($shocks);
            $total_amount            = 0;
            $commissions             = $this->getTotalShocksCommissions($total_shocks, $shop_id);
            $agent_commission        = $commissions['agent_commission_persentage'];
            $shop_commission         = $commissions['shop_commission_persentage'];  
           

            for($i=0; $i<$total_shocks; $i++){
                $total_amount += $this->singleShockSellPrice($shocks[$i]);
            }

            $agent_commission_amount = ($total_amount / 100) * $agent_commission;
            $shop_commission_amount  = ($total_amount / 100) * $shop_commission;

            $venture_amount = $total_amount - ( $shop_commission_amount + $agent_commission_amount );

            $shocks_bill_no = $this->generateShockBillNo($rack_code, $shop_id);

            $entry_user_id  = Auth::user()->id;
            $entry_datetime = date('Y-m-d H:i:s');
            

            try{
                DB::table('shock_bills')->insert([
                    "agent_id"       => Auth::user()->agent_id,
                    "shop_id"        => $shop_id,
                    "rack_code"      => $rack_code,
                    "sales_quantity" => $total_shocks,
                    "collect_amount" => $total_amount,
                    "shocks_bill_no" => $shocks_bill_no,
                    "entry_user_id"  => $entry_user_id,
                    "entry_datetime" => $entry_datetime,
                    "voucher_link" => "backend/assets/voucher/rack-bill/$shocks_bill_no.pdf"
                ]);    
            }catch(Exception $e){
                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Bill table updated failed"
                ];
                return response()->json($data);
            }

            try{
                DB::table('commissions')->insert([
                    "shoks_bill_no"               => $shocks_bill_no,
                    "agent_id"                    => Auth::user()->agent_id,
                    "shop_id"                     => $shop_id,
                    "rack_code"                   => $rack_code,
                    "quantity"                    => $total_shocks,
                    "total_amount"                => $total_amount,
                    "shop_commission_percentage"  => $shop_commission,
                    "shop_commission_amount"      => $shop_commission_amount,
                    "agent_commission_percentage" => $agent_commission,
                    "agent_commission_amount"     => $agent_commission_amount,
                    "venture_amount"              => $venture_amount,
                    "entry_user_id"               => $entry_user_id,
                    "entry_datetime"              => $entry_datetime,
                ]);
            }catch(Exception $e){
                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => $e->getMessage()
                ];
                return response()->json($data);
            }
            
            

            for($i=0; $i<$total_shocks; $i++){
                $shock_code = $shocks[$i];
                DB::table('rack_products')->where('shocks_code', $shock_code)->update([
                    "shocks_bill_no"                 => $shocks_bill_no,
                    "agent_bill_collection_datetime" => $entry_datetime,
                    "agent_bill_collection_user_id"  => $entry_user_id,
                    "status"                         => 3
                ]);

                $shocks_info = DB::table('rack_products')->where('shocks_code', $shock_code)->first();
                $this->socksLog($shocks_info->id, "BILL_COLLECTION_FROM_SHOPKEEPER_BY_AGENT");
            }

            $this->generateRackShocksVoucher($shocks_bill_no);
            $data = [
                "status"   => 200,
                "is_error" => false,
                "bill_no"  => $shocks_bill_no,
                "message"  => "Bill collection successfully.Your voucher no is : $shocks_bill_no "
            ];
            return response()->json($data);
            
            
        }

    }



    public function  singleShockSellPrice($shocks_code){
        $shock = DB::table('rack_products')->where('shocks_code', $shocks_code)->select('selling_price')->first();
        return $shock->selling_price ?? 0;
    }



    public function generateRackShocksVoucher($shocks_bill_no){


        $shop_info = DB::table('shock_bills as sb')
            ->select([
                's.name  as shop_name',
                's.address  as shop_address'
            ])
            ->leftJoin('shops as s', 'sb.shop_id', '=', 's.id')
            ->where('shocks_bill_no', $shocks_bill_no)
            ->first();

        $shop_info = [
            "shop_name"      => $shop_info->shop_name,
            "shop_address"   => $shop_info->shop_address,
            "shocks_bill_no" => $shocks_bill_no,
            "memo_date"      => date('Y-m-d')
        ];

        $shocks_sql = "SELECT
                            b.name as brand_name,
                            bs.name as brand_size_name,
                            count(*) as quantity,
                            sum(rp.selling_price) as amount 
                        from
                            rack_products rp 
                            left join
                            stocks s 
                            on rp.style_code = s.style_code 
                            left join
                            brands b 
                            on s.brand_id = b.id 
                            left join
                            brand_sizes bs 
                            on s.brand_size_id = bs.id 
                        where
                            rp.shocks_bill_no = '$shocks_bill_no' 
                        group by
                            s.brand_id,
                            s.brand_size_id";

        $shcoks_datas = DB::select(DB::raw($shocks_sql));

        $data = [
            "shop_info"    => $shop_info,
            "shcoks_datas" => $shcoks_datas,
            "sl"           => 1
        ];

        $pdf      = PDF::loadView('rack.bill-collection.voucher', $data);
        $path     = public_path('backend/assets/voucher/rack-bill/');
        $fileName = $shocks_bill_no. '.pdf';
        $pdf->save($path . '/' . $fileName); 
    }




    public function generateShockBillNo($rack_code, $shop_id){
        $shop          = DB::table('shops')->select('name')->where('id', $shop_id)->first();
        $shop_name     = $shop->name;
        $billSerial    = DB::table('shock_bills')->where('rack_code', $rack_code)->where('shop_id', $shop_id)->count();
        $billno        = $billSerial + 1;
        $socks_bill_no = strtolower($shop_name)."-".strtolower($rack_code)."-".$billno;
        $socks_bill_no = join("-", explode(" ", $socks_bill_no));
        return $socks_bill_no;
    }

}