<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
      public function index(){
        $sales_update_sql  = "SELECT
        * 
     from
        (
           select
              s.name as shop_name,
              s.area,
              u.mobile_number as contact_no1,
            s.contact_no as contact2,
            s.owner_contact as contact3,
              au.name as agent_name,
              s.entry_date,
              rm.rack_code,
              s.select_contact,
            s.id,
            
              (
                 select
                    DATE(sold_mark_date_time) 
                 from
                    rack_products 
                 where
                    rack_code = rm.rack_code 
                    and status = 1 
                 group by
                    DATE(sold_mark_date_time) 
                 order by
                    DATE(sold_mark_date_time) DESC limit 1 
              )
              sold_date,
              (
                 select
                    count(*) 
                 from
                    rack_products 
                 where
                    rack_code = rm.rack_code 
                    and status = 1
              )
              as total_due_sold,
              (
                 select
                    count(*) 
                 from
                    rack_products 
                 where
                    rack_code = rm.rack_code 
                    and 
                    (
                       status = 0 
                       or status = 2
                    )
              )
            
         
              as total_unsold,
            
            
              (
                 select
                    sold_mark_date_time 
                 from
                    rack_products 
                 where
                    rack_code = rm.rack_code 
                    and status in (1, 3, 7)
                 order by
                    sold_mark_date_time desc limit 1
              )
              as last_sales_update_date ,
            
            
      (select shop_commission_persentage  from commission_setups cs where (shop_id =  s.id or shop_id =0) and cat_id =1 and statring_range <= (total_due_sold or 1)  and ending_range >= (total_due_sold or 1) order by id desc limit 1) as socks_commission,
      (select shop_commission_persentage  from commission_setups cs where (shop_id =  s.id or shop_id =0) and cat_id =2 and statring_range <= (total_due_sold or 1) and ending_range >= (total_due_sold or 1) order by id desc limit 1) as tshirt_commission,
      (select shop_commission_persentage  from commission_setups cs where (shop_id =  s.id or shop_id =0) and cat_id =3 and statring_range <= (total_due_sold or 1) and ending_range >= (total_due_sold or 1) order by id desc limit 1) as pant_commission,
            
     		 (SELECT sum(collect_amount) FROM shock_bills sb WHERE sb.rack_code=rm.rack_code   )      
        as total_collect_bill,
            
             (SELECT count(collect_amount) FROM shock_bills sb WHERE sb.rack_code=rm.rack_code   )      
        as total_collect_count,
            
            (SELECT entry_datetime FROM shock_bills sb WHERE sb.rack_code=rm.rack_code   ORDER BY entry_datetime desc LIMIT 1)      
        as bill_collect_date_time
            
           from
              shops s 
              left join
                 rack_mapping rm 
                 on s.id = rm.shop_id 
              left join
                 agent_users au 
                 on rm.agent_id = au.id 
            
             left join
                 users u 
                 on u.shop_id = s.id
                 where s.is_active = 1
        )
        shop_report 
         where total_unsold > 0
     order by
        total_unsold, entry_date asc";
        
        
    /*----------------------------- Ramjan------------------------------- */
     /* ----------------------previous due bill -----------------------------------*/
         $current_ym = date('Y-m');
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
                         (select if(max(sold_date) is null, '0000-00-00',max(sold_date)) from rack_products rp3 where rp3.rack_code=rp.rack_code and status in (1,7)) as latest_sold_date,
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
                   where s.is_active =1
          )
          refill
          LEFT JOIN paremeter pr  ON pr.counter_name = 'remaining_socks'
          where shop_id != 0 and ( (refill.total_count * pr.counter_figure) > refill.unsold_socks_sell  or DATEDIFF( CURDATE() , refill.last_update_date) > 18) 
          order by refill_first desc ,last_update_days_count desc";

            $refill_result  = DB::select($refill_sql);
      /*-------------------------- reack rifill--------------------------------------- */

       /*------------------------------ total rack -----------------------------------------*/
        
          $socks_rack = DB::select("select count(*) as total_socks_rack from rack_mapping rm left join shops s on s.id = rm.shop_id  where rack_code not in (select rack_code  from rack_mapping rm where  (rack_code like '%VLS-2%' or  rack_code like '%VLS-3%')) and s.is_active = 1");
         $combine_racks = DB::select("select count(*) as total_combine_racks  from rack_mapping rm left join shops s on s.id = rm.shop_id where  (rack_code like '%VLS-2%' or  rack_code like '%VLS-3%') and s.is_active = 1 ");
       /*------------------------------ total rack -----------------------------------------*/

       $close_shop = DB::table('shops')->where('is_active', 0)->count();
        
       $curren_date = date('Y-m');
       $current_month = date('m');
       $current_year = date('Y');
       $last_month  = date("m", strtotime ( '-1 month' , strtotime ( $curren_date ) )) ;

      $this_month_rack = DB::select("SELECT count(*) as this_month_rack FROM  rack_mapping rm where rack_code in (select rp.rack_code from rack_products rp where rp.status= 0 and month(rp.entry_date) = '$current_month' GROUP by rp.rack_code)");
      $last_month_rack = DB::select("SELECT count(*) as last_month_rack  FROM  rack_mapping rm where rack_code in (select rp.rack_code from rack_products rp where rp.status= 0 and month(rp.entry_date) = '$last_month' GROUP by rp.rack_code)");

     
        /* #########################################  socks area ###################################################*/
      $this_month_sale_socks = DB::select("SELECT count(*) as this_month_sale_socks from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$current_month' and year(rp.sold_date)='$current_year' 
      and rp.style_code in (select style_code  from stocks s where cat_id =1) ");

      $last_month_sale_socks = DB::select("SELECT count(*) as last_month_sale_socks from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$last_month' and year(rp.sold_date)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =1)");

      $this_month_sale_socks_amt = DB::select("SELECT sum(venture_amount) as   this_month_sale_socks_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$current_month' and year(rp.auth_dateTime)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =1) ");

      $last_month_sale_socks_amt = DB::select("SELECT sum(venture_amount) as last_month_sale_socks_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$last_month' and year(rp.auth_dateTime)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =1)");


      /* #########################################  Tshirt area ###################################################*/
      $this_month_sale_tshirt = DB::select("SELECT count(*) as this_month_sale_tshirt from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$current_month' and year(rp.sold_date)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =2)");

      $last_month_sale_tshirt = DB::select("SELECT count(*) as last_month_sale_tshirt from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$last_month' and year(rp.sold_date)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =2) ");

      $this_month_sale_tshirt_amt = DB::select("SELECT sum(venture_amount) as   this_month_sale_tshirt_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$current_month' and year(rp.auth_dateTime)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =2) ");

      $last_month_sale_tshirt_amt = DB::select("SELECT sum(venture_amount) as last_month_sale_tshirt_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$last_month' and year(rp.auth_dateTime)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =2) ");

      /* #########################################  Pant area ###################################################*/
      $this_month_sale_pant = DB::select("SELECT count(*) as this_month_sale_pant from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$current_month' and year(rp.sold_date)='$current_year'
      and rp.style_code in (select style_code  from stocks s where cat_id =3) ");

      $last_month_sale_pant = DB::select("SELECT count(*) as last_month_sale_pant from rack_products rp
      where rp.status in  (1,3,7) and month(rp.sold_date)='$last_month' and year(rp.sold_date)='$current_year' 
      and rp.style_code in (select style_code  from stocks s where cat_id =3) ");

      $this_month_sale_pant_amt = DB::select("SELECT sum(venture_amount) as   this_month_sale_pant_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$current_month' and year(rp.auth_dateTime)='$current_year' 
      and rp.style_code in (select style_code  from stocks s where cat_id =3) ");

      $last_month_sale_pant_amt = DB::select("SELECT sum(venture_amount) as last_month_sale_pant_amt from rack_products rp
      where rp.status in  (7) and month(rp.auth_dateTime)='$last_month' and year(rp.auth_dateTime)='$current_year' 
      and rp.style_code in (select style_code  from stocks s where cat_id =3) ");


      $stocks_in_socks = DB::select("SELECT sum(remaining_socks) as total_socks  from stocks s 
      left join category c on s.cat_id = c.id
      where s.cat_id =1 and remaining_socks > 0");

      $stocks_in_tshirt = DB::select("SELECT sum(remaining_socks) as total_tshirt  from stocks s 
      left join category c on s.cat_id = c.id
      where s.cat_id =2 and remaining_socks > 0");


      $stocks_in_pant = DB::select("SELECT sum(remaining_socks) as total_pant  from stocks s 
      left join category c on s.cat_id = c.id
      where s.cat_id =3 and remaining_socks > 0");



      
    /*----------------------------- Ramjan------------------------------- */

        $sales_update = DB::select(DB::raw($sales_update_sql));
        $data = [
            "sales_update" => $sales_update,
            "sl"           => 1,
            'previous_due_result' => $previous_due_result,
            'refill_result' => $refill_result,
            'socks_rack' => $socks_rack,
            'combine_racks' => $combine_racks,
            'close_shop' => $close_shop,
            'this_month_rack' => $this_month_rack,
            'last_month_rack' => $last_month_rack,

            'this_month_sale_socks' => $this_month_sale_socks,
            'last_month_sale_socks' => $last_month_sale_socks,

            'this_month_sale_tshirt' => $this_month_sale_tshirt,
            'last_month_sale_tshirt' => $last_month_sale_tshirt,

            'this_month_sale_pant' => $this_month_sale_pant,
            'last_month_sale_pant' => $last_month_sale_pant,

             /* ---------- amount ---------*/
             "this_month_sale_socks_amt" => $this_month_sale_socks_amt,
             "last_month_sale_socks_amt" => $last_month_sale_socks_amt,

             "this_month_sale_tshirt_amt" => $this_month_sale_tshirt_amt,
             "last_month_sale_tshirt_amt" => $last_month_sale_tshirt_amt,

             "this_month_sale_pant_amt" => $this_month_sale_pant_amt,
             "last_month_sale_pant_amt" => $last_month_sale_pant_amt,

             /* ---------stock in product------- */
             "stocks_in_socks" => $stocks_in_socks,
             "stocks_in_tshirt" => $stocks_in_tshirt,
             "stocks_in_pant" => $stocks_in_pant,
        ];

      

        return view('home', $data); 
    }

}
