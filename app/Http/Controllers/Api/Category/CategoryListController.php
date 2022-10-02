<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryListController extends Controller
{
    /**
     * Category List
     * 
     * @group Product Category
     * 
     * 
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * @response {
     *    "status": 200,
     *    "success": true,
     *    "message": "Category fetching successfully",
     *    "data": {
     *        "categories": [
     *            {
     *                "id": 1,
     *                "name": "Socks",
     *                "icon_image_url": null
     *            },
     *            {
     *                "id": 1000,
     *                "name": "Wrong Sell",
     *                "icon_image_url": "https://www.onlygfx.com/wp-content/uploads/2018/04/wrong-stamp-1.png"
     *            }
     *        ]
     *    }
     *}
     */
    public function index(){
      $categories = DB::table('category')->select(['id', 'name', 'icon_image_url'])->get();
      
      $category_array = [];
      
      foreach($categories as $category){
        $res = [
          "id"             => $category->id,
          "name"           => $category->name,
          "icon_image_url" => $category->icon_image_url,
        ];
        array_push($category_array, $res);	
      }
      
      $wrong_sold = [
        "id" => 1000,
        "name" => "Wrong Sell",
        "icon_image_url" => "https://www.onlygfx.com/wp-content/uploads/2018/04/wrong-stamp-1.png",
      ];
      array_push($category_array, $wrong_sold);	
      
      $data = [
        "status" => 200,
        "success" => true,
        "message" => "Category fetching successfully",
        "data" => [
          "categories" => $category_array
        ]
      ];
      return response()->json($data);
	}
}
