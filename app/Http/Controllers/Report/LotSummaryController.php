<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class LotSummaryController extends Controller
{
    public function index(){
        

         $lots = DB::select(DB::raw("SELECT * FROM `lots` where lot_no <> ''  "));

       

         return view('report.lots-report.index', compact('lots'));

    }

    public function details(Request $request)
    {

    	$lot_no = Crypt::decrypt($request->lot_no);

    	$lot_details = DB::select(" SELECT s.style_code,br.name as brand, s.product_id, bs.name as size_name, s.per_packet_shocks_quantity,s.stock_in_date,s.stock_out_date,s.packet_buy_price,s.individual_buy_price, s.packet_sale_price,s.individual_sale_price, ai.name as agent_name,s.amount_receive_date,s.market_sales_price, s.voucher_no, s.lot_no, types.types_name FROM `stocks` s left join products pr on pr.id = s.product_id left join brands br on br.id = s.brand_id left join brand_sizes bs on bs.id = s.brand_size_id left join product_categories pc on pc.id = s.product_category_id left join types t on t.id = s.type_id LEFT JOIN agent_users ai on s.sales_agent_id = ai.id left join types on s.type_id=types.id where s.lot_no = '$lot_no' order by brand asc   "); 

    	return view('report.lots-report.details', compact('lot_details'));
    }
}
