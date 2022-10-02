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
       


         /* ----------------------previous due bill -----------------------------------*/
         $previous_due_sql = "SELECT
         rack_code,
         shop_id,
         sum(total_bill) as total_bill,
         last_billing_date,
         shop_name,
         shop_contact,
         (select sum(selling_price) from rack_products where rack_code =billable.rack_code and status=3) as authorize_pending_amount
      from
         (
            SELECT
               rack_due.*,
               s.name as shop_name,
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
               (rack_due.is_new_shop = 1 AND rack_due.last_payment_days_count > ( broken_month_day + 30 ))
               or (rack_due.is_new_shop = 0 and ( last_bill_year_month != current_year_month) or ( REPLACE(last_billing_month, '-', '') < REPLACE(current_year_month, '-', '')))
			   or (rack_due.is_new_shop = 0 and (select count(*) from rack_products where rack_code =rack_due.rack_code and status=3) > 0)
            ORDER BY
               last_payment_days_count,
               total_bill desc 
         )
         billable 
      group by
         billable.rack_code";


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
         if((refill.total_count * pr.counter_figure) > unsold_socks_sell, 1000, 0) as refill_first
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

        



/*       ########################### due shop count ############################
       $due_shop_sql = "SELECT count(*) as total_due_shop from (SELECT rack_code,
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
               total_bill desc) billable ) m";

      $due_shop_count = DB::select($due_shop_sql);
      if(count($due_shop_count) > 0)
      {
      $due_shop_result = $due_shop_count[0]->total_due_shop;
      }else{
      $due_shop_result=0;
      }
       ########################### due shop count ############################



       ####################### neeed refill ############################
       $refill_count_sql = "SELECT
        count(*) as total_refill_shop,         
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
         order by refill_first desc ,last_update_days_count desc ";
       $refill_count_reulst = DB::select($refill_count_sql);

       if(count($refill_count_reulst) > 0)
       {
           $total_refill_shop =  $refill_count_reulst[0]->total_refill_shop;
       }else{
           $total_refill_shop =0;
       }

       ####################### neeed refill ############################*/








       

        $data = [
            'previous_due_result' => $previous_due_result,
            'refill_result' => $refill_result,
            /*'due_shop_result' => $due_shop_result,
            'total_refill_shop' =>$total_refill_shop*/
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
