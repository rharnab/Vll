<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrderUpdateController extends Controller
{
    public function index()
    {
        $all_due_client = DB::select("SELECT cc.client_name, cs.client_id  from corporate_client cc 
       left join corporate_sale cs on cs.client_id =cc.id
       group by cs.client_id 
       ");

      $categories = DB::table('category')->select(['name', 'id'])->orderBy('name', 'asc')->get(); 

       $data  = [
            'all_due_client' => $all_due_client,
            'categories' => $categories
       ];
       return view('corporate.production.update.index', $data);
    }


    public function get_challan_no(Request $request)
    {
        $client_id =  $request->client_id;

       $all_challan_no = DB::select("SELECT cc.client_name , csb.challan_no , csb.total_qty , csb.total_sale_paid_amt , csb.total_sale_due_amt   from corporate_sales_bill csb 
       left join corporate_client cc on cc.id  = csb.client_id 
       where  csb.status <> 3 and csb.client_id ='$client_id'");
       $option='';
       $option .= '<option value="">--select--</option>';
       foreach($all_challan_no as $single_challan)
       {
        $option .= '<option value="'.$single_challan->challan_no.'">'.$single_challan->challan_no.'</option>';
       }
       echo $option;
   
        
    }


    public function details(Request $request)
    {
        $client_id =  $request->client_id;
        $challan_no =  $request->challan_no;

        $product_info = DB::select("SELECT cs.id as sale_id, c.name as product_name,  t.types_name ,  total_qty, cs.unit_buy_price, cs.total_buy_amt, cs.unit_sale_price , cs.total_sale_amt
         from corporate_sale cs
         left join types t on t.id = cs.type_id
         left join category c  on c.id  = cs.product_type 
         where cs.challan_no ='$challan_no' and cs.client_id = '$client_id' 
         ");

         $output = view('corporate.production.update.order_details', compact('product_info'));

         echo $output;
      
    }

    public function edit($id)
    {
        $sale_id = Crypt::decrypt($id);
        $order_info =  DB::table('corporate_sale as cs')
        ->select(['cs.*','t.types_name',  'c.name as category_name', 'cc.client_name'])
        ->leftJoin('types as t', 't.id', 'cs.type_id')
        ->leftJoin('category as c', 'c.id', 'cs.product_type')
        ->leftJoin('corporate_client as cc', 'cc.id', 'cs.client_id')
        ->where('cs.id', $sale_id)->first();

        $types = DB::table('types')->select('id', 'types_name')->get();
        $categories = DB::table('category')->select('id', 'name')->get();

        $data = [
            'order_info' => $order_info,
            'types' => $types,
            'categories' => $categories
        ];

        return view('corporate.production.update.edit', $data);
       
    }

    public function update(Request $request)
    {
        $update_sale_id = Crypt::decrypt($request->sale_id);
        $challan_no = Crypt::decrypt($request->challan_no); 
        $product_id = $request->product_id; 
        $type_id = $request->type_name; 
        $total_qty = $request->total_qty; 
        $unit_buy_price = $request->buing_unit_price; 
        $total_buying_price = $request->total_buying_price; 
        $unit_sale_price = $request->selling_unit_price; 
        $total_selling_price = $request->total_selling_price;

       
        $order_info = DB::table("corporate_sale")->where([
            ['id', '=', $update_sale_id],
            ['challan_no', '=', $challan_no]
        ])->select('id')->first();

        if($order_info->id == $update_sale_id){

            $update_data = [
                'product_type' => $product_id,
                'type_id' => $type_id,
                'total_qty' => $total_qty,
                'unit_buy_price' => $unit_buy_price,
                'unit_sale_price' => $unit_sale_price,
                'total_buy_amt' => $total_buying_price,
                'total_buy_paid_amt' => $total_buying_price,
                'total_buy_due_amt' => $total_buying_price,
                'total_sale_amt' => $total_selling_price,
                'total_sale_paid_amt' => $total_selling_price,
                'total_sale_due_amt' => $total_selling_price,
            ];

            try{
                
                DB::table("corporate_sale")->where([
                    ['id', '=', $update_sale_id],
                    ['challan_no', '=', $challan_no]
                ])->update($update_data);

                $summary_update = $this->UpdateBillSummary($challan_no); // update function fo bill summary

                if($summary_update['status'] == 200)
                {
                    $data = [
                        'status' => 200,
                        'is_error' => false,
                        'message' => "Product update success",
                        'chalan_no' => Crypt::encrypt($challan_no),
                    ];
                    return response()->json($data);
                }else{

                    return response()->json($summary_update);
                }


            }Catch(Exception $e){
                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => "Sorry update fail please try again"
                ];
                return response()->json($data);

            }


        }else{
            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => "Sorry data not found"
            ];
            return response()->json($data);
        }
        
    }



    public function UpdateBillSummary($challan_no)
    {
        $summary_info = DB::select("SELECT 
        sum(total_qty) as total_product, 
        sum(total_buy_amt) as total_buy_amount,
        sum(total_sale_amt) as total_sale_amount,
        cs.challan_no
        from corporate_sale cs where cs.status <> 5 and cs.challan_no ='$challan_no'");


       if(count($summary_info) > 0){

               $single_data = $summary_info[0];
               $total_qantity = $single_data->total_product;
               $total_buy_amount = $single_data->total_buy_amount;
               $total_sale_amount = $single_data->total_sale_amount;
               $challan_no = $single_data->challan_no;

               try{

                    DB::statement("UPDATE corporate_sales_bill
                    SET    total_qty = '$total_qantity',
                           total_buy_amt = '$total_buy_amount',
                           total_sale_amt = '$total_sale_amount',
                           total_buy_due_amt = '$total_buy_amount' - total_buy_paid_amt,
                           total_sale_due_amt = '$total_sale_amount' - total_sale_paid_amt
                    WHERE  challan_no = '$challan_no'  ");

                    $data = [
                        'status' => 200,
                        'is_error' => false,
                        'message' => "Data Update success"
                    ];
                    return $data;

               }Catch(Exception $e){

                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => "Data Update fail"
                ];
                return $data;

               }
           
       }else{

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => "Data not found fail"
            ];
            return $data;
       }


    }

    public function addProduct(Request $request)
    {
       $validation = Validator::make($request->all(), [
            'product_name' => 'required',
            'type_name' => 'required',
            'total_qty' => 'required',
            'buying_unit_price' => 'required',
            'total_buying_price' => 'required',
            'selling_unit_price' => 'required',
            'total_selling_price' => 'required',
            'add_challan_no' => 'required',
            
        ]);

        if($validation->fails()){
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validation->errors()->first()
            ];
            
            return response()->json($validation_error);
        }


        $product_type = $request->product_name; 
        $type_id = $request->type_name; 
        $total_qty = $request->total_qty; 
        $buying_unit_price = $request->buying_unit_price; 
        $total_buying_price = $request->total_buying_price; 
        $selling_unit_price = $request->selling_unit_price; 
        $total_selling_price = $request->total_selling_price; 
        $challan_no  = $request->add_challan_no; 

        $previous_order_info = DB::table('corporate_sale')->where('challan_no', $challan_no)->first();
        if($previous_order_info->challan_no === $challan_no){

            try{

                DB::table('corporate_sale')->insert([
 
                     "client_id" => $previous_order_info->client_id,
                     "product_type" => $product_type,
                     "type_id" => $type_id,
                     "total_qty" => $total_qty,
                     "total_buy_amt" => $total_buying_price,
                     "total_sale_amt" => $total_selling_price,
                     "total_buy_due_amt" => $total_buying_price,
                     "total_sale_due_amt" => $total_selling_price,
                     "challan_no" => $previous_order_info->challan_no,
                     "challan_date" => $previous_order_info->challan_date,
                     "order_no" => $previous_order_info->order_no,
                     "order_date" => $previous_order_info->order_date,
                     "status" => $previous_order_info->status,
                     "entry_by" => Auth::user()->id,
                     "entry_dateTime" => date('Y-m-d H:i:s'),
                     "fact_status" => $previous_order_info->fact_status,
                     "unit_buy_price" => $buying_unit_price,
                     "unit_sale_price" => $selling_unit_price,
                     "vsl_payment_received" => $previous_order_info->vsl_payment_received,
                     "factory_paid_bill" => $previous_order_info->factory_paid_bill,
                     "remarks" => $previous_order_info->remarks,
                ]);

                $summary_update = $this->UpdateBillSummary($challan_no); // update function fo bill summary

                if($summary_update['status'] == 200)
                {
                    $data = [
                        'status' => 200,
                        'is_error' => false,
                        'message' => 'New product add successful',
                        'chalan_no' => Crypt::encrypt($challan_no)
                    ];

                    return response()->json($data);

                }else{

                    return response()->json($summary_update);
                }
 
              }Catch(Exception $e){
 
                $data = [
                     'status' => 400,
                     'message' => 'Sorry ! Order  Placed fail'
                ];
      
                return response()->json($data);
 
              }

        }else{

            $data = [
                'status' => 400,
                'is_error' => true,
                'message' => "Data not found fail"
            ];
            return response()->json($data);
        }



    }


}
