<?php

namespace App\Http\Controllers\Report\Rack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RackProductReport extends Controller
{
    public function index()
    {
        //$all_rack= DB::table('rack_mapping')->select('rack_code')->where('rack_code', '!=', '')->orderby('id', 'desc')->get();
        $all_rack= DB::table('racks')->select('rack_code')->where('rack_code', '!=', '')->orderby('id', 'desc')->get();
        $data = [
            'all_rack' => $all_rack
        ];

        return view('report.rack-product-voucher.index', $data);
    }

    public function details(Request $request)
    {

        $rack_code = $request->rack_code;

        

        $shop_product= DB::table('rack_products')->select('entry_date')->where('rack_code', $rack_code)->OrderBy('entry_date', 'desc')->first();
        $rack_number = str_replace('VLS', '', str_replace('-', '', $rack_code)); 
        $invoice_no = $rack_number.str_replace('-', '', $shop_product->entry_date);
        $current_date = date('m-d-Y');
        $sql = "SELECT
                    s.*,
                    rm.rack_code,
                    au.name as agent_name,
                    racks.rack_category,
                    s.name as shop_name,
                    s.shop_address,
                    s.contact_no,
                    s.owner_contact 
                FROM
                    rack_mapping rm 
                    left join
                    `shops` s 
                    on rm.shop_id = s.id 
                    left join
                    agent_users au 
                    on au.id = rm.agent_id 
                    left join 
                        racks on rm.rack_code=racks.rack_code
                where
                    rm.rack_code = '$rack_code'";

        $shop_info=DB::select(DB::raw($sql));

        if(count($shop_info) > 0)
        {
            $shop_info = $shop_info[0];
            $shop_name  = trim($shop_info->shop_name);
            $shop_address = trim($shop_info->shop_address);
            $shop_rack_code = $shop_info->rack_code;
            $contact_no = ($shop_info->contact_no)? $shop_info->contact_no : $shop_info->owner_contact;

            $psql = "SELECT
                            t.types_name,
                            t.short_code,
                            rp.selling_price,
                            rp.rack_code,
                            racks.rack_category,
                            count(rp.type_id) as product_qty,
                            sum(rp.selling_price) as total_sale_price 

                        from
                            shops s 
                            left join
                            rack_products rp 
                            on rp.shop_id = s.id 
                            left join
                            types t 
                            on t.id = rp.type_id 

                            left join 
                            racks 
                            on 
                            rp.rack_code=racks.rack_code

                        where
                            rp.rack_code = '$rack_code' 
                            and rp.status in (0,2) 
                        group by
                            rp.type_id 
                        order by
                            rp.selling_price desc";
            

        }else{
            $shop_info = '';
            $shop_name  = '';
            $shop_address = '';
            $shop_rack_code = $rack_code;
            $contact_no = '';

            $psql = "SELECT t.types_name,
                                t.short_code,
                                rp.selling_price,
                                rp.rack_code,
                                racks.rack_category,
                                Count(rp.type_id)     AS product_qty,
                                Sum(rp.selling_price) AS total_sale_price
                        FROM   rack_products  rp   
                                LEFT JOIN types t
                                    ON t.id = rp.type_id
                                LEFT JOIN racks
                                    ON rp.rack_code = racks.rack_code
                        WHERE    rp.rack_code = '$rack_code' 
                                AND rp.status IN ( 0, 2 )
                        GROUP  BY rp.type_id
                        ORDER  BY rp.selling_price DESC ";
            }
        

        $product_info = DB::select(DB::raw($psql));
        

        $product_info_table='';
        $sl=1;
        $grand_qty=0;
        $grand_selling_price=0;

        foreach($product_info as $single_product){
            
            $product_info_table.= "<tr>
              <td style='text-align: center' >".$sl++."</td>
              <td style='text-align: center' >$single_product->types_name</td>
              <td style='text-align: center' >$single_product->short_code</td>
              <td style='text-align: center' >".number_format($single_product->selling_price, 2)." /=</td>
              <td style='text-align: center' >$single_product->product_qty</td>
              <td style='text-align: center'>".number_format($single_product->total_sale_price,2)." /=</td>
             
          </tr>";
          $grand_qty  += $single_product->product_qty;
          $grand_selling_price  += $single_product->total_sale_price;
        }

        $grnad = "
        <th style='text-align: center' >".$grand_qty." Pair </th>
        <th style='text-align: center' >".number_format($grand_selling_price, 2)." /=</th>";
        $amount_in_word = $this->ConvertnumberTowords(str_replace(',', '', $grand_selling_price)); 
        
       
            $mpdf = new \Mpdf\Mpdf([

                'default_font_size' => 12,
                'default_font'      => 'nikosh'
              
    
            ]);
            
        
    
       
            
    
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

                <div style='text-align: center'>
                    <p>   <img src='data:image/png;base64,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'/> </p>
                    <p> চালান / Invoice  </p>
                </div>
    
            

        
    
    
      <table>
    
      <tr>
            <td rowspan='6'>

            <span> <b> দোকানের নাম / Shop Name :</b> </span>  $shop_name
              <br> <br>  
              
               <b> মোবাইল নাম্বার / Mobile No :</b> $contact_no
              <br> <br>
              <span> <b> দোকানের  ঠিকানা / Shop Address :</b> </span> $shop_address
            
               
            </td>
            
      <tr>
     
      <tr>
            
            <td>Invoice No: </td>
            <td> $invoice_no </td>
      </tr>
      <tr>
           
            <td>Invoice Date: </td>
            <td> $current_date </td>
      </tr>    
      <tr>
          
            <td>Rack No: </td>
            <td> $shop_rack_code </td>
      </tr>        
    
      </table>
    
      <h4>  পণ্যের বিবরন  / Product Information</h4>
    
    
      <table >
          <tr>
              <th style='text-align: center' width='30'>ক্রমিক নং / <br> SL </th>
              <th style='text-align: center' width='100'>পণ্যের ধরন / <br> Product Type </th>
              <th style='text-align: center' width='30'>চিহ্নিতকরন  / <br> ShortCode</th>
              <th style='text-align: center' width='100'>পণ্যের পরিমাণ (প্রতি জোড়ায় ) / <br>  Quantity (In Pair)</th>
              <th style='text-align: center' width='100'>প্রতি জোড়া বিক্রয়মূল্য / <br> Unit Price</th>
              <th style='text-align: center' width='100'>মোট  বিক্রয়মূল্য / <br>   Selling Price</th>
          </tr>
    
      ".$product_info_table."
        
        <tr>
           <th style='text-align: center' colspan='4'> সর্বমোট / Total  </th>
           ".$grnad."
        </tr>

      </table>
    
     <p> **  সর্বমোট  / Total =  <b> $amount_in_word </b>   টাকা ** </>
    
    
    <table style='border:none; margin-top: 200px;'>
    
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
    
        
        
        </html>";

    //$mpdf->Output('voucher.pdf','F');
//return $output; 
$mpdf->WriteHTML($output);
$mpdf->Output();

    }

    // number to word

    function ConvertnumberTowords($num)
    {
       
        $ones = array(
            0 => "ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            "014" => "FOURTEEN"
        );
        $tens = array(
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY",
            4 => "FORTY",
            5 => "FIFTY",
            6 => "SIXTY",
            7 => "SEVENTY",
            8 => "EIGHTY",
            9 => "NINETY"
        );
        $hundreds = array(
                "HUNDRED",
                "THOUSAND",
                "MILLION",
                "BILLION",
                "TRILLION",
                "QUARDRILLION"
            ); /*limit t quadrillion */
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {

            while (substr($i, 0, 1) == "0")
            $i = substr($i, 1, 5);
            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
                if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0
        ) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }


    
}
