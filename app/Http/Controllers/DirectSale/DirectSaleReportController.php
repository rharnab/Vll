<?php

namespace App\Http\Controllers\DirectSale;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class DirectSaleReportController extends Controller
{
    public function index(){
            $sql = "SELECT
            ss.*,
            a.name as agent_name,
            s.name as shop_name,
            sb.total_paid,
            sb.total_due_amount
        from
            (
            SELECT
                agent_id,
                shop_id,
                voucher_no,
                status,
                count(*) total_socks_paid,
                sum(ind_selling_price) as total_amount,
                entry_date,
                entry_time 
            from
                single_sales
            where status=1 
            group by
                voucher_no,
                agent_id,
                shop_id,
                status
            )
            ss 
            left join
            agent_users a 
            on ss.agent_id = a.id 
            left join
            shops s 
            on ss.shop_id = s.id 
            
            LEFT JOIN single_sales_bill sb 
            on ss.voucher_no = sb.voucher_no
        ORDER by
            entry_date,
            entry_time";
        $vouchers = DB::select(DB::raw($sql));
        $data = [
            "vouchers" => $vouchers,
            "sl"       => 1
        ];
        return view('direct-sale.report.index', $data);
    }
}
