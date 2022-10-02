<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckQrIsProductController extends Controller
{
     /**
     * Check Qr Code
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @bodyParam  qr_code string required . Example: SH217032231
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "Valid product QR code"
	 *	}
     */
    public function checkValidProductQr(Request $request){
		$validator = Validator::make($request->all(), [ 
            'qr_code'      => 'required',
        ]);        
        /**
         * Validation Failed
         */ 
        if($validator->fails()){
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->errors()->first()
            ];
            return response()->json($data);
        }
		$qr_code = $request->input('qr_code');
		$qr_check = DB::table('rack_products')->where('printed_socks_code', $qr_code)->count();
		if($qr_check > 0){
			$data = [
                "status"  => 200,
                "success" => true,
                "message" => "Valid product QR code"
            ];
            return response()->json($data);
		}else{
			$data = [
                "status"  => 400,
                "success" => false,
                "message" => "This ($qr_code) qr code product not found in VLL"
            ];
            return response()->json($data);
		}
	}
}
