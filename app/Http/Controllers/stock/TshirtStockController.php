<?php

namespace App\Http\Controllers\stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use  App\Http\Controllers\stock\getProductCat;
use Image;

class TshirtStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

         
    }

    

    public function index()
    {


        

    
       $result= DB::table('stocks as s')
        ->select('s.*', 'pc.short_code', 'pc.full_name', 'b.name as brand_name', 'bs.name as size_name', 't.types_name')
        ->join('product_categories as pc', 'pc.id', '=', 's.product_category_id')
        ->join('brands as b', 'b.id' , '=', 's.brand_id')
        ->join('brand_sizes as bs', 'bs.id' , '=' , 's.brand_size_id')
        ->join('types as t', 't.id', '=', 's.type_id')
        ->orderBy('s.id','DESC')->get();

    	
    	return view('stock.index', compact('result'));
    }


    public function creat()
    {
        
    	$brands = DB::table('brands')->orderBy('name', 'asc')->where('cat_id', '<>',  1)->get();
    	$sizes =DB::table('brand_sizes')->orderBy('name', 'asc')->where('cat_id', '<>',  1)->get();
        $types =DB::table('types')->orderBy('types_name', 'asc')->where('cat_id', '<>',  1)->get();
        $company =DB::table('company')->orderBy('name', 'asc')->where('id', '<>',  1)->get();
        $category =DB::table('category')->orderBy('name', 'asc')->where('id', '<>',  1)->get();


    	$lot_result = DB::table('lots')->select('lot_no')->where([
            ['cat_id', '<>',  1],
            ['com_id', '<>',  1]
        ])->orderBy('lot_no', 'desc')->first();
    	if(!empty($lot_result))
    	{
    		$lot_no = $lot_result->lot_no;
    	}else{
    		$lot_no=1;
    	}


    	return view('stock.tshirt_stock_create', compact('brands', 'sizes', 'lot_no', 'types', 'company', 'category'));
    }

    public function store(Request $request)
    {
       
        $stock_lot =$request->stock_lot;
    	$products= $request->addmore;
    	$total_product=0;
    	$total_shocks=0;
    	$total_buying_price=0;
    	$total_saling_price=0;
    	$today = date('Y-m-d h:i:s');
    	$entry_by = Auth::user()->id;
        $valid_product = 0;
        $total_poroduct=0;
        $duplicate_poroduct=0;


        $com_id = $request->com_id;


       
        //product type wise validation
        foreach($products as $productInfo)
        {
            $single_product = $this->getProductDetails($productInfo['brand'], $productInfo['type'], $productInfo['size'], $com_id);


            if(!empty($single_product))
            {
                $valid_product = $valid_product + 1;
                
                
            }

        }

        
  
    	if(count($products) == $valid_product)
    	{
    		foreach($products as $productInfo)
    		{

                $single_product = $this->getProductDetails($productInfo['brand'], $productInfo['type'], $productInfo['size'], $com_id);

    			$pkt_qty = $productInfo['pkt_qty'];

    			$brand_id = $productInfo['brand'];
    			$brand_size_id = $productInfo['size'];
    			$per_packet_shocks_quantity = $productInfo['per_pkt_qty'];
    			$packet_buy_price = $single_product['individual_buying_price'] * $per_packet_shocks_quantity;
    			$packet_sale_price = $single_product['individual_selling_price'] * $per_packet_shocks_quantity;
    			$individual_buy_price = $single_product['individual_buying_price'];
    			$individual_sale_price = $single_product['individual_selling_price'];
                $product_id = $single_product['product_id'];
    			$lot_no = $stock_lot;
                $type_id = $single_product['type_id'];
                $sale_type = $single_product['sale_type'];
                $cat_id = $single_product['cat_id'];
                //$com_id = $single_product['com_id'];
    			$rate_date=date('Y-m-d');
    			if(!empty($individual_buy_price))
    			{

    				$product_category_id =  $this->getProductCat((INT) $individual_sale_price); /*product category*/
	    			$p_fist_number =  $this->priceFirstDgt((INT) $individual_sale_price); /*product category*/
	    			$p_last_number =  $this->getlast((INT) $individual_sale_price); /*product category*/

    			}else{

    				$product_category_id =  '';
	    			$p_fist_number =  '';
	    			$p_last_number =  '';
    			}
    			
    			if(!empty($individual_buy_price))
    			{
                    //$i=1;
    				for($i=1; $i <= $pkt_qty; $i++)
	    			{

	    			
                        
                        /*duplicate check*/
                        //$dupicate= DB::select("SELECT id  FROM `stocks` WHERE product_id='$product_id' and lot_no ='$lot_no' ");
                        $style_code_serial = $this->generateStyleCodeSerialNo($lot_no);

                        $style_code = $lot_no.date('dmY').$style_code_serial;
                        $GetProductBrandSize = $this->GetProductBrandSize($product_id);

                        //$printed_short_code = $this->GetProductTypeName($type_id).$stock_lot.'-'.$style_code_serial;
                        $printed_short_code = $this->GetProductTypeName($type_id).$stock_lot.'-'.$GetProductBrandSize['brand_name'].'-'.$GetProductBrandSize['size_name'].'-'.$style_code_serial;
	    				/*product insert*/
	    				$product_insert = DB::table('stocks')->insert([
	    					'brand_id' => $brand_id,
                            'style_code'=>$style_code,
	    					'brand_size_id' =>$brand_size_id,
	    					'per_packet_shocks_quantity' =>$per_packet_shocks_quantity,
	    					'packet_buy_price'=>str_replace(',', '', $packet_buy_price),
	    					'packet_sale_price'=>str_replace(',', '', $packet_sale_price),
	    					'individual_buy_price' =>str_replace(',', '',  $individual_buy_price),
	    					'individual_sale_price' => str_replace(',', '', $individual_sale_price),
	    					'product_category_id'=>$product_category_id['catgory_id'],
	    					'remaining_socks'=>$per_packet_shocks_quantity,
	    					'lot_no'=>$lot_no,
                            'product_id'=>$product_id,
                            'type_id'=>$type_id,
                            'sale_type'=>$sale_type,
	    					'entry_user_id'=>$entry_by,
	    					'entry_date_time'=>$today,
	    					'stock_in_date'=>date('Y-m-d'),
                            'print_packet_code'=>$printed_short_code,
                            'cat_id'=> $cat_id,
                            'com_id'=> $com_id,
                            


	    				]);

	    				$total_shocks = $total_shocks + $per_packet_shocks_quantity;
	    				//$total_product = $total_product + 1;
	    				$total_buying_price = $total_buying_price  + $packet_buy_price;
	    			    $total_saling_price = $total_saling_price  + $packet_sale_price;

	    			}

	    			

    			}
            }

                if($product_insert)
                {


                    $lot_no_result  = DB::table('lots')->where('lot_no', $lot_no)->where('com_id', $com_id)->where('cat_id', $cat_id)->count();
                    if($lot_no_result ==  0)
                    {

                         /*lots insert*/
                            $lots  = DB::table('lots')->insert([
                            'lot_no' => $lot_no,
                            //'total_product'=>count($products),
                            'total_shocks'=>str_replace(',', '', $total_shocks),
                            'total_buying_price'=>str_replace(',', '', $total_buying_price),
                            'total_saling_price'=>str_replace(',', '', $total_saling_price),
                            'entry_user_id'=>$entry_by,
                            'entry_datetime' =>$today,
                            'cat_id'=> $cat_id,
                            'com_id'=> $com_id,

                        ]);
                        file_put_contents('lot_no.txt', $com_id);

                    }else{

                        $sotck_lot_result  = DB::select("SELECT sum(per_packet_shocks_quantity) total_shocks ,sum(packet_buy_price) as total_buying_price, sum(packet_sale_price) as total_saling_price  FROM `stocks` where lot_no = '$lot_no' and com_id='$com_id' ");



                        $lots = DB::table('lots')->where('lot_no', $lot_no)->where('com_id', $com_id)->update([

                            'total_shocks'=>str_replace(',', '', $sotck_lot_result[0]->total_shocks),
                            'total_buying_price'=>str_replace(',', '', $sotck_lot_result[0]->total_buying_price),
                            'total_saling_price'=>str_replace(',', '', $sotck_lot_result[0]->total_saling_price),
                        ]);

                    }

                   


                        if($lots)
                        {

                            $response = [
                                "status" => 200,
                                "success" => true,
                                "message" => "Product stock Added Sucessfullyl",
                            ];

                           
                            return response()->json($response);
                            //return redirect('stock/stock-index')->with('message','Data Inserted Successfully !');

                        }else{

                            $response = [
                                "status" => 200,
                                "success" => true,
                                "message" => "Product stock not Added yet",
                            ];

                            return response()->json($response);
                        }    

                } //lot product

    	} //end if
        else{

            $response = [
                        "status" => 400,
                        "success" => false,
                        "message" => "Sorry product type not match",
                    ];

          return response()->json($response);
        }
    }

    public function generateStyleCodeSerialNo($lot_no){

        $today = date('Y-m-d');
        $max = DB::Select("SELECT COUNT(id) as max_number FROM `stocks` where date(entry_date_time) = '$today' and lot_no='$lot_no' ");
        return $max[0]->max_number  + 1;
    }


    public function getProductCat($price)
    {
    	$result = DB::table('product_categories')->select('short_code', 'id' )->where('starting_amt', '<=', $price)->where('ending_amt', '>=', $price)->first();
    	return	$result_array = array('short_code'=> $result->short_code, 'catgory_id'=> $result->id);
    	 
    	
    	 

    	//return strtoupper($cat_result[0]['short_code']);


    }

    public function priceFirstDgt($num)
    {
    	$str_number=strval($num);
		return $first_number = $str_number[0];
		
    }

    function getlast($num)
	{
	    return $last_number = $num % 10;
	}


    function getProductDetails($brand_id, $type_id, $brand_size_id, $com_id)
    {
        $product_details = DB::select("SELECT * FROM products where brand_id='$brand_id' and brand_size_id='$brand_size_id' and type_id='$type_id' and com_id='$com_id' order by id desc limit 1 ");
    

        //file_put_contents('123.txt', $sq."\n", FILE_APPEND);

        if(!empty($product_details))
        {       

                    
               $packet_buying_price = $product_details[0]->packet_buying_price;
               $packet_selling_price = $product_details[0]->packet_selling_price;
               $individual_buying_price = $product_details[0]->individual_buying_price;
               $individual_selling_price = $product_details[0]->individual_selling_price;
               $product_id = $product_details[0]->id;
               $type_id = $product_details[0]->type_id;
               $sale_type = $product_details[0]->sale_type;
               $cat_id = $product_details[0]->cat_id;
               

               return $product_array = array('packet_buying_price'=>$packet_buying_price, 'packet_selling_price'=>$packet_selling_price, 'individual_buying_price'=>$individual_buying_price, 'individual_selling_price'=>$individual_selling_price, 'product_id'=>$product_id, 'type_id'=> $type_id, 'sale_type'=>$sale_type, 'cat_id' => $cat_id);
        }else{
           
           return '';
        }

      

    }


    public function ProductCheck(Request $request)
    {
        $brand_check = $request->brand_check;
        $type_check = $request->type_check;
        $size_check = $request->size_check;

         $product_details = DB::select("SELECT id, packet_selling_price FROM products where brand_id='$brand_check' and brand_size_id='$size_check' and type_id='$type_check'  order by id desc limit 1 ");

         if(!empty($product_details[0]))
         {

            $data =[
                'success' => 1,
                'sale_price' => $product_details[0]->packet_selling_price,
            ];

            return response()->json($data);
            
            //echo  1;
         }else{
            $data =[
                'success' => 0,
                'sale_price' => '',
            ];

            return response()->json($data);
         }




    }


    //generate printed shor code
    public function GetProductTypeName($type_id)
    {
         $type = DB::table('types')->select('short_code')->where('id', $type_id)->first();

         if(!empty($type))
         {
             return $type->short_code;
         }else{
             return '';
         }
    }

    public function GetProductBrandSize($product_id)
    {
         $type = DB::select("SELECT b.short_code as brand_name, bs.name as size_name FROM products  p
         left join brands b on b.id = p.brand_id
         left join brand_sizes bs on bs.id = p.brand_size_id
         WHERE p.id='$product_id' ");

         if(count($type) > 0)
         {
            if(!empty($type))
            {
                $brand_name =  $type[0]->brand_name;
                $size_name = $type[0]->size_name;
                return ['brand_name' => $brand_name, 'size_name' => $size_name];
            }else{
                return '';
            }
         }

         
    }


    


    public function lot_voucher_index(){

         $data = DB::table('lot_voucher')->get();

        return view('stock.lot_voucher.index', compact('data'));
    }

    public function lot_voucher_create(Request $request){

       

        return view('stock.lot_voucher.create');
    }


    public function lot_voucher_store(Request $request){

        $lot_no = $request->lot_no;
        $voucher_no = $request->voucher_no;
        $total_amt = $request->total_amt;
        $voucher_img = $request->voucher_img;


      $last_inserted_id =  DB::table('lot_voucher')->insertGetId([

            "lot_no"=>$lot_no,
            "voucher_no"=>$voucher_no,
            "total_amt"=>$total_amt,
            "status"=>0,
            "entry_by"=>Auth::user()->id,
            "entry_datetime"=>date('Y-m-d h:i:s'),

        ]);


         if ($request->hasFile('image')) {

            $image = $request->image;
            
            $image_filename_extension = $image->getClientOriginalExtension();
            

             $filename = $last_inserted_id.".".$image_filename_extension;

             //echo base_path('public/uploads/blog_image/'.$filename);

             Image::make($image)->resize(400,300)->save(base_path('uploads/lot_voucher_image/'.$filename));

             DB::table('lot_voucher')->where('id',$last_inserted_id)->update([
                'image'=>$filename
             ]);

        }



        return redirect('stock/lot-voucher')->with('message',"Data Inserted Successfully !");


    }


    /* type info find out */
    public function typeCheck(Request $request)
    {
     

        $brand_id = $request->brand_id;
        $index_id = $request->index_id;
       

        if(!empty($brand_id))
        {

            $type_info = DB::table('types as ty')
                        ->leftJoin('products as pr', 'ty.id', '=', 'pr.type_id')
                        ->select('ty.types_name', 'ty.id')
                        ->where('pr.brand_id', $brand_id)
                        ->get();
           
            $data = [
                'type_info' => $type_info,
                'index_id' => $index_id

            ];

            $output =  view('stock.type_info', $data);

            return $output;

        }

    }


        /* type info find out */
        public function sizeCheck(Request $request)
        {
         
    
            $brand_id = $request->brand_id;
            $type_id = $request->type_id;
            $index_id = $request->index_id;
           
    
            if(!empty($brand_id))
            {
    
                $size_info = DB::table('types as ty')
                            ->leftJoin('products as pr', 'ty.id', '=', 'pr.type_id')
                            ->leftJoin('brand_sizes as bs', 'bs.id', '=', 'pr.brand_size_id')
                            ->select('bs.NAME AS size_name', 'bs.id')
                            ->where('pr.brand_id', $brand_id)->where('ty.id', $type_id)
                            ->get();
               
                $data = [
                    'size_info' => $size_info,
                    'index_id' => $index_id
    
                ];
    
                $output =  view('stock.size_info', $data);
    
                return $output;
    
            }
    
        }


        public function getLotNumber(Request $request)
        {
            $com_id = $request->com_id;
            $cat_id = $request->cat_id;
           

            $lot_result = DB::table('lots')->select('lot_no')->where([
                ['cat_id', '=',  $com_id],
                ['com_id', '=',  $cat_id]
            ])->orderBy('lot_no', 'desc')->first();

            if(!empty($lot_result))
            {
                $lot_no = $lot_result->lot_no;
            }else{
                $lot_no=1;
            }
            $previous_lot = $lot_no;
            $next_lot = $lot_no + 1;
            

            $output = ' <option value="">SELECT LOT </option>';
            $output .= '<option  value="'.$next_lot.'">'.$next_lot.'</option>';
            $output .= '<option value="'.$previous_lot.'">'.$previous_lot.'</option>';

            echo $output;

        }


        public function getBrands(Request $request)
        {
            $com_id = $request->com_id;
            $cat_id = $request->cat_id;

           $brands = DB::table('brands')
            ->select(['name', 'id'])
            ->where([
                ['com_id', '=', $com_id],
                ['cat_id', '=', $cat_id],
            ])->orderBy('name', 'asc')->get();

            

            $output = ' <option value="">State Brand</option> ';

            foreach($brands as $brand){
                $output .= '<option value="'. $brand->id.'">'.trim($brand->name).'</option>';
            }

            echo $output;
            
        }

    

   

}
