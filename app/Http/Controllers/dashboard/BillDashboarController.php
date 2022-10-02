<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillDashboarController extends Controller
{

    public function index()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

         /* -----------------------this month bill collection -------------------------------*/
         $this_month_bill_collection_sql  = "SELECT 
                                                 baui.shop_name,
                                                 Sum(baui.sold_amount) AS total_bill,
                                                 Sum(baui.sold_socks)  AS total_socks,
                                                 baui.address,
                                                 baui.shop_contact,
                                                 baui.owner_contact,
                                                 baui.rack_code,
                                                 baui.shop_id,
                                                 baui.shocks_bill_no
                                          FROM   (SELECT bau.shop_name,
                                                        bau.address,
                                                        bau.shop_contact,
                                                        bau.owner_contact,
                                                        bau.rack_code,
                                                        bau.shop_id,
                                                        bau.sold_amount,
                                                        bau.sold_socks,
                                                        bau.shocks_bill_no
                                                 FROM   (SELECT s.NAME                                     AS shop_name,
                                                               s.address,
                                                               s.contact_no                               AS
                                                               shop_contact,
                                                               s.owner_contact,
                                                               rp.rack_code,
                                                               rm.shop_id,
                                                               Sum(rp.selling_price - rp.shop_commission) AS sold_amount
                                                               ,
                                                               Count(rp.shocks_bill_no)
                                                               AS sold_socks,
                                                               rp.shocks_bill_no
                                                        FROM   rack_products rp
                                                               LEFT JOIN rack_mapping rm
                                                                      ON rm.rack_code = rp.rack_code
                                                               LEFT JOIN shops s
                                                                      ON s.id = rp.shop_id
                                                        WHERE  rp.status = 7
                                                        GROUP  BY rp.shocks_bill_no) bau
                                                        LEFT JOIN monthly_rack_conveynce_bill mrcb
                                                               ON mrcb.bill_no = bau.shocks_bill_no
                                                 WHERE  ( Month(mrcb.auth_date) = '02'
                                                        AND Year(mrcb.auth_date) = '2022' )
                                                 GROUP  BY bau.rack_code) baui
                                          GROUP  BY baui.rack_code  ";
       $this_month_bill_collection_result  =  DB::select($this_month_bill_collection_sql);

         /* -----------------------this month bill collection -------------------------------*/ 

       

        /* ---------------------------------------this month new shop number--------------- */
        $this_month_shop_number_sql = "SELECT  count(*)  as total_shop from (SELECT s.id
        FROM   shops s
               LEFT JOIN rack_mapping rm
                      ON s.id = rm.shop_id
               LEFT JOIN rack_products rp
                      ON rp.shop_id = s.id
        WHERE  ( Month(rm.entry_datetime) = '$currentMonth'
               AND Year(rm.entry_datetime) = '$currentYear')
               AND rp.status = 0
        GROUP  BY rp.shop_id order by entry_datetime desc) sc";

       $this_month_shop_number = DB::select($this_month_shop_number_sql);
       if(count($this_month_shop_number) > 0)
       {
       $this_month_shop_number = $this_month_shop_number[0]->total_shop;
       }else{
       $this_month_shop_number=0;
       }
       /* ---------------------------------------this month new shop number--------------- */

       /* -----------------------------------------up to bill receive --------------------------*/
       $up_to_bill_receive_result= DB::select('SELECT  sum(selling_price - shop_commission) as total_bill_collect from rack_products rp  where status  = 7');
       $up_to_bill_receive =  $up_to_bill_receive_result[0]->total_bill_collect;
       /* -----------------------------------------up to bill receive --------------------------*/ 

       /* -----------------------------------------up to bill due --------------------------*/
       $up_to_bill_due_result= DB::select('SELECT  sum(selling_price - shop_commission) as total_bill_due from rack_products rp  where status in(1,3)');
       $up_to_bill_due =  $up_to_bill_due_result[0]->total_bill_due; 
       /* -----------------------------------------up to bill due --------------------------*/ 




       $data = [
              'monthly_bill_collection' => $this_month_bill_collection_result,
              'this_month_shop_number' =>  $this_month_shop_number,
              'up_to_bill_receive' => $up_to_bill_receive,
              'up_to_bill_due' => $up_to_bill_due,
       ];
       return view('dashboard-bill.index', $data);


       
    }
    

    public function shop_details(Request $request)
    {
           $shop_id = $request->shop_id;
           $rack_code = $request->rack_code;

           $shop_info = DB::table('shops as s')
           ->leftJoin('rack_mapping as rm', 'rm.shop_id', '=', 's.id')
           ->leftJoin('agent_users as au', 'rm.agent_id', '=', 'au.id')
           ->select('s.*', 'au.name as agent_name', 'rm.rack_code')
           ->where([
                  ['rm.shop_id', '=',  $shop_id],
                  ['rm.rack_code', '=',  $rack_code],

           ])->first();

           if(!empty($shop_info))
           {
               return json_encode($shop_info);
           }else{
               return '';
           }

          
    }
}
