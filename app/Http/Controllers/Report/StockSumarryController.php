<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockSumarryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lots_no  = DB::table('stocks')->select('lot_no')->orderBy('id', 'desc')->groupBy('lot_no')->get();
        return view('report.stock-summary.index', compact('lots_no'));

    }
 
    public function details(Request $request)
    {
        $lot_no = $request->lot_no;

        if($lot_no !=0)
        {
            $condition = " WHERE s.lot_no='$lot_no' ";
        }else{
            $condition = " ";
        }
        $sql = "SELECT br.NAME                           AS brand_name,
                ty.types_name,
                bs.NAME                           AS size_name,
                s.per_packet_shocks_quantity as per_packet_shocks_qty,
                s.individual_buy_price,
                s.individual_sale_price,
                Count(s.product_id)               AS packet_qty,
                Sum(s.per_packet_shocks_quantity) AS total_shocks,
                Sum(s.individual_buy_price)       AS total_by_price,
                Sum(s.individual_sale_price)      AS total_sale_price
        FROM   stocks s
                LEFT JOIN products pr
                    ON pr.id = s.product_id
                LEFT JOIN brands br
                    ON br.id = pr.brand_id
                LEFT JOIN types ty
                    ON ty.id = s.type_id
                LEFT JOIN brand_sizes bs
                    ON bs.id = s.brand_size_id
        $condition
        GROUP  BY product_id
        ORDER  BY brand_name ASC";
        $data = DB::select($sql);


        $sum_sql = "SELECT sum(total_shocks) as t_shocks, sum(total_by_price) as t_buy_price, sum(total_sale_price) as t_sale_price from (SELECT br.NAME AS brand_name, s.product_id, Sum(s.per_packet_shocks_quantity) AS total_shocks, Sum(s.individual_buy_price) AS total_by_price, Sum(s.individual_sale_price) AS total_sale_price FROM stocks s LEFT JOIN products pr ON pr.id = s.product_id LEFT JOIN brands br ON br.id = pr.brand_id LEFT JOIN types ty ON ty.id = s.type_id LEFT JOIN brand_sizes bs ON bs.id = s.brand_size_id $condition GROUP BY product_id ORDER BY brand_name ASC) stc";
        $summation = DB::select($sum_sql);



        $datas = [

            'data' => $data,
            'lot_no' => $lot_no,
            'summation' => $summation

        ];

       

        return view('report.stock-summary.details', $datas);

        


    }



}
