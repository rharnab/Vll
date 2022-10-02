<?php

namespace App\Http\Controllers\Report\CashReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotReportController extends Controller
{
    public function index()
    {
        return view('report.cash-report.lot-report.index');
    }
    public function lot_info(Request $request)
    {
        $frm =  date('Y-m-d', strtotime($request->frm_date));
        $to =  date('Y-m-d', strtotime($request->to_date));

        $status = $request->status;

        if($status == 2) // sold
        {

            $lots = DB::select("SELECT si.lot_no,
            Sum(per_packet_shocks_quantity) as total_shocks,
                        Sum(packet_buy_price) as total_buying_price,
                        Sum(packet_sale_price) as total_saling_price,
                        sum(remaining_socks) as total_remaining_socks,
                        si.sold_socks
                FROM   (SELECT s.lot_no            AS lot_no,
                                Count(s.style_code) AS sold_socks
                        FROM   stocks s
                                LEFT JOIN rack_products rp
                                    ON rp.style_code = s.style_code
                        WHERE  rp.status  IN ( 1,3,7 ) and date(s.entry_date_time) BETWEEN '$frm' and '$to'
                        GROUP  BY s.lot_no) si
                left  join stocks s2 on s2.lot_no  = si.lot_no 
                group  by s2.lot_no 
                order by s2.id  asc ");

            $summation  = DB::select("SELECT  Sum(si.total_shocks)     AS grand_total_shocks,
            Sum(si.total_buying_price)  AS grand_total_buy_price,
            Sum(si.total_saling_price) AS grand_total_sale_price,
            sum(si.total_remaining_socks) as grand_total_remaining_socks,
            Count(si.lot_number) as grand_total_lot,
            sum(si.sold_socks) as grand_total_sold_socks
    
            from (SELECT si.lot_no,
                
                    Sum(per_packet_shocks_quantity) as total_shocks,
                    Sum(packet_buy_price) as total_buying_price,
                    Sum(packet_sale_price) as total_saling_price,
                    sum(remaining_socks) as total_remaining_socks,
                    si.sold_socks,
                    si.lot_no  as lot_number
            FROM   (SELECT s.lot_no            AS lot_no,
                        Count(s.style_code) AS sold_socks
                    FROM   stocks s
                        LEFT JOIN rack_products rp
                                ON rp.style_code = s.style_code
                    WHERE  rp.status IN ( 1,3,7 ) and date(s.entry_date_time) BETWEEN '$frm' and '$to'
                    GROUP  BY s.lot_no) si
            left  join stocks s2 on s2.lot_no  = si.lot_no 
            group  by s2.lot_no 
            order by s2.id  asc) si ");
           

        }else if($status == 3){ // unsold

            $lots = DB::select("SELECT si.lot_no,
                    Sum(per_packet_shocks_quantity) as total_shocks,
                                Sum(packet_buy_price) as total_buying_price,
                                Sum(packet_sale_price) as total_saling_price,
                                sum(remaining_socks) as total_remaining_socks,
                                si.unsold_socks
                        FROM   (SELECT s.lot_no            AS lot_no,
                                        Count(s.style_code) AS unsold_socks
                                FROM   stocks s
                                        LEFT JOIN rack_products rp
                                            ON rp.style_code = s.style_code
                                WHERE  rp.status IN ( 0, 2 ) and date(s.entry_date_time) BETWEEN '$frm' and '$to'
                                GROUP  BY s.lot_no) si
                        left  join stocks s2 on s2.lot_no  = si.lot_no 
                        group  by s2.lot_no 
                        order by s2.id  asc ");

                    $summation  = DB::select("SELECT  Sum(si.total_shocks)     AS grand_total_shocks,
                    Sum(si.total_buying_price)  AS grand_total_buy_price,
                    Sum(si.total_saling_price) AS grand_total_sale_price,
                    sum(si.total_remaining_socks) as grand_total_remaining_socks,
                    Count(si.lot_number) as grand_total_lot,
                    sum(si.unsold_socks) as grand_total_unsold_socks
            
                    from (SELECT si.lot_no,
                        
                            Sum(per_packet_shocks_quantity) as total_shocks,
                            Sum(packet_buy_price) as total_buying_price,
                            Sum(packet_sale_price) as total_saling_price,
                            sum(remaining_socks) as total_remaining_socks,
                            si.unsold_socks,
                            si.lot_no  as lot_number
                    FROM   (SELECT s.lot_no            AS lot_no,
                                Count(s.style_code) AS unsold_socks
                            FROM   stocks s
                                LEFT JOIN rack_products rp
                                        ON rp.style_code = s.style_code
                            WHERE  rp.status IN ( 0, 2 ) and date(s.entry_date_time) BETWEEN '$frm' and '$to'
                            GROUP  BY s.lot_no) si
                    left  join stocks s2 on s2.lot_no  = si.lot_no 
                    group  by s2.lot_no 
                    order by s2.id  asc) si ");

        }else{

            $lots = DB::select("SELECT lot_no,
            Sum(per_packet_shocks_quantity) as total_shocks,
            Sum(packet_buy_price) as total_buying_price,
            Sum(packet_sale_price) as total_saling_price,
            sum(remaining_socks) as total_remaining_socks
            FROM   stocks
            WHERE  Date(entry_date_time) BETWEEN '$frm' AND '$to' and cat_id = 1
            GROUP  BY lot_no
            ORDER  BY id ASC ");

        $summation  = DB::select("SELECT Sum(s.total_shocks)     AS grand_total_shocks,
                        Sum(s.total_buy_price)  AS grand_total_buy_price,
                        Sum(s.total_sale_price) AS grand_total_sale_price,
                        Sum(s.total_remaining_socks) AS grand_total_remaining_socks,
                        Count(s.lot_number) as grand_total_lot
                FROM   (SELECT Sum(per_packet_shocks_quantity) AS total_shocks,
                                Sum(packet_buy_price)           AS total_buy_price,
                                Sum(packet_sale_price)          AS total_sale_price,
                                sum(remaining_socks) as total_remaining_socks,
                                lot_no                          AS lot_number
                        FROM   stocks
                        WHERE  Date(entry_date_time) BETWEEN '$frm' AND '$to'
                        GROUP  BY lot_no) s ");

        }

        switch ($status) {
            case '2':
                $status_type = 'Sold Shocks';
                break;

            case '3':
                $status_type = 'UnSold Shocks';
                break;
            
            default:
                $status_type = 'Stock';
                break;
        }

       
                                
        $data = [
            'lots' => $lots,
            'summation' => $summation,
            'status_type' => $status_type,
            'status' => $status
        ];

        return view('report.cash-report.lot-report.details', $data);
    }

    public function lotInfoDetails(Request $request)
    {
        $lot_no  =  $request->lot_no;
        $sql = "SELECT b.NAME AS brand_name,
                    t.types_name,
                    bs.name as size_name,
                    s.per_packet_shocks_quantity,
                    count(s.product_id) as total_packet,
                    s.packet_buy_price,
                    sum(s.packet_buy_price) as total_buy_price,
                    s.packet_sale_price,
                    sum(s.packet_sale_price) as total_sale_price,
                    sum(per_packet_shocks_quantity) as total_shocks,
                    sum(remaining_socks) as total_remaining_socks,
                    s.lot_no
                FROM   stocks s
                    LEFT JOIN brands b
                            ON b.id = s.brand_id
                    LEFT JOIN types t
                            ON t.id = s.type_id
                    LEFT JOIN brand_sizes bs
                            ON bs.id = s.brand_size_id
                where  date(s.entry_date_time) and  s.lot_no= '$lot_no'
                group by s.product_id, s.type_id
                order by s.lot_no asc ";
        
       $lot_details =  DB::select($sql);
       
       if(count($lot_details) > 0)
       {
           $output = view('report.cash-report.lot-report.lot-info-details', compact('lot_details'));
           return $output;
       }
    }
}
