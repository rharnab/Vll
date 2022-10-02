<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RackFillUpReport extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $shops = DB::table('shops as s')
                ->join('rack_mapping as rp', 'rp.shop_id', '=', 's.id')
                ->select('s.name', 'rp.rack_code')
                ->orderBy('s.id', 'asc')->get();
       
        return view('report.rack-fillup.index', compact('shops'));
    }

    public function details(Request $request)
    {
        $rack_code = $request->rack_code;
        $fill_type = $request->fill_type;

        if($fill_type > 0)
        {
            $fill_sql = "AND rp.fill_type = '$fill_type' ";
        }else{
            $fill_sql = " ";
        }

        //for show detals product
        $sql ="SELECT br.NAME                           AS brand_name,
                    ty.types_name,
                    bs.NAME                           AS size_name,
                    st.per_packet_shocks_quantity      AS per_packet_shocks_qty,
                    rp.buying_price,
                    rp.selling_price,
                    Count(st.product_id)               AS packet_qty,
                    Sum(st.per_packet_shocks_quantity) AS total_shocks,
                    Sum(rp.buying_price)       AS total_by_price,
                    Sum( rp.selling_price)      AS total_sale_price
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
            WHERE  rp.rack_code = '$rack_code'
                    $fill_sql
            GROUP  BY st.product_id";

        $data = DB::select($sql);


        //product summarry 
        $sum_sql = "SELECT sum(total_shocks) as t_shocks, sum(total_by_price) as t_buy_price, sum(total_sale_price) as t_sale_price from 
        (SELECT br.NAME                           AS brand_name,
               ty.types_name,
               bs.NAME                           AS size_name,
               st.per_packet_shocks_quantity      AS per_packet_shocks_qty,
               rp.buying_price,
               rp.selling_price,
               Count(st.product_id)               AS packet_qty,
               Sum(st.per_packet_shocks_quantity) AS total_shocks,
               Sum(rp.buying_price)       AS total_by_price,
               Sum( rp.selling_price)      AS total_sale_price
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
        WHERE  rp.rack_code = '$rack_code'
                            $fill_sql
        GROUP  BY st.product_id)
        stc";

        $summation = DB::select($sum_sql);

        $shop_info = DB::table('rack_products as rp')
                    ->join('shops as s', 's.id', '=', 'rp.shop_id')
                    ->select('s.name as shop_name', 'rp.rack_code')
                    ->where('rp.rack_code', $rack_code)->first();



        



        $datas = [

            'data' => $data,
            'rack_code' => $rack_code,
            'summation' => $summation,
            'shop_info' =>$shop_info

        ];
        

        return view('report.rack-fillup.details', $datas);



    }

    
}
