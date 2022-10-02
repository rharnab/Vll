<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ShopVoucherReport extends Controller
{
    public function index()
    {
        $data = DB::table('shop_refill_voucher as sv')
            ->leftJoin('shops as s', 's.id', '=', 'sv.shop_id')
            ->select(['sv.*', 's.name'])
            ->get();

       return view('report.shop-voucher.index', compact('data'));

    }
}
