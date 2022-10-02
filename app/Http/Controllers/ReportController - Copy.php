<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportController extends Controller
{   

    public function socks_code_generate(){

        $get_rack_info = DB::table('racks')->get();
        return view('report.rack-socks-code.index', compact('get_rack_info'));

    }
    public function generate_pdf(Request $request){
     
         $rack_code = $request->rack_code;
         $date = $request->date;
         $ending_date = $request->ending_date;
         $price_tag = $request->price_tag;
         $socks_code = $request->socks_code;
         $new_socks_array = array();
         foreach($socks_code as $single_socks_code)
         {
            array_push($new_socks_array, "'".$single_socks_code."'");
         }

         $socks_code_list= implode(',', $new_socks_array);

         
         if($socks_code_list === "'0'")
         {
            $socks_code_list= '';
         }else{
            $socks_code_list=' and rp.printed_socks_code in ('.$socks_code_list.') ';
         }


         if (!empty($date)) {

            $finally_date =  date('Y-m-d', strtotime($date));
            $ending_date =  date('Y-m-d', strtotime($ending_date));
         }

         $date =  $request->date;
      
           $get_data=DB::select(DB::raw("SELECT rack.brand_id,rack.printed_socks_code,rack.selling_price,rack.shop_socks_code,b.short_code as brand_name, rack.sl_priority,rack.rp_id, shop_name 
          FROM (SELECT st.brand_id,rp.printed_socks_code,rp.shop_socks_code,rp.selling_price,t.sl_priority,rp.id as rp_id, 
          sh.name as shop_name FROM `rack_products` rp 
                LEFT JOIN stocks st on rp.style_code = st.style_code
                LEFT JOIN types t on t.id = st.type_id
                LEFT JOIN shops sh on rp.shop_id = sh.id
                WHERE rp.rack_code='$rack_code' and rp.entry_date  BETWEEN '$finally_date' and '$ending_date' AND (rp.status='0' or rp.status='2')) rack 
          LEFT JOIN brands b on rack.brand_id = b.id
          order by rack.sl_priority,rack.rp_id asc"));

          
    
        $refill_check = DB::select(DB::raw("SELECT count(*) as total  from (SELECT entry_date FROM `rack_products` WHERE rack_code='$rack_code' GROUP by entry_date) fill_count"));


        $shop_info=DB::select(DB::raw("SELECT sh.name as shop_name, sh.address, sh.contact_no  FROM `rack_products` rp left join shops sh on rp.shop_id=sh.id  WHERE rp.rack_code='$rack_code'"))[0];


        $data = [
            "get_data"     => $get_data,
            "rack_no"      => $rack_code,
            "price_tag"    => $price_tag,
            "date"         => $date,
            "refill_count" => $refill_check[0]->total,
            "shop_info" => $shop_info,
        ];



         //return $data;

         $pdf = PDF::loadView('report.rack-socks-code.generate_pdf', $data);
        
        // Storage::put('uploads/pdf/socks_code.pdf', $pdf->output());

        $downolad_file_name=$rack_code." socks-code-generate-pdf_".date('Y-m-d h:i:s a').".pdf";
        return $pdf->stream($downolad_file_name, array("Attachment" => false));
         
        //  $socks_code_generate_pdf="Rack Code : $rack_code date : $finally_date".".pdf";
        //  return $pdf->download("$socks_code_generate_pdf");

       // return view('report.rack-socks-code.index');

    } //end socks_code_generate



    // start lot brands report
    public function lot_brands(){

        $get_lot = DB::table('lots')->get();

        $data=[
            'lots'=>$get_lot
        ];

        return view('report.lot_brands.index', $data);
    }



    public function lot_brands_report_table(Request $request){
        
      $lot_no = $request->lot_no;


      DB::select(DB::raw("SELECT s.lot_no,s.brand_id,b.name as brand_name, sum(s.packet_buy_price) as total_packet_by_price, sum(s.packet_sale_price) as total_packet_sale_price, sum(s.individual_buy_price) as total_individual_buy_price, sum(s.individual_sale_price) as total_individual_sale_price, sum(s.remaining_socks) as total_remaining_socks FROM `stocks` s left join brands as b on s.brand_id = b.id WHERE lot_no='$lot_no' GROUP BY brand_id"));

    }


     //end lot brands report

    
    // start rack products


    // start rack products

    public function rack_product(){

        $get_rack_info = DB::table('racks')->get();

        return view('report.rack-product.index', compact('get_rack_info'));
    }


    public function rack_product_table(Request $request){

       $rack_code = $request->rack_code;
       $date = $request->date;

       if (!empty($date)) {

            $finally_date = date('Y-m-d',strtotime($date));
       }
      

        $get_data =   DB::select(DB::raw("select rp.style_code,b.name as brand_name, t.types_name, bz.name as size_name, st.per_packet_shocks_quantity,  rp.socks_pair from (SELECT style_code, count(*) as socks_pair from rack_products where rack_code = '$rack_code' and entry_date='$finally_date' GROUP by style_code) rp
                LEFT join stocks st on rp.style_code = st.style_code
                LEFT JOIN brands b on st.brand_id = b.id
                LEFT JOIN brand_sizes bz on st.brand_size_id = bz.id
                LEFT JOIN types t on st.type_id = t.id
                order by t.id asc"));

        

           return view('report.rack-product.data', compact('get_data'));
    }

    // end rack products








    public function rack_refil_voucher(){

        $get_rack_info = DB::table('racks')->get();
        return view('report.rack-refil-voucher.index', compact('get_rack_info'));
    }



     public function rack_refil_voucher_table(Request $request){

        $rack_code = $request->rack_code;
         $date = $request->date;

         if (!empty($date)) {

            $finally_date =  date('Y-m-d', strtotime($date));
         }

                     

        // $get_data=DB::select(DB::raw("SELECT * FROM `rack_products` WHERE rack_code='$rack_code'"));

        // $data = [
        //     "get_data" => $shop_info,
        //     "rack_no"=>$rack_code,
        //     "date"=>$date
        // ];



         //  return $data;

        //  $pdf = PDF::loadView('report.rack-refil-voucher.generate_pdf', $data);
        
        // // Storage::put('uploads/pdf/socks_code.pdf', $pdf->output());

        //  return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
         
        //  $socks_code_generate_pdf="Rack Code : $rack_code date : $finally_date".".pdf";
        // return $pdf->download("$socks_code_generate_pdf");



          $mpdf = new \Mpdf\Mpdf([

            'default_font_size'=>10,
            'default_font'=>'nikosh'

        ]);

        $mpdf->WriteHTML($this->pdfHTML($rack_code, $finally_date));

         $mpdf->Output();


             


    } //end rack_refil_voucher_table function






    public function pdfHTML($rack_code, $date){

        // echo "$rack_code, $date";


$shop_info=DB::select(DB::raw("SELECT s.*, au.name as agent_name, s.name as shop_name FROM `shops` s
left join rack_mapping rm on rm.shop_id = s.id
left join agent_users au on au.id = rm.agent_id
where rm.rack_code = '$rack_code'"));



if(count($shop_info) > 0)
{
  $shop_info = $shop_info[0];
}else{
  return "";
}

      $sql = "select  t.types_name, t.short_code, rp.selling_price, count(rp.type_id) as product_qty   from shops s
      left join rack_products rp on rp.shop_id = s.id
      left join types t on t.id = rp.type_id
      where rp.rack_code = '$rack_code' and rp.fill_type='2' and rp.entry_date='$date'  group by rp.type_id order by rp.selling_price desc";


         $product_info = DB::select(DB::raw($sql)); 

    
    $product_info_table='';
    $sl=1;
    foreach($product_info as $single_product){
        
        $product_info_table.= "<tr>
          <td>".$sl++."</td>
          <td>$single_product->types_name</td>
          <td>$single_product->short_code</td>
          <td>$single_product->selling_price</td>
          <td>$single_product->product_qty</td>
         
      </tr>";
    }

   
        

        $output = "<html>

        <style type='text/css'>

            table, td, th {     
              border: 1px solid black;
              text-align: left;
            }

        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          padding: 5px;
          font-size: 12px;
        }

       
       

       


    </style>

            <img style='margin-left: 50px;' src='data:image/png;base64,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'>
          
            
            <table style='border:none;'>

            <tr style='border:none;'>
        
               
                <td style='border:none; width:25rem'> </td> 
                <td style='border:none; width:25rem'> 
                  <p style='text-align: center; font-size: 2.3rem; color: #3C80BE';> পণ্য প্রদান রশিদ  </p>
                </td>
              
                <td style='border:none; width:10rem; font-size: 1rem; '>".date('d-M-Y')."</td>
        
               
            </tr>
        </table>


           
            <p style='font-size: 1.3rem'> <span style='color:red'> ** </span> দোকানের তথ্য/ Shop Information  </p>

            <table>
      <tr>
         <td>দোকানের নাম /  Shop name <span style='color:red;'>*</span></td>
         <td>".$shop_info->shop_name."</td> 
      </tr>

      <tr>
         <td>দোকান নং / Shop No  <span style='color:red;'>*</span></td>
         <td>".$shop_info->shop_no."</td> 
      </tr>

       <tr>
         <td>দোকানের  ঠিকানা / Shop Address <span style='color:red;'>*</span></td>
         <td>".$shop_info->shop_address."</td> 
      </tr>


      <tr>
         <td>এলাকা / Area <span style='color:red;'>*</span></td>
         <td>".$shop_info->area."</td> 
      </tr>


       <tr>
         <td>মার্কেটের নাম / Market Name <span style='color:red;'>*</span></td>
         <td>".$shop_info->market_name."</td> 
      </tr>


      

        <tr>
         <td>ম্যানেজার নাম / Manager Name <span style='color:red;'>*</span></td>
         <td>".$shop_info->manager_name."</td> 
      </tr>

       <tr>
         <td>ম্যানেজারের মোবাইল নাম্বার  / Manager Mobile Number <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>


      <tr>
         <td>ম্যানেজারের ইমেইল  / Manager Email <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>


      

       <tr>
         <td>আলনা নং  / Rack No. <span style='color:red;'>*</span></td>
         <td>".$shop_info->rack_no."</td> 
      </tr>

       <tr>
         <td>আলনার ধরন  / Rack Type. <span style='color:red;'>*</span></td>
         <td>".$shop_info->rack_type."</td> 
      </tr>

      <tr>
         <td>এজেন্ট নাম  / Agent Name. <span style='color:red;'>*</span></td>
         <td>".$shop_info->agent_name."</td> 
      </tr>

  </table>

  <h4>  পণ্যের বিবরন  / Product Information</h4>


  <table>
      <tr>
          <th>ক্রমিক নং </th>
          <th>পণ্যের ধরন </th>
          <th>চিহ্নিতকরন  / ShortCode</th>
          <th>বিক্রয়মূল্য / Sell Price</th>
          <th>পণ্যের পরিমাণ (প্রতি জোড়ায় হিসেবে) /  Product Quantity (Per Pair)</th>
      </tr>

    ".$product_info_table."      
  </table>


<br>
<br>
<br>
<table style='border:none;'>

    <tr style='border:none;'>

        <td style='border:none;'>
        <p><b>_________________</b></p>
        স্বাক্ষর (কর্তৃপক্ষ )</td>

        <td style='border:none;'>&nbsp;&nbsp;</td>
        <td style='border:none;'></td>
        <td style='border:none;'><p> <b> ____________________</b></p>স্বাক্ষর (বিক্রয়  প্রতিনিধি  )</td>

        <td style='border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style='border:none;'></td>

        <td style='border:none;'><p> <b> _______________</b></p>স্বাক্ষর (দোকান )</td>
    </tr>
</table>



<img src='data:image/png;base64,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'/>






         </html>";
        return $output;
    }


    public function find_socks_code(Request $request)
    {
        $rack_code = $request->rack_code;

        $all_socks_code= DB::select("SELECT printed_socks_code from rack_products WHERE (STATUS = 0 or status=2) and rack_code= '$rack_code' order by printed_socks_code asc ");

       

        
        $data  = [
          'all_socks_code' => $all_socks_code
        ];

         $output = view('report.rack-socks-code.socks_code', $data);

         return $output;

       
    }

    


}
