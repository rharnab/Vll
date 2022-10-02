<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AreaWiseReportController extends Controller
{
    public function index()
    {
        $all_area= DB::table('area_list')->select('area')->where('area', '<>', '')->groupBy('area')->orderBy('area', 'asc')->get();
        $all_market= DB::table('shops')->select('market_name')->where('market_name', '<>', '')->groupBy('market_name')->orderBy('market_name', 'asc')->get();


        $data = [
            'all_area' => $all_area,
            'all_market' => $all_market
        ];

        return view('report.area_wise_report.index', $data);
       
    }

    public function show(Request $request)
    {
       $area = str_replace(',', '', $request->area);
       $market_name = str_replace(',','', $request->market);
       $purpose = $request->purpose;
        
       if(!empty($area )) {
                $area_sql = "and  s.area like '%".$area."%' ";
       }else{
         $area_sql = " ";
       }


       if(!empty($market_name )) {
        $market_sql = "and s.market_name like '%".$market_name."%' ";
       }else{
        $market_sql = " ";
       }

      


       if($purpose == 1) {
            $sql = "SELECT s.*, au.name as agent_name,
            sum(rp.selling_price) as total_sale_price, sum(rp.shop_commission) as total_shop_commistion, sum(rp.agent_commission), sum(rp.venture_amount) as total_venture_amt
            from shops s
            left join rack_products rp on rp.shop_id = s.id 
            left join agent_users au on au.id  = rp.agent_id
            where rp.status in (1,3) $area_sql $market_sql
            group by rp.shop_id ";
       }else{

             $sql = "SELECT s.*, au.name as agent_name from shops s
                    left join rack_mapping rm on rm.shop_id  = s.id 
                    left join agent_users au on au.id  = rm.agent_id 
                    where s.name <> '' $area_sql $market_sql ";
       }

     $shop_info = DB::Select($sql);

     $data = [
        'market_name' => $market_name,
        'shop_info' => $shop_info
     ];


     return view('report.area_wise_report.show', $data);

     



    }
}
