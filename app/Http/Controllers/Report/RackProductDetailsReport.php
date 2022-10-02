<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RackProductDetailsReport extends Controller
{
    public function __Construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
         $racks = DB::table('racks')->select('rack_code')->get();
         return view('report.rack-product-details.index', compact('racks'));
    }

    public function details(Request $request)
    {

         $rack_code = $request->rack_code;
         $rack_status = $request->rack_status;

         if($rack_status == '')
         {
             $rack_status_sql = " ";
         }else if($rack_status == 8)
         {
            $rack_status_sql = "and rp.status in (0,2) ";
         }else{
            $rack_status_sql = "and rp.status= '$rack_status' ";
         }

        
         



         $sql = "SELECT br.NAME                           AS brand_name,
        ty.types_name,
        bs.NAME                           AS size_name,
        st.per_packet_shocks_quantity      AS per_packet_shocks_qty,
        rp.buying_price,
        rp.selling_price,
        st.per_packet_shocks_quantity,
        rp.buying_price,
        rp.selling_price,
        rp.status,
        rp.style_code,
        rp.printed_socks_code,
        st.print_packet_code,
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
        WHERE  rp.rack_code = '$rack_code' $rack_status_sql order by rp.entry_date desc, brand_name asc";

         $data = DB::select($sql);

         $datas = [
             'rack_code' => $rack_code,
             'data' => $data
         ];

         return view('report.rack-product-details.data', $datas);

       
    }

}
