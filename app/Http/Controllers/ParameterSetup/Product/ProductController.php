<?php

namespace App\Http\Controllers\ParameterSetup\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){

       $get_data = DB::select(DB::raw("SELECT p.id, b.name as brand_name,bs.name as brand_size_name, types.types_name, p.packet_socks_pair_quantity, p.packet_buying_price,p.packet_selling_price, p.individual_buying_price,p.individual_selling_price, p.entry_date, p.entry_time, p.sale_type   FROM `products` p left join brands b on p.brand_id=b.id left join brand_sizes bs on p.brand_size_id=bs.id left join types on p.type_id=types.id order by p.id desc"));

       return view('parameter-setup.product.index', compact('get_data'));   
       
    }

    public function create(){

            $brands =  DB::table('brands')->get();
            $brand_sizes =  DB::table('brand_sizes')->get();
            $types =  DB::table('types')->get();
            $company = DB::table('company')->get();
            $category = DB::table('category')->get();

            return view('parameter-setup.product.create', compact('brands','brand_sizes','types', 'company', 'category'));

    }   


    public function store(Request $request){
        $brand = $request->brand;
        $brand_sizes = $request->brand_sizes;
        $type = $request->type;
        $packet_socks_pair_quantity = $request->packet_socks_pair_quantity;

        $com_id = $request->com_id;
        $cat_id = $request->cat_id;
        

        $packet_buying_price = $request->packet_buying_price;
        $packet_selling_price = $request->packet_selling_price;
        $ind_buying_price = $request->ind_buying_price;
        $ind_selling_price = $request->ind_selling_price;
        $select_type = $request->select_type;
        
        $com_id = $request->com_id;
        $cat_id = $request->cat_id;

        $get_data_count = DB::table('products')->where('brand_id',$brand)
        ->where('brand_size_id', $brand_sizes)
        ->where('type_id', $type)
        ->where('packet_socks_pair_quantity', $packet_socks_pair_quantity)
        ->where('packet_buying_price', $packet_buying_price)
        ->where('individual_buying_price', $ind_buying_price)
        ->where('packet_selling_price', $packet_selling_price)
        ->where('individual_selling_price', $ind_selling_price)->count();

        if($get_data_count>0){
            return redirect('parameter-setup/product/index')->with('warning_msg', ' This Data Already Exist ! ');
        }

        DB::table('products')->insert([
            "brand_id"=>$brand,
            "brand_size_id"=>$brand_sizes,
            "type_id"=>$type,
            "packet_socks_pair_quantity"=>$packet_socks_pair_quantity,
            "packet_buying_price"=>$packet_buying_price,
            "packet_selling_price"=>$packet_selling_price,
            "individual_buying_price"=>$ind_buying_price,
            "individual_selling_price"=>$ind_selling_price,
            "entry_user_id"=>Auth::user()->id,
            "entry_date"=>date('Y-m-d'),
            "entry_time"=>date('h:i:s a'),
            "sale_type"=>$select_type,
            "cat_id"=>$cat_id,
            "com_id"=>$com_id
        ]);


        return redirect('parameter-setup/product/index')->with('message',"Data Inserted Successfully");


    }

    public function edit(Request $request){

        $brands =  DB::table('brands')->get();
        $brand_sizes =  DB::table('brand_sizes')->get();
        $types =  DB::table('types')->get();


        $id = $request->id;
        $get_data = DB::table('products')->where('id', $id)->first();

        return view('parameter-setup.product.edit', compact('get_data','brands','brand_sizes','types'));
        
    }

    public function update(Request $request){
        $id = $request->hidden_id;


        $brand = $request->brand;
        $brand_sizes = $request->brand_sizes;
        $type = $request->type;
        $packet_socks_pair_quantity = $request->packet_socks_pair_quantity;

        $packet_buying_price = $request->packet_buying_price;
        $packet_selling_price = $request->packet_selling_price;
        $ind_buying_price = $request->ind_buying_price;
        $ind_selling_price = $request->ind_selling_price;
        $select_type = $request->select_type;

        $get_data_count = DB::table('products')->where('brand_id',$brand)
        ->where('brand_size_id', $brand_sizes)
        ->where('type_id', $type)
        ->where('packet_socks_pair_quantity', $packet_socks_pair_quantity)
        ->where('packet_buying_price', $packet_buying_price)
        ->where('individual_buying_price', $ind_buying_price)
        ->where('packet_selling_price', $packet_selling_price)
        ->where('individual_selling_price', $ind_selling_price)->count();

        if($get_data_count>0){
            return redirect('parameter-setup/product/index')->with('warning_msg', ' This Data Already Exist ! ');
        }

        DB::table('products')->where('id', $id)->update([
            "brand_id"=>$brand,
            "brand_size_id"=>$brand_sizes,
            "type_id"=>$type,
            "packet_socks_pair_quantity"=>$packet_socks_pair_quantity,
            "packet_buying_price"=>$packet_buying_price,
            "individual_buying_price"=>$ind_buying_price,
            "packet_selling_price"=>$packet_selling_price,
            "individual_selling_price"=>$ind_selling_price,
            "sale_type"=>$select_type,
        ]);

        return redirect('parameter-setup/product/index')->with('message',"Data Updated Successfully");        

    }
}
