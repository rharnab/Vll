<?php

namespace App\Http\Controllers\Accounts\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlTransactionsReportController extends Controller
{
    public function index(){
        $accounts= DB::table(DB::raw('gl_accounts ga'))
                ->select('acc_name','acc_no','asset_liability_status')
                ->get();
        $data = [
            "accounts" => $accounts
        ];
        // return $data;

        return view('gl.accounts.report.transaction.index', $data);
    }


    public function generate(Request $request){
        $account_no = $request->input('account_no');
        $from_date  = date('Y-m-d', strtotime($request->input('frm_date')));
        $to_date    = date('Y-m-d', strtotime($request->input('to_date')));

        if($account_no == "all"){
            $account_sql = "";
        }else{
            $account_sql = " where (dr_acc_no ='$account_no' or cr_acc_no ='$account_no') ";
        }

        $sql = "SELECT
                    dr.*,
                    ga.acc_name as dr_account_name,
                    cga.acc_name as cr_account_name 
                from
                    (
                    select
                        tr.acc_no as dr_acc_no,
                        tr.remarks,
                        tr.transaction_date,
                        tr.amount,
                        ui.name as authorized_user,
                        tr.authorized_at,
                        tracer_no,
                        (
                            select
                                acc_no 
                            from
                                `transaction` 
                            where
                                batch_no = tr.batch_no 
                                and trnTp = 'cr' 
                        )
                        as cr_acc_no 
                    from
                        `transaction` tr 
                        left join
                            users ui 
                            on tr.authorized_by = ui.id 
                    where
                        tr.trnTp = 'dr' 
                        and tr.status = 1 
                        and tr.transaction_date between '$from_date' and '$to_date' 
                    )
                    dr 
                    left join
                    gl_accounts ga 
                    on dr.dr_acc_no = ga.acc_no 
                    left join
                    gl_accounts cga 
                    on dr.cr_acc_no = cga.acc_no
                    $account_sql
                    order by transaction_date  desc";

        $transactions = DB::select($sql);

        $data = [
            "transactions" => $transactions,
            "from_date"    => $from_date,
            "account_no"   => $account_no,
            "to_date"      => $to_date
        ];

        return view('gl.accounts.report.transaction.details', $data );

    }
}
