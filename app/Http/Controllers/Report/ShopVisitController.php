<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopVisitController extends Controller
{
    public function shop_visit()
    {
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
        where shop_id != 0 and ( (refill.total_count * pr.counter_figure) > refill.unsold_socks_sell or DATEDIFF( CURDATE() , refill.last_update_date) > 12) 
        order by refill_first desc ,last_update_days_count desc";

           $refill_result  = DB::select($refill_sql);

           $data = [
            'refill_result' => $refill_result,
            ];
        return view('report.shop-visit.index', $data);
    }
}
