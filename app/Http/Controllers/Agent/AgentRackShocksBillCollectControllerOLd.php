<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
class AgentRackShocksBillCollectControllerOld extends Controller
{
    public function billCollect(Request $request){


        if($request->has('shocks')){

            $shocks                  = $request->input('shocks');
            $rack_code               = $request->input('rack_code');
            $shop_id                 = $request->input('shop_id');
            $total_shocks            = count($shocks);
            $total_amount            = 0;
            $commissions             = $this->getTotalShocksCommissions($total_shocks);
            $agent_commission        = $commissions['agent_commission_persentage'];
            $shop_commission         = $commissions['shop_commission_persentage'];  
           

            for($i=0; $i<$total_shocks; $i++){
                $total_amount += $this->singleShockSellPrice($shocks[$i]);
            }

            $agent_commission_amount = ($total_amount / 100) * $agent_commission;
            $shop_commission_amount  = ($total_amount / 100) * $shop_commission;

            $venture_amount = $total_amount - ( $shop_commission_amount + $agent_commission_amount );

            $shocks_bill_no = date('YmdHis').$rack_code.$shop_id;

            $entry_user_id  = Auth::user()->id;
            $entry_datetime = date('Y-m-d H:i:s');

            if(date('d') > 5){
                $starting_date  = date('Y-m-01');
                $ending_date    = date("Y-m-t");
            }else{
                $starting_date  = date('Y-m-d', strtotime('first day of last month'));
                $ending_date    = date('Y-m-d', strtotime('last day of previous month'));
            }

            $bill_check = DB::table('shock_bills')->where('starting_date', $starting_date)->where('ending_date', $ending_date)->where('rack_code', $rack_code)->count();
            if($bill_check < 0){
                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Already collected $starting_date To $ending_date date range bill"
                ];
                return response()->json($data);
            }

            try{
                DB::table('shock_bills')->insert([
                    "agent_id"       => Auth::user()->agent_id,
                    "shop_id"        => $shop_id,
                    "rack_code"      => $rack_code,
                    "sales_quantity" => $total_shocks,
                    "collect_amount" => $total_amount,
                    "shocks_bill_no" => $shocks_bill_no,
                    "starting_date"  => $starting_date,
                    "ending_date"    => $ending_date,
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
                    "starting_date"               => $starting_date,
                    "ending_date"                 => $ending_date,
                    "entry_user_id"               => $entry_user_id,
                    "entry_datetime"              => $entry_datetime,
                ]);
            }catch(Exception $e){
                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Commission table updated failed"
                ];
                return response()->json($data);
            }
            
            

            for($i=0; $i<$total_shocks; $i++){
                $shock_code = $shocks[$i];
                DB::table('rack_products')->where('shocks_code', $shock_code)->update([
                    "sold_timestamp" => $entry_datetime,
                    "shocks_bill_no" => $shocks_bill_no,
                    "status"         => 1
                ]);
            }

            $this->generateRackShocksVoucher($shocks_bill_no);

            $data = [
                "status"   => 200,
                "is_error" => false,
                "bill_no"  => $shocks_bill_no,
                "message"  => "Bill collection successfully"
            ];
            return response()->json($data);
            
            
        }
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
            "shcoks_datas" => $shcoks_datas
        ];

        $pdf      = PDF::loadView('rack.bill-collection.voucher', $data);
        $path     = public_path('backend/assets/voucher/rack-bill/');
        $fileName = $shocks_bill_no. '.pdf';
        $pdf->save($path . '/' . $fileName); 
    }

}
