<?php

use App\Http\Controllers\Api\Authentication\AuthController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Category\CategoryListController;
use App\Http\Controllers\Api\OnbordingScreenController;
use App\Http\Controllers\Api\Product\CheckQrIsProductController;
use App\Http\Controllers\Api\Product\ProductSellController;
use App\Http\Controllers\Api\Product\SingleProductDetailsController;
use App\Http\Controllers\Api\Product\WrongProductUnsoldController;
use App\Http\Controllers\Api\Shopkeeper\ProfileController;
use App\Http\Controllers\Api\Shopkeeper\SingleCategoryUnsoldProductSummary;
use App\Http\Controllers\Api\Shopkeeper\SoldInformationController;
use App\Http\Controllers\Api\Shopkeeper\SoldProductListController;
use App\Http\Controllers\Api\Shopkeeper\SoldProductSearchController;
use App\Http\Controllers\Api\Shopkeeper\TypewiseProductSearchController;
use App\Http\Controllers\Api\Shopkeeper\TypeWiseRackUnsoldSocksListController;
use App\Http\Controllers\Api\Shopkeeper\UnsoldProductListController;
use App\Http\Controllers\Api\Shopkeeper\UnsoldProductSearchController;
use App\Http\Controllers\Api\ShopLocationsController;
use App\Http\Controllers\Api\Voucher\ProductBillVoucherController;
use App\Http\Controllers\Api\Voucher\ProductRefillVoucher;
use App\Http\Controllers\Api\Voucher\ShopActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function(){

    ##################################################################
    # Authentication Related API
    #################################################################
    Route::post('tokens', [AuthController::class, 'tokenGenerate']);
    Route::post('logout', [LogoutController::class, 'logout'])->middleware('jwt.verify');


    ##################################################################
    # Product Category List Controller
    #################################################################
    Route::get('category/index', [CategoryListController::class, 'index'])->middleware('jwt.verify');

    ##################################################################
    # Shopkeeper Related API
    #################################################################
    Route:: get('shopkeeper/profile', [ProfileController::class, 'shopkeeperProfile'])->middleware('jwt.verify');
    Route:: post('shopkeeper/category/product-sold-summary', [SoldInformationController::class, 'soldInformation'])->middleware('jwt.verify');
    Route:: post('shopkeeper/category/rack-unsold-product-summary', [SingleCategoryUnsoldProductSummary::class, 'rackUnsoldSocksSummary'])->middleware('jwt.verify');
    Route:: post('shopkeeper/category/typewise-rack-unsold-product', [TypeWiseRackUnsoldSocksListController::class, 'singleTypeRackUnsoldSocks'])->middleware('jwt.verify');
    Route:: post('shopkeeper/category/typewise-search-rack-unsold-product', [TypewiseProductSearchController::class, 'singleTypeWiseSearchRackUnsoldSocks'])->middleware('jwt.verify');
    Route:: post('shopkeeper/rack-current-unsold-products', [UnsoldProductListController::class, 'rackCurrentUnsolSocks'])->middleware('jwt.verify');
    Route:: post('shopkeeper/unsold/search-product', [UnsoldProductSearchController::class, 'searchUnsoldSocks'])->middleware('jwt.verify');
    Route:: get('shopkeeper/all-sold-product-list', [SoldProductListController::class, 'allSoldProductList'])->middleware('jwt.verify');
    Route:: post('shopkeeper/sold-product/search-product', [SoldProductSearchController::class, 'searchProduct'])->middleware('jwt.verify');
    Route:: get('shopkeeper/product/product-details/{product_id}', [SingleProductDetailsController::class, 'singleProductDetails'])->middleware('jwt.verify');
    Route:: post('shopkeeper/product/product-sell', [ProductSellController::class, 'productSold'])->middleware('jwt.verify');
    Route:: post('shopkeeper/wrong-sold/product-unsold', [WrongProductUnsoldController::class, 'wrongSoldProductUnsold'])->middleware('jwt.verify');
    Route:: post('product/check-valid-product-qr', [CheckQrIsProductController::class, 'checkValidProductQr'])->middleware('jwt.verify');

    ##################################################################
    # Shopkeeper Voucher
    #################################################################
    Route:: get('shopkeeper/product/refill-voucher', [ProductRefillVoucher::class, 'refillVoucher'])->middleware('jwt.verify');
    Route:: get('shopkeeper/product/bill-voucher', [ProductBillVoucherController::class, 'billVoucher'])->middleware('jwt.verify');
    Route:: get('shopkeeper/activity', [ShopActivityController::class, 'activityLog'])->middleware('jwt.verify');
   

    ##################################################################
    # Shop Location & Onboarding Screen 
    #################################################################
    Route:: get('shop-locations', [ShopLocationsController::class, 'shopLocation']);
    Route:: get('onboarding', [OnbordingScreenController::class, 'onboarding']);


});