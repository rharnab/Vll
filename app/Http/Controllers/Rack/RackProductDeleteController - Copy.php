<?php

namespace App\Http\Controllers\Rack;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RackProductDeleteController extends Controller
{
    public function index(){
        $racks = DB::table('rack_products')->select('rack_code')->where('status',0)->orWhere('status', 2)->groupBy('rack_code')->get();
        $data = [
            "racks" => $racks
        ];
        return view('rack.socks-delete.index', $data);
    }

    public function findSocksList(Request $request){
        $rack_code = $request->input('rack_code');
        $socks_no = DB::select("SELECT
                    rp.shocks_code,
                    rp.printed_socks_code,
                    rp.shop_socks_code,
                    bd.name as brand_name,
                    bz.name as brand_size_name,
                    t.id as type_id,
                    t.types_name  
                FROM
                    `rack_products` rp 
                    left JOIN
                    stocks st 
                    on rp.style_code = st.style_code 
                    left JOIN
                    brands bd 
                    on st.brand_id = bd.id 
                    LEFT JOIN
                    brand_sizes bz 
                    on st.brand_size_id = bz.id 
                    LEFT JOIN
                    types t 
                    on st.type_id = t.id 
                where
                    rp.rack_code = '$rack_code'
                    and (rp.status = 0 or rp.status = 2) order by rp.type_id asc");
        $output = "<option value=''>Select Socks</option>";
        foreach($socks_no as $socks){
            $output .= "<option value='$socks->printed_socks_code'>$socks->printed_socks_code</option>";
        }
        echo $output;

        //$output = view('rack.socks-delete.shock_list', compact('socks_no'));

        //return $output;
    }

    public function findSocks(Request $request){

        if($request->has('socks_code')){

            $socks_code = $request->input('socks_code');
            $sql = "SELECT rp.rack_code,rp.status,rp.entry_date,rp.style_code,rp.printed_socks_code, b.name  as brand_name, bs.name  as size_name, t.types_name 
            FROM `rack_products` rp 
            left join stocks st on rp.style_code  = st.style_code  
            left  join brands b on st.brand_id  = b.id 
            left  join  brand_sizes bs  on st.brand_size_id  = bs.id 
            left join  types t on st.type_id  = t.id 
            where rp.printed_socks_code='$socks_code' and rp.status = 0";

            $shocks_info = DB::select(DB::raw($sql));

            if( count($shocks_info) > 0){
                $data = [
                    "rack_code"  => $shocks_info[0]->rack_code,
                    "entry_date" => $shocks_info[0]->entry_date,
                    "brand_name" => $shocks_info[0]->brand_name,
                    "size_name"  => $shocks_info[0]->size_name,
                    "types_name" => $shocks_info[0]->types_name,
                    "style_code" => $shocks_info[0]->style_code,
                    "rack_code"  => $shocks_info[0]->rack_code,
                    "socks_code" => $socks_code,
                    "found"      => true
                ];
                return view('rack.socks-delete.search', $data);
            }else{
                $data = [
                    "found"      => false,
                    "socks_code" => $socks_code
                ];
                return view('rack.socks-delete.search', $data);
            }
            
        }
    }

    public function deleteSocks(Request $request){
        $socks_code_array = $request->input('socks_code');
        echo "<pre>";
        print_r($socks_code_array);die;


        $return_count = 0;
        foreach($socks_code_array as $socks_code){
            $socks_info = DB::table('rack_products')->where('printed_socks_code', $socks_code)->first();
            if($socks_info->status == 0 or $socks_info->status == 2){
                $style_code = $socks_info->style_code;
                try{
                    DB::table('rack_products')->where('printed_socks_code', $socks_code)->update([
                        "status"         => 5,
                        "return_user_id" => Auth::user()->id,
                        "return_date"    => date('Y-m-d')
                    ]);
                    $return_count++;
                    DB::update("UPDATE stocks SET remaining_socks = (remaining_socks + 1) WHERE style_code='$style_code'");
                    // rack log
                    $this->socksLog($socks_info->id, "SOCKS_RETURN_FROM_RACK");                    
                }catch(Exception $e){
                    $data = [
                        "status" => 400,
                        "message" => $e->getMessage()
                    ];
                    return response()->json($data);
                    die();
                }
            }else{
                $data = [
                    "status" => 400,
                    "message" => "$socks_code not available for return"
                ];
                return response()->json($data);
                die();
            }
        }

        $data = [
            "status"  => 200,
            "message" => "$return_count Socks Return From Rack successfully"
        ];
        return response()->json($data);

    }


    public function socks_return_voucher(){

        $get_rack = DB::table('racks')->get();
        return view('rack.socks_return_voucher.index', compact('get_rack'));

    }

   public function generate_socks_return_voucher(Request $request){
        
        $rack_code = $request->rack_code;
        $starting_date = $request->starting_date;
        $ending_date = $request->ending_date;


       $mpdf = new \Mpdf\Mpdf([
            'default_font_size'=>10,
            'default_font'=>'nikosh'
        ]);

        $mpdf->WriteHTML($this->pdfHTML($rack_code, $starting_date,  $ending_date));
       // $mpdf->Output();
       
       $download_file_name=$rack_code." Socks Return Voucher ".date('Y-m-d h:i:s a').".pdf";
        $mpdf->Output("$download_file_name", 'I');

    }


      public function pdfHTML($rack_code, $starting_date, $ending_date){

       // echo $rack_code;
       $start_date = date('Y-m-d', strtotime($starting_date));
       $end_date = date('Y-m-d', strtotime($ending_date));
      
        $entry_datetime = date('jS, F Y h:i a', strtotime(date('Y-m-d')));


 


      $data = DB::select(DB::raw("SELECT rp.type_id, t.types_name,sh.name as shop_name,au.name as agent_name, rp.rack_code,rp.selling_price, COUNT(rp.id) as unit FROM `rack_products` rp LEFT JOIN types t on rp.type_id = t.id LEFT JOIN shops sh on rp.shop_id=sh.id LEFT JOIN agent_users au ON rp.agent_id=au.id WHERE rp.`rack_code` = '$rack_code' AND rp.`status` = 5 and (rp.return_date BETWEEN '$start_date' and '$end_date') GROUP BY rp.type_id"));

      $table_data = "";

      $sl=0;
      $type_wise_socs_array =[];

      $total_socks_pair = 0;
        foreach($data as $single_data){
            $sl++;
           $type_id = $single_data->type_id;
           $total_socks_pair = $total_socks_pair + $single_data->unit;

          $type_wise_data = DB::select(DB::raw("SELECT rp.type_id,  rp.rack_code,  rp.printed_socks_code FROM `rack_products` rp WHERE rp.`rack_code` = '$rack_code' AND rp.`status` = 5 and (rp.return_date BETWEEN '$start_date' and '$end_date') and rp.type_id='$type_id'"));

        

          foreach($type_wise_data as $type_wise_socs_code){
            $printed_socks_code = $type_wise_socs_code->printed_socks_code;

            array_push($type_wise_socs_array, $printed_socks_code);

          }

         $separated_socks_code = implode(' | ', $type_wise_socs_array);
         $type_wise_socs_array=[];

           $table_data .="<tr>
                           <td>$sl</td>
                           <td>$single_data->types_name</td>
                           <td>$single_data->selling_price</td>
                           <td>$single_data->unit</td>
                           <td>$separated_socks_code</td>
                       
                     </tr>";

        }

  

        if(!empty($single_data->shop_name)){

            $shop_name = $single_data->shop_name;

        }else{
            $shop_name="";
        }

        if(!empty($single_data->agent_name)){

            $agent_name = $single_data->agent_name;
            
        }else{
            $agent_name="";
        }
        

       


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

<img style='margin-left:40px;' src='data:image/jpeg;base64,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'/>


        <h2 style='text-align:center;'>  Socks Return Voucher</h2>
        <h2 style='text-align:center;font-size:25px;margin-top:-80px;'>  ফেরতকৃত মোজার ভাউচার </h2>

       
                  
       

            <table style='border:none;'>

                <tr style='border:none;'>
                   
                    <td style='border:none; width:62%;' ></td>
                    <td style='border:none;'> <span> তারিখ /  Date :  $entry_datetime </span> </td>

                </tr>
            </table>


          <table style='margin-top:10px;'>


            <tr>
                <td>দোকানের নাম /  Shop name</td>
                <td>$shop_name</td>
            </tr> 

             <tr>
               <td>আলনা কোড  / Rack Code. <span style='color:red;'>*</span></td>
               <td>$rack_code</td> 
            </tr>

           

            <tr>
                <td>এজেন্ট নাম  / Agent Name.</td>
                <td>$agent_name</td>
            </tr>
           

    </table>

<h4>  পণ্যের বিবরন  / Product Information</h4>


<table>
    <tr>
        <td>ক্রমিক নং </td>
       

        <td>পণ্যের ধরন </td>        
        <td>প্রতি জোড়ার দাম / Unit Price</td>
        <td> একক / Unit (জাড়া)</td>
        <td> Socks Code</td>
     
       
    </tr>

    $table_data
    

    <tr>
      
        <td colspan='3' >সর্বমোট /  Total = </td>
        <td> $total_socks_pair জাড়া</td>
     
       
    </tr>

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

<br>
<img src='data:image/png;base64,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'/>

       </html>";
      return $output;


  }
  
}


