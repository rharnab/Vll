<?php

namespace App\Http\Controllers\Agent\Rack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RackBillVoucherController extends Controller
{
    public function voucherList(){
        $agent_id = Auth::user()->agent_id;
die;
       $sql = "SELECT sb.voucher_link, r.* from (SELECT s.NAME AS shop_name,
                     cm.shop_id,
                     cm.rack_code,
                     cm.shoks_bill_no,
                     Sum(quantity) AS total_socks,
                     Sum(total_amount)  AS total_paid_amount,
                     Sum(shop_commission_amount) AS total_shop_commission,
                     Sum(agent_commission_amount) AS total_agent_commission,
                     Sum(venture_amount) AS total_venture_amount,

                     (cm.shop_commission_amount * 100) / cm.total_amount as shop_commission_parcent,
                     (cm.agent_commission_amount * 100) / cm.total_amount as agent_commission_parcent,
                     cm.entry_datetime
              FROM   commissions cm
                     LEFT JOIN shops s
                            ON s.id = cm.shop_id
              WHERE  cm.agent_id = '$agent_id'
              GROUP  BY cm.shoks_bill_no   order by cm.shoks_bill_no desc) r
              LEFT join shock_bills sb on sb.shocks_bill_no = r.shoks_bill_no
              GROUP  BY sb.shocks_bill_no   order by r.shoks_bill_no desc; ";





        $vouchers = DB::select($sql);

        $data = [
            "vouchers" => $vouchers,
            "sl"       => 1
        ];
        return view('agent.rack.voucher.index', $data);
    }
}
