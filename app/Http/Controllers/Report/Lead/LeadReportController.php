<?php

namespace App\Http\Controllers\Report\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class LeadReportController extends Controller
{
    public function index()
    {
       $users = DB::table('users')->orderBy('name', 'asc')->groupBy('id')->get();
       $works_type = DB::table('work_type')->orderBy('work_name', 'asc')->get();
       $data = [
            'users' => $users,
            'works_type' => $works_type
       ];

       return view('report.lead-report.index', $data);
    }

    public function summary(Request $request)
    {
        $status  = $request->status;

        if($status  != ''){
             $status_sql_m = "and l.status = $status";
             $status_sql2_s = "and le.status = $status";
        }else{
            $status_sql_m = "";
            $status_sql2_s = "";
        }
        

        

        if($request->lead_id ==0){
            $users= DB::table('users')->select(['name', 'id'])->where('is_officer', 1)->orderBy('name', 'asc')->get();
            $lead_user_sql = '';
        }else{
            $users= DB::table('users')->select(['name', 'id'])->where('is_officer', 1)->where('id', $request->lead_id)->first();
            $lead_user_sql = 'and l.lead_id= '.$users->id;
        }


        if($request->work_type == 0){
            $work_type = DB::table('work_type')->select(['work_name', 'id'])->orderBy('work_name', 'asc')->get();
            $work_type_sql = '';
        }else{
            $work_type = DB::table('work_type')->select(['work_name', 'id'])->where('id',  $request->work_type)->first();
            $work_type_sql = 'and work_type= '.$work_type->id;
        }
      
        $start_dt = date('Y-m-d', strtotime($request->start_dt));
        $end_dt = date('Y-m-d', strtotime($request->end_dt));

           $sql = "SELECT * from (select u.name as lead_user_name, l.lead_id, l.status,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =1 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as new_shop_select,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =2 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as rack_delivery,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =3 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as sales_update,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =4 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as refill,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =5 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as product_return,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =6 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as rack_return,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =7 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as bill_collection,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =8 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as rack_change,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =9 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql  group by le.work_type ) as lead_visit,
                (select count(le.work_type) total_work from leads le where le.lead_id=l.lead_id  and le.work_type =10 and le.lead_date between '$start_dt' and '$end_dt' $status_sql2_s $work_type_sql group by le.work_type ) as app_delivery
                from leads l 
                left join users u  on u.id = l.lead_id
                where l.lead_date between '$start_dt' and '$end_dt' $status_sql_m  $lead_user_sql $work_type_sql 
                group by l.lead_id order by l.id desc) m";

       

        $leads_info = DB::select($sql);

       

       $works_type = DB::table('work_type')->orderBy('id', 'asc')->get();
        $data = [
            'works_type' => $works_type,
            'users' => $users,
            'leads_info' => $leads_info,
            'start_dt' => $start_dt,
            'end_dt' => $end_dt,
            'rqst_work_type'=> $request->work_type,
            'status' => $status
        ];
       return view('report.lead-report.summary', $data);
    }


    public function details(Request $request)
    {
       $lead_id =  $request->lead_id;
       $start_dt =  $request->start_dt;
       $end_dt =  $request->end_dt;
       $work_type =  $request->rqst_work_type;
       $status = $request->status;

         if($status !=''){
            $status_sql = " l.status= $status"; 
        }else{
            $status_sql = " l.id  <> '' "; 
        }


       if($work_type == 0){
        
        $details = DB::table('leads as l')
        ->select(['l.*', 'wa.area_name', 'wt.work_name', 's.name as shop_name', 'rc.name as rach_change_type', 's.area'])
        ->leftJoin('work_area as wa', 'l.work_area', 'wa.id')
        ->leftJoin('work_type as wt', 'l.work_type', 'wt.id')
        ->leftJoin('shops as s', 'l.shop_id', 's.id')
        ->leftJoin('rack_change as rc', 'l.rack_change_id', 'rc.id')
        ->where('l.lead_id', $lead_id)->whereBetween('l.lead_date', [$start_dt, $end_dt])
        ->whereRaw($status_sql)
        ->orderBy('l.work_type', 'asc')
        ->get();


       }else{

        $details = DB::table('leads as l')
        ->select(['l.*', 'wa.area_name', 'wt.work_name', 's.name as shop_name', 'rc.name as rach_change_type', 's.area'])
        ->leftJoin('work_area as wa', 'l.work_area', 'wa.id')
        ->leftJoin('work_type as wt', 'l.work_type', 'wt.id')
        ->leftJoin('shops as s', 'l.shop_id', 's.id')
        ->leftJoin('rack_change as rc', 'l.rack_change_id', 'rc.id')
        ->where('l.lead_id', $lead_id)->whereBetween('l.lead_date', [$start_dt, $end_dt])
        ->where('l.work_type', $work_type)
        ->whereRaw($status_sql)
        ->orderBy('l.work_type', 'asc')
        ->get();

       }
       
      
       

      

       

       $lead_user_info = DB::table('users')->where('id', $lead_id)->first();

       $works_type = DB::table('leads as l')
                    ->select(['wt.work_name', 'wt.id'])
                    ->leftJoin('work_type as wt', 'l.work_type', 'wt.id')
                    ->where('l.lead_id', $lead_id)->whereBetween('l.lead_date', [$start_dt, $end_dt])
                    ->orderBy('l.work_type', 'asc')
                    ->groupBy('l.work_type')
                    ->get();

       $data =[
            'start_dt' => $start_dt,
            'end_dt' => $end_dt,
            'details' => $details,
            'lead_user' => $lead_user_info->name,
            'works_type' => $works_type
       ];


       return view('report.lead-report.details', $data);

      
    }


}
