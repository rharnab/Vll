<?php

namespace App\Http\Controllers\DashboardReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardReportController extends Controller
{
    public function rack_info($get_date)
    {
         $report_date = $get_date."-01";
         $month = date('m', strtotime($report_date));
         $year = date('Y');


       $this_month_rack_reuslt  = DB::select("SELECT rm.rack_code, s.name, s.market_name, rm.agent_id, s.area, s.contact_no, s.owner_email, au.name as agent_name, r.rack_category, r.total_count, s.owner_contact
       FROM   rack_mapping rm
       left join shops s on s.id =rm.shop_id
       left join agent_users au on au.id = rm.agent_id
       left join racks r on r.rack_code = rm.rack_code
       WHERE  rm.rack_code IN (SELECT rp.rack_code
                            FROM   rack_products rp
                            WHERE  rp.status = 0
                                   AND Month(rp.entry_date) = '$month' and Year(rp.entry_date) = '$year'
                            GROUP  BY rp.rack_code) 
       order by rm.rack_code asc");

         /* echo "<pre>";
         print_r($this_month_rack_reuslt);die; */
        

         $data = [
             'this_month_rack_reuslt' => $this_month_rack_reuslt,
             'report_date'=> $report_date
         ];

         return view('dashboardReport.rack', $data);
    }

    public function close_shop()
    {
        $close_shop  = DB::select("SELECT rp.rack_code, s.name, s.market_name, rp.agent_id, s.area, s.contact_no, s.owner_email, au.name as agent_name, r.rack_category, r.total_count, s.owner_contact
        from shops s 
        left join rack_products rp on s.id = rp.shop_id
        left join agent_users au on au.id = rp.agent_id
        left join racks r on r.rack_code = rp.rack_code
        where s.is_active=0 
        GROUP by s.id");

        return view('dashboardReport.close_shop', compact('close_shop'));
        
    }

    public function socks_bill($get_date)
    {
         $report_date = $get_date."-01";
         $month = date('m', strtotime($report_date));
         $year = date('Y');
         
         if($month == date('m'))
         {
             $sts_sql = "rp.status=7";
         }else{
              $sts_sql = "rp.status=7";
         }
         
        

        $sql ="SELECT sold_date, rack_code, s.name as shop_name,
        Count(*)              AS total_socks,
        Sum(rp.selling_price)    AS total_bill,
        Sum(rp.shop_commission)  AS shop_commission_amt,
        Sum(rp.agent_commission) AS agent_commission_amt,
        Sum(rp.venture_amount) AS venture_commission_amt,
        sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
        FROM   rack_products rp
        left join shops s on s.id = rp.shop_id 
        WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql 
        and rp.style_code in (select style_code  from stocks s where cat_id =1)
        GROUP  BY rack_code";

        $socks_bill = DB::Select($sql);

        $summation_reuslt = DB::select("SELECT sum(m.total_socks) as grand_shocks, sum(m.total_bill) as grand_total_bill, sum(m.shop_commission_amt) as grand_shop_commission,
        sum(m.agent_commission_amt) as grand_agent_commission, sum(m.venture_commission_amt) as grand_venture_amt
        from (SELECT 
                Count(*)              AS total_socks,
                Sum(rp.selling_price)    AS total_bill,
                Sum(rp.shop_commission)  AS shop_commission_amt,
                Sum(rp.agent_commission) AS agent_commission_amt,
                Sum(rp.venture_amount) AS venture_commission_amt,
                sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
                FROM   rack_products rp
                left join shops s on s.id = rp.shop_id 
                WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql
                and rp.style_code in (select style_code  from stocks s where cat_id =1)
                GROUP  BY rack_code) m")[0];

        $data = [
            'socks_bill' => $socks_bill,
            'report_date'=> $report_date,
            'summation_reuslt'=> $summation_reuslt
        ];

        return view('dashboardReport.socks_bill', $data);
    }

    public function due_shop()
    {
        $previous_due_sql = "SELECT
         rack_code,
         shop_id,
         sum(total_bill) as total_bill,
         sum(total_venture_amount) as total_venture_amount,
         sum(total_agent_commission) as total_agent_commission,
         ( sum(total_venture_amount) + sum(total_agent_commission) ) sorting_amount,
         last_billing_date,
         shop_name,
         shop_contact,
         owner_contact,
         (select sum(selling_price) from rack_products where rack_code =billable.rack_code and status=3) as authorize_pending_amount
      from
         (
            SELECT
               rack_due.*,
               s.name as shop_name,
               s.owner_contact,
               (
                  CASE
                     WHEN
                        s.contact_no is null 
                     THEN
                        s.owner_contact 
                     ELSE
                        s.contact_no 
                  end
               )
               as shop_contact 
            from
               (
                  select
                     DATE_FORMAT( CURDATE(), '%Y-%m') as current_year_month,
                     DATE_FORMAT(last_billing_date, '%Y-%m') as last_bill_year_month,
                     YEAR(curdate()) as current_year,
                     MONTH(curdate()) as current_month,
                     due.*,
                     DATEDIFF( LAST_DAY(starting_count_date) , starting_count_date) as broken_month_day,
                     Datediff(Last_day(last_billing_date), starting_count_date) AS old_rack_broken_month_day 
                  from
                     (
                        select
                           sh.*,
                           DATEDIFF( CURDATE() , starting_count_date) as last_payment_days_count 
                        from
                           (
                              select
                                 rack_bill.*,
                                 (
                                    CASE
                                       WHEN
                                          rack_bill.last_billing_date is null 
                                       THEN
                                          1 
                                       ELSE
                                          0 
                                    end
                                 )
                                 as is_new_shop, 
                                 (
                                    CASE
                                       WHEN
                                          rack_bill.last_billing_date is null 
                                       THEN
                                          shop_entry_date 
                                       ELSE
                                          rack_bill.last_billing_date 
                                    end
                                 )
                                 as starting_count_date 
                              from
                                 (
                                    select
                                       rack.*,
                                       (
                                          select
                                             billing_year_month 
                                          from
                                             shock_bills sb 
                                          where
                                             rack_code = rack.rack_code 
                                          order by
                                             billing_year_month desc limit 1 
                                       )
                                       as last_billing_month,
                                       (
                                          select
                                             date(entry_datetime) 
                                          from
                                             shock_bills sb 
                                          where
                                             rack_code = rack.rack_code 
                                          order by
                                             entry_datetime desc limit 1 
                                       )
                                       as last_billing_date,
                                       (
                                          select
                                             shop_reg_date 
                                          from
                                             rack_mapping 
                                          where
                                             rack_code = rack.rack_code 
                                       )
                                       as shop_entry_date 
                                    from
                                       (
                                          select
                                             rack.rack_code,
                                             rack.sold_year,
                                             rack.sold_month,
                                             rack.shop_id,
                                             total_bill,
                                             total_venture_amount,
                                             total_agent_commission
                                          from
                                             (
                                                SELECT
                                                   rack_code,
                                                   sold_year,
                                                   sold_month,
                                                   shop_id,
                                                   Sum(selling_price) AS total_bill,
                                                   Sum(venture_amount) AS total_venture_amount,
                                                   Sum(agent_commission) AS total_agent_commission 
                                                FROM
                                                   (
                                                      SELECT
                                                         Year(sold_date) AS sold_year,
                                                         Month(sold_date) AS sold_month,
                                                         rack_code,
                                                         shop_id,
                                                         selling_price,
                                                         venture_amount,
                                                         agent_commission 
                                                      FROM
                                                         rack_products 
                                                      WHERE
                                                      (status=1 or status=3) 
                                                   )
                                                   rp 
                                                GROUP BY
                                                   rack_code,
                                                   shop_id,
                                                   sold_year,
                                                   sold_month 
                                                order by
                                                   sold_year,
                                                   sold_month 
                                             )
                                             rack 
                                       )
                                       rack 
                                 )
                                 rack_bill 
                           )
                           sh 
                     )
                     due 
                  where
                     ( MONTH(curdate()) != sold_month or  (select count(*) from rack_products where rack_code =due.rack_code and status=3) > 0 )
               )
               rack_due 
               left join
                  shops s 
                  on rack_due.shop_id = s.id 
            where
               (rack_due.is_new_shop = 1 AND rack_due.last_payment_days_count > ( broken_month_day + DAY(LAST_DAY(DATE_ADD(rack_due.starting_count_date, INTERVAL 1 MONTH))) ))
               or (rack_due.is_new_shop = 0 and ( last_bill_year_month != current_year_month) or ( REPLACE(last_billing_month, '-', '') < REPLACE(current_year_month, '-', '')))
			   or (rack_due.is_new_shop = 0 and (select count(*) from rack_products where rack_code =rack_due.rack_code and status=3) > 0) and s.is_active=1
            ORDER BY
               last_payment_days_count,
               total_bill desc 
         )
         billable 
      group by
         billable.rack_code
         order by sorting_amount desc";

         $previous_due_result = DB::select($previous_due_sql);

         return view('dashboardReport.due_bill', compact('previous_due_result'));
    }
    
    public function pant_bill($get_date)
    {
         $report_date = $get_date."-01";
         $month = date('m', strtotime($report_date));
         $year = date('Y');
         
         if($month == date('m'))
         {
             $sts_sql = "rp.status=7";
         }else{
              $sts_sql = "rp.status=7";
         }
         
        

        $sql ="SELECT sold_date, rack_code, s.name as shop_name,
        Count(*)              AS total_socks,
        Sum(rp.selling_price)    AS total_bill,
        Sum(rp.shop_commission)  AS shop_commission_amt,
        Sum(rp.agent_commission) AS agent_commission_amt,
        Sum(rp.venture_amount) AS venture_commission_amt,
        sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
        FROM   rack_products rp
        left join shops s on s.id = rp.shop_id 
        WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql 
        and rp.style_code in (select style_code  from stocks s where cat_id =3)
        GROUP  BY rack_code";

        $socks_bill = DB::Select($sql);

        $summation_reuslt = DB::select("SELECT sum(m.total_socks) as grand_shocks, sum(m.total_bill) as grand_total_bill, sum(m.shop_commission_amt) as grand_shop_commission,
        sum(m.agent_commission_amt) as grand_agent_commission, sum(m.venture_commission_amt) as grand_venture_amt
        from (SELECT 
                Count(*)              AS total_socks,
                Sum(rp.selling_price)    AS total_bill,
                Sum(rp.shop_commission)  AS shop_commission_amt,
                Sum(rp.agent_commission) AS agent_commission_amt,
                Sum(rp.venture_amount) AS venture_commission_amt,
                sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
                FROM   rack_products rp
                left join shops s on s.id = rp.shop_id 
                WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql
                and rp.style_code in (select style_code  from stocks s where cat_id =3)
                GROUP  BY rack_code) m")[0];

        $data = [
            'socks_bill' => $socks_bill,
            'report_date'=> $report_date,
            'summation_reuslt'=> $summation_reuslt
        ];

        return view('dashboardReport.pant_bill', $data);
    }

    public function tshirt_bill($get_date)
    {
         $report_date = $get_date."-01";
         $month = date('m', strtotime($report_date));
         $year = date('Y');
         
         if($month == date('m'))
         {
             $sts_sql = "rp.status=7";
         }else{
              $sts_sql = "rp.status=7";
         }
         
        

        $sql ="SELECT sold_date, rack_code, s.name as shop_name,
        Count(*)              AS total_socks,
        Sum(rp.selling_price)    AS total_bill,
        Sum(rp.shop_commission)  AS shop_commission_amt,
        Sum(rp.agent_commission) AS agent_commission_amt,
        Sum(rp.venture_amount) AS venture_commission_amt,
        sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
        FROM   rack_products rp
        left join shops s on s.id = rp.shop_id 
        WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql 
        and rp.style_code in (select style_code  from stocks s where cat_id =2)
        GROUP  BY rack_code";

        $socks_bill = DB::Select($sql);

        $summation_reuslt = DB::select("SELECT sum(m.total_socks) as grand_shocks, sum(m.total_bill) as grand_total_bill, sum(m.shop_commission_amt) as grand_shop_commission,
        sum(m.agent_commission_amt) as grand_agent_commission, sum(m.venture_commission_amt) as grand_venture_amt
        from (SELECT 
                Count(*)              AS total_socks,
                Sum(rp.selling_price)    AS total_bill,
                Sum(rp.shop_commission)  AS shop_commission_amt,
                Sum(rp.agent_commission) AS agent_commission_amt,
                Sum(rp.venture_amount) AS venture_commission_amt,
                sum(rp.venture_amount - rp.buying_price ) as total_profit_amount
                FROM   rack_products rp
                left join shops s on s.id = rp.shop_id 
                WHERE  month(rp.auth_dateTime)='$month' and year(rp.auth_dateTime)='$year'  and $sts_sql
                and rp.style_code in (select style_code  from stocks s where cat_id =2)
                GROUP  BY rack_code) m")[0];

        $data = [
            'socks_bill' => $socks_bill,
            'report_date'=> $report_date,
            'summation_reuslt'=> $summation_reuslt
        ];

        return view('dashboardReport.tshirt', $data);
    }
}
