<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnbordingScreenController extends Controller
{
    /**
     * App Instruction
     * 
     * @response {
    *    "status": 200,
    *    "success": true,
    *    "message": "Onboarding content fetching success",
    *    "data": [
    *        {
    *            "id": 1,
    *            "image": "https://png.pngtree.com/png-clipart/20190705/original/pngtree-cartoon-characters-in-swimsuits-on-mobile-screen-png-image_4280509.jpg",
    *            "title": "Best Digital Solution",
    *            "subtitle": "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    *        },
    *        {
    *            "id": 2,
    *            "image": "https://png.pngtree.com/png-clipart/20190705/original/pngtree-cartoon-characters-in-swimsuits-on-mobile-screen-png-image_4280509.jpg",
    *            "title": "Best Digital Solution",
    *            "subtitle": "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    *        },
    *        {
    *            "id": 3,
    *            "image": "https://png.pngtree.com/png-clipart/20190705/original/pngtree-cartoon-characters-in-swimsuits-on-mobile-screen-png-image_4280509.jpg",
    *            "title": "Best Digital Solution",
    *            "subtitle": "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    *        }
    *    ]
    *}
     */
    public function onboarding(){
        $data = [
            "status" => 200,
            "success" => true,
            "message"=> "Onboarding content fetching success",
            "data" => [
                [
                    "id" => 1,
                    "image" => "https://rabiul.xyz/vll-api/public/images/1.png",
                    "title" => "Qr Scan",
                    "subtitle" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                ],
                [
                    "id" => 2,
                    "image" => "https://rabiul.xyz/vll-api/public/images/2.png",
                    "title" => "Best Digital Solution",
                    "subtitle" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                ],
                [
                    "id" => 3,
                    "image" => "https://rabiul.xyz/vll-api/public/images/3.png",
                    "title" => "Best Digital Solution",
                    "subtitle" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                ]
            ]
        ];
        return response()->json($data);

    }
}
