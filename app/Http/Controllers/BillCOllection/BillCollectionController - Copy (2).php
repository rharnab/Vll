<?php

namespace App\Http\Controllers\BillCOllection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class BillCollectionController extends Controller
{
    public function rackList()
    {
         $agent_id = Auth::user()->agent_id;

         $all_due_shop= DB::table('rack_products as rp')
         ->select('s.name as shop_name', 'rp.rack_code', 'rp.shop_id')
         ->leftJoin('shops as s', 's.id', '=', 'rp.shop_id')
         ->where([

            ['rp.agent_id', '=', $agent_id],
            ['rp.status', '=', '1'] 
         ])->groupBy('rp.rack_code')->get();
        

        $data = [
            "all_due_shop" => $all_due_shop
        ];
        return view('billCollection.rack-list', $data);
    }



    public function GetAllDue(Request $request)
    {

        $rack_code= $request->rack_code;

        $sql = "SELECT sum(month_sale_price) as monthly_due, shop_id from (SELECT sold_date,shop_id, rack_code, sum(selling_price) as month_sale_price from rack_products where status = '1' and rack_code= '$rack_code'  GROUP by sold_date) rp 
        GROUP by month(sold_date) , year(sold_date)";
        $due_month = DB::select($sql);
        $total_due= 0;
        $total_due_month= 0;
        $shop_id = '';

        if($due_month !='')
        {
            foreach($due_month as $single_month)
            {
               
               $total_due =  $single_month->monthly_due + $total_due;
               $shop_id = $single_month->shop_id;
            }

            $total_due_month = count($due_month);

        }



        $data =[

            'total_due' => $total_due,
            'total_due_month' => $total_due_month,
            'shop_id' => $shop_id,

        ];


        return json_encode($data);

       

    }


    public function pay_all_due(Request $request)
    {
        $rack_code = $request->rack_code;
        $shop_id = $request->shop_id;
        $due_amount =  $request->due_amount;
        $num_of_month = $request->num_of_month;
        $entry_user = Auth::user()->id;
        $entry_datetime = date('Y-m-d H:i:s');
        $current_date  = date('Y-m-d');

        $socks_bill_no = $this->generateShockBillNo($rack_code, $shop_id);

       $sql = "SELECT sold_date, count(*) as sales_quantity, sum(selling_price) as collect_amount, agent_id, sum(shop_commission) as shop_commission_amount, sum(agent_commission) agent_commission_amount, sum(venture_amount) as venture_amount  from rack_products where rack_code='$rack_code' and status ='1' and shop_id='$shop_id' GROUP by month(sold_date), year(sold_date)";

        $monthly_due_bill= DB::select($sql);

        foreach($monthly_due_bill as $single_monthly_due_bill)
        {
              $due_month = $single_monthly_due_bill->sold_date;
              $agent_id = $single_monthly_due_bill->agent_id;
              $sales_quantity = $single_monthly_due_bill->sales_quantity;
              $collect_amount = $single_monthly_due_bill->collect_amount;
              $shop_commission_amount = $single_monthly_due_bill->shop_commission_amount;
              $agent_commission_amount = $single_monthly_due_bill->agent_commission_amount;
              $venture_amount = $single_monthly_due_bill->venture_amount;


              $month = date('m', strtotime($due_month));
              $year = date('Y', strtotime($due_month));

                $UpdateRackBillCommission= $this->UpdateRackBillCommission($rack_code, $shop_id, $due_month);

                if($UpdateRackBillCommission['is_error']== false)
                {

                   try {

                        DB::table('rack_products')->where([
                            ['shop_id', '=', $shop_id],
                            ['rack_code', '=', $rack_code],

                        ])->where('status', 1)->whereMonth('sold_date', $month)->whereYear('sold_date', $year)->update([

                             'status' => 3,
                             'shocks_bill_no' => $socks_bill_no,

                        ]);

                       

                   } catch (Exception $e) {

                        $data = [
                            "status"   => 200,
                            "is_error" => false,
                            "message"  => "rack_products not update"
                        ];

                        return response()->json($data);
                       
                   }

                   try {
                       
                       DB::table('shock_bills')->insert([
                        'agent_id' => $agent_id,
                        'shop_id' => $shop_id,
                        'rack_code' => $rack_code,
                        'sales_quantity' => $sales_quantity,
                        'collect_amount' => $collect_amount,
                        'shocks_bill_no' => $socks_bill_no,
                        'status' => 0,
                        'entry_user_id' => Auth::user()->id,
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'billing_year_month' =>date('Y-m', strtotime($due_month))

                       ]);


                   } catch (Exception $e) {

                        $data = [
                            "status"   => 200,
                            "is_error" => false,
                            "message"  => "shock_bills not insert"
                        ];

                        return response()->json($data);
                       
                   }


                   try{
                        DB::table('commissions')->insert([
                            "shoks_bill_no"               => $socks_bill_no,
                            "agent_id"                    => $agent_id,
                            "shop_id"                     => $shop_id,
                            "rack_code"                   => $rack_code,
                            "quantity"                    => $sales_quantity,
                            "total_amount"                => $collect_amount,
                            //"shop_commission_percentage"  => $shop_commission_parcent_pay,
                            "shop_commission_amount"      => $shop_commission_amount,
                            //"agent_commission_percentage" => $agent_commission_parcent_pay,
                            "agent_commission_amount"     => $agent_commission_amount,
                            "venture_amount"              => $venture_amount,
                            "entry_user_id"               => Auth::user()->id,
                            "billing_year_month"          => date('Y-m', strtotime($due_month)),
                            "entry_datetime"              => date('Y-m-d H:i:s'),
                        ]);
                    }catch(Exception $e){
                        $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => $e->getMessage()
                        ];
                        return response()->json($data);
                    }


                




                }else{

                    return response()->json($data);

                }
              
        }


         $data = [
            "status"   => 200,
            "is_error" => false,
            "bill_no"  => $socks_bill_no,
            "message"  => "Bill collection successfully.Your voucher no is : $socks_bill_no "
        ];
        return response()->json($data);
        

        
       
    }



    public function UpdateRackBillCommission($rack_code, $shop_id, $bill_month)
    {

        $month = date('m', strtotime($bill_month));
        $year = date('Y', strtotime($bill_month));

        $billing_year_month = $year.'-'.$month;

        $sql = "SELECT 
                    sum(selling_price) as total_amount_payment, 
                    sum(shop_commission) as total_shopkeeper_amount_payment, 
                    sum(agent_commission) as total_agent_amount_payment, 
                    sum(venture_amount) as total_venture_amount 
                from rack_products 
                where rack_code='$rack_code' 
                and status in (1,3) 
                and shop_id='$shop_id' 
                and month(sold_date)='$month' 
                and year(sold_date)='$year'; ";

        $commission_result  = DB::select($sql);

        if($commission_result[0]->total_amount_payment > 0)
        {
            $commission_result = $commission_result[0];

            $total_amount_payment = $commission_result->total_amount_payment;
            $total_shopkeeper_amount_payment = $commission_result->total_shopkeeper_amount_payment;
            $total_agent_amount_payment = $commission_result->total_agent_amount_payment;
            $total_venture_amount = $commission_result->total_venture_amount;



            $rack_bill_commission = DB::table('rack_monthly_bill')->where([
                'shop_id' => $shop_id,
                'rack_code' => $rack_code,

            ])->where('billing_year_month', $billing_year_month)->first();

            if($rack_bill_commission  != '')
            {
                try {

                    $rack_bill_commission = DB::table('rack_monthly_bill')->where([
                        'shop_id' => $shop_id,
                        'rack_code' => $rack_code,

                    ])->where('billing_year_month', $billing_year_month)->update([

                        'total_amount_payment' => $total_amount_payment + $rack_bill_commission->total_amount_payment,
                        'total_shopkeeper_amount_payment' => $total_shopkeeper_amount_payment + $rack_bill_commission->total_shopkeeper_amount_payment,
                        'total_agent_amount_payment' => $total_agent_amount_payment + $rack_bill_commission->total_agent_amount_payment,
                        'total_venture_amount_payment' => $total_venture_amount + $rack_bill_commission->total_venture_amount,
                        'last_bill_collection_date' =>date('Y-m-d'),
                        'bill_collect_user_id' => Auth::user()->id,

                    ]);

                    $data = [
                        "status"   => 200,
                        "is_error" => false,
                        "message"  => ""
                    ];

                    return $data;


                    
                } catch (Exception $e) {

                    $data = [
                        "status"   => 400,
                        "is_error" => true,
                        "message"  => "rack_monthly_bill  update fail"
                    ];
                    
                }
            }else{

                 $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "rack_bill_commission not found"
                ];
              return $data;

            }





        }else{

              $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Data not found"
                ];
             return $data;

        }

         


    }




    ############################################################## month wise bill collection contoller ##########
    public function allRack()
    {
         $agent_id = Auth::user()->agent_id;

         $current_month = date('m');
         $current_year = date('Y');
        
        $racks = DB::select(DB::raw("SELECT rm.rack_code, sum(mc.due_blill) as total_due, mc.shop_id, s.name as shop_name from monthly_commission mc 
          LEFT JOIN rack_mapping rm on rm.rack_code = mc.rack_code 
          LEFT JOIN shops s on s.id = rm.shop_id where rm.agent_id='$agent_id' and mc.status in (0,1)  and month(mc.sale_date) != '$current_month' /*and year(mc.sale_date) != '$current_year'*/
          GROUP by mc.rack_code"));


        $data = [
            "racks" => $racks
        ];
        return view('billCollection.month-wsie-racks', $data);
    }

    


    public function month_wise($rack_code)
    {
      
        $rack_code = Crypt::decrypt($rack_code);
        $current_month = date('m');
        $current_year = date('Y');
        $payable_month_due = DB::table('monthly_commission')->where([

           ['rack_code' , '=', $rack_code],

        ])->select('sale_date', 'due_blill', 'rack_code', 'shop_id')
            ->whereMonth('sale_date', '!=', $current_month)->whereYear('sale_date', '!=', $current_year)
            ->whereIn('status', [0,1])->orderByRaw('sale_date', 'asc')->first();


        if($payable_month_due !='')
        {

             $month = date('m', strtotime($payable_month_due->sale_date));
             $year = date('Y', strtotime($payable_month_due->sale_date));
        

            $all_due = DB::table('monthly_commission')->where([

               ['rack_code' , '=', $rack_code],

            ])->select('sale_date')->whereIn('status', [0,1])->whereMonth('sale_date', '!=', $month)->orderBY('id', 'asc')->get();

        }else{

            $all_due = [];

        }
        
        

      $shops_info  = DB::table('rack_mapping as rm')
                     ->select('rm.rack_code', 's.name', 'rm.shop_id')
                     ->leftJoin('shops as s', 's.id', '=', 'rm.shop_id')
                     ->where('rm.rack_code', $rack_code)
                     ->first();

       $data = [

            'payable_month_due' => $payable_month_due,
            'all_due' => $all_due,
            'shops_info' => $shops_info


       ];

       return  view('billCollection.single-month', $data);


    }


    public function check_bill(Request $request)
    {

         $due_month = $request->due_month;
         $pay_amount = $request->pay_amount;
          $shop_id = Crypt::decrypt($request->shop_id);

        $pay_month = date('m', strtotime($due_month));
        $pay_year = date('Y', strtotime($due_month));

         $bill_info = DB::table('monthly_commission')->select('due_blill')->whereMonth('sale_date', $pay_month)->whereYear('sale_date', $pay_year)->first();

         if($bill_info->due_blill > 0)
         {
            echo number_format($bill_info->due_blill, 2);
         }else{
            echo  0;
         }




        
    }


    public function single_month_due(Request $request)
    {


        $shop_id = Crypt::decrypt($request->shop_id);
        $rack_code = Crypt::decrypt($request->rack_code);
        $due_month = $request->due_month;
        $pay_amount = $request->pay_amount;
        $chk_full = $request->chk_full;
        $chk_other = $request->chk_other;

        


            $month = date('m', strtotime($due_month));
            $year = date('Y', strtotime($due_month));

           

           $bill_info= DB::table('monthly_commission')->where([
                ['shop_id', '=', $shop_id],
                ['rack_code', '=', $rack_code],

            ])->whereIn('status', [0,1])->whereMonth('sale_date', $month)->whereYear('sale_date', $year)->first();

           $last_bill_date  = DB::table('collection_date')->select('bill_collection_last_day')->first(); 

           $shocks_bill_no = $this->generateShockBillNo($rack_code, $shop_id); 

            $sale_pair = $bill_info->sale_pair;
            $due_blill = $bill_info->due_blill;

            /*selected shop bill by sale date*/

            if($chk_other == 'on' )
            {
                if($pay_amount > 0 )
                {
                     $socks_paid_bill = $pay_amount;

                }else{

                    $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => "Sorry Bill not pay Pleas try again"
                        ];
                        return response()->json($data);  

                }
            }else{

                  $socks_paid_bill = $due_blill;

            }

         

        

            /*selected shop bill by sale date*/

            if($due_blill > 0)
            {

                $current_date = date('Y-m-d');
                $allow_days = $last_bill_date->bill_collection_last_day;
           
               
                $date = date('Y-m-t', strtotime($due_month));
                $date=date_create($date);
                date_add($date,date_interval_create_from_date_string($allow_days." days")); /*add 5 days with bill month las day*/
                $new_bill_date = date_format($date,"Y-m-d");


                $total_due_month = $this->getPreviousDue($rack_code, $shop_id);
                if($total_due_month > 0)
                {

                    $min_commission = $this->getMinimuamCommission($shop_id);
                    $agent_commission_parcent_pay = $min_commission['minimum_agent_commission'];
                    $shop_commission_parcent_pay  = $min_commission['minimum_shop_commission'];                         
                }else{
                   $commissions      = $this->getTotalShocksCommissions($sale_pair, $shop_id);
                   $agent_commission_parcent_pay = $commissions['agent_commission_persentage'];
                   $shop_commission_parcent_pay  = $commissions['shop_commission_persentage'];

                }

               /*for update acctual parsentage*/
               $commissions      = $this->getTotalShocksCommissions($sale_pair, $shop_id);
               $agent_commission_parcent = $commissions['agent_commission_persentage'];
               $shop_commission_parcent  = $commissions['shop_commission_persentage'];


               $new_due_bill = $due_blill - $socks_paid_bill;
               $paid_bill = $bill_info->paid_bill + $socks_paid_bill;

               $shop_commission_pay = (($socks_paid_bill * $shop_commission_parcent_pay) / 100);
               $agent_commission_pay = (($socks_paid_bill * $agent_commission_parcent_pay) / 100);

               if($new_due_bill == 0)
               {
                 $sts = 2;
               }else{
                 $sts = 1;

               }

                $mothly_total_shocks =  $this->GetMonthlyTotalSocks($rack_code, $shop_id, $month, $year);
                if($mothly_total_shocks > 0)
                {
                    $total_shocks = $mothly_total_shocks;

                }else{

                    $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => "Sorry this month socks not found ".date('M Y', strtotime($single_bill_month->sale_date))
                        ];
                        return response()->json($data);  
                }


              try {
                    /*---------------------------monthly commissions update-----------------------*/ 
                    DB::table('monthly_commission')->where([
                        ['shop_id', '=', $shop_id],
                        ['rack_code', '=', $rack_code],

                    ])->whereIn('status', [0,1])->whereMonth('sale_date', $month)->whereYear('sale_date', $year)
                    ->update([

                        'due_blill' =>$new_due_bill,
                        'paid_bill' =>$paid_bill,
                        'shop_commission_parcent' =>$shop_commission_parcent,
                        'agent_commission_parcent' =>$agent_commission_parcent,
                        'shop_commission_parcent_pay' => $shop_commission_parcent_pay,
                        'agent_commission_parcent_pay' => $agent_commission_parcent_pay,
                        'shop_commission_pay' => $shop_commission_pay + $bill_info->shop_commission_pay,
                        'agent_commission_pay' => $agent_commission_pay + $bill_info->agent_commission_pay,
                        'bill_collect_date' => date('Y-m-d H:i:s'),
                        'update_user_id' => Auth::user()->id,
                        'update_datetime' => date('Y-m-d H:i:s'),
                        'status' => $sts,

                    ]);
                    /*---------------------------monthly commissions update-----------------------*/



                    $venture_amount = $socks_paid_bill - ( $shop_commission_pay + $agent_commission_pay );

                    

                    $entry_user_id  = Auth::user()->id;
                    $entry_datetime = date('Y-m-d H:i:s');
                    

                    }catch (Exception $e) {

                        $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => "Monthly Commission  table updated failed"
                        ];
                        return response()->json($data);  
                  }
                    
                  try{

                        DB::table('shock_bills')->insert([
                            "agent_id"       => Auth::user()->agent_id,
                            "shop_id"        => $shop_id,
                            "rack_code"      => $rack_code,
                            "sales_quantity" => $total_shocks,
                            "collect_amount" => $socks_paid_bill,
                            "shocks_bill_no" => $shocks_bill_no,
                            "entry_user_id"  => $entry_user_id,
                            "entry_datetime" => $entry_datetime,
                            "bill_date"      => $due_month,
                            "voucher_link" => "backend/assets/voucher/rack-bill/$shocks_bill_no.pdf"
                        ]);    
                    }catch(Exception $e){
                        $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => "Bill table updated failed"
                        ];
                        return response()->json($data);
                    }

                    try{
                        DB::table('commissions')->insert([
                            "shoks_bill_no"               => $shocks_bill_no,
                            "agent_id"                    => Auth::user()->agent_id,
                            "shop_id"                     => $shop_id,
                            "rack_code"                   => $rack_code,
                            "quantity"                    => $total_shocks,
                            "total_amount"                => $socks_paid_bill,
                            "shop_commission_percentage"  => $shop_commission_parcent_pay,
                            "shop_commission_amount"      => $shop_commission_pay,
                            "agent_commission_percentage" => $agent_commission_parcent_pay,
                            "agent_commission_amount"     => $agent_commission_pay,
                            "venture_amount"              => $venture_amount,
                            "entry_user_id"               => $entry_user_id,
                            "entry_datetime"              => $entry_datetime,
                            "bill_date"                   => $due_month,
                        ]);
                    }catch(Exception $e){
                        $data = [
                            "status"   => 400,
                            "is_error" => true,
                            "message"  => $e->getMessage()
                        ];
                        return response()->json($data);
                    }

                    if($new_due_bill == 0)
                    {

                        try
                        {

                            DB::table('rack_products')->where([
                                ['shop_id', '=', $shop_id],
                                ['rack_code', '=', $rack_code],
                                ['status', '=', 1]

                            ])->whereMonth('sold_date', $month)->whereYear('sold_date', $year)->update([

                                "shocks_bill_no"                 => $shocks_bill_no,
                                "agent_bill_collection_datetime" => $entry_datetime,
                                "agent_bill_collection_user_id"  => $entry_user_id,
                                "status"                         => 3


                            ]);

                        }catch(Exception $e)
                        {

                             $data = [
                                "status"   => 400,
                                "is_error" => true,
                                "message"  => $e->getMessage()
                            ];

                            return response()->json($data);

                        }

                    }


                    file_put_contents('bill.txt', $new_due_bill."\n", FILE_APPEND);

                    $data = [
                        "status"   => 200,
                        "is_error" => false,
                        "bill_no"  => $shocks_bill_no,
                        "message"  => "Bill collection successfully.Your voucher no is : $shocks_bill_no "
                    ];
                    return response()->json($data); 

                    
                   
                            
            }else{
                $data =[

                    'status' => 400,
                    'is_error' => true,
                    'message' => "Sorry Not found due in this ".date('Y M', strtotime($single_bill_month->sale_date)) 
                ];
            }
                    
       


    }



############################################################## month wise bill collection contoller ##########


    public function generateShockBillNo($rack_code, $shop_id){
        $current_date = date('Ymd');
        $shop          = DB::table('shops')->select('name')->where('id', $shop_id)->first();
        $shop_name     = $shop->name;
        $billSerial    = DB::table('shock_bills')->count();
        $billno        = $billSerial + 1;
        $socks_bill_no = $current_date.$billno;
        $socks_bill_no = join("-", explode(" ", $socks_bill_no));
        return $socks_bill_no;
    }


    public function getShopRegistrationDate($rack_code ,$shop_id)
    {

        $shor_registration_date = DB::table('rack_mapping')->where([

                    ['shop_id', '=', $shop_id],
                    ['rack_code', '=', $rack_code],

                ])->select('shop_reg_date')->first();

        if($shor_registration_date->shop_reg_date !='')
        {
         
              return $date = $shor_registration_date->shop_reg_date;    
              

        }else{

            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => "Shop not registered yeat",
            ];

            return $data;
        }

    }


    public function getMinimuamCommission($shop_id)
    {

       $checkDataCount = DB::table('commission_setups')->where('shop_id', $shop_id)->count();
        if($checkDataCount > 0){
            $shocks_commission = DB::table('commission_setups')->select('agent_commission_persentage', 'shop_commission_persentage')->where('shop_id', $shop_id
            )->orderBy('id', 'asc')->take(1)->first();
        }else{
            $shocks_commission = DB::table('commission_setups')->select('agent_commission_persentage', 'shop_commission_persentage')->orderBy('id', 'asc')->take(1)->first();
        }
        
        
       
        $data = [
            "minimum_agent_commission" => $shocks_commission->agent_commission_persentage ?? 0,
            "minimum_shop_commission" => $shocks_commission->shop_commission_persentage ?? 0
        ];

        return $data;
        
    }

    public function GetMonthlyTotalSocks($rack_code, $shop_id, $month, $year)
    {

        $total_socks = DB::table('rack_products')->where([
            ['shop_id', '=', $shop_id],
            ['rack_code', '=', $rack_code],
            ['status', '=', 1]

        ])->whereMonth('sold_date', $month)->whereYear('sold_date', $year)->count('*');

        if($total_socks > 0)
        {
            return $total_socks;
        }else{
            return 0;
        }


    }


    public function getPreviousDue($rack_code, $shop_id)
    {
         $curent_month =  date('Y-m-d');

          $shop_regis_date = $this->getShopRegistrationDate($rack_code, $shop_id);

          if(!empty($shop_regis_date))
          {


                $regi_date = date('Y-m-t', strtotime($shop_regis_date));

                 $previous_month = date('Y-m-t', strtotime($curent_month."-1 months "));


                 try{

                    $due_month = DB::table('monthly_commission')->where([
                        ['shop_id', '=', $shop_id],
                        ['rack_code', '=', $rack_code],
                        ['sale_date', '<', $previous_month]
                    ])->whereIn('status', [0,1])->whereBetween('sale_date', [$regi_date, $previous_month])->count('*');

                    return  $due_month;


                 }catch(Exception $e){


                        $data = [
                                "status"   => 400,
                                "is_error" => true,
                                "message"  => "Due not found",
                            ];

                        return $data;


                 }


          }else{

                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "Shop not registered yet",
                ];

            return $data;
          }

         

        
       
        

        
    }


    



}
