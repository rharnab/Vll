<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class PacketCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function socks_code_generate(){

        $lot_info = DB::table('lots')->get();
        return view('report.packet-socks-code.index', compact('lot_info'));

    }

    public function generate_pdf(Request $request){

         $rack_code = $request->rack_code;
         $date = $request->date;

         if (!empty($date)) {

            $finally_date =  date('Y-m-d', strtotime($date));
         }

          $get_data=DB::select(DB::raw("SELECT print_packet_code, br.name as brand_short_code, ty.types_name, bs.name as brand_size FROM stocks as s
          left join brands br on br.id = s.brand_id
          left join types ty on ty.id = s.type_id
          left join brand_sizes bs on bs.id = s.brand_size_id
          WHERE s.lot_no='$rack_code' and date(s.entry_date_time )= '$finally_date'"));


        $data = [
            "get_data" => $get_data,
            "rack_no"=>$rack_code,
            "date"=>$date
        ];



        

         $pdf = PDF::loadView('report.packet-socks-code.generate_pdf', $data);
        
       
         
         $socks_code_generate_pdf="Packet Code : $rack_code date : $finally_date".".pdf";
        return $pdf->download("$socks_code_generate_pdf");

      

    } //end socks_code_generate 





}
