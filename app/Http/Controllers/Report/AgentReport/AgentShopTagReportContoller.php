<?php

namespace App\Http\Controllers\Report\AgentReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentShopTagReportContoller extends Controller
{
    public function index()
    {
        return view('report.agent-shop.index');
    }

    public function TagDetails(Request $request)
    {
        
        $frm = date('Y-m-d', strtotime($request->frm_date));
        $to = date('Y-m-d', strtotime($request->to_date));
        $sql = "SELECT au.NAME AS agent_name,
                        u.mobile_number,
                        au.present_address,
                        au.email,
                        Count(rm.agent_id) as total_shop,
                        rm.agent_id
                FROM   agent_users au
                        LEFT JOIN rack_mapping rm
                            ON rm.agent_id = au.id
                        LEFT JOIN users u
                            ON u.agent_id = au.id
                        LEFT JOIN roles r
                            ON r.id = u.role_id
                WHERE  Date(rm.entry_datetime) BETWEEN '$frm' AND '$to'
                GROUP  BY rm.agent_id ";

        $agent_result = DB::select($sql);

        

        return view('report.agent-shop.details', compact('agent_result'));
        
    }
    public function shop_details(Request $request)
    {
       $agent_id =  $request->agent_id;
        $sql = "SELECT s.NAME AS shop_name,
                        s.contact_no,
                        s.owner_contact,
                        s.shop_address,
                        rm.rack_code,
                        au.name  as agent_name,
                        (select count(us.style_code) as unsold_socks from rack_products us where us.rack_code= rm.rack_code and us.status in (0,2)) as unsold_socks,
                        (select count(s.style_code) as sold_socks from rack_products s where s.rack_code= rm.rack_code and s.status in (1,3)) as sold_socks,
                        (select count(b.style_code) as bill_receive_socks from rack_products b where b.rack_code= rm.rack_code and b.status=7) as bill_receive_socks,
                        (select sum(selling_price - shop_commission) as bill_receive_socks from rack_products ba where ba.rack_code= rm.rack_code and ba.status=7) as bill_receive_amount
                FROM   rack_mapping rm
                        LEFT JOIN shops s
                            ON s.id = rm.shop_id
                        LEFT JOIN rack_products rp
                            ON rp.rack_code = rm.rack_code
                    LEFT JOIN agent_users au
                            ON rp.agent_id  = au.id
                WHERE  rm.agent_id = '$agent_id' 
                GROUP  BY rp.rack_code 
                order by s.NAME asc";

       $shop_details =  DB::select($sql);
       if(count($shop_details) > 0)
       {
            $output = view('report.agent-shop.shop-info-details', compact('shop_details'));
            return $output;
       }    
      

       
    }



}
