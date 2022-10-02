<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AverageReportController extends Controller
{
    public function index()
    {
        
        $products = DB::table('products as p')
        ->select(['br.name as brand_name', 'bs.name as brand_size_name', 't.types_name', 'p.packet_socks_pair_quantity', 'p.id as product_id', 'br.id as brand_id', 'bs.id as brand_size_id', 't.id as type_id'])
        ->leftJoin('brands as br', 'br.id', 'p.brand_id')
        ->leftJoin('brand_sizes as bs', 'bs.id', 'p.brand_size_id')
        ->leftJoin('types as t', 't.id', 'p.type_id')
        ->get();


        $shops = DB::table('shops')->select(['name', 'id'])->orderBy('name', 'asc')->get();
        $brand_size = DB::table('brand_sizes')->select(['name', 'id'])->orderBy('name', 'asc')->get();
        $types = DB::table('types')->select(['types_name', 'id'])->orderBy('types_name', 'asc')->get();

       $data  = [
            'products' => $products,
            'shops' => $shops,
            'brand_size' => $brand_size,
            'types' => $types
       ];
       return view('report.average_shop_report.index', $data);
    }


    public function show(Request $request)
    {
       $type_id = $request->type_id;
       $size_id = $request->size_id;
       $shop_id = $request->shop_id;
       $product_id = $request->product_id;
       $starting_date = date('Y-m-d', strtotime($request->starting_date));
       $ending_date = date('Y-m-d', strtotime($request->ending_date));

       if(!empty($type_id)) {
            $condition_sql = "st.type_id = '$type_id' and ";
       }else if(!empty($size_id)){
            $condition_sql = "st.brand_size_id = '$size_id' and ";
       }else if(!empty($product_id)){
            $condition_sql = "st.product_id = '$product_id' and ";
       }else if(!empty($shop_id)){
                $condition_sql = "rp.shop_id = '$shop_id' and ";
        }else{
           $condition_sql = '';
       }


       $sql = "SELECT br.NAME                           AS brand_name,
       ty.types_name,
       bs.NAME                           AS size_name,
       st.per_packet_shocks_quantity      AS per_packet_shocks_qty,
       rp.buying_price,
       rp.selling_price,
       st.per_packet_shocks_quantity,
       rp.status,
       rp.style_code,
       rp.printed_socks_code,
       st.print_packet_code,
       rp.venture_amount,
       date(rp.entry_date) as entry_date
       FROM   rack_products rp
               JOIN stocks st
               ON st.style_code = rp.style_code
               LEFT JOIN products pr
                   ON pr.id = st.product_id
               LEFT JOIN brands br
                   ON br.id = pr.brand_id
               LEFT JOIN types ty
                   ON ty.id = st.type_id
               LEFT JOIN brand_sizes bs
                   ON bs.id = st.brand_size_id
       WHERE $condition_sql   date(st.entry_date_time) between '$starting_date' and '$ending_date'  order by rp.entry_date desc, brand_name asc";


       $product_info  = DB::select($sql);


       $data = [
            'product_info' => $product_info,
            'starting_date' => $starting_date,
            'ending_date' => $ending_date
       ];


       return view('report.average_shop_report.show', $data);

    }




}
