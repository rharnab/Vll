<?php

namespace App\Http\Controllers\Api\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    /**
     * Shopkeeper Profile
	 * @group Shopkeeper
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * @response {
	 * 		"status": 200,
	 *		"success": true,
	 *		"message": "Shopkeeper info fetching successfully",
	 *		"data": {
	 *			"shop_name": "Perfect Footwear Collection",
	 *			"shop_image_url": "http://venturelifestylelimited.com/uploads/shop_images/67.jpeg",
	 *			"total_amount": "410.00",
	 *			"total_shop_commission": "80.00",
	 *			"total_sold": "5.00"
	 *		}
	 *	}
     */	
    public function shopkeeperProfile(){
		$shop_id =  Auth::user()->shop_id;
		$sql = "select 
					name,
					image			
					from shops where id = '$shop_id'";
		$shop_info = DB::select(DB::raw($sql));
		
		$transaction_sql = "select  sum(selling_price) as total_amount, sum(shop_commission) as total_shop_comission, count(id) as total_sold from rack_products rp where shop_id = '$shop_id' and status = 1";
		$transaction_info = DB::select(DB::raw($transaction_sql));

		$shop_image = "http://venturelifestylelimited.com/uploads/shop_images/".$shop_info[0]->image;
		if(!file_exists($shop_image)){
		  $shop_image = "https://scontent.fdac45-1.fna.fbcdn.net/v/t39.30808-6/264156003_110554554799532_2287020694308712341_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=22K0joGOWxIAX8khC5t&_nc_ht=scontent.fdac45-1.fna&oh=00_AT-wosapc2y4GDEPgkYIx67AyHxipkdspc7fekL6ex2JzQ&oe=62591D22";
		}


		$data = [
			"status"  => 200,
			"success" => true,
			"message" => "Shopkeeper info fetching successfully",
			"data"    => [
				"shop_name"             => $shop_info[0]->name,
				"shop_image_url"        => $shop_image,
				"total_amount"          => number_format($transaction_info[0]->total_amount,2),
				"total_shop_commission" => number_format($transaction_info[0]->total_shop_comission,2),
				"total_sold"            => number_format($transaction_info[0]->total_sold,2)
			]
		];
		return response()->json($data);
	}
}
