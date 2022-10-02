<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PDF;

class FactoryBillController extends Controller
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
       return view('corporate.Bill.factory.collection_bill', $data);
    }

    public function get_challan_no(Request $request)
    {
        $client_id =  $request->client_id;

       $all_challan_no = DB::select("SELECT cc.client_name , csb.challan_no , csb.total_qty , csb.total_sale_paid_amt , csb.total_sale_due_amt   from corporate_sales_bill csb 
       left join corporate_client cc on cc.id  = csb.client_id 
       where  csb.fact_status in (1,2) and csb.client_id ='$client_id'");
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

        $bill_info = DB::select("SELECT  csb.total_qty , csb.total_buy_paid_amt , csb.total_buy_due_amt, csb.total_buy_amt   from corporate_sales_bill csb 
        where  csb.fact_status in (1,2)  and csb.client_id ='$client_id' and csb.challan_no ='$challan_no'  ")[0];

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
        $client_id =$request->client_id;

        
       
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
                "client_id" => $client_id,
                'is_factory' => 'Y'
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
        $all_pedding_bills = DB::select("SELECT cbc.*, cc.client_name, u.name as generate_by, au.name as auth_by FROM corporate_bill_collection cbc 
        left join corporate_client cc on cc.id  = cbc.client_id
        left join users u on u.id  = cbc.entry_by 
        left join users as au on au.id = cbc.auth_by  
        where cbc.status=0 and cbc.is_factory='Y' ");
        
        return view('corporate.Bill.factory.authorize', compact('all_pedding_bills'));
        
    }

    public function bill_authorize(Request $request)
    {
         $bill_Collecton_id  = $request->id;

         $bill_collection_info = DB::table('corporate_bill_collection as cbc')
                                ->select('cbc.*', 'u.name as bill_generate_name')
                                ->leftJoin('users as u', 'u.id', 'cbc.entry_by')
                                ->where('cbc.is_factory', 'Y')
                                ->where('cbc.id', $bill_Collecton_id)->first();
         $challan_no  =$bill_collection_info->challan_no;
         $collect_amount  =$bill_collection_info->collect_amount;
         $total_due  =$bill_collection_info->total_due;
         $client_id = $bill_collection_info->client_id;
         $total_paid = $bill_collection_info->total_paid;

         $total_sale_paid_amt = $total_paid + $collect_amount;

         $bill_generate_name = $bill_collection_info->bill_generate_name;
         

         if($total_due == 0){
             $sts = 'fact_status=3';
         }else{
            $sts = 'fact_status=2';
         }

         $authorize_user_id = Auth::user()->id;
         $authorize_date = date('Y-m-d H:i:s');
        
         try{


            DB::statement("UPDATE corporate_sales_bill
            SET    authorize_datetime = '$authorize_date',
                   authorize_user_id = '$authorize_user_id',
                   total_buy_paid_amt = '$total_sale_paid_amt',
                   total_buy_due_amt = '$total_due',
                   $sts
            where  challan_no = '$challan_no'
            AND    client_id=  '$client_id' ");
          
         
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

                'status' => 1,
                'auth_by' => $authorize_user_id,
                'auth_date' => $authorize_date
   
            ]);


         }Catch(Exception $e){

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()
            ];

            return response()->json($data);

         }

         try{

            if($total_due == 0){
                $payment_sts = '3';
            }else{
                $payment_sts = '2';
            }
             DB::table('corporate_sale')->where('client_id', $client_id)->where('challan_no', $challan_no)->update([
                    'fact_status' => $payment_sts,
                    'factory_paid_bill'=> 'Y'
             ]);

         }Catch(Exception $e){

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage(),
            ];

            return response()->json($data);
         }

         $this->show_voucher(Crypt::encrypt($bill_Collecton_id)); // for print voucher        

    }//end bill_authorize function



    public function bill_voucher()
    {
      

        $all_bill_list = DB::select("SELECT cbc.*, cc.client_name, u.name as generate_by, au.name as auth_by FROM corporate_bill_collection cbc 
        left join corporate_client cc on cc.id  = cbc.client_id
        left join users u on u.id  = cbc.entry_by 
        left join users as au on au.id = cbc.auth_by  
        where cbc.status=1 and cbc.is_factory='Y' order by cbc.id desc ");

        return view('corporate.Bill.factory.voucher_list', compact('all_bill_list'));

    }


    public function show_voucher($collection_id)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size'=>10,
            'default_font'=>'nikosh'
        ]);
        
        $collection_id = Crypt::decrypt($collection_id);
        

        $bill_collection_info = DB::table('corporate_bill_collection as cbc')
                               ->select('cbc.*', 'u.name as bill_generate_name')
                               ->leftJoin('users as u', 'u.id', 'cbc.entry_by')
                               ->orderBy('id', 'desc')
                               ->where('cbc.is_factory', 'Y')
                               ->where('cbc.id', $collection_id)->first();

        $challan_no  =$bill_collection_info->challan_no;
        $collect_amount  =$bill_collection_info->collect_amount;
        $total_due  =$bill_collection_info->total_due;
        $client_id = $bill_collection_info->client_id;
        $total_paid = $bill_collection_info->total_paid;

        $total_sale_paid_amt = $total_paid + $collect_amount;

        $bill_generate_name = $bill_collection_info->bill_generate_name;

        $product_info = DB::select("SELECT c.name as product_name, t.types_name , cs.product_type , total_qty,  cs.total_buy_due_amt,
        cs.unit_buy_price, cs.total_buy_due_amt,  cs.total_buy_amt , cs.total_sale_amt 
         from corporate_sale cs
         left join types t on t.id = cs.type_id
         left join category c  on c.id  = cs.product_type
       where cs.challan_no ='$challan_no'
       ");

       $shop_info = DB::select("SELECT 
                   cc.client_name , cc.contact_no , cc.address , cs.challan_no, cs.order_no, cs.order_date
                   from corporate_sale cs
                   left join corporate_client cc on cc.id = cs.client_id 
                   where cs.challan_no ='$challan_no' limit 1")[0];


        $data = [
            'product_info' => $product_info,
            'shop_info' => $shop_info,
            'bill_generate_name' => $bill_generate_name,
            "collect_amount" => $collect_amount,
            "total_sale_paid_amt" => $total_sale_paid_amt,
            "total_sale_due_amt" => $total_due,

        ];


        $pdf = view('corporate.Bill.factory.voucher', $data);  
        $mpdf->WriteHTML($pdf);
        $mpdf->Output();


    }


}