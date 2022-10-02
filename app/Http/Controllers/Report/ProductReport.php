<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReport extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function product()
    {
    	$get_data = DB::select(DB::raw("SELECT p.id, b.name as brand_name,bs.name as brand_size_name, types.types_name, p.packet_socks_pair_quantity, p.packet_buying_price,p.packet_selling_price, p.individual_buying_price,p.individual_selling_price, p.entry_date, p.entry_time   FROM `products` p left join brands b on p.brand_id=b.id left join brand_sizes bs on p.brand_size_id=bs.id left join types on p.type_id=types.id order by brand_name asc"));

    	 return view('report.product.index', compact('get_data'));
    }
}
