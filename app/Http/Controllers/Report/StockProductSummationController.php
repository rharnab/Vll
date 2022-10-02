<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockProductSummationController extends Controller
{
    public function index(){
        $categories = DB::table('category')->get();
        $types  = DB::table('types')->get();
        $data = [
            "categories" => $categories,
            "types"      => $types
        ];
        return view('report.stock.product-summation.index', $data);
    }


    public function generate(Request $request){
        $category_id   = $request->input('category_id');
        $type_id       = $request->input('type_id');
        $starting_date = $request->input('starting_date');
        $ending_date   = $request->input('ending_date');
        $starting_date = date('Y-m-d', strtotime($starting_date));
        $ending_date   = date('Y-m-d', strtotime($ending_date));

        if($category_id != "all"){
            $category_sql = " and st.cat_id='$category_id' ";
        }else{
            $category_sql = "";
        }


        if($type_id != "all"){
            $type_sql = " and st.type_id='$type_id' ";
        }else{
            $type_sql = "";
        }

        $sql = "SELECT t.types_name,c.name  as product_name,st.cat_id,st.type_id, sum(st.remaining_socks) as remaining_product ,sum(st.total_buy_price) as total_buy_price,sum(st.total_sell_price) as total_sell_price  from (
            select remaining_socks ,type_id,cat_id,(individual_buy_price * remaining_socks) as total_buy_price, (individual_sale_price * remaining_socks) as total_sell_price  from stocks st 
            where st.remaining_socks > 0 and date(st.entry_date_time) between '$starting_date' and '$ending_date'  $category_sql $type_sql
            ) st 
            left join types t on st.type_id  = t.id
            left join category c on st.cat_id = c.id
            group by type_id ";
            
        $products = DB::select(DB::raw($sql));
        $data = [
            "products" => $products
        ];
        return view('report.stock.product-summation.report_view', $data);
    }

}
