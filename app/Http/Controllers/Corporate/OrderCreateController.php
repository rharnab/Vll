<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PDF;
class OrderCreateController extends Controller
{
    public function create()
    {
       
       $clients= DB::table('corporate_client')->where('status', 1)->get();
       $types= DB::table('types')->get();

       $data  = [
            'clients' => $clients,
            'types' => $types,
       ];
       return view('corporate.production.create', $data);
    }
    public function single_row(Request  $request)
    {
         $index_no = $request->index_no;
         $types= DB::table('types')->get();

         $data  = [
            'types' => $types,
            'index_no' => $index_no
       ];

         $output = view('corporate.production.single_row', $data);
         return $output;
    }

    public function store(Request $request)
    {
      

        $total_request = count($request->product_name);
        $current_date = date('Y-m-d');

        $client_id = $request->client_name;
        $order_no = $request->order_no;

         $invoice = $this->invoice_no(); // find out invoice number
        

        if($invoice['status'] ==200){
          $invoice_no = $invoice['invoice_no'];
        }else{
          $data = [
               'status' => 400,
               'message' => 'Invoice number not found'
          ];

          return response()->json($data);
 
        }
       

        
       

        $grand_total_qty = 0;
        $grand_total_amount = 0;

       for($i=0; $i < $total_request; $i++)
       {
             $product_name  = $request->product_name[$i];
             $type_id  = $request->type_name[$i];
             $color_qty  = $request->color_qty[$i];
             $color_qty  = $request->color_qty[$i];
             $lot_qty  = $request->lot_qty[$i];
             $total_qty  = $request->total_qty[$i];
             $single_price  = $request->single_price[$i];
             $total_price  = $request->total_price[$i];

             $grand_total_qty += $total_qty;
             $grand_total_amount += $total_price;
             
             try{

               DB::table('corporate_sale')->insert([

                    "client_id" => $client_id,
                    "product_name" => $product_name,
                    "type_id" => $type_id,
                    "color_qty" => $color_qty,
                    "lot_qty" => $lot_qty,
                    "total_qty" => $total_qty,
                    "total_amt" => $total_price,
                    //"due_amt" => $total_price,
                    "challan_no" => $invoice_no,
                    "challan_date" => $current_date,
                    "order_no" => $order_no,
                    "order_date" => $current_date,
                    "status" => 1,
                    "entry_by" => Auth::user()->id,
                    "entry_dateTime" => date('Y-m-d H:i:s'),
                    "single_price" => $single_price
               ]);

             }Catch(Exception $e){

               $data = [
                    'status' => 400,
                    'message' => 'Sorry ! Order  Placed fail'
               ];
     
               return response()->json($data);

             }
           

       }

       try{

          DB::table('corporate_sales_bill')->insert([
               "client_id" => $client_id,
               "challan_no" =>  $invoice_no,
               "total_paid" =>  0,
               "total_due" => $grand_total_amount,
               "total_qty" => $grand_total_qty,
               "total_bill" => $grand_total_amount
            ]);
     
            $data = [
                    'status' => 200,
                    'message' => 'Order Successfully Placed',
                    'chalan_no' => Crypt::encrypt($invoice_no)
               ];
     
          return response()->json($data);

       }Catch(Exception $e){

          $data = [
               'status' => 400,
               'message' => $e->getMessage()
          ];

          return response()->json($data);

       }

       


        
    }


    public function invoice_no()
    {     
        
         $order_no = DB::table('corporate_sale')->count();
         if($order_no > 0)
         {
              $order_sl = $order_no + 101;

         }else{
             $order_sl = 0 + 101;
         }

         $prfix = "VLL/DLL/";
         $year = date('Y')."/";
         $invoice_no = $prfix.$year.$order_sl;

         $data = [
              'status' => 200,
              'invoice_no' => $invoice_no
         ];

         return $data;

    }

    public function orderPlaceVoucehr($chanlan_no)
    {
       $product_info = DB::select("SELECT t.types_name , cs.product_name , color_qty  , lot_qty , total_qty, cs.single_price, cs.total_amt
        from corporate_sale cs
        left join types t on t.id = cs.type_id
        where cs.challan_no ='$chanlan_no'
        ");

        $shop_info = DB::select("SELECT 
                    cc.client_name , cc.contact_no , cc.address , cs.challan_no, cs.order_no, cs.order_date, u.name, u.mobile_number
                    from corporate_sale cs
                    left join corporate_client cc on cc.id = cs.client_id
                    left join users u on u.id  = cs.entry_by  
                    where cs.challan_no ='$chanlan_no' limit 1")[0];

       

          $data = [
               'product_info' => $product_info,
               'shop_info' => $shop_info
          ];

          

          $pdf= PDF::loadView('corporate.production.voucher', $data);
          

          return $pdf->stream();

          //return view('corporate.production.voucher', $data);
          

          
    }


    public function order_list()
    {
         $all_order = DB::select("SELECT m.*, cc.client_name from (SELECT  sum(total_qty) as total_product, sum(total_amt) as total_bill, sum(due_amt) as total_due, cs.challan_no, client_id, order_no, order_date, cs.status  FROM corporate_sale cs where cs.status in (1,2) GROUP by challan_no) m
         left join corporate_client cc on cc.id = m.client_id;");
     
         return view('corporate.production.authorize', compact('all_order'));
    }

    public function order_authorize($chalan_no)
    {
         $chalan_no = Crypt::decrypt($chalan_no);

         $product_info = DB::select("SELECT t.types_name , cs.product_name , color_qty  , lot_qty , total_qty, cs.single_price, cs.total_amt
         from corporate_sale cs
         left join types t on t.id = cs.type_id
         where cs.challan_no ='$chalan_no'
         ");

         $order_info = DB::select("SELECT m.*, cc.client_name  from (SELECT  sum(total_qty) as total_product, sum(total_amt) as total_bill, sum(due_amt) as total_due, cs.challan_no, client_id, order_no, order_date, remarks, cs.status  FROM corporate_sale cs where cs.status <> '' and cs.challan_no= '$chalan_no') m
         left join corporate_client cc on cc.id = m.client_id")[0];
         $data = [
               'order_info' => $order_info,
               'chalan_no' => $chalan_no,
               'product_info' => $product_info
         ];
         return view('corporate.production.show-order-details', $data);
    }

    

    public function confrim_auth(Request $request)
    {
         $chalan_no = Crypt::decrypt($request->chalan_no);
         $remarks= $request->remarks;
         $selcted_sts  = $request->sts;

         try{
               DB::table('corporate_sale')->where('challan_no', $chalan_no)->update([
                         'status' => $selcted_sts,
                         'remarks' => $remarks
               ]);
          
               if($selcted_sts=='2'){
                    $status = 'production';
               }elseif($selcted_sts=='3'){
                    $status = 'delivery';
               }     

               $data = [
                    'status' => 200,
                    'is_error' => false,
                    'message' => "Authorize Successful Product is on {$status} state "
               ];

               return response()->json($data);

         }Catch(Exception $e){

               $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => "Sorry Authorize  fail "
               ];

               return response()->json($data);

         }
         
    }

    public function voucher_list()
    {
          $all_order = DB::select("SELECT m.*, cc.client_name from (SELECT  sum(total_qty) as total_product, sum(total_amt) as total_bill, sum(due_amt) as total_due, cs.challan_no, client_id, order_no, order_date, cs.status  FROM corporate_sale cs where cs.status <> '' GROUP by challan_no) m
          left join corporate_client cc on cc.id = m.client_id;");
     
          return view('corporate.production.voucher_list', compact('all_order'));
    }

    public function show_voucher($chalan_no)
    {
         $chalan_no = Crypt::decrypt($chalan_no);
         echo $this->orderPlaceVoucehr($chalan_no);
    }



}
