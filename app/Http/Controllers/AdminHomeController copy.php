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
                    and status = 1 
                 order by
                    sold_mark_date_time desc limit 1
              )
              as last_sales_update_date ,
            
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
        )
        shop_report 
     order by
        total_unsold, entry_date asc";

        $sales_update = DB::select(DB::raw($sales_update_sql));
        $data = [
            "sales_update" => $sales_update,
            "sl"           => 1,
        ];

      

        return view('home', $data); 
    }

    public function index2(){
      return view('home2');
   }

}
