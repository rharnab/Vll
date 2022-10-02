<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class BillDueController extends Controller
{
    public function index(){
       
        if(Auth::user()->role_id=='1'){

          $condition = "";

        }elseif(Auth::user()->role_id=='2'){
             $user_id = Auth::user()->agent_id;
            $condition = " WHERE agent_id='$user_id' ";
        }else{

            $condition = "";
        }
        
        $data = DB::select(DB::raw("select * from (SELECT s.name as shop_name,au.name as agent_name,s.shop_address,s.contact_no,s.owner_contact,s.market_name,s.area,rack.total_due, rack.total_venture_amount ,rack.due_pair,(SELECT entry_datetime FROM `shock_bills` WHERE rack_code=rack.rack_code order by entry_datetime desc limit 1) as last_collect_bill_datetime FROM (SELECT rack_code,shop_id,agent_id,sum(selling_price) as total_due, sum(venture_amount) as total_venture_amount , count(*) as due_pair from rack_products WHERE status = 1 group by rack_code) rack
        left join shops s on rack.shop_id = s.id
        left join agent_users au on au.id = rack.agent_id $condition 
        order by rack.total_due desc) bill "));

        return view('report.bill-due-report.index', compact('data'));
    }
}
