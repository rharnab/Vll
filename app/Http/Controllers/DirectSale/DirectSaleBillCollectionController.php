<?php

namespace App\Http\Controllers\DirectSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectSaleBillCollectionController extends Controller
{

   public function index(){

        $shops = DB::select(DB::raw("
        select * from shops where id in (
            SELECT shop_id from single_sales GROUP by shop_id
        )"));

        $data = [
            "shops" => $shops
        ];

        return view('direct-sale.bill-collection.index', $data);

   }
   

   public function get_voucher(Request $request){

         $shop_id = $request->shop_id;

        $get_data = DB::select(DB::raw("SELECT sb.voucher_no,(SELECT count(*) from single_sales where voucher_no=sb.voucher_no) as total from single_sales_bill sb where total_due_amount > 0 and voucher_no in (
            select voucher_no from single_sales where shop_id= '$shop_id') "));
        
        $select_voucher ='';
        $select_voucher.= "<option value=''> --select-- </option>";
        foreach($get_data as $single_get_data){
            
            $select_voucher.= "<option value='$single_get_data->voucher_no'> $single_get_data->voucher_no - $single_get_data->total Pair </option>";
        }

      
        return  $select_voucher;

   }

   public function get_amount(Request $request){

        $shop_id = $request->shop_id;
        $voucher_no = $request->voucher_no;

        $get_data = DB::select(DB::raw("SELECT * from single_sales_bill where total_due_amount > 0 and voucher_no in (
            select voucher_no from single_sales where shop_id= '$shop_id' and voucher_no='$voucher_no')"))[0];

       return json_encode($get_data); 

   }

   public function bill_store(Request $request){
        $voucher_no   = $request->voucher_no;
        $total_amount = $request->total_amount;
        $paid_amount  = $request->paid_amount;
        $due_amt  = $request->due_amt;
        $bill_collection_amt  = $request->bill_collection_amt;

        $final_due = $due_amt - $bill_collection_amt;

       $data_insert = DB::table('single_sale_bill_collection')->insert([

            "voucher_no"     => $voucher_no,
            "total_amount"   => $total_amount,
            "total_paid"     => $paid_amount,
            "total_due"      => $final_due,
            "collect_amount" => $bill_collection_amt,
            "status"         => 0,
            "entry_by"       => Auth::user()->id,
            "entry_date"     => date('Y-m-d'),
            

        ]);

   }

    // start function bill_authorize
   public function bill_authorize(Request $request){

       $get_data = DB::table('single_sale_bill_collection as sbl')
        ->leftJoin('users as u','sbl.entry_by','=','u.id')
        ->leftJoin('users as u2','sbl.auth_by','=','u2.id')
        ->select('sbl.id','sbl.voucher_no', 'sbl.total_amount', 'sbl.collect_amount',
        'sbl.status', 'u.name as entry_by', 'sbl.entry_date', 'u2.name as auth_name', 'sbl.auth_date')
       
        ->orderBy('sbl.id','DESC')
        ->get();

        $data = [
            "get_data" => $get_data
        ];

        
        return view('direct-sale.bill-collection.bill_authorize', $data);

   }

  // end function bill_authorize


  // start function bill_voucher_authorize
  public function bill_voucher_authorize(Request $request){
   
    $id = $request->id;
    $get_data =  DB::table('single_sale_bill_collection')->where('id', $id)->first();

    $voucher_no = $get_data->voucher_no;
    $collect_amount = $get_data->collect_amount;

    $get_data_single_sale_bill = DB::table('single_sales_bill')->where('voucher_no', $voucher_no)->first();
    $single_sale_total_paid = $get_data_single_sale_bill->total_paid;
    $single_sale_total_due_amount = $get_data_single_sale_bill->total_due_amount;

    $paid_now = $single_sale_total_paid + $collect_amount;
    $due_now = $single_sale_total_due_amount - $collect_amount;

    $update_single_sale_bill = DB::table('single_sales_bill')
    ->where('voucher_no', $voucher_no)->update([
        "total_paid" => $paid_now,
        "total_due_amount" => $due_now
    ]);

   $update_single_sale_bill_collection = DB::table('single_sale_bill_collection')->where('id', $id)->update([
        "status"=>1,
        "auth_by"=>Auth::user()->id,
        "auth_date"=>date('Y-m-d'),
    ]);

    if($update_single_sale_bill && $update_single_sale_bill_collection){
        echo '1';
    }

  }

  // end function bill_voucher_authorize

}
