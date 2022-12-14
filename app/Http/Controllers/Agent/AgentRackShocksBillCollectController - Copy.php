<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
class AgentRackShocksBillCollectController extends Controller
{
    public function billCollect(Request $request){

        if($request->has('shocks')){

            $shocks                  = $request->input('shocks');
            $rack_code               = $request->input('rack_code');
            $shop_id                 = $request->input('shop_id');
            $agent_sale_date         = $request->input('agent_sale_date');
            $total_bill              = $request->input('total_bill');
            $shop_committion         = $request->input('shop_committion');
            $agent_committion        = $request->input('agent_committion');
            $bill_col_last_day       = $request->input('bill_col_last_day');
            $total_shocks            = count($shocks);
            $total_amount            = 0;




            $entry_user_id  = Auth::user()->id;
            $entry_datetime = date('Y-m-d H:i:s');
            
             if(date('d') > $bill_col_last_day){
                $sold_date    = date("Y-m-d");
            }else{ 
              
                $sold_date    = date('Y-m-d', strtotime($agent_sale_date));

             } 

              /*--------------shocks commission ------------------------*/
              $commission_info= $this->updateScoksCommission($rack_code, $shop_id, $sold_date);
               $get_agent_commission_parcent = $commission_info['agent_commission_persentage'];
              $get_shop_commission_parcent = $commission_info['shop_commission_persentage'];
              /*--------------shocks commission ------------------------*/


            for($i=0; $i<$total_shocks; $i++)
            {
                $shock_code = $shocks[$i];

                $sold_socks_sale_price = DB::table('rack_products')->select('selling_price')->where('shocks_code', $shock_code)->first();

                 $shop_commission = ($sold_socks_sale_price->selling_price * $get_shop_commission_parcent) / 100;
                 $agent_commission = ($sold_socks_sale_price->selling_price * $get_agent_commission_parcent) / 100;
                 $venture_amount = $sold_socks_sale_price->selling_price -  ($shop_commission +  $agent_commission);
                DB::table('rack_products')->where('shocks_code', $shock_code)->update([
                    "status"              => 1,
                    "sold_mark_date_time" => $entry_datetime,
                    "sold_date"           => $sold_date,
                    "sold_mark_user_id"   => Auth::user()->id,
                    "shop_commission" => $shop_commission,
                    "agent_commission" => $agent_commission,
                    "venture_amount" => $venture_amount,
                ]);
                $shocks_info = DB::table('rack_products')->where('shocks_code', $shock_code)->first();
                $this->socksLog($shocks_info->id, "SOCKS_SOLD_MARK_BY_AGENT");

               

            }
             /*--------------monthly bill calculation ------------------------*/
            $this->monthlyBillCollection($rack_code, $shop_id, $sold_date);
             /*--------------monthly bill calculation ------------------------*/

            


            $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => "$total_shocks pair socks sold mark successfully"
            ];
            return response()->json($data);
            
            
        }
    }


    public function updateScoksCommission($rack_code, $shop_id, $bill_date)
    {
        $month = date('m', strtotime($bill_date));
        $year = date('Y', strtotime($bill_date));

        $total_sale_socks = DB::table('rack_products')->where([
            'shop_id' => $shop_id,
            'rack_code' => $rack_code,
        ])->whereIn('status', [1,3])->whereMonth('sold_date', $month)->whereYear('sold_date', $year)->count('*');


        $commissions      = $this->getTotalShocksCommissions($total_sale_socks, $shop_id);
        $agent_commission_parcent_pay = $commissions['agent_commission_persentage'];
        $shop_commission_parcent_pay  = $commissions['shop_commission_persentage'];

        $data =[
            'agent_commission_persentage' => $agent_commission_parcent_pay,
            'shop_commission_persentage'  => $shop_commission_parcent_pay,
        ];

        if($data !='')
        {
            return $data;
        }else{

              $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "commission not found",
                ];

              return $data;

        }
    }


    public function monthlyBillCollection($rack_code, $shop_id, $bill_date)
    {

          $month = date('m', strtotime($bill_date));
          $year = date('Y', strtotime($bill_date));

          $year_month = $year."-".$month;


        $sql= "SELECT sum(selling_price) as total_amount, sum(shop_commission) as shop_commission, sum(agent_commission) as agent_commission, sum(venture_amount) as venture_amount, count(*) as total_sock_pair FROM `rack_products` WHERE  rack_code='$rack_code' and status in (1,3) and month(sold_date)='$month' and year(sold_date)='$year' ";
        $bill_info = DB::select($sql);

        if($bill_info !='')
        {
            $bill_info = $bill_info[0];

            $sold_socks_pair = $bill_info->total_sock_pair;
            $total_amount = $bill_info->total_amount;
            $total_shopkeeper_amount = $bill_info->shop_commission;
            $total_agent_amount = $bill_info->agent_commission;
            $total_venture_amount = $bill_info->venture_amount;
        }



        $duplicate = DB::table('rack_monthly_bill')->where([
            ['shop_id', '=', $shop_id],
            ['rack_code', '=', $rack_code],
        ])->where('billing_year_month', $year_month)->count('*');

        if($duplicate ==0)
        {
            try {
                
                DB::table('rack_monthly_bill')->insert([
                        'shop_id' => $shop_id,
                        'rack_code' =>$rack_code,
                        'billing_year_month' => date('Y-m', strtotime($bill_date)),
                        'sold_socks_pair' =>$sold_socks_pair,
                        'total_amount' => $total_amount,
                        'total_shopkeeper_amount' => $total_shopkeeper_amount,
                        'total_agent_amount' => $total_agent_amount,
                        'total_venture_amount' => $total_venture_amount,

                ]);

            } catch (Exception $e) {

                 $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "rack_monthly_bill  insert ",
                ];

                return $data;
                
            }

        }else{

            $duplicate = DB::table('rack_monthly_bill')->where([
                ['shop_id', '=', $shop_id],
                ['rack_code', '=', $rack_code],
            ])->whereMonth('billing_year_month', $month)->whereYear('billing_year_month', $year)->first();

            
            try {
                
                DB::table('rack_monthly_bill')->where([
                    ['shop_id', '=', $shop_id],
                    ['rack_code', '=', $rack_code],
                ])->whereMonth('billing_year_month', $month)->whereYear('billing_year_month', $year)
                ->update([
                        'sold_socks_pair' =>$sold_socks_pair,
                        'total_amount' => $total_amount,
                        'total_shopkeeper_amount' => $total_shopkeeper_amount,
                        'total_agent_amount' => $total_agent_amount,
                        'total_venture_amount' => $total_venture_amount,

                ]);

            } catch (Exception $e) {

                 $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => "rack_monthly_bill update   fail ",
                ];

                return $data;
                
            }



        }








    }


    public function generateRackShocksVoucher($shocks_bill_no=''){


         $mpdf = new \Mpdf\Mpdf([

            'default_font_size'=>10,
            'default_font'=>'nikosh'

        ]);

        $mpdf->WriteHTML($this->pdfHTML($shocks_bill_no));

         $mpdf->Output();


    }



    public function pdfHTML($rack_code){


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
            
  

    
            <img src='data:image/png;base64,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'/>

          <h2 style='text-align:center;'>???????????????  ????????? ??????????????????</h2>
    <table>
        <tr>
        <td>??????????????? /  Date <span style='color:red;'>*</span></td>
        <td></td> 
         </tr>

      <tr>
         <td>????????????????????? ????????? /  Shop name <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>

     
      <tr>
         <td>??????????????? / Area <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>


       <tr>
         <td>??????????????????????????? ????????? / Market Name <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>



       <tr>
         <td>???????????? ?????????  / Rack Code. <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>


      <tr>
         <td>?????????????????? ?????????  / Agent Name. <span style='color:red;'>*</span></td>
         <td></td> 
      </tr>

  </table>

  <h4>  ?????????????????? ???????????????  / Product Information</h4>



  <table >
      <tr>
          <td>?????????????????? ?????? </td>
          <td>?????????????????? ????????? </td>
          <td> ????????? / Unit</td>
          <td>??????????????? ??????????????? ????????? / Unit Price</td>
          <td>????????????????????? /  Total</td>
          <td>?????????????????????????????? ???????????????  /  Shop Commission</td>
         
      </tr>

      <tr>

          <td>01 </td>
          <td>-- </td>
          <td> 10</td>
          <td>50</td>
          <td>500</td>
          <td>100</td>
         
      </tr>

      <tr>

          <td>01 </td>
          <td>-- </td>
          <td> 10</td>
          <td>50</td>
          <td>500</td>
          <td>100</td>
         
      </tr>

      <tr>

          <td>01 </td>
          <td>-- </td>
          <td> 10</td>
          <td>50</td>
          <td>500</td>
          <td>100</td>
         
      </tr>

      <tr>

          <td>01 </td>
          <td>-- </td>
          <td> 10</td>
          <td>50</td>
          <td>500</td>
          <td>100</td>
         
      </tr>


      <tr>

          <td>01 </td>
          <td>-- </td>
          <td> 10</td>
          <td>50</td>
          <td>500</td>
          <td>100</td>
         
      </tr>


     
  </table>

<br>
<p>?????? ????????????  ???????????? , ????????????????????? ????????? ???????????? , ?????????????????????????????? ??????????????? ????????? ???????????? , ???????????????????????? ???????????? ????????? ???????????? </p>   
<br>
<br>
<br>
<table style='border:none;'>

    <tr style='border:none;'>

        <td style='border:none;'>
        <p><b>_________________</b></p>
        ???????????????????????? (??????????????????????????? )</td>

        <td style='border:none;'>&nbsp;&nbsp;</td>
        <td style='border:none;'></td>
        <td style='border:none;'><p> <b> ____________________</b></p>???????????????????????? (??????????????????  ???????????????????????????  )</td>

        <td style='border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style='border:none;'></td>

        <td style='border:none;'><p> <b> _______________</b></p>???????????????????????? (??????????????? )</td>
    </tr>
</table>

<br>
<img src='data:image/png;base64,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'/>


         </html>";
        return $output;


    }


     //public function generateRackShocksVoucher($shocks_bill_no=''){


        // $shop_info = DB::table('shock_bills as sb')
        //     ->select([
        //         's.name  as shop_name',
        //         's.address  as shop_address'
        //     ])
        //     ->leftJoin('shops as s', 'sb.shop_id', '=', 's.id')
        //     ->where('shocks_bill_no', $shocks_bill_no)
        //     ->first();

        // $shop_info = [
        //     "shop_name"      => $shop_info->shop_name,
        //     "shop_address"   => $shop_info->shop_address,
        //     "shocks_bill_no" => $shocks_bill_no,
        //     "memo_date"      => date('Y-m-d')
        // ];

        // $shocks_sql = "SELECT
        //                     b.name as brand_name,
        //                     bs.name as brand_size_name,
        //                     count(*) as quantity,
        //                     sum(rp.selling_price) as amount 
        //                 from
        //                     rack_products rp 
        //                     left join
        //                     stocks s 
        //                     on rp.style_code = s.style_code 
        //                     left join
        //                     brands b 
        //                     on s.brand_id = b.id 
        //                     left join
        //                     brand_sizes bs 
        //                     on s.brand_size_id = bs.id 
        //                 where
        //                     rp.shocks_bill_no = '$shocks_bill_no' 
        //                 group by
        //                     s.brand_id,
        //                     s.brand_size_id";

        // $shcoks_datas = DB::select(DB::raw($shocks_sql));

        // $data = [
        //     "shop_info"    => $shop_info,
        //     "shcoks_datas" => $shcoks_datas
        // ];

        // $data = [
        //     "shop_info"    => '',
        //     "shcoks_datas" => ''
        // ];

        // $pdf      = PDF::loadView('rack.bill-collection.voucher', $data);
        // $path     = public_path('backend/assets/voucher/rack-bill/');
        // //$fileName = $shocks_bill_no. '.pdf';
        // $fileName = 'hasan'. '.pdf';
        // $pdf->save($path . '/' . $fileName); 
    //}

}
