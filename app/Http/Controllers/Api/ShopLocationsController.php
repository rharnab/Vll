<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopLocationsController extends Controller
{
    /**
     * Shop Locations
     * 
     * 
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
	 *		"status": 200,
	 *		"success": true,
	 *		"message": "shop feching success",
	 *		"shops": [
	 *			{
	 *				"id": 1,
	 *				"shop_name": "Xplore",
	 *				"remaining_socks": "11 pair",
	 *				"color": "#fd3995",
	 *				"coordinates": {
	 *					"latitude": 23.735778278942618,
	 *					"longitude": 90.41519258564742
	 *				}
	 *			},
	 *			{
	 *				"id": 2,
	 *				"shop_name": "Silver Jeans",
	 *				"remaining_socks": "15 pair",
	 *				"color": "#25aae2",
	 *				"coordinates": {
	 *					"latitude": 23.73372299868151,
	 *					"longitude": 90.41854974235783
	 *				}
	 *			}
	 *		]
	 *	}
    */
    public function shopLocation(){
        $shops = [
            [
                "id" => 1,
                "shop_name" => "Xplore",
                "remaining_socks"=> '11 pair',
                "color"=> '#fd3995',
                "coordinates" => [
                    "latitude" => 23.735778278942618, 
                    "longitude" => 90.41519258564742,
                ]
            ],
            [
                "id" => 2,
                "shop_name" => "Silver Jeans",
                "remaining_socks" => '15 pair',
                "color"=> '#25aae2',
                "coordinates" => [
                    "latitude" => 23.73372299868151, 
                    "longitude"=> 90.41854974235783, 
                ]
            ]
        ];


        $data = [
            "status" => 200,
            "success" => true,
            "message" => "shop feching success",
            "shops" => $shops
        ];
        return response()->json($data);
    }
}
