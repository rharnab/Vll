<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDashboardController extends Controller
{
    public function index()
    {
          
           $currentMonth = date('m');
           $currentYear = date('Y');
        /* ----------------------------need to refill -------------------------------------*/
        $refill = "SELECT count(*) as total_refill_racks
        FROM   (SELECT *,
                       ( total_count * pr.counter_figure ) minimum_socks
                FROM   (SELECT Count(*)          total_socks,
                               r.total_count,
                               rp.shop_id,
                               rp.rack_code,
                               'remaining_socks' AS remaining_socks
                        FROM   shops s
                               LEFT JOIN rack_products rp
                                      ON rp.shop_id = s.id
                               LEFT JOIN racks r
                                      ON r.rack_code = rp.rack_code
                        WHERE  ( rp.status = 0 or rp.status = 2)
                        GROUP  BY rp.shop_id) r
                       LEFT JOIN paremeter pr
                              ON pr.counter_name = r.remaining_socks) m
        WHERE  m.total_socks < m.minimum_socks; ";
        $refill_result = DB::select($refill);

        if(count($refill_result) > 0)
        {
            $refil_racks =  $refill_result[0]->total_refill_racks;
        }else{
            $refil_racks =0;
        }
        /* ----------------------------need to refill -------------------------------------*/

         /* ---------------------------- not need to refill -------------------------------------*/
         $not_refill = "SELECT count(*) as total_refill_racks
         FROM   (SELECT *,
                        ( total_count * pr.counter_figure ) minimum_socks
                 FROM   (SELECT Count(*)          total_socks,
                                r.total_count,
                                rp.shop_id,
                                'remaining_socks' AS remaining_socks
                         FROM   shops s
                                LEFT JOIN rack_products rp
                                       ON rp.shop_id = s.id
                                LEFT JOIN racks r
                                       ON r.rack_code = rp.rack_code
                         WHERE  rp.status = 0
                         GROUP  BY rp.shop_id) r
                        LEFT JOIN paremeter pr
                               ON pr.counter_name = r.remaining_socks) m
         WHERE  m.total_socks > m.minimum_socks; ";
         $not_refill_result = DB::select($not_refill);

         if(count($not_refill_result) > 0)
         {
             $not_refil_racks =  $not_refill_result[0]->total_refill_racks;
         }else{
             $not_refil_racks =0;
         }
         /* ---------------------------- not need to refill -------------------------------------*/


         /* ----------------------previous due bill -----------------------------------*/
         $previous_due_sql = "SELECT rack_code,
         shop_id,
         sum(total_bill) as total_bill ,
         last_billing_date,
         shop_name,
         shop_contact
         from (SELECT
               rack_due.*,
               s.name  as shop_name,
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
                                             total_bill 
                                          from
                                             (
                                                SELECT
                                                   rack_code,
                                                   sold_year,
                                                   sold_month,
                                                   shop_id,
                                                   Sum(selling_price) AS total_bill 
                                                FROM
                                                   (
                                                      SELECT
                                                         Year(sold_date) AS sold_year,
                                                         Month(sold_date) AS sold_month,
                                                         rack_code,
                                                         shop_id,
                                                         selling_price 
                                                      FROM
                                                         rack_products 
                                                      WHERE
                                                         status = 1 
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
               )
               rack_due 
               left join
                  shops s 
                  on rack_due.shop_id = s.id 
            WHERE
               (
                  rack_due.is_new_shop = 1 
                  AND rack_due.last_payment_days_count > ( broken_month_day + 30 ) 
               )
               OR 
               (
                    ( DATE_FORMAT(last_billing_date, '%Y-%m') != DATE_FORMAT( CURDATE(), '%Y-%m') and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month ) 
                  or 
                  (
                     REPLACE(last_billing_month, '-', '') < DATE_FORMAT( CURDATE(), '%Y%m' and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month)
                  )
               )
            ORDER BY
               last_payment_days_count,
               total_bill desc) billable ";


         $previous_due_result = DB::select($previous_due_sql);
         /* ----------------------previous due bill -----------------------------------*/

         /*-------------------------- reack rifill--------------------------------------- */
          $refill_sql = "SELECT
         refill.shop_id,
         refill.rack_code,
         refill.total_count,
         refill.shop_name,
         refill.shop_contact,
         refill.unsold_socks_sell,
         refill.sold_socks_sell,
         refill.last_update_date,         
         DATEDIFF( CURDATE() , refill.last_update_date) as last_update_days_count,
         if(refill.sold_socks_sell > 40 , 10000, 0) as refill_first
      from
         (
            select
               rack.shop_id,
               rack.rack_code,
               r.total_count,
               s.name as shop_name,
               ( select count(*) from rack_products rp where status = 1  and rack_code = rack.rack_code ) as sold_socks_sell,
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
               as shop_contact , 
               (
                  select
                     count(*) 
                  from
                     rack_products rp 
                  where
                     (status = 0  or status = 2) 
                     and rack_code = rack.rack_code
               )
               as unsold_socks_sell,
               (
                
                select  
                     CASE 
                        WHEN latest_entry_date > latest_sold_date AND latest_entry_date > latest_shop_map_date THEN latest_entry_date
                        WHEN latest_sold_date > latest_entry_date AND latest_sold_date > latest_shop_map_date THEN latest_sold_date
                        WHEN latest_shop_map_date > latest_entry_date AND latest_shop_map_date > latest_sold_date THEN latest_shop_map_date
                    end last_update_date
                from (
                    select 
                        (select if(max(entry_date) is null, '0000-00-00',max(entry_date))  from rack_products rp2 where rp2.rack_code=rp.rack_code and status in (0,2)) as latest_entry_date,
                        (select if(max(sold_date) is null, '0000-00-00',max(sold_date)) from rack_products rp3 where rp3.rack_code=rp.rack_code and status in (1)) as latest_sold_date,
                        (select if(max(shop_reg_date) is null, '0000-00-00',max(shop_reg_date)) from rack_mapping rm where rm.rack_code=rp.rack_code) as latest_shop_map_date,
                        rp.rack_code
                    from rack_products rp
                    where  rp.status in (0,1,2) group by rack_code 
                ) dt where dt.rack_code = rack.rack_code
               )
               as last_update_date 
            from
               (
                  select
                     shop_id,
                     rack_code 
                  from
                     rack_products rp 
                  group by
                     rack_code
               )
               rack 
               left join
                  shops s 
                  on rack.shop_id = s.id 
               LEFT JOIN
                  racks r 
                  ON r.rack_code = rack.rack_code
         )
         refill
         LEFT JOIN paremeter pr  ON pr.counter_name = 'remaining_socks'
         where shop_id != 0 and ( (refill.total_count * pr.counter_figure) > refill.unsold_socks_sell  or DATEDIFF( CURDATE() , refill.last_update_date) > 12) 
         order by refill_first desc ,last_update_days_count desc";

            $refill_result  = DB::select($refill_sql);
         /*-------------------------- reack rifill--------------------------------------- */

         /*----------------------------------- This month new ----------------------------- */
         $this_month_new_shop_sql  = "SELECT s.name,
                                         s.id as shop_id,
                                          s.contact_no,
                                          rp.rack_code,
                                          s.owner_contact,
                                          Count(*) as total_socks,
                                          s.address
                                   FROM   shops s
                                          LEFT JOIN rack_mapping rm
                                                 ON s.id = rm.shop_id
                                          LEFT JOIN rack_products rp
                                                 ON rp.shop_id = s.id
                                   WHERE  ( Month(rm.entry_datetime) = '$currentMonth'
                                          AND Year(rm.entry_datetime) = '$currentYear' )
                                          AND rp.status = 0
                                   GROUP  BY rp.shop_id order by entry_datetime desc ";

         $this_month_new_shop_result = DB::select($this_month_new_shop_sql);
         /*----------------------------------- This month new ----------------------------- */


         /* -----------------------this month bill collection -------------------------------*/
         $this_month_bill_collection_sql  = "SELECT s.name,
                                                        s.address,
                                                        s.contact_no,
                                                        s.owner_contact,
                                                        rp.rack_code,
                                                        rm.shop_id,
                                                        Count(*)              total_socks,
                                                        Sum(rp.selling_price) total_bill
                                                 FROM   shops s
                                                        LEFT JOIN rack_mapping rm
                                                               ON rm.shop_id = s.id
                                                        LEFT JOIN rack_products rp
                                                               ON rp.rack_code = rm.rack_code
                                                        LEFT JOIN shock_bills sb
                                                               ON sb.shocks_bill_no = rp.shocks_bill_no
                                                 WHERE  rp.status IN ( 3 )
                                                        and (month(sb.entry_datetime) ='$currentMonth'
                                                        and year(sb.entry_datetime) ='$currentYear' )
                                                 GROUP  BY rp.shop_id,
                                                        ( Month(rp.agent_bill_collection_datetime)
                                                               AND Year(rp.shocks_bill_no) )
                                                 ORDER  BY total_bill DESC ";
       $this_month_bill_collection_result  =  DB::select($this_month_bill_collection_sql);
         /* -----------------------this month bill collection -------------------------------*/ 

         /* --------------------------total bil collection ----------------------------------*/
         $total_bill_collecton_sql = "SELECT *
                                          FROM   (SELECT rp.shop_id,
                                                        rp.rack_code,
                                                        s.shop_address,
                                                        Sum(rp.selling_price) due_bill,
                                                        s.name,
                                                        rp.sold_date,
                                                        s.contact_no,
                                                        s.owner_contact
                                                 FROM   shops s
                                                        LEFT JOIN rack_products rp
                                                               ON rp.shop_id = s.id
                                                 WHERE  rp.status = 3 /* and (month(rp.sold_date) <> '$currentMonth'
                                                 and year(rp.sold_date)) <> '$currentYear' */
                                                 GROUP  BY rp.shop_id,
                                                        Month(rp.sold_date),
                                                        Year(rp.sold_date)) d
                                          GROUP  BY d.shop_id,
                                                 Month(d.sold_date),
                                                 Year(d.sold_date)
                                          HAVING Count(Month(d.sold_date)) > 0
                                          order by d.due_bill  desc";
       $total_bill_collecton_result  = DB::select($total_bill_collecton_sql);
         /* --------------------------total bil collection ----------------------------------*/

         /* ----------------------this month  bill collection amount------------------------------- */
         $this_month__bill_collect_sql= "SELECT sum(b.total_bill) as this_month_bill_collection from (SELECT sb.entry_datetime,
                                          Sum(rp.selling_price) total_bill
                                   FROM   shops s
                                          LEFT JOIN rack_mapping rm
                                                 ON rm.shop_id = s.id
                                          LEFT JOIN rack_products rp
                                                 ON rp.rack_code = rm.rack_code
                                          LEFT JOIN shock_bills sb
                                                 ON sb.shocks_bill_no = rp.shocks_bill_no
                                   WHERE  rp.status IN ( 3 )
                                          AND ( Month(sb.entry_datetime) = '$currentMonth'
                                                 AND Year(sb.entry_datetime) = '$currentYear' )
                                   GROUP  BY rp.shop_id,
                                          ( Month(rp.agent_bill_collection_datetime)
                                                 AND Year(rp.shocks_bill_no) )
                                   ORDER  BY total_bill DESC) b ";
                                   
         $this_month__bill_collect_result = DB::select($this_month__bill_collect_sql);
         if(count($this_month__bill_collect_result) > 0)
         {
              $this_month__bill_collect_result = $this_month__bill_collect_result[0]->this_month_bill_collection;
         }else{
                $this_month__bill_collect_result=0;
         }
         
         
         /* ----------------------this  bill collection amount------------------------------- */

         /* -----------------------upto bll collection----------------------------------------- */
         $up_to_bill_amt_sql = "SELECT sum(b.total_bill) as total_bill_collection 
                            from (SELECT sb.entry_datetime,
                                   Sum(rp.selling_price) total_bill
                            FROM   shops s
                                   LEFT JOIN rack_mapping rm
                                          ON rm.shop_id = s.id
                                   LEFT JOIN rack_products rp
                                          ON rp.rack_code = rm.rack_code
                                   LEFT JOIN shock_bills sb
                                          ON sb.shocks_bill_no = rp.shocks_bill_no
                            WHERE  rp.status IN ( 3 )
                                   
                            GROUP  BY rp.shop_id,
                                   ( Month(rp.agent_bill_collection_datetime)
                                          AND Year(rp.shocks_bill_no) )
                            ORDER  BY total_bill DESC) b;"; 

                     $upto__bill_collect_amt = DB::select($up_to_bill_amt_sql);
                     if(count($upto__bill_collect_amt) > 0)
                     {
                     $upto__bill_collect_amt = $upto__bill_collect_amt[0]->total_bill_collection;
                     }else{
                            $upto__bill_collect_amt=0;
                     }

         /* -----------------------upto bll collection----------------------------------------- */
         
         /* -----------------------------Up to due bill -----------------------------------------*/
         $upto_due_bill_sql = "select sum(bld.total_bill) as total_bill_due from (SELECT rack_code,
         shop_id,
         sum(total_bill) as total_bill ,
         last_billing_date,
         shop_name,
         shop_contact
         from (SELECT
               rack_due.*,
               s.name  as shop_name,
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
                                             total_bill 
                                          from
                                             (
                                                SELECT
                                                   rack_code,
                                                   sold_year,
                                                   sold_month,
                                                   shop_id,
                                                   Sum(selling_price) AS total_bill 
                                                FROM
                                                   (
                                                      SELECT
                                                         Year(sold_date) AS sold_year,
                                                         Month(sold_date) AS sold_month,
                                                         rack_code,
                                                         shop_id,
                                                         selling_price 
                                                      FROM
                                                         rack_products 
                                                      WHERE
                                                         status = 1 
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
               )
               rack_due 
               left join
                  shops s 
                  on rack_due.shop_id = s.id 
            WHERE
               (
                  rack_due.is_new_shop = 1 
                  AND rack_due.last_payment_days_count > ( broken_month_day + 30 ) 
               )
               OR 
               (
                    ( DATE_FORMAT(last_billing_date, '%Y-%m') != DATE_FORMAT( CURDATE(), '%Y-%m') and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month ) 
                  or 
                  (
                     REPLACE(last_billing_month, '-', '') < DATE_FORMAT( CURDATE(), '%Y%m' and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month)
                  )
               )
            ORDER BY
               last_payment_days_count,
               total_bill desc) billable) bld";

          $upto__due_bill_amt = DB::select($upto_due_bill_sql);
          if(count($upto__due_bill_amt) > 0)
          {
               $upto__due_bill_amt = $upto__due_bill_amt[0]->total_bill_due;
          }else{
                 $upto__due_bill_amt=0;
          }
         /* -----------------------------Up to due bill -----------------------------------------*/

         /* -------------------------this month due bill --------------------------------- */
         $this_month_due_bill_sql = "SELECT sum(b.total_bill) as  total_bill_due
         from (SELECT sb.entry_datetime,
                Sum(rp.selling_price) total_bill
         FROM   shops s
                LEFT JOIN rack_mapping rm
                       ON rm.shop_id = s.id
                LEFT JOIN rack_products rp
                       ON rp.rack_code = rm.rack_code
                LEFT JOIN shock_bills sb
                       ON sb.shocks_bill_no = rp.shocks_bill_no
         WHERE  rp.status=1 AND ( Month(sb.entry_datetime) = '$currentMonth'
                                                 AND Year(sb.entry_datetime) = '$currentYear' )
                
         GROUP  BY rp.shop_id,
                ( Month(rp.agent_bill_collection_datetime)
                       AND Year(rp.shocks_bill_no) )
         ORDER  BY total_bill DESC) b;";

       $this_month_due_bill_amt = DB::select($this_month_due_bill_sql);
       if(count($this_month_due_bill_amt) > 0)
       {
       $this_month_due_bill_amt = $this_month_due_bill_amt[0]->total_bill_due;
       }else{
       $this_month_due_bill_amt=0;
       }
         /* -------------------------this month due bill --------------------------------- */

       /* ---------------------------------------this month new shop number--------------- */
       $this_month_shop_number_sql = "SELECT  count(*)  as total_shop from (SELECT s.id
                                   FROM   shops s
                                          LEFT JOIN rack_mapping rm
                                                 ON s.id = rm.shop_id
                                          LEFT JOIN rack_products rp
                                                 ON rp.shop_id = s.id
                                   WHERE  ( Month(rm.entry_datetime) = '$currentMonth'
                                          AND Year(rm.entry_datetime) = '$currentYear')
                                          AND rp.status = 0
                                   GROUP  BY rp.shop_id order by entry_datetime desc) sc;";

      $this_month_shop_number = DB::select($this_month_shop_number_sql);
      if(count($this_month_shop_number) > 0)
      {
      $this_month_shop_number = $this_month_shop_number[0]->total_shop;
      }else{
      $this_month_shop_number=0;
      }
       /* ---------------------------------------this month new shop number--------------- */



       ########################### due shop count ############################
       $due_shop_sql = "SELECT count(*) total_due_shop
       from (SELECT
             rack_due.*,
             s.name  as shop_name,
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
                                           total_bill 
                                        from
                                           (
                                              SELECT
                                                 rack_code,
                                                 sold_year,
                                                 sold_month,
                                                 shop_id,
                                                 Sum(selling_price) AS total_bill 
                                              FROM
                                                 (
                                                    SELECT
                                                       Year(sold_date) AS sold_year,
                                                       Month(sold_date) AS sold_month,
                                                       rack_code,
                                                       shop_id,
                                                       selling_price 
                                                    FROM
                                                       rack_products 
                                                    WHERE
                                                       status = 1 
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
             )
             rack_due 
             left join
                shops s 
                on rack_due.shop_id = s.id 
          WHERE
             (
                rack_due.is_new_shop = 1 
                AND rack_due.last_payment_days_count > ( broken_month_day + 30 ) 
             )
             OR 
             (
                  ( DATE_FORMAT(last_billing_date, '%Y-%m') != DATE_FORMAT( CURDATE(), '%Y-%m') and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month ) 
                or 
                (
                   REPLACE(last_billing_month, '-', '') < DATE_FORMAT( CURDATE(), '%Y%m' and YEAR(curdate()) != sold_year and MONTH(curdate()) != sold_month)
                )
             )
          ORDER BY
             last_payment_days_count,
             total_bill desc) billable";

      $due_shop_count = DB::select($due_shop_sql);
      if(count($due_shop_count) > 0)
      {
      $due_shop_result = $due_shop_count[0]->total_due_shop;
      }else{
      $due_shop_result=0;
      }
       ########################### due shop count ############################



       ####################### neeed refill ############################
       $refill_count_sql = "SELECT count(*) as total_refill_racks
       FROM   (SELECT *,
                      ( total_count * pr.counter_figure ) minimum_socks
               FROM   (SELECT Count(*)          total_socks,
                              r.total_count,
                              rp.shop_id,
                              rp.rack_code,
                              'remaining_socks' AS remaining_socks
                       FROM   shops s
                              LEFT JOIN rack_products rp
                                     ON rp.shop_id = s.id
                              LEFT JOIN racks r
                                     ON r.rack_code = rp.rack_code
                       WHERE  ( rp.status = 0 or rp.status = 2)
                       GROUP  BY rp.shop_id) r
                      LEFT JOIN paremeter pr
                             ON pr.counter_name = r.remaining_socks) m
       WHERE  m.total_socks < m.minimum_socks; ";
       $refill_count_reulst = DB::select($refill_count_sql);

       if(count($refill_count_reulst) > 0)
       {
           $rack_refills =  $refill_count_reulst[0]->total_refill_racks;
       }else{
           $refil_racks =0;
       }

       ####################### neeed refill ############################


       

        $data = [

            'toatal_rack_refils' => $refil_racks,
            'not_refil_racks' => $not_refil_racks,
            'previous_due_result' => $previous_due_result,
            'refill_result' => $refill_result,
            'this_month_new_shop_result' => $this_month_new_shop_result,
            'this_month_bill_collection_result' => $this_month_bill_collection_result,
            'total_bill_collecton_result' => $total_bill_collecton_result,
            'this_month__bill_collect_result' => $this_month__bill_collect_result,
            'upto__bill_collect_amt' => $upto__bill_collect_amt,
            'upto__due_bill_amt' => $upto__due_bill_amt,
            'this_month_due_bill_amt' => $this_month_due_bill_amt,
            'this_month_shop_number' => $this_month_shop_number,
            'due_shop_result' => $due_shop_result
        ];
        return view('dashboard.index', $data);
    }

    public function details($type)
    {
        if($type == trim('refill') )
        {
            $sql = "SELECT * 
            FROM   (SELECT *,
                           ( total_count * pr.counter_figure ) minimum_socks
                    FROM   (SELECT Count(*)          total_socks,
                                   r.total_count,
                                   rp.shop_id,
                                   'remaining_socks' AS remaining_socks,
                                    s.name as shop_name,
                                    rp.rack_code,
                                    s.shop_address,
                                    s.manager_name,
                                    au.name as agent_name,
                                    s.contact_no
                            FROM   shops s
                                   LEFT JOIN rack_products rp
                                          ON rp.shop_id = s.id
                                   LEFT JOIN racks r
                                          ON r.rack_code = rp.rack_code
                                    LEFT JOIN agent_users au
                                          ON au.id = rp.agent_id
                            WHERE  rp.status = 0
                            GROUP  BY rp.shop_id) r
                           LEFT JOIN paremeter pr
                                  ON pr.counter_name = r.remaining_socks) m
            WHERE  m.total_socks < m.minimum_socks order by m.total_socks asc ";

        }else if($type == trim('NotRefill') ){


            $sql = "SELECT * 
            FROM   (SELECT *,
                           ( total_count * pr.counter_figure ) minimum_socks
                    FROM   (SELECT Count(*)          total_socks,
                                   r.total_count,
                                   rp.shop_id,
                                   'remaining_socks' AS remaining_socks,
                                    s.name as shop_name,
                                    rp.rack_code,
                                    s.shop_address,
                                    s.manager_name,
                                    au.name as agent_name,
                                    s.contact_no
                            FROM   shops s
                                   LEFT JOIN rack_products rp
                                          ON rp.shop_id = s.id
                                   LEFT JOIN racks r
                                          ON r.rack_code = rp.rack_code
                                    LEFT JOIN agent_users au
                                          ON au.id = rp.agent_id
                            WHERE  rp.status = 0 
                            GROUP  BY rp.shop_id) r
                           LEFT JOIN paremeter pr
                                  ON pr.counter_name = r.remaining_socks) m
            WHERE  m.total_socks > m.minimum_socks order by m.total_socks desc ";



        }

         $result_info = DB::select($sql);
         
         $data = [ 
            'result_info' => $result_info,
            'type' => $type,

         ];

         return view('dashboard.details', $data);

    }



    public function shop_details(Request $request)
    {
           $shop_id = $request->shop_id;
           $rack_code = $request->rack_code;

           $shop_info = DB::table('shops as s')
           ->leftJoin('rack_mapping as rm', 'rm.shop_id', '=', 's.id')
           ->leftJoin('agent_users as au', 'rm.agent_id', '=', 'au.id')
           ->select('s.*', 'au.name as agent_name', 'rm.rack_code')
           ->where([
                  ['rm.shop_id', '=',  $shop_id],
                  ['rm.rack_code', '=',  $rack_code],

           ])->first();

           if(!empty($shop_info))
           {
               return json_encode($shop_info);
           }else{
               return '';
           }

          
    }


}
