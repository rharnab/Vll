<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomMessageController extends Controller
{
    public function messageSend(Request $request){
        $message = $request->input('message');
        $insert = DB::table('shopkeeper_message')->insert([
            "shop_id"        => Auth::user()->shop_id,
            "message"        => $message,
            "entry_user_id"  => Auth::user()->id,
            "entry_datetime" => date('Y-m-d H:i:s')
        ]);

        if($insert){
            $data = [
                "status" => 200,
                "message" => "Message sent successfully"
            ];
            return response()->json($data);
        }else{
            $data = [
                "status" => 400,
                "message" => "Message sent failed"
            ];
            return response()->json($data);
        }
    }
}
