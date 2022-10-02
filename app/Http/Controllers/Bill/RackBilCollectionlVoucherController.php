<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RackBilCollectionlVoucherController extends Controller
{
    public function voucherList(){


        $sql = "SELECT sb.billing_year_month ,au.name as agent_name, sb.voucher_link, r.* from (SELECT s.NAME AS shop_name,
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
                     cm.entry_datetime,
                    (select sum(paid_amt) from partial_bill pb where status =0 and bill_no = cm.shoks_bill_no) as partial_bill 
              FROM   commissions cm
                     LEFT JOIN shops s
                            ON s.id = cm.shop_id
              GROUP  BY cm.shoks_bill_no   order by cm.shoks_bill_no desc) r
              LEFT join shock_bills sb on sb.shocks_bill_no = r.shoks_bill_no
              LEFT join agent_users au on au.id = sb.agent_id
              where sb.status = 0
              GROUP  BY sb.shocks_bill_no   order by r.shoks_bill_no desc";


        $vouchers = DB::select($sql);
        $data = [
            "vouchers" => $vouchers,
            "sl"       => 1
        ];
        return view('bill.rack.voucher.index', $data);
    }
    
    
     public function auth_voucher_list()
    {
        $sql = "SELECT sb.billing_year_month ,au.name as agent_name, sb.voucher_link, r.* from (SELECT s.NAME AS shop_name,
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
              GROUP  BY cm.shoks_bill_no   order by cm.shoks_bill_no desc) r
              LEFT join shock_bills sb on sb.shocks_bill_no = r.shoks_bill_no
              LEFT join agent_users au on au.id = sb.agent_id
              where sb.status = 1
              GROUP  BY sb.shocks_bill_no   order by r.shoks_bill_no desc";


        $vouchers = DB::select($sql);
        $data = [
            "vouchers" => $vouchers,
            "sl"       => 1
        ];
        return view('bill.rack.voucher.auth_bill', $data);
    }
}
