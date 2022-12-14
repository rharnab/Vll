<?php

namespace App\Http\Controllers\DirectSale;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class DirectSaleAuthDeclineController extends Controller
{
    public function index(){
        $sql = "SELECT
                    ss.*,
                    a.name as agent_name,
                    s.name as shop_name
                from
                    (
                    SELECT
                        agent_id,
                        shop_id,
                        voucher_no,
                        status,
                        count(*) total_socks_paid,
                        sum(ind_selling_price) as total_amount,
                        entry_date,
                        entry_time 
                    from
                        single_sales
                    where status=0 
                    group by
                        voucher_no,
                        agent_id,
                        shop_id,
                        status
                    )
                    ss 
                    left join
                    agent_users a 
                    on ss.agent_id = a.id 
                    left join
                    shops s 
                    on ss.shop_id = s.id 
                ORDER by
                    entry_date,
                    entry_time";
        $vouchers = DB::select(DB::raw($sql));
        $data = [
            "vouchers" => $vouchers,
            "sl"       => 1
        ];
        return view('direct-sale.auth-decline.index', $data);
    }


    public function voucherDetails($voucher_no){
        $voucher_no = Crypt::decrypt($voucher_no);
        $sql = "SELECT
            b.name as brand_name,
            bz.name as brand_size,
            t.types_name as type_name,
            count(*) as total_socks,
            sum(ss.ind_selling_price) as total_amount,
            if(st.print_packet_code != '', st.print_packet_code, ss.style_code) as packet_code
            from
            single_sales ss 
            LEFT JOIN
                stocks st 
                on ss.style_code = st.style_code 
            LEFT JOIN
                brands b 
                on st.brand_id = b.id 
            LEFT JOIN
                brand_sizes bz 
                on st.brand_size_id = bz.id 
            LEFT JOIN
                types t 
                on st.type_id = t.id 
            where ss.voucher_no = $voucher_no
            GROUP by
            st.brand_id,
            st.brand_size_id,
            st.type_id,
            ss.style_code";
        $socks        = DB::select(DB::raw($sql));
        $voucher_link = $this->getVoucherLink($voucher_no);
        $data         = [
            "socks"        => $socks,
            "voucher_no"   => $voucher_no,
            "sl"           => 1,
            "voucher_link" => $voucher_link
        ];
        return view('direct-sale.auth-decline.view', $data);
    }


    public function voucherAuthorize(Request $request){
        $voucher_no = $request->input('voucher_no');

        // amount calculation 
        $amount = DB::table('single_sales')->where('voucher_no', $voucher_no)->sum('ind_selling_price');
       //  $voucher_link = $this->generateSingleSalesVocuher($voucher_no);
        DB::table('single_sales_bill')->insert([
            "agent_id" => $this->getAgentCode($voucher_no),
            "voucher_no" => "$voucher_no",
            "total_amount" => $amount,
            "total_due_amount" => $amount,
            "voucher_link" =>  "",
            "authorize_user_id" => Auth::user()->id,
            "authorize_datetime" => date('Y-m-d H:i:s')
        ]);

        try{
            DB::table('single_sales')->where('voucher_no', $voucher_no)->update([
                "status"         => 1,
                "sold_timestamp" => date('Y-m-d H:i:s')
            ]);
            $data = [
                "status"   => 200,
                "is_error" => false,
                "message"  => "Sales voucher authorization successfully"
            ];
            return response()->json($data);
        }catch(Exception $e){
            $data = [
                "status"   => 400,
                "is_error" => true,
                "message"  => "Single sales database updated failed"
            ];
            return response()->json($data);
        }       
    }

    public function voucherDeclined(Request $request){
        $voucher_no = $request->input('voucher_no');
        $socks      = DB::table('single_sales')->where('voucher_no', $voucher_no)->get();
        foreach($socks as $sock){
            $single_socks_id = $sock->id;
            $style_code      = $sock->style_code;
            try{
                DB::update("UPDATE stocks SET remaining_socks = (remaining_socks - 1),is_packet_sale=0 WHERE style_code='$style_code'");
                DB::table('single_sales')->where('id', $single_socks_id)->delete();
            }catch(Exception $e){
                $data = [
                    "status"   => 400,
                    "is_error" => true,
                    "message"  => $e->getMessage()
                ];
                return response()->json($data);
            }
        }
        $data = [
            "status"   => 200,
            "is_error" => false,
            "message"  => "Sales voucher decline successfully"
        ];
        return response()->json($data);
    }

    public function generateSingleSalesVocuher($voucher_no){
        $sql = "SELECT
                b.name as brand_name,
                bz.name as brand_size,
                t.types_name as type_name,
                count(*) as total_socks,
                sum(ss.ind_selling_price) as total_amount 
                from
                single_sales ss 
                LEFT JOIN
                    stocks st 
                    on ss.style_code = st.style_code 
                LEFT JOIN
                    brands b 
                    on st.brand_id = b.id 
                LEFT JOIN
                    brand_sizes bz 
                    on st.brand_size_id = bz.id 
                LEFT JOIN
                    types t 
                    on st.type_id = t.id 
                where ss.voucher_no = $voucher_no
                GROUP by
                st.brand_id,
                st.brand_size_id,
                st.type_id";
        $socks = DB::select(DB::raw($sql));
        $data = [
            "shcoks_datas"      => $socks,
            "voucher_no" => $voucher_no,
            "sl"         => 1
        ];

        $pdf      = PDF::loadView('direct-sale.auth-decline.voucher', $data);
        $path     = public_path('backend/assets/voucher/single-sale-bill');
        $fileName = "single_sales_".$voucher_no. '.pdf';
        $filepath = $path . '/' . $fileName;
        $pdf->save($filepath); 

        return $filepath;
    }


    public function getAgentCode($voucher_no){
        $sql = "SELECT agent_id FROM single_sales where voucher_no=$voucher_no GROUP by agent_id";
        $data = DB::select(DB::raw($sql));
        return $data[0]->agent_id;
    }

    public function getVoucherLink($voucher_no){
        $sql = "SELECT voucher_link from single_sales_bill where voucher_no = $voucher_no";
        $data = DB::select(DB::raw($sql));
        if(count($data) > 0){
            return $data[0]->voucher_link;
        }else{
            return false;
        }
    }


   
    public function voucherDownload($voucher_no){
       //return $data;

      

       $mpdf = new \Mpdf\Mpdf([
        'default_font_size'=>10,
        'default_font'=>'nikosh'
    ]);

    $mpdf->WriteHTML($this->pdfHTML($voucher_no));
   // $mpdf->Output();
   
    $download_file_name=$voucher_no." Direct sale voucher ".date('Y-m-d h:i:s a').".pdf";
    $mpdf->Output("$download_file_name", 'I');

  

    }


    public function pdfHTML($voucher_no){

        $get_data = DB::select(DB::raw("SELECT s.store_name, s.location, count(s.id) total_socks, t.types_name , sh.name as shop_name, st.cat_id,s.ind_selling_price, sum(s.ind_selling_price) as total_selling_price
        FROM `single_sales` s LEFT JOIN stocks st on s.style_code = st.style_code
         LEFT JOIN types t on st.type_id = t.id
         LEFT JOIN shops sh on s.shop_id = sh.id
         WHERE s.voucher_no='$voucher_no' group by st.type_id"));
        
        
 
        $data = [
            "get_data" => $get_data
        ];

        $product_outline = '';
       
                $sl = 1;
                $total_socks = 0;
                $total_selling_price = 0;
            
        
             foreach($get_data as $single_item_data){
        
                $sl++;
                $total_socks = $total_socks + $single_item_data->total_socks;
                $total_selling_price = $total_selling_price + $single_item_data->total_selling_price;
                $cat_id =  $single_item_data->cat_id;
            
                if($cat_id=='1'){
                    $cat_name = " Socks "; 
                    $pairs_or_piece = " Pairs ";
                }else{
                    $cat_name = ""; 
                    $pairs_or_piece = " Piece ";
                }

                $product_outline.="<tr>
                    <td>$sl</td>
                    <td>$single_item_data->types_name {$cat_name}</td>
                    <td>{$single_item_data->ind_selling_price} BDT </td>
                    <td>$single_item_data->total_socks {$pairs_or_piece}</td>
                    <td>$single_item_data->total_selling_price TK</td>
                   
                </tr>";
        
             }

            $total_selling_price_amount = number_format($total_selling_price, 2);
            
             $sl2 = 1;
             $total_socks_pair = 0;
         
           
           
           $shop_name = $get_data[0]->shop_name;
           $store_name = $get_data[0]->store_name;
           $store_location = $get_data[0]->location;

        $output ="
        <!DOCTYPE html>
        <html>
        <head>
            <title>VLL Socks</title>
        
            <style type='text/css'>
                table, td, th {     
              border: 1px solid black;
              text-align: center;
              font-size:12px;
            }
        
            table {
            border-collapse: collapse;
            width: 90%;
            
            
            }
        
            th{
            padding: 5px;
            
            }
        
            p{
                font-size:12px;
            }
        
            </style>
            
        </head>
        <body>
            <img style='margin-left:40px;' src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gIoSUNDX1BST0ZJTEUAAQEAAAIYAAAAAAQwAABtbnRyUkdCIFhZWiAAAAAAAAAAAAAAAABhY3NwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAA9tYAAQAAAADTLQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlkZXNjAAAA8AAAAHRyWFlaAAABZAAAABRnWFlaAAABeAAAABRiWFlaAAABjAAAABRyVFJDAAABoAAAAChnVFJDAAABoAAAAChiVFJDAAABoAAAACh3dHB0AAAByAAAABRjcHJ0AAAB3AAAADxtbHVjAAAAAAAAAAEAAAAMZW5VUwAAAFgAAAAcAHMAUgBHAEIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAABvogAAOPUAAAOQWFlaIAAAAAAAAGKZAAC3hQAAGNpYWVogAAAAAAAAJKAAAA+EAAC2z3BhcmEAAAAAAAQAAAACZmYAAPKnAAANWQAAE9AAAApbAAAAAAAAAABYWVogAAAAAAAA9tYAAQAAAADTLW1sdWMAAAAAAAAAAQAAAAxlblVTAAAAIAAAABwARwBvAG8AZwBsAGUAIABJAG4AYwAuACAAMgAwADEANv/bAEMAAwICAgICAwICAgMDAwMEBgQEBAQECAYGBQYJCAoKCQgJCQoMDwwKCw4LCQkNEQ0ODxAQERAKDBITEhATDxAQEP/bAEMBAwMDBAMECAQECBALCQsQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEP/AABEIAFACUwMBIgACEQEDEQH/xAAdAAEAAwEAAwEBAAAAAAAAAAAABgcIBQMECQIB/8QASBAAAQMDAwIFAQUCCAwHAQAAAQIDBAAFBgcREhMhCBQiMUFRFSMyYXEWQhczOHaCkbGzJDY3Q1J0dXeBobK0JzQ1coWStcH/xAAbAQEAAgMBAQAAAAAAAAAAAAAAAwUBBAYCB//EADERAAIBAwIDBgUEAwEAAAAAAAABAgMEEQUhEjFhQVFxgZHRBhMjksEUFSKxQnLhMv/aAAwDAQACEQMRAD8A+pF0ucGy2yVeLnIDEOCyuTIdIJDbaElSlEAE9gCewrlYnmllzNd5VYZLcqPZrkq2KktL5tuupZacXxUOxCS6UHYkckKG+4IEM8T4ys6DZl+xo5z/ALNcS62EclLiq9MgJ+QoMqcUNu+6dvmsWeFnxBZzjd5xvTaJJi27G5FyEbkLWqSl2U+FBCXVhYUkFXq2QR3TuQRy36DT9DlqFhUuqclxReMdMZz357F3+RQahrUbC+p2tRfxks565xjux2v/AKfQ13M8PYDqn8rszYYc6DpXOaHTc7+hXq7K9Kux79j9K8jOUYzJ6hj5Fa3QzLTAc4TG1cJRIAYOx7OEkAI/F3Hasyz8N0YsMl65J1KeTfbfeJy50uTbbmthQQ7OW6y03GdaPRYWuV1HEuKQkoIcPsB6M7T3SpLciJM12fgRoTzPkFRrIWgZEFmSzGdStwLRKKFJkFRZCQt5O6ODh9US0yg+UpfY/Y9PU66/xj98fc1VFybG565DcHILbIVDWtuQGpbayypBAWlYB9JTyTuD7chv7ivLar5Zb628/ZLxBuDcd5Ud5cWQh1LbqfxIUUk7KG/cHuKz3gWj9hyCVep+G6l9ZDjsi3zkfYDzTQjOvpU8hovOb8i7G2C2yWUkL4tAk1amkeliNKrbcra1ehPbnyxJQlMYspZAbSjiApaz3KSrYEISVEIQhOya1Lm2t6KkozbksbNNeOcm5bXNzWcXKCUXndNP0wT6lKVXliKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKrjVTUnL8WvmN4Pp1gjeS5NlAlvsmdPMC2wIkXpdeRJkJbdWNlSGUobQ2payo/hCVKFj1nvxBaS6X5vrFpHOy7S7EcjmzbpcoT7l3tEeQZLDdomutMOLcbWS2l0BYSQQlXqA3oC38TvWYylG25zikW1XFLfVS9bJy50B5IIBCXltNLQsEjdC2xuD6FOcV8ZLXzywLQfEci1bw1etehGneHXebf58P8Ag6hYFaWYHkBaritMoT0oWq5kLZYJUlbaGlLTyZSotKrnq8OGNccnvOIeFXDcR08tt4skJVvzXFW3r7MmuzI6Z7kKY6VLahtBaUpB6rbxD4bUhCkqAGvbLqnq9m2SX1WDaU2b9k7BdZdl8/fsgdgzbnJiuqZkLjR24ryUspdQtKFurSXNuQCUkKNqWm4KutvZnLgS4K3NwuNLbCHWlpJSpKtiUnYg+pJUlQ2UlSkkE/PDWrQ/w7YbhOpuoLfhqbvV2xPUjyVgi4njsZZj9S2wFJTIjdMsvQwsqJbdbWnk4eISpwqrwZnp/pBfNKsy1Exrw+YjZF2edbHskgW7CrSi6WUJsvVfgstz4q0Rlmd5dta1sq2bdW5xIIXQH0anz4VqgybncpTUaJDaW/IfdVxQ02hJUpaifYAAkn8qqpvVHVnKc6yGxac6XWd7H8Tm/Zc665Dfnbc5Om9JDi24jDUV8lpCXW93XCkKJ2Qkgc6xdbdBNH3bNqBPlWLErldHtILjkwZiWKzwZeNTnCp5hhKrY02G3mmVMgr3KlEuEKLS0oTItfdHNA8RxfXhyHp9p5hQjX+zW2FkJ02j3lqwMO2uE48tMdlhS2kq3d9aUEJcdCiATyAG/bLc37rBTIlWqXbZCTwejSQOTa9gSApJKFjuNlJJHx2IIHv1878F0csLfh/v+T6SeFfTvUmJHnwWMNvmYYXaoU+4WgxmhKuDjHSZU+lt7qqbS6pl11G+6lEJLl1+CjSfDdPrhn82zosNwu786G1JucDEYePuNBURlTkLysdtBjobdCt2l7rCwrmSrc0BqWvXZnwpEqRCYlNLkRCjrtJUCtvkN07j3AI9j87H6Gvn/wCL3RG3y73ncNWjGmenmGsY5Mu0HMIWEWu4XLIbmWFrXHckuN721ReISHFNqU4paAh1LjiUjteIjRPQTBbDq9Nt2neC4x5eDYWoF6k4AzfouNh9bwedbhJaWWWlBJH3SOKXXA4pJ9RIG7q9edPhWyKubcZTUaO2QFuuqCUp3IA3J7Abkd6+amP6FeHp3ww5ZnNx0JnZ3hmIi0y8LyS1YlDtmSX1SG22pLwbQwhb8RLyiveY25yQXS4l3ppUe/h+n2h2pmnWaZFO8P8AieKZJbdP8ZkXG2N4szaZduuDkq6F0qaS0hTYkMoYK0/hcaUlJ5o7UBrSy6p6vZtkl9Vg2lNm/ZOwXWXZfP37IHYM25yYrqmZC40duK8lLKXULShbq0lzbkAlJCjalpuCrrb2Zy4EuCtzcLjS2wh1paSUqSrYlJ2IPqSVJUNlJUpJBOBM40Tj2p7KIOhHhE0kyiZI1YRZZsq6YdAmN2G0m3QFrcbjks8kBa1q4hxKRyV7FfIezI0XttuteskzEPBto9fcxseSWu3t26XjsAwIcU2uIX5sRtxCOo3uoyBH6jZPNaSsrBCgN/UrLXgo0nw3T64Z/Ns6LDcLu/OhtSbnAxGHj7jQVEZU5C8rHbQY6G3Qrdpe6wsK5kq3NUz4oNC7VIyLPYMrRTTDTjDLTYJV2tGQW7B7XOm5RMEZTq2HZi297aeqOA+7DjhP3b3JSRQGxtVNVrjhrNss2C4n+12V3y8JscG3edESMxI8quWtcyRxX0G0R21udkLWr0pSklXbr4lfNQlutW7UTD7ZbpTySWpdjuTlwhKUBuUOFxhlxpR2JG6FIO23MKKUHKWbeHLQKDqG9BY0YwpUX+EjG4Tcd2xxnGmIrsELdjNIUghthS91llADZUpSuO6iTUem2l2jeU+Jy+wMUwrE8vua8qREu+EvaTQrZasUxpovpUZLkmKAqWFLTxdjuKLym0hQUgpDYH03pXzLVgfhvxLU3UTRyB4WE2jHbddbYzAv+U4szJZVdHbiwDHhznWlOBh9lThQ266QQ3sjbqcK+l8ePHiR2okRhthhhAbaabSEoQgDYJSB2AAGwAoDy0pSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgPUulzg2W2Srxc5AYhwWVyZDpBIbbQkqUogAnsAT2FcrE80suZrvKrDJblR7NclWxUlpfNt11LLTi+Kh2ISXSg7EjkhQ33BAhnifGVnQbMv2NHOf9muJdbCOSlxVemQE/IUGVOKG3fdO3zWLPCz4gs5xu843ptEkxbdjci5CNyFrVJS7KfCghLqwsKSCr1bII7p3II5b9Bp+hy1CwqXVOS4ovGOmM5789i7/IoNQ1qNhfU7Wov4yWc9c4x3Y7X/0+hruZ4ewHVP5XZmww50HSuc0Om539CvV2V6Vdj37H6V5GcoxmT1DHyK1uhmWmA5wmNq4SiQAwdj2cJIAR+LuO1Zln4boxYZL1yTqU8m+2+8Tlzpcm23NbCgh2ct1lpuM60eiwtcrqOJcUhJQQ4fYD0Z2nulSW5ESZrs/AjQnmfIKjWQtAyILMlmM6lbgWiUUKTIKiyEhbyd0cHD6olplB8pS+x+x6ep11/jH74+5qqLk2Nz1yG4OQW2QqGtbcgNS21llSCAtKwD6SnkncH25Df3FeW1Xyy31t5+yXiDcG47yo7y4shDqW3U/iQopJ2UN+4PcVnvAtH7DkEq9T8N1L6yHHZFvnI+wHmmhGdfSp5DRec35F2NsFtkspIXxaBJq1NI9LEaVW25W1q9Ce3PliShKYxZSyA2lHEBS1nuUlWwIQkqIQhCdk1qXNtb0VJRm3JY2aa8c5Ny2ubms4uUEovO6afpgn1KUqvLE/hAIII3Bqnsb8K2leJZ8c8sLNyjHzwuaLOHkG3NS0ocQl5DZRzSUh5whIXxBI2T6U7XFSp6N1Wt1KNKTSksPqiCta0biUZVYpuLyujKouPhs0/ud4vN+kTb8idfXVmW81P4EsuIdQ4x2T6kKQ+4ndfJwJCEpWkIQE/ud4cdPbq21Hucm/SokKYufa4rlzc6VrfUHtlxgNihSVPrWlRJUlQRseKEpFqUqT9fdbfUe3Ui/b7Xf6a36ERwbTHHdP518uVlemuycgkplTXJLiVFSxy2/ClO59avUrdZHEFRCUgS6lK16lSdWXHN5Zs06cKUeCCwhSlK8HsUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKy+14wrjhGoFx011bw9KJNvmqii5WpRSl1B/inCw4dwFpKVbhf7w7VeuK6o4FmbKXLBkkV1ajsWHVFl4H6cF7E/qNx+dWFzpd3awVSpB8L5NbrfqvyV9LVLStP5SmlLuez9Hz8iV0pSq8sBXKuuM2S9XWzXu5QQ9Nx+S7LtzvJQLDrjDjCzsDsd23XE7Hcd9/cAjpqUltJccUEpSNySdgBVf5Frzpjjy/LjImrpKKuAj23aQon22KweA2PY7qH9tTUbercy4aMXJ9Ea9xdULSHHXmorq8ExuNgs12uFqutxt7T8yySFyre8oeqO6tlxlakkfVt1xJB7d/qAR+r3ZLXkVuctF6hplRHVtrW0okbqQtK0HcEEEKSk/qKr7CtWbtqBlSbXZ7G1DtkdtT0p59ZcdKB2SBtslJKiPr2Bq0KxWozoS4Z8zxZ3tG/purQeY5xnGM+GTl2XGbJj0q7zLPBEd2+z/ALTnkLUetJLLTJXsSQn7thsbDYenfbckngZvpNiGd2W92a4xnIn2/IgTJkmIG+qZMN1p2M9s4lbaloUwz+NCgQhIII7VM6VEbZUWB+F3SvT7H42N22BJnx/2blYvc5M9aVzLxFkOhxxct5CUFxwqLx5AJ/jl+3bayLZjNks93vF9tsEMzb+8zIuLoWo9d1plLKFEE7AhttCe23ZI+e9dWlAQhOjenjcK/wBiYx2Kzj2VR32LzYW2kpt0tTo2cdLAHFDi0lQWpHHny3XyUEkSGy4pjmOSJsuxWeNAduHQ8yWEcA50WkstbgdvS2hCBsPwpSPgV1qUBGMo0y0/zSW/cMqxK3XOVKs0zHnX32t3FW2UU+Yjcvfgvgncfl223NdiNZLXEu82+xoaW59ybZZlPBR3dQzz6YI327dRfcDfv332G3v0oCNWDT7GMTvc684pBTZ0XQqcuEGGlLcSTIJB8yWgOKX/AHCnE7FYV95zKWyj2Ltg+K3167SLrZmZDl9t7FruCySlT8Vlby2myQQQEqkvEbEEFZru0oDl2XGbJj0q7zLPBEd2+z/tOeQtR60kstMlexJCfu2GxsNh6d9tySefctO8PvUbJ4F6srVwh5kyI96iyd3GZTfQDBSUn2BbAB2/X371JKUBybLimOY5Imy7FZ40B24dDzJYRwDnRaSy1uB29LaEIGw/ClI+BXOyLTLAMtuEy7ZJiVunzp9mex6TJda3dctrqw45G5juEFaUq2B7KAI2NSelARy5afYfdrgbpPsqHJZuUS7l0OLSfNxkhLLvY7bpSOP0I7Hev5len2MZhJhXW4wQzebWSq2XmMEtzoCj7lp3YkJP7zat21jdK0qSSDJKUBz71YrXkdrcs98htS4rpbWttY7c0LStCh9ClaUqB+CkH4roUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUB/CAQQRuDVPY34VtK8Sz455YWblGPnhc0WcPINualpQ4hLyGyjmkpDzhCQviCRsn0p2uKlT0bqtbqUaUmlJYfVEFa1o3EoyqxTcXldGVRcfDZp/c7xeb9Im35E6+urMt5qfwJZcQ6hxjsn1IUh9xO6+TgSEJStIQgJ/c7w46e3VtqPc5N+lRIUxc+1xXLm50rW+oPbLjAbFCkqfWtKiSpKgjY8UJSLUpUn6+62+o9upF+32u/01v0Ijg2mOO6fzr5crK9Ndk5BJTKmuSXEqKljlt+FKdz61epW6yOIKiEpAl1KVr1Kk6suObyzZp04Uo8EFhClKV4PYpSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQGNPHvpr03LNqxbI+xJFruSkDvuN1MOHb9FoKj9Gx9KqjT/IBNjx31q/8wkNOj6Oj5/r/ALa35qRhMDUbBr1hVy4hq7RVMoWob9J0eppzb5KVhKv6NfMvFfP4zkdwxG8NKjymH3GHGie7chpRStP/ACP/ANRX0f4Zulf2ErOo94beT5ej/B81+MdP+XUV1Bc9/Pt9/U314esuVcrRKxWa8Vv249aOVK3JYUe4/oq/6x9KuCsYaX5m5j19tmRhZ4NL6UtI/ebPZY2/Q8h+YFaX1e1HhaaaZXjOg62tceLtAB7h6Q56WRt8jkoE7fuhR+K5HU7CpC8VOC3k8efIvvhfVY3GnuNV70+f+vNe3kY78YOqN1znVI6cWC6vps9j2hPstOqDT8snd1S0g7K4dkdx2KF7e9czDbU1HSlTaNmoqA03v9dvf+r+2q2waHJuU+Xkc9xb8h5xQDizupxxR3Wo/md/+ZrSGlGFHI8htuPlBLIPXmKHw2nuvv8Amdkg/VQrvbpU9I0+NvDsW/5fn+Tg9Qr1dY1Hgju29l1fJeRoPQ7E/wBnMObuEhrjMvBEpzf3S1t92n+o8v6ZqxaoLXDPNU7XrHptpJpjkNqsScvjXRb8qbbBLS0YrPVTsjknsQlSexHuD8bVyNYcr8Q2h+i+S5nd8+sGR3lMq2sWny1hEZDHUkdN4LSXFdQqC0be3Hiffevltaq61R1Jdp9fsrSFlbwt4corHu/N7mlKVmqZ4j8mueg2mGpmPriMXPJsltVivLa2QtKFrdWzLQEnug82yU/IBHv71z9ZMq8TGnmbYjZbfqhjLsPO8jNogpVjfqgNqO6Cs9X70pSQD+HcjftUWTawalpWfF55rBhGtelGlWX5XaL4jLEXx66SYtqEXmmPGLrCUJ5qKCFDud+9czVzXnUDDcq1btNkkwUx8Ow+FerWHIwWUyXXOKys7+pO3xWRg0tSsqv6ueILTCw6faj57kWK5Ri2ZzbbDnRY9qXCmW8TWwtC21JcUlzj333HfYAAb8k9OFmXiC1I1t1OwTCNQcfx21YNItrbKZlh84t0SmFL/EHE7bFtX1/EPpWMjBpelcPC4OWW3GYcLOb9DvN7b6nmp0SH5Vp3dxRRxa5K47IKUnudykn52qD+G/ULI9TdOl5LlLsdc1N1mRAWGQ2nptr2T2Hzt81FKtGNWNJ85JteWM/2bdKxq1bWpeRxw03FPvzPixj7XktSlZU1R8ROpOJ37X632eTASzp5b7DJsgciBRQuWhkvdQ7+sbrVtv7VY+mdo8RE1+wZPmGq+OXGyTI7cuVbo2OdB5aXGuSUB3qnYhSk9+PfY/WpjUwXJSso6D5L4qNctNbfqPE1bxW0Nz3pDQiOYv1lI6Tqm9+QdTvvx39vmplkObax5vrJetItNcpseMM4hZ4c26XSbajOdmSpAKkNttFxKUN8R3VuVA/BoMF+UrO2J5n4gtTtNH7jBvllw/JcTutytF8VIsbkiPczHCS29HStaShCkn37gnfbbbYcTRLLvE3qnox/C5+3+PuO3O1XNdstDWPgOCaw660yFO89lJUtnuOPsv8AKgwakpWb7h4l7xI8KFk1Xx9mO9mOQ+VscKKUbpXelvdBxPD4AUh1wJPuAB871JsN1IziR4kL1pBfrhDl22z4hCuZcbihtbk1S20OObj2SSpRCfjegwXVSqH8QuoOqFg1L0t0400yC2WZzOHbs1KlzreJaW/LNMuIITyT/prHv8j6VPtNrDq9Znp6tT9QLPkbTqGxDTAs3kSwoFXMqPUVz3BTt7bbH60ME6pVPWLU7Kbh4pMm0nkOxjYLXi8a6x0BkB0SFuoSolfuRso9qhPigzHxBaR2yXn+L6g4+LG/c4kCJa3rCFvMh4hBKni56tlclfhHY7UM4NL0rMusWYeIfR/Ccd85qLj11vmT5rbrAxNbsHSajRn2X+XJouHmeaEK33HYEfNdi16i6zabazYfpdq3eMcyW154xOFsulst7kKRGlRWw4tDrZWtJQQpKQR33VuSADvjIwaCpSlZMClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUApSlAKUpQClKUArBPjd06ew/UiDqRaGS3EyJIU8pI9KJzIAVv8Dmjgr8yFn61vaq18Q+midVNKbxjrDHUuLCPP23YdxKaBKUj/wB6SpH9OrjQr/8Ab72FST/i9n4P2e5WavZq9tJU0t1uvFe/IxphV6aloacQr7qagKT3/Cv6f2j/AIV4/EJqneMss2LaWIJU1Zt3ndjuXnVehgH6cGyoD8l1XmC34W9iVElOFvyYMlvf3AH4h3+d9u35mmMCTkmRzMouI5HmVDt25q9gPySn/wDlfTp2EJ3cblrl/fLPofIrepU0/wCak8RxjxTeUiwcJsbcUMRkp3bhIBUdvxL+v9e5rYXh9xP7Kx17JpTW0i7K4tbjulhB2H6clbn8wE1nvTfEZN+udtsDCSl2e6C6oe6Ee6lf0UgmtrQ4ke3xGIMRsNsRm0tNIHslKRsB/UK4n4ov/m1PlRe34XuzpfgrTnVqyvaq/wDPL/Z8/Rf2Zf8AEgnNVeKTREadu2RvIfJ5B5NV6bdXDH+CfedQMkLP3fPbYj1cd+29eXxQJ1JR4YbkNVH8advX2/a+KsfakNxeh5xjjuH1KXz35b99ttvzqV646aarXvV/TvVfTCDj857DI9zbei3ea5HQ4ZTPSGxQhR7BSj+oFc7UrBfEHrNpXe8MzCwYbaJ659qk202+6PvNuIakhx/qlbYKSEoRx2B3JO+21ccfTe4ojVP/AMN9Srhoo6vpwbjqbjucWBtR/wAxLdWiWlI+EofSEgD8/arz8VH+UrQT+fTX9ia9jxLeHS9at51ptn2KuwGp2I3dly4CU4UdaCHm3fSQk7qSptWye2/UPepRrdpbk2oWYaXX2wrhJjYdkzd3uIkOlCiwANw2Ak8ldvY7frQZIfq5/LL0F/1PJP8AsF1WPiH/AMffEJ/u5tf99V566aX5zf8AM8E1d0w+ypGSYI9NAt1zeUyxPiymek4gOJCuCwN+JI29RJPYAwS7aB6t6gWLVjKszTj9uyzPrPFslrtcOW45FgxmDv8AfPlAK1qV3JSnYbfPLZIJleZDc9S5eKaG23WvH7NbNNftSxqbnWV9UqQ9ISwPJolBzh0WlDcuKQFbbbA+wMjwpGtS/E/r1/A/JwlnaZY/tH9pWJbm/wDgrvS6Pl1p2/znLlv+7t81Y+rGiOZZnofgOAWZ22i74tNscqV131JZWIjXB0IWEk77ntuBv+VceNp54h9P9aNSs/09sOF3a2Z1ItzqE3S6PsOsiKwpH4UNEdy4r5PYCgyaItQugtcMXxUVVx8u35wxAoMF/iOfTCt1BHLfbc77bb1SPgu/yNu/7euX97Vu4XIzGVjMN/PrdbIF+V1PNx7ZIW9GRs4oI4LWlKjujgTuBsSR8VRelWF+JTSPGXsSs+NYNcYpnyZqH5N2kIWeqvlsQlrbtVddOVO6pVeFtJSTws8+HHLwOl0mMLjSrq0+ZGM5TpNcUlHKiqmcN7bcS9Sl9d/8a/Fv/sfE/wC6j1pvQhevCrVaU6jRcCbxwWNjyKrJImLmlzi10+qHkBsJ6fPlxJPLjt23qttR/DdqRmF310uUFyzIGpNusMa0pXKWODkRDIe6voPEbtq4kb79vatI4pbJNlxez2eYUF+DAjxneB3TzQ2lJ2PyNxVijmn3GR/A03r8dHcUVjUvT9OFfacjzCJ0eaq6FjzavMcFIWGue3PhunYenlv3q1tX9LMyjZ2dc9CrtFRm1uhJh3exyVAxb7DT6kMubEFt7YehZI9kjdIG5hmh+B+LLQ/TmBp1asR06ucaA6+6mTIvcpC1F11SyCEs7dirapbedP8AW3BdXMn1U0rtuL31nO4NuavFsuk12IuLLiNdFp1pxKFBbfBR5JOxPx9aGHzJppzqvadZdJpOY2yBItz4ZlwrjbpI2egTWklLrC/qQdiDsN0qSSAdwIX4Ef5KeD//ACX/AOlJqRaH6R5Bpxp1f7Xk1xgTMly67XHILsuEFJiImSwAUNcgFcEhCBuQPntXs+GPTbIdIdD8a07ytcNd1tPnOuqI4XGj1ZjzyeKiAT6XE79vfegM9YJpxeY/jDnaVPPMnC8RuszUmFG+PMTGmm2mwP3Q06takj44qP7w3svFP5d2b/zFg/37dTCx6W5NbvE5kmr0hyEbFdsZjWiOlLpL4fbcQpRUjjsE7JPfl/wqJ5TpzrrYfERe9YdM7NiV0hXiwxrOWbvcXo60FtSVKVs22r5SAO/zQzzOH4rE5erXzQEYG5Z278ZOQ+SVd0OrhhXl42/UDRCyOPLbiR32+KvvTtOqCLI+NWX8Wdu/mldE461IbjeW4I4hQfUpXU59Tcg7bcfneqS1F098RuaZLpdqYzj2EtZFg0q8OSoBur/lHG5LbLbXFzpcidkOFXYbED33q3NNrhrROenjVfG8WtbSEtmEbLcHpKnFbq5hYcQniAOO22/uaGGVbin8u7N/5iwf79unjy/yFs/zjtX99XkynTnXWw+Ii96w6Z2bErpCvFhjWcs3e4vR1oLakqUrZttXykAd/mva1j021j1r0TYxi+23GrXlCb5FmrZiz3XIgjsuctw4pvlzI+OO350Haej41/8A0DSr/ejY/wDok01+/lP+HT/XMi/7WPUm8UWmGcaoYvicfT9FrXdMby6BkRbuUhTLLjcdt4ceSUqO5U4j49t64cHS3W7PdV8Z1T1aViFrZwaJP+w7VZXn5BdmSWw2px91xCdkAJQQE790j6ncDQVKjGmn8If7E27+Fb7I/an77z/2Tz8p/HL6fDn6v4rp77/vb1J6yYFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAwD4hPDFqE3qpeLlp7h0252W7r+0G1RUpKWXHNy60e422WFED/RUmvPhvh71NtcWJDl4RcGwn718lA7q9yPf9B+gre9K6mn8WXdOgqPCnhYzvnx58zlr34Utb2blKckm84WMf0U/oVp5csdXPv+Q29cWY4PLRmnAOSW+xUr/idgPn0n61cFKVzlxXlcVHUnzLzT7Gnp1urelyXqyLakSsygYq/PwKMJV3YcbLcUpSQ+lSuCkkq9gArnuO/o/PY8G0T9XTpnebjcITTmVoDiIEVSENpJabQ0VDbsQ44288jlv2dQD2G1WPSoTdIxp3LyuZjSH8xZU3O8w8EcwA4pgLPTK9kNjlt89NG/Y8RvXp5bNzVjKLPHsrUz7KcCesuLHZdC3eu2FJfLhBQ0GS4rkgg7j3JAQqZ0oCvMzu+pUXPbHCxi0vO2Iqime8EtltSXH1Ie33SVbob4q7KRtyB+8AUE9+1jKnc2vS7hLcRYmGI7dvj9BAS44pO7jnU25EgjiBuB6j79tpJSgK+05uWp82+3prOremNDbUrywASUhXWcCQ2QhO6C0Gz3Lh391AkoT1tSZ2XQceQrC4b8ie7LZaWWOHNpok8ljmhYHsBvwXty7gDdSZXSgKsyV7UKbh2nt1dRd4F5RIZk39NpjIddYUq2SUup6S90KSJC2xseQB4kbkA11b5cNRG8Sxl9cWTFuUhDX7QG1MNSXoqzFWpQZQ5ySpPmAhBOyjxJPbutM+pQFf3686l2/FcbuDVnW5dnYqheo0FpDvTlKhOFISFH8AlcBuDtt7njua9m8JzCQMAltyLiwpNxbVfm4qEbFtUGQCHUkH0eYLIO3ty37FIUmb0oDxSm3nYzzUaQWHVoUlDoSFFtRHZWx7HY99jVdYJlGoGUaYXXLUsw371IZk/Y0YFPl1ustdJJ5jbk27IbccCt/wCLcR7VZVKAgVim6gycTydZRNcnNJdFgduMZliS8ryqCOq2jZsbSC4kEhO6UjfcetXrs33UWdhGc3OPapke7R23jjjEiKhDq1JtrCk+j2VvLL23L9PYbVYtKA9W2x5kWCzHnz1TpCE7OSFNpbLivrxT2H6VFvO5qdRlQ3WZiLGOPS6cdlUZbPQUVLcdJ6iXQ/xSEp3HDvxO5WmZ0oCBNXHUQ6jGG5Gkiy+dWhQLDXlRb/J8kvJd/jC+ZX3ZQTtw3PEbBauHmMzWVm55JIxlyX5eKZZtUdMNhbboatsZ5kbqTyPUll9o+r23A4kBQtmlARK/Wq9TNRMUuEaXcEWuBGuK5bTSwI63lJaQ11Rtursp0p79iP1351vuGoi9Q3YkuLJFmEl9KkqYaEVEMMoLDrbo+8U8p0qSpJJAHL0p2SpU+pQEZx1vLJF2yZy+XB5qH57y9pZTHbT044ZbPVCtiVkuKcHq3Hp9vr+dMEX9vTvG28qdnOXpFsjouKpu3W8yEAOBRAG+ytwFdyQASSTuZRSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgFKUoBSlKAUpSgP//Z'/>
           
           <h3>$shop_name Chalan</h3>
            <p> Store Name : $store_name</p>
            <p> Store Address: $store_location</p>
        
            <br>
            <p>Product Outline:</p>
         
            <table>
              <tr>
                <th>SL</th>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Unit</th>
                <th>Amount</th>
              </tr>
               
             $product_outline
        
              <tr>
                  
                  <th colspan='3'>Total</th>
                  <th>{$total_socks} {$pairs_or_piece}</th>
                  <th>{$total_selling_price_amount} TK</th>
              </tr>
        
            </table>
        
            
        
            <p>Pegasus Socks have delivered the above-mentioned products to $shop_name outlet.</p>
            
            <br>
<br>
<br>
<img src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gIoSUNDX1BST0ZJTEUAAQEAAAIYAAAAAAQwAABtbnRyUkdCIFhZWiAAAAAAAAAAAAAAAABhY3NwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAA9tYAAQAAAADTLQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlkZXNjAAAA8AAAAHRyWFlaAAABZAAAABRnWFlaAAABeAAAABRiWFlaAAABjAAAABRyVFJDAAABoAAAAChnVFJDAAABoAAAAChiVFJDAAABoAAAACh3dHB0AAAByAAAABRjcHJ0AAAB3AAAADxtbHVjAAAAAAAAAAEAAAAMZW5VUwAAAFgAAAAcAHMAUgBHAEIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAABvogAAOPUAAAOQWFlaIAAAAAAAAGKZAAC3hQAAGNpYWVogAAAAAAAAJKAAAA+EAAC2z3BhcmEAAAAAAAQAAAACZmYAAPKnAAANWQAAE9AAAApbAAAAAAAAAABYWVogAAAAAAAA9tYAAQAAAADTLW1sdWMAAAAAAAAAAQAAAAxlblVTAAAAIAAAABwARwBvAG8AZwBsAGUAIABJAG4AYwAuACAAMgAwADEANv/bAEMAAwICAgICAwICAgMDAwMEBgQEBAQECAYGBQYJCAoKCQgJCQoMDwwKCw4LCQkNEQ0ODxAQERAKDBITEhATDxAQEP/bAEMBAwMDBAMECAQECBALCQsQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEP/AABEIAFgDGAMBIgACEQEDEQH/xAAdAAEAAgIDAQEAAAAAAAAAAAAABQgGBwECBAMJ/8QASxAAAQMDAwIDBAYFBwoGAwAAAgADBAEFBgcREhMiFCEyFTFCUggjQVFichYkM4GCNENhcZGSlBclU1RVc6Gx0dJWY3SDosKEsuL/xAAbAQEBAQADAQEAAAAAAAAAAAAAAQIDBAUGB//EADoRAQABAwICBQcMAQUAAAAAAAACAQMSBBEFIiExMkLwBlJicrGy0hMUI0FRYXGCoaLR4hWBkcLh8v/aAAwDAQACEQMRAD8A/VNERAREQEREBERARaI+kzqVqRo45YM8xh+NLx5x/wBn3eBJj0MRKtak26JjsY1rShjXz47iHlXdT2mH0gbNqDIh22VaXLfOl7iFRdo4zU6UrXblXatN6U8vKvvpTdehXheo+a01kabwr9n1bfbR5dzjGks6r5ndljOvVvTorv8AZXq/32bZReK83e34/aJt9u0kY8G3R3JUh0vcDQDUir+6lKqu4/S/plXKmC4m6xFrUuEy6FTkQ08t6NBXand7tzr7t60+xY0nD9TraSlZjvSPXXqpRviHFdJwuNJamW2/VTrrVZVFCYdS/VxyE9k0nrXKQ31n/qxCjdS86BSlKU2402p/XSqm11JRxlWLu2rnysKT2rTem+1eun4iIiy5BERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERBi+puDQdScCveEz+AhdIpNtOFTejT1O5pz+E6CX7lQfSi93fG7m5Y51XId2sUusYxL1NPtHXj/ZUaj/AAr9IFRv6WeF10+1hgZ/b2ujbMvDhJIabC3Nb40Ktfspyp0y/pr1K/evrfJfUxuVucOu9U6b0/Gn809j4vyy0FbunjrLfat+zx7WbfSz1hbu2mWPYVjkigzs34vTBAt6sRWip1AL7abu023+2jblFDfRx09aut8gMnH/AFKAIy3qVp5VANqNhX7+RbVr99N1o+yuPZzmL9/dpWsdkaQolN96C2O9TKn9dalWn56q+Wh2I0xnDWpj7PCXdq0kn5bVFrbZsf6uPd/WdV3+J0jwPhtNHb7Uq71/1/inseHoZXfKXi0J36ctulK1+zem3tr7atSStaNZYP0fLVrBBv2N3283sLOLFlZtJNUZfmSGg6ZHR8irvQyGnbTzrSvnttWWyLWjPbtbcmybAr/Zo1qtN/x63waSbUUgpMW6s2shcqVHg4kFZzpeVK0KnGnltvWPwXSnMLXpbh2B00hYsF2sl0xmbd7m3IgcZ/gZ7Djx1Jlyrh1oFHSpzpvXzpTzrtXvYtA82xvEdQMViRGX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' />

        </body>
        </html>
        
        ";


        return $output;
        
    }



}
