<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductBillVoucherController extends Controller
{
    /**
     * Product Bill Voucher
	 * @group Voucher
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Your bill voucher list fetching successfully",
	 *		"data": {
	 *			"vouchers": [
	 *				{
	 *					"voucher_name": "March 2022",
	 *					"voucher_date": "2nd April, 2022",
	 *					"location": "http://venturelifestylelimited.com/public/Bill/voucher/90000180125-bill.pdf"
	 *				},
	 *				{
	 *					"voucher_name": "February 2022",
	 *					"voucher_date": "3rd March, 2022",
	 *					"location": "http://venturelifestylelimited.com/public/Bill/voucher/90000148927-bill.pdf"
	 *				}
	 *			]
	 *		}
	 *	}
    */
    public function billVoucher(){
        $shop_id      = Auth::user()->shop_id;
        $rack_mapping = DB::table('rack_mapping')->where('shop_id', $shop_id)->first();
        if($rack_mapping){
            $rack_code    = $rack_mapping->rack_code;
            $voucher_list = [];

            $bill_vouchers = DB::select(DB::raw("SELECT 
                                    sb.voucher_link,
                                    sb.id,
                                    group_concat(sb.billing_year_month) as billing_ym,
                                    sb.entry_datetime 
                                from shock_bills sb 
                                where sb.rack_code = '$rack_code' group by sb.shocks_bill_no  
                                order by sb.entry_datetime  desc"));
            foreach($bill_vouchers as $voucher){
                $single_voucher = [
                    "id" => $voucher->id,
                    "voucher_name" => $this->getVoucherName($voucher->billing_ym),
                    "voucher_date" => date('jS F, Y', strtotime($voucher->entry_datetime)),
                    "location"     => "http://venturelifestylelimited.com/public/".$voucher->voucher_link,
                ];
                array_push($voucher_list, $single_voucher);
            }
            
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "Your bill voucher list fetching successfully",
                "data" => [
                    "vouchers" => $voucher_list
                ]
            ];
            return response()->json($data);



        }else{
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => "Your rack didn't mapping yet"
            ];
            return response()->json($data);
        }
    }


    public function getVoucherName($year_month){
        $year_month_array = explode(",", $year_month);
        $year_months = '';
        for($i=0; $i < count($year_month_array); $i++){
            if(!empty($year_months)){
                $year_months .= ",";
            }
            $year_months .= date('F Y', strtotime($year_month_array[$i]."-01"));            
        }
        return $year_months;
    }
}
