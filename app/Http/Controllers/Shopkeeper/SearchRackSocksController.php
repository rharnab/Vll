<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchRackSocksController extends Controller
{
    public function searchSocks(Request $request){
        $search_socks_code = $request->input('search_socks_code');
        $rack_code         = $request->input('rack_code');
        $sql               = "SELECT
                                rp.shocks_code,
                                rp.shop_socks_code,
                                rp.printed_socks_code,
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
                                and 
                                (
                                rp.status = 0 
                                or rp.status = 2
                                )
                                and ( rp.shop_socks_code LIKE '%-$search_socks_code%' or  rp.printed_socks_code LIKE '%$search_socks_code%' )
                            order by
                                rp.printed_socks_code asc";
                                file_put_contents('m.txt', $sql);
        $socks = DB::select(DB::raw($sql));

        $data = [
            "socks" => $socks
        ];

        $view =  view('shopkeeper.search-rack-socks', $data)->render();
        return response()->json(['html' => $view]);


    }

}
