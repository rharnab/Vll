<?php

namespace App\Http\Controllers\BillPaymentAuthorize;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillPaymentAuthorizeController extends Controller
{
    public function index()
    {
       
        $get_data = DB::select(DB::raw("SELECT sb.id, au.name as agent_name,sh.name as shop_name,
         sb.agent_id,sb.shop_id,sb.rack_code,
        sb.shocks_bill_no,sb.billing_year_month,
         sum(sales_quantity) total_sales_quantity, SUM(collect_amount) as total_collect_amt,
         (SELECT sum(shop_commission) FROM `rack_products` WHERE `shocks_bill_no` = sb.shocks_bill_no ) as total_shop_commission,
         (select sum(pb.paid_amt) from partial_bill pb where pb.bill_no = sb.shocks_bill_no) as total_paid_amt
         
         FROM `shock_bills` sb LEFT JOIN agent_users au ON sb.agent_id = au.id 
         LEFT JOIN shops sh on sb.shop_id=sh.id WHERE sb.status='0' GROUP BY sb.shocks_bill_no 
         ORDER BY date(sb.entry_datetime) desc
         "));


        return view('bill_authorize.index', compact('get_data'));
    } // end index function

    public function single_submit(Request $request)
    {
        if ($request->ajax()) {

            $socks_bill_id = $request->socks_bill_id;

            $get_socks_data = DB::table('shock_bills')->where('id', $socks_bill_id)->first();
            $shocks_bill_no = $get_socks_data->shocks_bill_no;

            $update = DB::table('shock_bills')->where('shocks_bill_no', "$shocks_bill_no")->update([

                "status" => 1,
                'auth_dateTime' => date('Y-m-d H:i:s'),
                'auth_user_id' => Auth::user()->id
            ]);

            DB::table('rack_products')->where('shocks_bill_no', "$shocks_bill_no")->update([

                "status" => 7,
                'auth_dateTime' => date('Y-m-d H:i:s'),
                'auth_user_id' => Auth::user()->id

            ]); //status 7=bill authorize

        } else {
            echo 'This request is not ajax !';
        }
    } // single-submit function

    public function show_details(Request $request)
    {

        $shocks_bill_no = $request->shocks_bill_no;

        $get_data_shocks_bill = DB::table('shock_bills')
            ->where('shocks_bill_no', $shocks_bill_no)->first();

        $rack_code = $get_data_shocks_bill->rack_code;

        $get_commission_data = DB::select(DB::raw("SELECT c.id,au.name as agent_name,
        sh.name as shop_name,
        c.billing_year_month,c.rack_code 
        FROM `commissions` c LEFT JOIN agent_users au ON c.agent_id=au.id
         LEFT JOIN shops sh on c.shop_id=sh.id WHERE c.`shoks_bill_no`='$shocks_bill_no'
          and c.billing_year_month not in (SELECT mrb.year_and_month 
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code' and mrb.bill_no='$shocks_bill_no')  "));


        $get_single_commission_data = DB::select(DB::raw("SELECT count(*) as total_month, c.id,au.name as agent_name,
        sh.name as shop_name,c.shoks_bill_no,
        c.billing_year_month,c.rack_code, c.entry_user_id,Sum(c.agent_commission_amount) AS agent_commission_amount,
                                            Sum(c.shop_commission_amount) AS shop_commission_amount,
                                            SUM(c.total_amount) as total_bill,
                                            (select sum(buying_price)  from rack_products rp where rp.shocks_bill_no ='$shocks_bill_no' ) as factory_bill
        FROM `commissions` c LEFT JOIN agent_users au ON c.agent_id=au.id
         LEFT JOIN shops sh on c.shop_id=sh.id WHERE c.`shoks_bill_no`='$shocks_bill_no'
          and c.billing_year_month not in (SELECT mrb.year_and_month 
          from monthly_rack_conveynce_bill mrb where mrb.rack_id='$rack_code' and mrb.bill_no ='$shocks_bill_no' )"))[0];

        $entry_user_id = $get_single_commission_data->entry_user_id;

        $entry_user_id = $get_single_commission_data->entry_user_id;

        //check convenience bill monthly
        $billing_year_month = $get_single_commission_data->billing_year_month;

        $get_convence = DB::table('monthly_rack_conveynce_bill as mb')
            ->select(['amount', 'is_officer'])
            ->leftJoin('rack_mapping as rm', 'rm.rack_code', '=', 'mb.rack_id')
            ->leftJoin('users as u', 'u.agent_id', '=', 'rm.agent_id')
            ->where([
                ['mb.year_and_month', '=', $billing_year_month],
                ['mb.rack_id', '=', $rack_code],
                ['u.is_officer', '=', 0]
            ])->get();

        if (count($get_convence) > 0) {
            $is_agent_convence_pay = 1;
        } else {
            $is_agent_convence_pay = 0;
        }


        $get_user_data  = DB::table('users')->where('id', $entry_user_id)->first();

        $single_array = [];
        foreach ($get_commission_data as $single_commission_data) {
            $single_commission_data->billing_year_month;
            array_push($single_array, $single_commission_data->billing_year_month);
        }


        $billing_month = implode(" -- ", $single_array);

        $conveynce_bill_parameter = DB::table('convence_bill_parameter')->first();

        $total_paid = DB::table('partial_bill')->where('bill_no', $shocks_bill_no)->sum('paid_amt');
        $last_partial_info  = DB::table('partial_bill as pb')
        ->select('au.name as agent_name', 'u.name as auth_name', 'pb.*')
        ->leftJoin('users as au', 'au.id', '=', 'pb.select_employee')
        ->leftJoin('users as u', 'u.id', '=', 'pb.auth_by')
        ->where('pb.bill_no', $shocks_bill_no)
        ->orderBy('pb.id', 'desc')->first();
        $total_convence_paid = DB::table('partial_bill')->where('bill_no', $shocks_bill_no)->sum('convence_amt');

        $agent_user = DB::table('users')->whereIn('role_id', [2, 8])->get();

        return view('bill_authorize.show_details', compact('get_data_shocks_bill', 'get_single_commission_data', 'billing_month', 'conveynce_bill_parameter', 'agent_user', 'get_user_data', 'is_agent_convence_pay', 'total_paid', 'total_convence_paid', 'last_partial_info'));
    } // end show detaiuls

    public function agent_or_officer_conveynce_bill_submit(Request $request)
    {

        if ($request->ajax()) {

            
            $conveynce_month = $request->conveynce_month;

            $conveynce_month_exp = explode("--", $conveynce_month);


            $bill_no = $request->bill_no;
            $shop_name = $request->shop_name;
            $rack_no = $request->rack_no;
            $bill_receive_employee_type = $request->bill_receive_employee_type;
            $select_emp = $request->select_emp;
            $enter_amt = str_replace(",", "", $request->enter_amt);
            $total_month = $request->total_month;
            $paid_amount = str_replace(",", "", $request->paid_amount);
            $bill_due_amount = str_replace(",", "", $request->bill_due_amount);

            $venture_amount = $this->getVentureAmount($bill_no); // get venture bill amount

            if ($paid_amount > $bill_due_amount) {

                $data = [
                    "is_error" => true,
                    "message"  => "Sorry !! Please check Due amount"
                ];
                return response()->json($data);
            } else if ($paid_amount < $bill_due_amount) {
               $store_parital_paid = $this->StorePartialPayment($conveynce_month, $bill_no, $shop_name, $rack_no, $bill_receive_employee_type, $select_emp, $enter_amt, $total_month, $venture_amount['amount'], $paid_amount);
               if($store_parital_paid['is_error'] == false){
                return response()->json($store_parital_paid);
               }
            } else {

               $store_parital_paid = $this->StorePartialPayment($conveynce_month, $bill_no, $shop_name, $rack_no, $bill_receive_employee_type, $select_emp, $enter_amt, $total_month, $venture_amount['amount'], $paid_amount);

                $partial_paid_bill = $this->getPartialPayment($bill_no); // 

                if ($bill_receive_employee_type == "Agent") {
                    $get_agent_commission = $request->get_agent_commission;
                } else {
                    $get_agent_commission = 0;
                }


                $final_amt = $partial_paid_bill['total_convence_amt'] / $total_month;

                foreach ($conveynce_month_exp as $single_year_month) {

                    //################ check if bill already paid ############


                    $get_data_count = DB::table('monthly_rack_conveynce_bill')
                        ->where('year_and_month', 'LIKE', "%$single_year_month%")
                        ->where('bill_no', "$bill_no")
                        ->where('rack_id', $rack_no)
                        ->count();


                    if ($get_data_count > 0) {
                        echo '0';
                        die;
                    }

                    DB::table('monthly_rack_conveynce_bill')->insert([
                        "year_and_month" => $single_year_month,
                        "bill_no"   => $bill_no,
                        "auth_by"   => Auth::user()->id,
                        "shop_name"   => $shop_name,
                        "rack_id"   => $rack_no,
                        "amount"   => $final_amt,
                        "auth_date"   => date('Y-m-d h:i:s a'),
                        "bill_receive_emp_type"   => $bill_receive_employee_type,
                        "bill_receive_emp_id"   => $select_emp,
                        "agent_commission"   => $get_agent_commission,
                    ]);
                } // end foreach 

                try {

                    $update = DB::table('shock_bills')->where('shocks_bill_no', $bill_no)->update([

                        "status" => 1,
                        'auth_dateTime' => date('Y-m-d H:i:s'),
                        'auth_user_id' => Auth::user()->id
                    ]);

                    DB::table('rack_products')->where('shocks_bill_no', $bill_no)->update([
                        "status" => 7,
                        'auth_dateTime' => date('Y-m-d H:i:s'),
                        'auth_user_id' => Auth::user()->id
                    ]); //status 7=bill authorize


                    $this->UpdatePartialBill($bill_no);// update partisal bill status

                    $this->insertSocksLog($bill_no);
                    $this->billAccount($bill_no, $partial_paid_bill['total_convence_amt'], $get_agent_commission);
                } catch (Exception $e) {
                    $data = [
                        "is_error" => true,
                        "message"  => 'Shocks Bill Update fail'
                    ];
                    return response()->json($data);
                }
            }
        } else {
            echo "This is not ajax request";
        }
    } //end agent_or_officer_conveynce_bill_submit function


    public function insertSocksLog($bill_no)
    {
        $socks_data = DB::table('rack_products')->select('id')->where('shocks_bill_no', $bill_no)->get();
        foreach ($socks_data as $socks) {
            $this->socksLog($socks->id, "SOCKS_BILL_VOUCHER_AUTHORIZE");
        }
    }






    #######################  bill athorize accounting ##################################
    function billAccount($shocks_bill_no, $convence, $agent_commission)
    {
        $retail_bill_amt  = DB::table('commissions')->where('shoks_bill_no', $shocks_bill_no)
            ->groupBy('shoks_bill_no')
            ->sum(DB::raw('total_amount - shop_commission_amount'));

        $retail_acc_no = '900005'; //RETAIL SALES BILL RECEIVE
        $cash_in_hand_acc_no = '100004'; //CASH IN HAND
        $convence_acc_no = '100011'; // CONVEYANCE
        $commission_acc_no = '100031'; // other account 


        $net_bill_amt = $retail_bill_amt - ($convence + $agent_commission);
        #################### for convence  BIll #####################

        if ($convence > 0) {
            $debit_result = $this->debitGl($retail_acc_no, $convence);
            if ($debit_result['is_error'] == false) {
                $this->CreditGl($convence_acc_no, $convence);
            } else {
                return response()->json($debit_result);
            }
        }

        #################### for convence  BIll #####################

        #################### for Commission  BIll #####################
        if ($agent_commission > 0) {

            $debit_result = $this->debitGl($retail_acc_no, $agent_commission);
            if ($debit_result['is_error'] == false) {
                $this->CreditGl($commission_acc_no, $agent_commission);
            } else {
                return response()->json($debit_result);
            }
        }
        #################### for Commission  BIll #####################


        #################### for net shocks  BIll #####################
        if ($net_bill_amt != 0) {

            $debit_result = $this->debitGl($retail_acc_no, $net_bill_amt);
            if ($debit_result['is_error'] == false) {
                $this->CreditGl($cash_in_hand_acc_no, $net_bill_amt);
            } else {
                return response()->json($debit_result);
            }
        }

        #################### for net shocks  BIll #####################

    }

    public function debitGl($account_no, $amount)
    {
        $sql = "UPDATE gl_accounts  SET gl_bal = gl_bal - $amount  WHERE acc_no = '$account_no'";
        try {
            DB::update(DB::raw($sql));
            return [
                "is_error" => false,
                "message"  => "Balance reduce successfully"
            ];
        } catch (Exception $e) {
            return [
                "is_error" => true,
                "message"  => $e->getMessage()
            ];
        }
    }

    public function CreditGl($account_no, $amount)
    {
        $sql = "UPDATE gl_accounts  SET gl_bal = gl_bal + $amount  WHERE acc_no = '$account_no'";
        try {
            DB::update(DB::raw($sql));
            return [
                "is_error" => false,
                "message"  => "Balance increased successfully"
            ];
        } catch (Exception $e) {
            return [
                "is_error" => true,
                "message"  => $e->getMessage()
            ];
        }
    }
    #######################  bill athorize accounting ##################################


    ########################## partial bill function ######################
    public function getVentureAmount($shocks_bill_no)
    {
        $venture_amount = DB::table('rack_products')->where('shocks_bill_no', $shocks_bill_no)->sum('venture_amount');
        file_put_contents('wp.txt', $shocks_bill_no);
        if ($venture_amount > 0) {
            $data = [
                'status' => 200,
                'is_error' => false,
                'amount' => (int) $venture_amount
            ];
        } else {
            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => "Sorry bill number not match"
            ];
        }

        return $data;
    }

    public function StorePartialPayment($conveynce_month, $bill_no, $shop_name, $rack_no, $bill_receive_employee_type, $select_emp, $enter_amt, $total_month, $venture_amount, $paid_amount)
    {
         $partial_paid_bill = $this->getPartialPayment($bill_no);
        
        try {

            DB::table('partial_bill')->insert([
                'convenience_month' => $conveynce_month,
                'bill_no' => $bill_no,
                'shop_name' => $shop_name,
                'rack_no' => $rack_no,
                'employee_type' => $bill_receive_employee_type,
                'select_employee' => $select_emp,
                'convence_amt' => $enter_amt,
                'total_month' => $total_month,
                'auth_by' => Auth::user()->id,
                'auth_date' => date('Y-m-d H:i:s'),
                'venture_amt' => $venture_amount,
                'paid_amt' => $paid_amount,
                'total_paid' =>  $paid_amount + $partial_paid_bill['total_paid_amt'],
                'total_convence' => $enter_amt + $partial_paid_bill['total_convence_amt'],
                'status' => 0
            ]);

            $data = [
                "is_error" => false,
                "message"  => "Partial bill receive success"
            ];
            return $data;
        } catch (Exception $e) {

            $data = [
                "is_error" => true,
                "message"  => $e->getMessage(),
            ];
            return $data;
        }
    }

    public function getPartialPayment($bill_no)
    {
        $total_paid_amt= DB::table('partial_bill')->where('bill_no', $bill_no)->sum('paid_amt');
        $total_convence_amt= DB::table('partial_bill')->where('bill_no', $bill_no)->sum('convence_amt');

        $data =[
            'total_paid_amt' => $total_paid_amt,
            'total_convence_amt' => $total_convence_amt
        ];

        return $data;
    }

    public function UpdatePartialBill($bill_no)
    {

            DB::table('partial_bill')->where('bill_no', $bill_no)->update([
                'status' => 1
            ]);
        
    }
}
 