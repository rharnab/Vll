<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class CorporateBillController extends Controller
{
    public function index()
    {
       
       $all_due_client = DB::select("SELECT cc.client_name, cs.client_id  from corporate_client cc 
       left join corporate_sale cs on cs.client_id =cc.id
       group by cs.client_id 
       ");

       $data  = [
            'all_due_client' => $all_due_client,
       ];
       return view('corporate.Bill.corporate.collection_bill', $data);
    }

    public function get_challan_no(Request $request)
    {
        $client_id =  $request->client_id;

       $all_challan_no = DB::select("SELECT cc.client_name , csb.challan_no , csb.total_qty , csb.total_paid , csb.total_due   from corporate_sales_bill csb 
       left join corporate_client cc on cc.id  = csb.client_id 
       where  csb.status in (0,4) and csb.client_id ='$client_id'");
       $option='';
       $option .= '<option value="">--select--</option>';
       foreach($all_challan_no as $single_challan)
       {
        $option .= '<option value="'.$single_challan->challan_no.'">'.$single_challan->challan_no.'</option>';
       }
       echo $option;
   
        
    }

    public function get_amount(Request $request)
    {
        $client_id =  $request->client_id;
        $challan_no =  $request->challan_no;

        $bill_info = DB::select("SELECT  csb.total_qty , csb.total_paid , csb.total_due, csb.total_bill   from corporate_sales_bill csb 
        where  csb.status in (0,4)  and csb.client_id ='$client_id' and csb.challan_no ='$challan_no'  ")[0];

        echo json_encode($bill_info);
    }
    

    public function bill_store(Request $request)
    {
        $challan_no   = $request->challan_no;
        $total_amount = $request->total_amount;
        $paid_amount  = $request->paid_amount;
        $due_amt  = $request->due_amt;
        $bill_collection_amt  = $request->bill_collection_amt;
        $final_due = $due_amt - $bill_collection_amt;
        
        try{
            $data_insert = DB::table('corporate_bill_collection')->insert([
                "challan_no"     => $challan_no,
                "total_amount"   => $total_amount,
                "total_paid"     => $paid_amount,
                "total_due"      => $final_due,
                "collect_amount" => $bill_collection_amt,
                "status"         => 0,
                "entry_by"       => Auth::user()->id,
                "entry_date"     => date('Y-m-d H:i:s'),
            ]);

            $data = [
                'status' => 200,
                'is_error' => false,
                'message' => 'Bill pay Success'
            ];

            return response()->json($data);

        }Catch(Exception $e){
            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);
        }

      
    }




    public function auth_index()
    {
        $all_pedding_bills = DB::select("SELECT * FROM corporate_bill_collection cbc where cbc.status=0; ");
        
        return view('corporate.Bill.corporate.authorize', compact('all_pedding_bills'));
        
    }

    public function bill_authorize(Request $request)
    {
         $bill_Collecton_id  = $request->id;

         $bill_collection_info = DB::table('corporate_bill_collection')->where('id', $bill_Collecton_id)->first();
         $challan_no  =$bill_collection_info->challan_no;
         $collect_amount  =$bill_collection_info->collect_amount;
         $total_due  =$bill_collection_info->total_due;

         if($total_due == 0){
             $sts = 'status=5';
         }else{
            $sts = 'status=4';
         }

         $authorize_user_id = Auth::user()->id;
         $authorize_date = date('Y-m-d H:i:s');
        
         try{


            DB::statement("UPDATE  corporate_sales_bill set authorize_datetime='$authorize_date',  authorize_user_id='$authorize_user_id', total_paid = total_paid + '$collect_amount' , total_due = total_due - '$collect_amount', $sts where challan_no ='$challan_no' ");
          
         
         }Catch(Exception $e){

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);

         }

        

         try{
            DB::table('corporate_bill_collection')->where('id', $bill_Collecton_id)->update([
             
                'status' => 1
   
            ]);

            //   $data = [
            //     'status' => 200,
            //     'is_error' => false,
            //     'message' => 'Bill Authorize success'
            // ];

            // return response()->json($data);

         }Catch(Exception $e){

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);

         }



         $product_info = DB::select("SELECT t.types_name , cs.product_name , color_qty  , lot_qty , total_qty, cs.single_price, cs.total_amt
        from corporate_sale cs
        left join types t on t.id = cs.type_id
        where cs.challan_no ='$challan_no'
        ");

        $shop_info = DB::select("SELECT 
                    cc.client_name , cc.contact_no , cc.address , cs.challan_no, cs.order_no, cs.order_date
                    from corporate_sale cs
                    left join corporate_client cc on cc.id = cs.client_id 
                    where cs.challan_no ='$challan_no' limit 1")[0];

       

          $data = [
               'product_info' => $product_info,
               'shop_info' => $shop_info
          ];


         $pdf= PDF::loadView('corporate.Bill.corporate.voucher', $data);  
         return $pdf->stream();        

    }//end bill_authorize function



    public function bill_voucher()
    {
        $all_bill_list = DB::select("SELECT csb.*, u.name as generate_by, au.name as auth_by from  corporate_bill_collection csb
        left join users u on u.id  = csb.entry_by 
        left join users as au on au.id = csb.auth_by 
        ");

        return view('corporate.Bill.corporate.voucher_list', compact('all_bill_list'));

    }


}
