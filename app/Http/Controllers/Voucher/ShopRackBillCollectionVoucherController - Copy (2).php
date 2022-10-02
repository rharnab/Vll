<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopRackBillCollectionVoucherController extends Controller
{

  public function voucherInfo($voucher_no){

        $this->voucherShow('202201271213267');die;
        $voucher_info_sql = "SELECT s.name as shop_name,au.name as agent_name,c.rack_code,c.shocks_bill_no, c.socks_pair, c.sale_amount,c.shop_commission_parcent,c.shop_commission,c.agent_commission,c.agent_commission_parcent FROM commissions c 
            LEFT JOIN shops s on c.shop_id = s.id
            LEFT JOIN agent_users au on c.agent_id = au.id
            WHERE c.shocks_bill_no = '$voucher_no'";


            $voucher_info = DB::select(DB::raw($voucher_info_sql));
            $data = [
              "voucher_info" => $voucher_info[0]
            ];
            return view('agent.rack.bill-collection.voucher-info', $data);
  }

    public function voucherShow($voucher_no){
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size'=>10,
            'default_font'=>'nikosh'
        ]);

        $mpdf->WriteHTML($this->pdfHTML($voucher_no));
        $mpdf->Output();
    }



    public function pdfHTML($voucher_no){
            
            $rack_info = DB::table('rack_monthly_bill as mc')
            ->select([
                       
                        's.name  as shop_name',
                        's.area  as shop_area',
                        's.market_name' ,
                        'rm.rack_code' ,
                        'au.name  as agent_name'
                    ])
            ->leftJoin('rack_mapping as rm', 'rm.shop_id', '=', 'mc.shop_id')
            ->leftJoin('shops as s', 'rm.shop_id', 's.id')
            ->leftJoin('agent_users as au', 'rm.agent_id', 'au.id')
            ->groupBy('mc.billing_year_month')->first();

          


            
            //$entry_datetime = date('jS,F Y h:i a', strtotime($rack_info->entry_datetime));
            $shop_name      = $rack_info->shop_name;
            $shop_area      = $rack_info->shop_area;
            $market_name    = $rack_info->market_name;
            $rack_code      = $rack_info->rack_code;
            $agent_name     = $rack_info->agent_name;

        

            $socks_info = '';
            $sl = 0;
            $total = 0;
            $total_shop_commission = 0;
            $total_unit = 0;

           


          
              
            $output         = "<html>
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

          <img
           src='data:image/png;base64,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'
        />

        <h2 style='text-align:center;'>সকল বকেয়া বিলের রশিদ </h2>
          <table>


      <tr>
      <td>তারিখ /  Date <span style='color:red;'>*</span></td>
      <td></td> 
       </tr>

    <tr>
       <td>দোকানের নাম /  Shop name <span style='color:red;'>*</span></td>
       <td>$shop_name</td> 
    </tr>

   
    <tr>
       <td>এলাকা / Area <span style='color:red;'>*</span></td>
       <td>$shop_area</td> 
    </tr>


     <tr>
       <td>মার্কেটের নাম / Market Name <span style='color:red;'>*</span></td>
       <td>$market_name</td> 
    </tr>



     <tr>
       <td>আলনা কোড  / Rack Code. <span style='color:red;'>*</span></td>
       <td>$rack_code</td> 
    </tr>


    <tr>
       <td>এজেন্ট নাম  / Agent Name. <span style='color:red;'>*</span></td>
       <td>$agent_name</td> 
    </tr>

</table>

<h4>  পণ্যের বিবরন  / Product Information</h4>";


 $billing_month_sql  = "SELECT sold_date FROM  rack_products where STATUS=3 and shocks_bill_no='$voucher_no' GROUP by month(sold_date), year(sold_date) order by sold_date asc";
 $billing_month = DB::select($billing_month_sql);

 foreach($billing_month as $singel_month)
 {
        $month = date('m', strtotime($singel_month->sold_date));
        $year = date('Y', strtotime($singel_month->sold_date));

        $billing_year_month = $year.'-'.$month;
      // $sql = "SELECT rp.sold_date,
      //                  ty.types_name,
      //                  rp.selling_price,
      //                  Count(*)            AS total_socks  ,
      //                  Sum(selling_price)   AS total_bill,
      //                  Sum(shop_commission) AS total_commission,
      //                  rmb.total_shopkeeper_amount - (cm.shop_commission_amount +  cm.old_shop_commission) as due_shop_commission,
      //                  rmb.total_agent_amount - (cm.agent_commission_amount +  cm.old_agent_commission) as due_agent_commission
      //           FROM   rack_products rp
      //                  LEFT JOIN types ty
      //                         ON ty.id = rp.type_id
      //                  LEFT JOIN commissions cm
      //                         ON cm.shoks_bill_no = rp.shocks_bill_no
      //                  LEFT JOIN rack_monthly_bill rmb
      //                         ON rmb.billing_year_month = cm.billing_year_month
      //           WHERE  rp.shocks_bill_no = '$voucher_no'
      //                  AND Month(sold_date) = '$month'
      //                  AND Year(sold_date) = '$year'
      //                  AND status = 3
      //           GROUP  BY rp.type_id,
      //                     rp.shocks_bill_no,
      //                     Month(rp.sold_date),
      //                     Year(rp.sold_date)";

      $sql = "SELECT *,
                     rmb.total_shopkeeper_amount,
                     cm.shop_commission_amount,
                     cm.old_shop_commission,
                     cm.old_shop_commission as due_shop_commission,
                     cm.old_agent_commission as due_agent_commission
              FROM   (SELECT rp.shocks_bill_no AS rp_socks_bill,
                             ty.types_name,
                             rp.type_id,
                             rp.selling_price,
                             Count(*) AS total_socks,
                             Sum(selling_price) AS total_bill,
                             Sum(shop_commission) as total_commission
                      FROM   rack_products rp
                             LEFT JOIN types ty
                                    ON ty.id = rp.type_id
                      WHERE  rp.shocks_bill_no = '$voucher_no'
                             AND status = 3 
                             AND Month(sold_date) = '$month'      
                             AND Year(sold_date) = '$year'
                      GROUP  BY rp.type_id) r
                     LEFT JOIN commissions cm
                            ON cm.shoks_bill_no = r.rp_socks_bill
                     LEFT JOIN rack_monthly_bill rmb
                            ON rmb.billing_year_month = cm.billing_year_month
              where cm.billing_year_month = '$billing_year_month'
              GROUP  BY cm.shoks_bill_no";




    $sold_info = DB::Select($sql);

    $sl = 1;
    $total_unit =0;
    $total_bill_amt = 0;
    $total_shop_commission =0; 
    foreach($sold_info as $single_sold_info)
    {

     $total_unit += $single_sold_info->total_socks;
     $total_bill_amt += $single_sold_info->total_bill;
     $total_shop_commission += $single_sold_info->total_commission;
     $shop_pay_due= $single_sold_info->due_shop_commission;
     $shop_pay_amount = $total_bill_amt - ($total_shop_commission + $shop_pay_due);

     $total_bill_amt= number_format($total_bill_amt, 2);
     if($single_sold_info->due_shop_commission == 0 )
     {
      $total_shop_commission= number_format($total_shop_commission, 2);
    }else{
       $total_shop_commission= number_format($total_shop_commission, 2).'+'.$single_sold_info->due_shop_commission;
    }
     

     

     

 $output .= "<h4>". date('M-Y', strtotime($singel_month->sold_date)) ."</h4>

<table>
    <tr>
        <td>ক্রমিক নং </td>
        <td>পণ্যের ধরন </td>        
        <td>প্রতি জোড়ার দাম / Unit Price</td>
        <td> একক / Unit</td>
        <td>সর্বমোট /  Total</td>
        <td>দোকানদারের কমিশন  /  Shop Commission</td>
       
    </tr>

    
     

    <tr>
        <td>".$sl++."</td>
        <td>".$single_sold_info->types_name."</td>        
        <td>".$single_sold_info->selling_price."</td>        
        <td>".$single_sold_info->total_socks."</td>        
        <td>".$single_sold_info->total_bill."</td>        
        <td>".$single_sold_info->total_commission."</td>        
    </tr>

    <tr>
        <td colspan='3'>Total / সর্বোমোট = </td>
        <td>".$total_unit." Pair</td>
        <td>$total_bill_amt</td>
        <td>$total_shop_commission</td>                
    </tr>

</table>

<p>$total_unit জোড়া  মোজা , সর্বমোট $total_bill_amt টাকা , দোকানদারের কমিশন $total_shop_commission টাকা ,  দোকানদার দিবে $shop_pay_amount টাকা   </p>";
    
       
    
    }


}
$output .="<br> 

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

<br>
<img src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gIoSUNDX1BST0ZJTEUAAQEAAAIYAAAAAAQwAABtbnRyUkdCIFhZWiAAAAAAAAAAAAAAAABhY3NwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAA9tYAAQAAAADTLQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlkZXNjAAAA8AAAAHRyWFlaAAABZAAAABRnWFlaAAABeAAAABRiWFlaAAABjAAAABRyVFJDAAABoAAAAChnVFJDAAABoAAAAChiVFJDAAABoAAAACh3dHB0AAAByAAAABRjcHJ0AAAB3AAAADxtbHVjAAAAAAAAAAEAAAAMZW5VUwAAAFgAAAAcAHMAUgBHAEIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAABvogAAOPUAAAOQWFlaIAAAAAAAAGKZAAC3hQAAGNpYWVogAAAAAAAAJKAAAA+EAAC2z3BhcmEAAAAAAAQAAAACZmYAAPKnAAANWQAAE9AAAApbAAAAAAAAAABYWVogAAAAAAAA9tYAAQAAAADTLW1sdWMAAAAAAAAAAQAAAAxlblVTAAAAIAAAABwARwBvAG8AZwBsAGUAIABJAG4AYwAuACAAMgAwADEANv/bAEMAAwICAgICAwICAgMDAwMEBgQEBAQECAYGBQYJCAoKCQgJCQoMDwwKCw4LCQkNEQ0ODxAQERAKDBITEhATDxAQEP/bAEMBAwMDBAMECAQECBALCQsQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEP/AABEIAFgDGAMBIgACEQEDEQH/xAAdAAEAAgIDAQEAAAAAAAAAAAAABQgGBwECBAMJ/8QASxAAAQMDAwIDBAYFBwoGAwAAAgADBAEFBgcREhMiFCEyFTFCUggjQVFichYkM4GCNENhcZGSlBclU1RVc6Gx0dJWY3SDosKEsuL/xAAbAQEBAQADAQEAAAAAAAAAAAAAAQIDBAUGB//EADoRAQABAwICBQcMAQUAAAAAAAACAQMSBBEFIiExMkLwBlJicrGy0hMUI0FRYXGCoaLR4hWBkcLh8v/aAAwDAQACEQMRAD8A/VNERAREQEREBERARaI+kzqVqRo45YM8xh+NLx5x/wBn3eBJj0MRKtak26JjsY1rShjXz47iHlXdT2mH0gbNqDIh22VaXLfOl7iFRdo4zU6UrXblXatN6U8vKvvpTdehXheo+a01kabwr9n1bfbR5dzjGks6r5ndljOvVvTorv8AZXq/32bZReK83e34/aJt9u0kY8G3R3JUh0vcDQDUir+6lKqu4/S/plXKmC4m6xFrUuEy6FTkQ08t6NBXand7tzr7t60+xY0nD9TraSlZjvSPXXqpRviHFdJwuNJamW2/VTrrVZVFCYdS/VxyE9k0nrXKQ31n/qxCjdS86BSlKU2402p/XSqm11JRxlWLu2rnysKT2rTem+1eun4iIiy5BERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERBi+puDQdScCveEz+AhdIpNtOFTejT1O5pz+E6CX7lQfSi93fG7m5Y51XId2sUusYxL1NPtHXj/ZUaj/AAr9IFRv6WeF10+1hgZ/b2ujbMvDhJIabC3Nb40Ktfspyp0y/pr1K/evrfJfUxuVucOu9U6b0/Gn809j4vyy0FbunjrLfat+zx7WbfSz1hbu2mWPYVjkigzs34vTBAt6sRWip1AL7abu023+2jblFDfRx09aut8gMnH/AFKAIy3qVp5VANqNhX7+RbVr99N1o+yuPZzmL9/dpWsdkaQolN96C2O9TKn9dalWn56q+Wh2I0xnDWpj7PCXdq0kn5bVFrbZsf6uPd/WdV3+J0jwPhtNHb7Uq71/1/inseHoZXfKXi0J36ctulK1+zem3tr7atSStaNZYP0fLVrBBv2N3283sLOLFlZtJNUZfmSGg6ZHR8irvQyGnbTzrSvnttWWyLWjPbtbcmybAr/Zo1qtN/x63waSbUUgpMW6s2shcqVHg4kFZzpeVK0KnGnltvWPwXSnMLXpbh2B00hYsF2sl0xmbd7m3IgcZ/gZ7Djx1Jlyrh1oFHSpzpvXzpTzrtXvYtA82xvEdQMViRGX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' />

       </html>";
      return $output;


  }



}
