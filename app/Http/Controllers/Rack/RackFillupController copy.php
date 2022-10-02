<?php

namespace App\Http\Controllers\Rack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class RackFillupController extends Controller
{
    public function index(){
        $sql = "SELECT
                rack.*,

                (
                SELECT
                    count(*) 
                from
                    rack_products 
                where
                    rack_code = rack.rack_code 
                    and status = 0 
                )
                as current_shocks,
                r.rack_category,
                r.rack_level,
                r.total_count,
                au.name as agent_name,
                s.name shop_name 
            from
                (
                SELECT
                    id,
                    rack_code,
                    agent_id,
                    shop_id 
                from
                    rack_products 
                group by
                    rack_code,agent_id,shop_id
                )
                rack 
                left join
                racks r 
                on rack.rack_code = r.rack_code 
                LEFT JOIN
                agent_users au 
                on rack.agent_id = au.id 
                LEFT join
                shops s 
                on rack.shop_id = s.id";

        $racks = DB::select(DB::raw($sql));
        $data = [
            "racks" => $racks,
            "sl" => 1
        ];

       // return $data;

        return view('rack.rack-fillup.index', $data);
    }

    public function create(){
        $racks  = DB::table('racks')->select('id', 'rack_code', 'rack_category', 'total_count')->get();
        $agents = DB::table('agent_users')->select('name','id','mobile_number')->get();
        $shops  = DB::table('shops')->select('name', 'id')->get();
        $data = [
            "racks"  => $racks,
            "agents" => $agents,
            "shops"  => $shops
        ];

        return view('rack.rack-fillup.create', $data);
    }


    public function addNewRow(Request $request){
        $index = $request->input('index');
        $style_codes = $request->input('style_codes');
        if(is_array($style_codes)){
            $style_list = "";
            for($i=0; $i<count($style_codes); $i++){
                $style_list .= "'$style_codes[$i]',";
            }   
            $style_list = substr_replace($style_list, "", -1);    
            $styleSql = " and st.style_code not in ($style_list) ";
        }else{
            $styleSql = "";
            $style_list = "";
        }
        $sql = "SELECT
                    st.style_code,
                    bd.name as brand_name,
                    bz.name as size_name,
                    st.per_packet_shocks_quantity,
                    st.remaining_socks,
                    st.individual_buy_price,
                    st.individual_sale_price 
                FROM
                    stocks st 
                    left join
                    brands bd 
                    on st.brand_id = bd.id 
                    left join
                    brand_sizes bz 
                    on st.brand_size_id = bz.id 
                where 
                    remaining_socks > 0 and status=0 and st.sale_type = 2 $styleSql order by st.lot_no,st.style_code";
        $products = DB::select(DB::raw($sql));
        $data = [
            "products" => $products,
            "index"    => $index
        ];

        $output = view('rack.rack-fillup.add-new-row', $data);
        return $output;
    }


    public function styleCodeRemainingProduct(Request $request){
        if($request->has('style_code') && !empty($request->input('style_code'))){
            $style_code = $request->input('style_code');
            $index = $request->input('index');

            $shocks = DB::table('stocks')->where('style_code', $style_code)->select('remaining_socks')->first();
            return $shocks->remaining_socks ?? 0;
        }
    }


    public function store(Request $request){
       

        $rack_code               = $request->input('rack_id');
        $status                  = $request->input('status');
        $agent_id                = $request->input('agent_id');
        $shop_id                 = $request->input('shop_id');
        $products_array          = $request->input('products');
        $remaining_shocks_array  = $request->input('remaining_shocks');
        $shocks_take_array       = $request->input('shocks_take');
        $total_row_count         = count($products_array);
        $racks_remainning_shocks = $this->rackStoreRemainingShocks($rack_code);
        $total_taken_shocks      = array_sum($request->input('shocks_take'));

        // if($this->checkRakRefill($rack_code) === true){
        //     $status = 2; // refill
        // }else{
        //     $status = 1; // initial
        // }


        if($total_taken_shocks > $racks_remainning_shocks){
            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => "You have take maximum $racks_remainning_shocks shocks in this rack"
            ];
            return response()->json($data);
        }

        $duplicate_products = $this->findDuplicate($products_array);
        if($duplicate_products === false){

            // shocks check remaming 
            for($i=0; $i< $total_row_count; $i++){
                
                $shocks_take      = $shocks_take_array[$i]; 
                $style_code       = $products_array[$i];

                if($this->checkRemainingShocks($style_code) < $shocks_take){

                    $data = [
                        "status"   => 400,
                        "is_error" => true,
                        "message"  => "Insufficient shocks in $style_code packet"
                    ];
                    return response()->json($data);
                    
                }
            }

            // reamming validation pas



            for($i=0; $i< $total_row_count; $i++){
          
                $style_code       = $products_array[$i];
                $shocks_take      = $shocks_take_array[$i];

                if($this->insertRackProducts($agent_id, $shop_id, $rack_code, $style_code, $shocks_take, $status) === false){
                    $data = [
                        "status"   => 400,
                        "is_error" => true,
                        "message"  => "Failed to insert socks in rack"
                    ];
                    return response()->json($data);
                }
                
            }

            DB::table('racks')->where('rack_code', $rack_code)->update([
                "status" => 1
            ]);

            $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => "$total_taken_shocks shocks insert rack successfully"
            ];
            return response()->json($data);

        }else{
            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => "You had selected $duplicate_products product multiple times"
            ];
            return response()->json($data);
        }


        
    }


    public function insertRackProducts($agent_id, $shop_id, $rack_code, $style_code, $shocks_take, $status){
      
        $stylecodeprice  = DB::table('stocks')->where('style_code', $style_code)->first();
        $buying_price    = $stylecodeprice->individual_buy_price;
        $selling_price   = $stylecodeprice->individual_sale_price;
        $current_user_id = Auth::user()->id;
        $today           = date('Y-m-d');
        $time            = date('H:i:s');

        for($i=0; $i<$shocks_take; $i++){
            $get_style_code_shock_no = $this->getStyleCodeShockNo($style_code);
            $insertSql  = [
                "agent_id"         => $agent_id,
                "shop_id"          => $shop_id,
                "rack_code"        => $rack_code,
                "style_code"       => $style_code,
                "packet_shocks_no" => $get_style_code_shock_no,
                "shocks_code"      => $style_code."-".$get_style_code_shock_no,
                "buying_price"     => $buying_price,
                "selling_price"    => $selling_price,
                "status"           => 0,
                "entry_user_id"    => $current_user_id,
                "entry_date"       => $today,
                "entry_time"       => $time,
                "status"           => $status
            ];
           
            file_put_contents("h.txt", json_encode($insertSql)."\n", FILE_APPEND);
            DB::table('rack_products')->insert($insertSql);    
        }

        try{
            $today = date('Y-m-d');
            DB::update("UPDATE stocks SET remaining_socks = (remaining_socks - $shocks_take),stock_out_date='$today',sales_agent_id='$agent_id' WHERE style_code='$style_code'");
            return true;
        }catch(Exception $e){
            return false;
        }
       
       
    }

                

    public function showDetails($id){

     
       $get_heading_info = DB::select(DB::raw("SELECT rp.id, au.name as agent_name, sh.name as shop_name, rack_code FROM `rack_products` rp LEFT JOIN `agent_users` au on rp.agent_id = au.id LEFT JOIN shops sh on rp.shop_id = sh.id WHERE rp.id = '$id'"))[0];



        // return $get_heading_info;

        $rack_code = $get_heading_info->rack_code;

        $get_data=DB::select(DB::raw("SELECT rp.rack_code,rp.style_code, rp.shocks_code, rp.buying_price, rp.selling_price, rp.entry_date, rp.entry_time, st.brand_id, st.brand_size_id, br.name as brand_name, bs.name as brand_sise_name  FROM `rack_products`  rp left join stocks st on rp.style_code=st.style_code left join brands br on st.brand_id = br.id left join brand_sizes bs on st.brand_size_id = bs.id  WHERE rp.rack_code = '$rack_code'"));
                // $view =  view('rack.rack-fillup.show-details',['data'=>$get_data ])->render();

                // return response()->json(['html' => $view]);


         return view('rack.rack-fillup.show-all-socks',compact('get_heading_info', 'get_data'));




    }


    public function generate_pdf_socks_code($id){


//                          $output = '';
//                                                     $str = '';
//                                                     $etr = '';
//                                                     $sl = 1;

//                                                     for($i=1; $i<26; $i++){
//                                                        if($sl == 1){
//                                                              $output.="<tr>";
//                                                        }
//                                                         $sl++;
//                                                        $output.="<td>HALIM</td>";

//                                                        if(($i % 6) == 0){

//                                                              $output.="</tr>";
//                                                              $sl = 1;
//                                                        }

                                                      
//                                                     }
//                                                     if(($i-1)%6 != 0){
//                                                         $output.="</tr>";
//                                                     }
                                                    


//                                                     // echo $output;                           

// file_put_contents("g.txt", $output);
//                                                     return $output;
                                     
        

       $get_heading_info = DB::select(DB::raw("SELECT rp.id, au.name as agent_name, sh.name as shop_name, rack_code FROM `rack_products` rp LEFT JOIN `agent_users` au on rp.agent_id = au.id LEFT JOIN shops sh on rp.shop_id = sh.id WHERE rp.id = '$id'"))[0];


        $rack_code = $get_heading_info->rack_code;

        $get_data=DB::select(DB::raw("SELECT rp.rack_code,rp.style_code, rp.shocks_code, rp.buying_price, rp.selling_price, rp.entry_date, rp.entry_time, st.brand_id, st.brand_size_id, br.name as brand_name, bs.name as brand_sise_name  FROM `rack_products`  rp left join stocks st on rp.style_code=st.style_code left join brands br on st.brand_id = br.id left join brand_sizes bs on st.brand_size_id = bs.id  WHERE rp.rack_code = '$rack_code'"));

          
        // $pdf = PDF::loadView('rack.rack-fillup.socks_codePDF', compact('get_heading_info', 'get_data'));
        
        //  Storage::put('uploads/pdf/socks_code.pdf', $pdf->output());
         
        // return $pdf->download('socks_code.pdf');


        return view('rack.rack-fillup.show_socks_code', compact('get_data'));



    }



    public function checkRakRefill($rack_code){
        $rack__data = DB::table('rack_products')->where('rack_code', $rack_code)->count();
        if($rack__data > 0){
            return true;
        }else{
            return false;
        }
    }


}
