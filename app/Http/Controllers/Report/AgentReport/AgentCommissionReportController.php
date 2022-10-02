<?php

namespace App\Http\Controllers\Report\AgentReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;



class AgentCommissionReportController extends Controller
{
    public function index()
    {
        $role_id = Auth::user()->role_id;
        
        if($role_id == 2)
        {
            $all_agents= DB::table('agent_users as au')
            ->select('au.name', 'rm.agent_id')
            ->leftJoin('rack_mapping as rm', 'rm.agent_id', '=', 'au.id')
            ->where('rm.agent_id', '!=', '')->where('rm.agent_id', Auth::user()->id)
            ->groupBy('rm.agent_id')
            ->get();
        }else{

            $all_agents= DB::table('agent_users as au')
            ->select('au.name', 'rm.agent_id')
            ->leftJoin('rack_mapping as rm', 'rm.agent_id', '=', 'au.id')
            ->where('rm.agent_id', '!=', '')
            ->groupBy('rm.agent_id')
            ->get();

        }
        
        
        

        return view('report.agent-commission.index', compact('all_agents'));

    }

    

    public function agent_shop_list(Request $request)
    {
          $agent_id  = $request->agent_id;
          if($agent_id  !=0)
          {
              $agent_sql = "rp.agent_id='$agent_id' ";
          }else{
              $agent_sql = '';
          }
          
        $all_shops =  DB::select("SELECT s.name  as shop_name, rp.agent_id, rp.shop_id  from shops s  
        left join rack_products rp    on rp.shop_id  = s.id
        where $agent_sql group by rp.shop_id  order by s.name  asc  ");

        $output = "<option value='0'>All</option>";
        foreach($all_shops as $shop){
            $output .= "<option value='$shop->shop_id'>$shop->shop_name</option>";
        }
        echo $output;
         
        
    }

    

    public function shop_list(Request $request)
    {
        $agent_id= $request->agent_id;
        $shop_id= $request->shop_id;
        $frm_date= date('Y-m-d', strtotime($request->frm_date));
        $to_date= date('Y-m-d', strtotime($request->to_date));

        if($agent_id !=0){
            $agent_result = DB::table('agent_users')->select('name as agent_name')->where('id', $agent_id)->first();
            $agent_sql = "and rp.agent_id = '$agent_id' "; 
            $agent_unsold_sql = "and us.agent_id = '$agent_id' "; 
            $agent_sold_sql = "and s.agent_id = '$agent_id' "; 
            $agent_bill_socks_sql = "and b.agent_id = '$agent_id' "; 
            $agent_bill_receive_sql = "and ba.agent_id = '$agent_id' "; 
            $agent_commission_sql = "and ba.agent_id = '$agent_id' "; 
            $agent_name= $agent_result->agent_name;
        }else{
            $agent_result ='';
            $agent_sql ='';
            $agent_unsold_sql = ''; 
            $agent_sold_sql = ''; 
            $agent_bill_socks_sql = ''; 
            $agent_bill_receive_sql = ''; 
            $agent_commission_sql = '';
            $agent_name=''; 
        }

        if($shop_id !=0)
        {
            $shop_result = DB::table('shops')->select('name as shop_name')->where('id', $shop_id)->first();
            $shop_sql = "and rp.shop_id='$shop_id' ";
            $shop_unsold_sql = "and us.shop_id = '$shop_id' "; 
            $shop_sold_sql = "and s.shop_id = '$shop_id' "; 
            $shop_bill_socks_sql = "and b.shop_id = '$shop_id' "; 
            $shop_bill_receive_sql = "and ba.shop_id = '$shop_id' "; 
            $shop_commission_sql = "and ba.shop_id = '$shop_id' ";
            $shop_name = $shop_result->shop_name;
        }else{
            $shop_result ='';
            $shop_sql ='';
            $shop_unsold_sql = ''; 
            $shop_sold_sql = ''; 
            $shop_bill_socks_sql = ''; 
            $shop_bill_receive_sql = " "; 
            $shop_commission_sql = " ";
            $shop_name=''; 
        }




          $sql = "SELECT rp.agent_id,
                        rp.rack_code                      AS main_rack_code,
                        rp.sold_date,
                        s.NAME                            AS shop_name,
                        s.contact_no,
                        s.owner_contact,
                        s.shop_address,
                        rp.rack_code,
                        au.NAME                           AS agent_name,
                        (SELECT Count(id)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7)           AS total_sold_socks,
                        (SELECT Sum(selling_price)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7)           AS total_sale_price,
                        (SELECT Sum(shop_commission)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7)           AS total_shop_commission,
                        (SELECT Sum(agent_commission)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7)           AS total_agent_commission,
                        (SELECT Sum(venture_amount)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7)           AS total_venture_amt,
                        (SELECT Sum(agent_commission)
                        FROM   monthly_rack_conveynce_bill mrcb
                        WHERE  rack_id = main_rack_code) AS paid_agent_commission,
                        (SELECT Sum(amount)
                        FROM   monthly_rack_conveynce_bill mrcb
                        WHERE  rack_id = main_rack_code) AS paid_convenience
                FROM   rack_products rp
                        LEFT JOIN shops s
                            ON s.id = rp.shop_id
                        LEFT JOIN agent_users au
                            ON rp.agent_id = au.id
                WHERE rp.sold_date  between '$frm_date' and '$to_date'   $agent_sql  $shop_sql and rp.status =7
                GROUP  BY rp.shop_id order by s.name asc ";
        $result= DB::select($sql);

        // WHERE  s.is_active= 1 $agent_sql  $shop_sql and rp.sold_date  between '$frm_date' and '$to_date'
        $summation_sql = "SELECT sum(sm.total_sold_socks) as  grand_sold_socks ,
                                sum(sm.total_sale_price) as grand_sale_price, 
                                sum(sm.total_shop_commission) as grand_shop_commission, 
                                sum(sm.total_agent_commission) as grand_agent_commission, 
                                sum(sm.total_venture_amt) as grand_venture_amt, 
                                sum(sm.paid_agent_commission) as grand_paid_agent_commission, 
                                sum(sm.paid_convenience) as grand_paid_convenience
                        from (select rp.rack_code as main_rack_code,
                                    (select count(id) from rack_products rp where rack_code =main_rack_code and status=7) as total_sold_socks,
                                    (select sum(selling_price) from rack_products rp where rack_code =main_rack_code and status=7) as total_sale_price,
                                    (select sum(shop_commission) from rack_products rp where rack_code =main_rack_code and status=7) as total_shop_commission,
                                    (select sum(agent_commission) from rack_products rp where rack_code =main_rack_code and status=7) as total_agent_commission,
                                    (select sum(venture_amount) from rack_products rp where rack_code =main_rack_code and status=7) as total_venture_amt,
                                    (select sum(agent_commission)  from monthly_rack_conveynce_bill mrcb  where rack_id =main_rack_code) as paid_agent_commission,
                                    (select sum(amount)  from monthly_rack_conveynce_bill mrcb  where rack_id =main_rack_code) as paid_convenience
                                

                        from rack_products rp 
                        WHERE  rp.sold_date  between '$frm_date' and '$to_date'   $agent_sql  $shop_sql and rp.status =7
                        group by rp.shop_id) sm





";
        
        $grand_total = DB::select($summation_sql);


        $date_range_array = [
            'frm_date' => $frm_date,
            'to_date' => $to_date
        ];

       

        
        $data = [
            'result' => $result,
            'frm_date'=> $frm_date,
            'to_date' => $to_date,
            'agent_name' => $agent_name,
            'shop_name' => $shop_name,
            'grand_total'=> $grand_total,
            'date_range_array' => $date_range_array
        ];
        return view('report.agent-commission.details', $data); 
    }

    public function shopDetails($url_array)
    {
       
        $url_decrypt_array = Crypt::decrypt($url_array);
        
        $rack_code = $url_decrypt_array['rack_code'];
        $frm_date = $url_decrypt_array['frm_date'];
        $to_date = $url_decrypt_array['to_date'];
        
        $sql = "SELECT rp.agent_id,
                        rp.rack_code                      AS main_rack_code,
                        rp.sold_date,
                        s.NAME                            AS shop_name,
                        s.contact_no,
                        s.owner_contact,
                        s.shop_address,
                        rp.rack_code,
                        au.NAME                           AS agent_name,
                        date_format(rp.sold_date, '%Y-%m') as sold_year_month, 
                        (SELECT Count(id)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_sold_socks,
                        (SELECT Sum(selling_price)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month )           AS total_sale_price,
                        (SELECT Sum(shop_commission)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_shop_commission,
                        (SELECT Sum(agent_commission)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_agent_commission,
                        (SELECT Sum(venture_amount)
                        FROM   rack_products rp
                        WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_venture_amt,
                        (SELECT Sum(agent_commission)
                        FROM   monthly_rack_conveynce_bill mrcb
                        WHERE  rack_id = main_rack_code and year_and_month = sold_year_month) AS paid_agent_commission,
                        (SELECT Sum(amount)
                        FROM   monthly_rack_conveynce_bill mrcb
                        WHERE  rack_id = main_rack_code and year_and_month = sold_year_month ) AS paid_convenience
                FROM   rack_products rp
                        LEFT JOIN shops s
                            ON s.id = rp.shop_id
                        LEFT JOIN agent_users au
                            ON rp.agent_id = au.id
                WHERE  rp.sold_date BETWEEN '$frm_date' AND '$to_date'
                        AND rp.rack_code ='$rack_code' and rp.status =7
                GROUP  BY Year(rp.sold_date), Month(rp.sold_date) order by s.name asc ";

      $bill_result  = DB::select($sql);

        $sum_sql = "SELECT sum(sm.total_sold_socks) as  grand_sold_socks ,
                            sum(sm.total_sale_price) as grand_sale_price, 
                            sum(sm.total_shop_commission) as grand_shop_commission, 
                            sum(sm.total_agent_commission) as grand_agent_commission, 
                            sum(sm.total_venture_amt) as grand_venture_amt, 
                            sum(sm.paid_agent_commission) as grand_paid_agent_commission, 
                            sum(sm.paid_convenience) as grand_paid_convenience

                    from (SELECT 
                        rp.rack_code                      AS main_rack_code,
                        date_format(rp.sold_date, '%Y-%m') as sold_year_month, 
                        (SELECT Count(id)
                            FROM   rack_products rp
                            WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_sold_socks,
                        (SELECT Sum(selling_price)
                            FROM   rack_products rp
                            WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month )           AS total_sale_price,
                        (SELECT Sum(shop_commission)
                            FROM   rack_products rp
                            WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_shop_commission,
                        (SELECT Sum(agent_commission)
                            FROM   rack_products rp
                            WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_agent_commission,
                        (SELECT Sum(venture_amount)
                            FROM   rack_products rp
                            WHERE  rack_code = main_rack_code
                                AND status = 7 and date_format(sold_date, '%Y-%m') like sold_year_month)           AS total_venture_amt,
                        (SELECT Sum(agent_commission)
                            FROM   monthly_rack_conveynce_bill mrcb
                            WHERE  rack_id = main_rack_code and year_and_month = sold_year_month) AS paid_agent_commission,
                        (SELECT Sum(amount)
                            FROM   monthly_rack_conveynce_bill mrcb
                            WHERE  rack_id = main_rack_code and year_and_month = sold_year_month ) AS paid_convenience
                    FROM   rack_products rp
                        LEFT JOIN shops s
                                ON s.id = rp.shop_id
                        LEFT JOIN agent_users au
                                ON rp.agent_id = au.id
                    WHERE  rp.sold_date BETWEEN '$frm_date' AND '$to_date'
                        
                        AND rp.rack_code ='$rack_code' and status=7
                    GROUP  BY Year(rp.sold_date), Month(rp.sold_date)) sm";

        $grand_total = DB::select($sum_sql);



      //find agent name 

     $agent_info =  DB::table('rack_mapping as rm')
      ->select('au.name as agent_name')
      ->leftJoin('agent_users as au',  'au.id', '=', 'rm.agent_id')
      ->where('rm.rack_code', $rack_code)
      ->first();
      if(!empty($agent_info))
      {
          $agent_name = $agent_info->agent_name;
      }else{
          $agent_name='';
      }

    

      $data = [
           'bill_result'=> $bill_result,
           'frm_date'=> $frm_date,
           'to_date' => $to_date,
           'agent_name' => $agent_name,
           'grand_total' => $grand_total
      ];

      return view('report.agent-commission.shop-info-details', $data);



        

    }

}
