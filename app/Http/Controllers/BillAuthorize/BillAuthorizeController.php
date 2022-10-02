<?php

namespace App\Http\Controllers\BillAuthorize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;

class BillAuthorizeController extends Controller
{
    public function index()
    {
        $all_bill = DB::table('shock_bills')->where('status', 0)->get();
    }
}
