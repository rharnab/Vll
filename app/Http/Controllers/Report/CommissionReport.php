<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionReport extends Controller
{
    public function index()
    {
         $shops = DB::table('shops')->orderBy('id', 'asc')->get();
        return view('report.commission.index', compact('shops'));
    }

    public function details(Request $request)
    {
         $shop_id =  $request->shop_id;

         $shop_info = DB::table('shops')->select('name')->where('id', $shop_id)->first();

         if($shop_id > 0 )
         {
            $data =  DB::table('commission_setups  as cs')
             ->leftjoin('shops as s', 's.id', '=', 'cs.shop_id')
             ->select('cs.*', 's.name as shop_name')
             ->where('cs.shop_id', $shop_id)->get();
         }else{
            $data =  DB::table('commission_setups  as cs')->select('cs.*')->where('cs.shop_id', 0 )->get();
         }

         $datas  = [
            'data' => $data,
            'shop_name'=> $shop_info
         ];
        return view('report.commission.details', $datas);
        

    }


}
