<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        $leades = DB::table('leads as l')
        ->select(['l.*', 'wa.area_name', 'wt.work_name', 's.name as shop_name', 'rc.name as rach_change_type', 's.area', 'u.name'])
        ->leftJoin('work_area as wa', 'l.work_area', 'wa.id')
        ->leftJoin('work_type as wt', 'l.work_type', 'wt.id')
        ->leftJoin('shops as s', 'l.shop_id', 's.id')
        ->leftJoin('rack_change as rc', 'l.rack_change_id', 'rc.id')
        ->leftJoin('users as u', 'u.id', 'l.lead_id')
        ->where('l.status', 0)
        ->orderBy('l.id', 'desc')
        ->get();

        return view('lead.index', compact('leades'));
    }

    public function create()
    {

        $officers = DB::table('users')->where('is_officer', 1)->orderBy('name', 'asc')->get();
        $works_type  = DB::table('work_type')->where('status', 1)->orderBy('work_name', 'asc')->get();
        $works_area  = DB::table('work_area')->where('status', 1)->orderBy('area_name', 'asc')->get();

        $data = [
            'officers' => $officers,
            'works_type' => $works_type,
            'works_area' => $works_area,
        ];

        return view('lead.create', $data);
    }

    public function getHtmlForm(Request $request)
    {
        $type_id =  $request->id;

        if ($type_id == 1) {
            $area_list = DB::table('area_list')->orderBy('area', 'asc')->get();
            $output =  view('lead.html-view.shop_register', compact('area_list'));
        } else if ($type_id == 7) {
            $all_due_shop = DB::table('rack_products as rp')
                ->select('s.name as shop_name', 'rp.rack_code', 'rp.shop_id')
                ->leftJoin('shops as s', 's.id', '=', 'rp.shop_id')
                ->where([
                    // ['rp.agent_id', '=', $agent_id],
                    ['rp.status', '=', '1']
                ])->groupBy('rp.rack_code')->get();

            $output =  view('lead.html-view.bill_collection', compact('all_due_shop'));
        } else if ($type_id == 8) {

            $rack_trafer_list = DB::table('rack_change')->where('status', 1)->get();
            $output =  view('lead.html-view.rack_change', compact('rack_trafer_list'));
        } else {
            $output = '';
        }

        return $output;
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'work_area' => 'required',
            'work_type' => 'required',
            'lead_date' => 'required',
            'remarks' => 'required',
        ]);



        $entry_id = Auth::user()->id;
        $timeStamp = date('Y-m-d H:i:s');
        $work_area = $request->input('work_area');
        $work_type = $request->input('work_type');
        $lead_date = date('Y-m-d', strtotime($request->input('lead_date')));
        $remarks = $request->input('remarks');

        /* bill collection data */
        $rack_code = $request->input('rack_code');
        $due_amount = $request->input('due_amount');
        $full_amount = $request->input('full_amount');
        $partial_amount = $request->input('partial_amount');
        $is_full = $request->input('is_full');
        $payment_mode = $request->input('payemnt_mode');
        $shop_id = $request->input('shop_id');

        /* Rack Change data */
        $rack_change_id = $request->input('rack_change_id');

        /* new shop data */
        $shops_name = $request->input('shops_name');
        $area = $request->input('area');
        $shops_address = $request->input('shops_address');
        $owner_name = $request->input('owner_name');
        $owner_name = $request->input('owner_name');
        $owner_contact_no = $request->input('owner_contact_no');
        $rack_type = $request->input('rack_type');


        if($request->work_type == 1){

            try{

                 $shop_id = DB::table('shops')->insertGetId([
                    'name' => $shops_name,
                    'area' => $area,
                    'shop_address' => $shops_address,
                    'owner_name' => $owner_name,
                    'owner_contact' => $owner_contact_no,
                    'rack_type' => $rack_type
    
                ]);

            }Catch(Exception $e){

                $data  = [
                    'status' => 400,
                    'is_error' => true,
                    'message' => $e->getMessage()
    
                ];
                return response()->json($data);

            }

        }


        try {

            DB::table('leads')->insert([
                'lead_id' => $entry_id,
                'work_area' => $work_area,
                'work_type' => $work_type,
                'rack_change_id' => $rack_change_id,
                'due_rack_code' => $rack_code,
                'due_amount' => $due_amount,
                'full_amount' => $full_amount,
                'partial_amount' => $partial_amount,
                'payment_mode' => $payment_mode,
                'lead_date' => $lead_date,
                'remarks' => $remarks,
                'entry_id' => $entry_id,
                'entry_date' => $timeStamp,
                'status' => 0,
                'shop_id' => $shop_id
            ]);

            $data  = [
                'status' => 200,
                'is_error' => true,
                'message' => "Lead store success"

            ];
            return response()->json($data);

        } catch (Exception $e) {

            $data  = [
                'status' => 400,
                'is_error' => true,
                'message' => $e->getMessage()

            ];
            return response()->json($data);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;

        try{
            DB::table('leads')->where('id', $id)->update([
                'status' => 1
            ]);

            $data = [
                'status' => 200,
                'iss_error'=> false,
                'message' => "Task has been completed"

            ];
            return response()->json($data);

        }Catch(Exception $e){

            $data = [
                'status' => 400,
                'iss_error'=> true,
                'message' => $e->getMessage()

            ];
            return response()->json($data);

        }


      

    }





}
