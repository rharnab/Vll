<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Agent\AgentHomeController;
use App\Http\Controllers\Agent\AgentRackController;
use App\Http\Controllers\Agent\AgentRackShocksBillCollectController;
use App\Http\Controllers\Agent\Rack\ProductStatusChangeController;
use App\Http\Controllers\Agent\Rack\RackBillCollectionController;
use App\Http\Controllers\Agent\Rack\RackBillVoucherController;
use App\Http\Controllers\Agent\SoldDelete\RackWrongSoldItemDeteController;
use App\Http\Controllers\Bill\RackBilCollectionlVoucherController;
use App\Http\Controllers\DirectSale\DirectProductSalesController;
use App\Http\Controllers\DirectSale\DirectSaleAuthDeclineController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ParameterSetup\Agent\AgentController;
use App\Http\Controllers\Rack\RackFillupController;
use App\Http\Controllers\ParameterSetup\Brand\BrandController;
use App\Http\Controllers\ParameterSetup\BrandSize\BrandSizeController;
use App\Http\Controllers\ParameterSetup\Racks\RacksController;
use App\Http\Controllers\ParameterSetup\Shops\ShopsController;
use App\Http\Controllers\ParameterSetup\Types\TypesController;
use App\Http\Controllers\ParameterSetup\Product\ProductController;
use App\Http\Controllers\ParameterSetup\ProductCategories\ProductCategoriesController;
use App\Http\Controllers\ParameterSetup\User\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Report\LotSummaryController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DirectSale\DirectSaleReportController;
use App\Http\Controllers\Accounts\Report\GlTransactionsReportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\stock\StockController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Report\ProductReport;
use App\Http\Controllers\Rack\RackMappingController;
use App\Http\Controllers\Rack\RackProductDeleteController;
use App\Http\Controllers\Shopkeeper\DashboardController;
use App\Http\Controllers\Shopkeeper\ShopkeeperSingleRackController;
use App\Http\Controllers\Report\PacketCodeController;

use App\Http\Controllers\Finance\Rack\FinaceRackBillCollectionController;
use App\Http\Controllers\Shopkeeper\CustomMessageController;
use App\Http\Controllers\Shopkeeper\SearchRackSocksController;
use App\Http\Controllers\Voucher\ShopRackBillCollectionVoucherController;
use App\Http\Controllers\Report\StockSumarryController;
use App\Http\Controllers\ParameterSetup\commission\CommissionSetUpController;
use App\Http\Controllers\Report\CommissionReport;
use App\Http\Controllers\Report\BillDueController;

use App\Http\Controllers\AccountManager\AccountManagerController;
use App\Http\Controllers\Accounts\GlTransactionController;
use App\Http\Controllers\Accounts\Report\GlBalanceReportController;
use App\Http\Controllers\Report\RackFillUpReport;
use App\Http\Controllers\Report\RackProductDetailsReport;
use App\Http\Controllers\Accounts\TransactionController;
use App\Http\Controllers\Accounts\Report\TransferReport;
use App\Http\Controllers\Rack\SocksQrCodeGenerateController;
use App\Http\Controllers\Report\ShopVoucherReport;
use App\Http\Controllers\BillCOllection\BillCollectionController;

use App\Http\Controllers\BillAuthorize\BillAuthorizeController;
use App\Http\Controllers\dashboard\MasterDashboardController;


use App\Http\Controllers\All_Agent\AllAgentController;
use App\Http\Controllers\BillPaymentAuthorize\BillPaymentAuthorizeController;
use App\Http\Controllers\Report\ShopVisitController;
use App\Http\Controllers\Report\StatusWiseReportController;
use App\Http\Controllers\Report\CashReport\LotReportController;
use App\Http\Controllers\Report\AgentReport\AgentShopTagReportContoller;
use App\Http\Controllers\Rack\RackTransferController;
use App\Http\Controllers\Report\CashReport\BillReportController;
use  App\Http\Controllers\stock\TshirtStockController;
use App\Http\Controllers\Report\StockProductSummationController;
use App\Http\Controllers\Report\Rack\RackProductReport;
use App\Http\Controllers\Report\AgentReport\AgentCommissionReportController;
use App\Http\Controllers\Report\SocksReturnReport\SocksReturnReportController;
use App\Http\Controllers\Report\StatusWiseSummationController;
use App\Http\Controllers\Report\UserWiseSummationController;
use App\Http\Controllers\AgentBillVoucherController;
use App\Http\Controllers\ParameterSetup\Company\CompanyController; 
use App\Http\Controllers\ParameterSetup\Category\CategoryController; 
use App\Http\Controllers\DirectSale\DirectSaleBillCollectionController; 

use App\Http\Controllers\Corporate\OrderCreateController;
use App\Http\Controllers\DashboardReport\DashboardReportController;
use App\Http\Controllers\Corporate\CorporateBillController;
use App\Http\Controllers\Report\DashboardOverViewController;
use App\Http\Controllers\Report\UserWiseActivityReportController;
use App\Http\Controllers\Report\AreaWiseReportController;
use App\Http\Controllers\Report\AverageReportController;
use App\Http\Controllers\salary\EmployeeSalaryController;
use App\Http\Controllers\Bill_Return\BillReturnController;
use App\Http\Controllers\Report\ShopDueBillReportController;


use App\Http\Controllers\salary\UpdateEmployeeSalaryController;
use App\Http\Controllers\Report\SalaryDisburseReportController;
use App\Http\Controllers\ParameterSetup\Employee\EmployeeSetupController;
use App\Http\Controllers\Lead\LeadController;
use App\Http\Controllers\Report\Lead\LeadReportController;
use App\Http\Controllers\Report\PartialReportController;

use App\Http\Controllers\BillPaymentAuthorize\PartialPaymentVoucherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





################################# website ################################


Route::get('/db-backup', function () {

    // Database configuration
    $host = "localhost";
    $username = "pegasus_socks";
    $password = "pegasus_socks";
    $database_name = "pegasus_socks";

    // Get connection object and set the charset
    $conn = mysqli_connect($host, $username, $password, $database_name);
    $conn->set_charset("utf8");


    // Get All Table Names From the Database
    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $sqlScript = "";
    foreach ($tables as $table) {
        
        // Prepare SQLscript for creating table structure
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
        
        
        $query = "SELECT * FROM $table";
        $result = mysqli_query($conn, $query);
        
        $columnCount = mysqli_num_fields($result);
        
        // Prepare SQLscript for dumping data for each table
        for ($i = 0; $i < $columnCount; $i ++) {
            while ($row = mysqli_fetch_row($result)) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $columnCount; $j ++) {
                    $row[$j] = $row[$j];
                    
                    if (isset($row[$j])) {
                        $sqlScript .= '"' . $row[$j] . '"';
                    } else {
                        $sqlScript .= '""';
                    }
                    if ($j < ($columnCount - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
        }
        
        $sqlScript .= "\n"; 
    }

    if(!empty($sqlScript))
    {
        // Save the SQL script to a backup file
        $backup_file_name = $database_name . '_backup_' . time() . '.sql';
        $fileHandler = fopen($backup_file_name, 'w+');
        $number_of_lines = fwrite($fileHandler, $sqlScript);
        fclose($fileHandler); 

        // Download the SQL backup file to the browser
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backup_file_name));
        ob_clean();
        flush();
        readfile($backup_file_name);
        exec('rm ' . $backup_file_name); 
    }
});

Route::get('/', function () {
   //return view('landing.index');
   return redirect()->route('home');
});


Route::get('/contact', function () {
   return view('landing.contact');
});

Route::get('/condition', function () {
   return view('landing.condition');
});


Route::get('/gallary', function () {
   return view('landing.gallary');
});

################################ end website #############################



Route::get('/generateRackShocksVoucher',[AgentRackShocksBillCollectController::class,'generateRackShocksVoucher']);



Route::get('/login', function () {
   return redirect()->route('home');
});

######################################################## password change ######################################
Route::get('/password-change', [App\Http\Controllers\HomeController::class, 'password_change'])->name('password.change');
Route::post('/password-save', [App\Http\Controllers\HomeController::class, 'password_change_save'])->name('password.change.save');

Route::get('/user-profile', [App\Http\Controllers\HomeController::class, 'user_profile'])->name('user.profile');
######################################################## password change ######################################

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/monthly-due-bill', [App\Http\Controllers\HomeController::class, 'monthly_due_bill'])->name('monthly_due_bill');



Route::get('/contact-us', function(){

    return view('contact');
});


Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('language');


Route::get('admin/home',[AdminHomeController::class, 'index'])->name('admin.home');
Route::get('admin/home2',[AdminHomeController::class, 'index2'])->name('admin.home2');



#################################################
# Agent  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/agent', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Agent', 'as' => 'parameter_setup.agent.'], function(){

    Route:: get('index', [AgentController::class, 'index'])->name('index');
    Route:: get('edit-agent/{id}', [AgentController::class, 'edit_agent_url'])->name('edit_agent_url');
   
    Route:: get('create', [AgentController::class, 'create'])->name('create');
    Route:: post('store', [AgentController::class, 'store'])->name('store');
    Route:: get('edit/{id}', [AgentController::class, 'edit'])->name('edit');
    Route:: post('update', [AgentController::class, 'update'])->name('update');
   
});

#################################################
#  Agent End 
#################################################




#################################################
# Brand  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/brand', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Brand', 'as' => 'parameter_setup.brand.'], function(){

    Route::get('index', [BrandController::class, 'index'])->name('index');
    Route::get('create', [BrandController::class, 'create'])->name('create');
    Route::post('store', [BrandController::class, 'store'])->name('store');
    Route::get('edit-brand/{id}', [BrandController::class, 'edit'])->name('edit');
    Route::post('update', [BrandController::class, 'update'])->name('update');
   
});

#################################################
#  Brand End 
#################################################

#################################################
# Agent Home Section Start
#################################################
Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'middleware' => 'auth', 'as' => 'agent.rack.'], function(){
    Route::get('details/{rackcode}', [AgentRackController::class, 'rackDetails'])->name('details');
    Route::post('calculate-shocks-bill', [AgentRackController::class, 'calculateShocksBill'])->name('calculate_shocks_bill');
    Route::post('rack/socks/bill-collection', [AgentRackShocksBillCollectController::class, 'billCollect'])->name('socks.bill_collect');
});
#################################################
# Agent Home Section End
#################################################


#################################################
# Agent Rack Section Start
#################################################
Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'middleware' => 'auth', 'as' => 'agent.'], function(){
    Route::get('home', [AgentHomeController::class, 'agentHome'])->name('home');
    Route::get('/shopkeeper/update/{rack_code}', [AgentHomeController::class, 'shop_update'])->name('shopkeeper.update');
    Route::post('shop-update-shocks-bill', [AgentHomeController::class, 'calculateShocksBill'])->name('calculate_shocks_bill');
    Route::post('/update/sales/socks', [AgentHomeController::class, 'billCollect'])->name('update.sales.socks');
});
#################################################
# Agent Rack Section Start
#################################################



#################################################
# All Agent 
#################################################
# All Agent or Super Agent
#################################################
Route::group(['prefix' => 'all-agent', 'namespace' => 'All_Agent', 'middleware' => 'auth', 'as' => 'all_agent.'], function(){
   
    Route::get('all-agent-home', [AllAgentController::class, 'all_agent_home'])->name('all_agent_home');
    Route::post('search_shop', [AllAgentController::class, 'search_shop'])->name('search_shop');
    
   
});
#################################################
# All Agent 
# All Agent or Super Agent
#################################################




################################################
# Brand Size  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/brandsize', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\BrandSize', 'as' => 'parameter_setup.brandsize.'], function(){

    Route::get('index', [BrandSizeController::class, 'index'])->name('index');
    Route::get('create', [BrandSizeController::class, 'create'])->name('create');
    Route::post('store', [BrandSizeController::class, 'store'])->name('store');
    Route::get('edit/{id}', [BrandSizeController::class, 'edit'])->name('edit');
    Route::post('update', [BrandSizeController::class, 'update'])->name('update');
   
});

#################################################
#  Brand End 
#################################################




#################################################
# Racks  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/racks', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Racks', 'as' => 'parameter_setup.racks.'], function(){

    Route::get('index', [RacksController::class, 'index'])->name('index');
    Route::get('create', [RacksController::class, 'create'])->name('create');
    Route::post('store', [RacksController::class, 'store'])->name('store');
    Route::get('edit/{id}', [RacksController::class, 'edit'])->name('edit');
    Route::post('update', [RacksController::class, 'update'])->name('update');
   
});

#################################################
#  Racks End 
#################################################




#################################################
# shops  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/shops', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Shops', 'as' => 'parameter_setup.shops.'], function(){

    Route::get('index', [ShopsController::class, 'index'])->name('index');
    Route::get('create', [ShopsController::class, 'create'])->name('create');
    Route::post('store', [ShopsController::class, 'store'])->name('store');
    Route::get('edit-shop/{id}', [ShopsController::class, 'edit'])->name('edit');
    Route::post('update', [ShopsController::class, 'update'])->name('update');
   
});

#################################################
#  shops End 
#################################################




#################################################
# product categories  Start 
#################################################
Route::group(['prefix' => 'parameter-setup/product_categories', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\ProductCategories', 'as' => 'parameter_setup.product_categories.'], function(){

    Route::get('index', [ProductCategoriesController::class, 'index'])->name('index');
    Route::get('create', [ProductCategoriesController::class, 'create'])->name('create');
    Route::post('store', [ProductCategoriesController::class, 'store'])->name('store');
    Route::get('edit/{id}', [ProductCategoriesController::class, 'edit'])->name('edit');
    Route::post('update', [ProductCategoriesController::class, 'update'])->name('update');
   
});

#################################################
#  product categories End 
#################################################




#################################################
# Types  Start 
#################################################

Route::group(['prefix' => 'parameter-setup/types/', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Types', 'as' => 'parameter_setup.types.'], function(){

    Route::get('index', [TypesController::class, 'index'])->name('index');
    Route::get('create', [TypesController::class, 'create'])->name('create');
    Route::post('store', [TypesController::class, 'store'])->name('store');
    Route::get('edit/{id}', [TypesController::class, 'edit'])->name('edit');
    Route::POST('update', [TypesController::class, 'update'])->name('update');

   
});

#################################################
#  Types  End 
#################################################



#################################################
# Products  Start 
#################################################

Route::group(['prefix' => 'parameter-setup/product/', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\Product', 'as' => 'parameter_setup.products.'], function(){

    Route::get('index', [ProductController::class, 'index'])->name('index');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::POST('update', [ProductController::class, 'update'])->name('update');
   
});

#################################################
#  Products  End 
#################################################



#################################################
# User Entry  Start 
#################################################

Route::group(['prefix' => 'parameter-setup/user/', 'middleware' => 'auth', 'namespace' => 'ParameterSetup\User', 'as' => 'parameter_setup.user.'], function(){

    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');

    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('update', [UserController::class, 'update'])->name('update');

   
});

#################################################
#  User Entry  End 
#################################################



##################################################### stock store ###########################################
Route::group(['prefix'=>'stock', 'as'=>'stock.'], function(){
	Route::get('stock-index', [StockController::class, 'index'])->name('index');
	Route::get('stock-creat', [StockController::class, 'creat'])->name('creat');
	Route::post('stock-creat', [StockController::class, 'store'])->name('store');


    //vailation route

    Route::post('product-check', [StockController::class, 'ProductCheck'])->name('product-check');
    Route::post('type-info', [StockController::class, 'typeCheck'])->name('type-info');
    Route::post('size-info', [StockController::class, 'sizeCheck'])->name('size-info');


    Route::get('lot-voucher', [StockController::class, 'lot_voucher_index'])->name('lot_voucher');
    Route::get('lot-voucher-create', [StockController::class, 'lot_voucher_create'])->name('lot_voucher.create');
    Route::post('lot-voucher-store', [StockController::class, 'lot_voucher_store'])->name('lot_voucher.lot_voucher_store');


});
##################################################### stock store ###########################################


#################################################
# Rack Bill Voucher Section Start
#################################################
Route::group(['prefix' => 'agent/rack/bill-voucher', 'middleware' => 'auth', 'namespace' => 'Agent\Rack', 'as' => 'agent.rack.bill_voucher.'], function(){
    Route::get('voucher-list', [RackBillVoucherController::class, 'voucherList'])->name('voucher_list');   
});

#################################################
#  Rack Bill Voucher Section End
#################################################


#################################################
# Rack Bill Voucher Section Start
#################################################
Route::group(['prefix' => 'rack/bill-voucher', 'middleware' => 'auth', 'namespace' => 'Rack', 'as' => 'bill.rack.bill_voucher.'], function(){
    Route::get('voucher-list', [RackBilCollectionlVoucherController::class, 'voucherList'])->name('voucher_list');   
    Route::get('auth-voucher-list', [RackBilCollectionlVoucherController::class, 'auth_voucher_list'])->name('auth_voucher_list');   
    Route::get('partial/{bill_no}', [PartialPaymentVoucherController::class, 'partialvoucherShow'])->name('partial');   
});

#################################################
#  Rack Bill Voucher Section End
#################################################



#################################################
# Lot Summary Section Start
#################################################
Route::group(['prefix' => 'report/lot', 'middleware' => 'auth', 'namespace' => 'Report', 'as' => 'report.lot.'], function(){
    Route::get('No', [LotSummaryController::class, 'index'])->name('summary');   
    Route::get('details', [LotSummaryController::class, 'details'])->name('details');   
});

#################################################
#  Lot Summary Section End
#################################################

Route::get('agent/details/voucher-download/{bill_no}', function($bill_no){
    $pdf = public_path("backend/assets/voucher/rack-bill/$bill_no.pdf"); 
    return response()->download($pdf); 
});




#################################################
# Report section Section Start
#################################################
Route::group(['prefix' => 'report/', 'middleware' => 'auth', 'namespace' => '', 'as' => 'report.'], function(){
    
    
    //socks code generate 
    Route::get('socks-code-generate', [ReportController::class, 'socks_code_generate'])->name('socks_code_generate');  
    Route::get('socks-code-generate2', [ReportController::class, 'socks_code_generate2'])->name('socks_code_generate2');  
     
    Route::post('socks-code-generate-pdf', [ReportController::class, 'generate_pdf'])->name('socks_code.generate_pdf');
    Route::post('socks-code-generate-pdf2', [ReportController::class, 'generate_pdf2'])->name('socks_code.generate_pdf2');  
    //end socks code generate

    Route::post('find_socks_code', [ReportController::class, 'find_socks_code'])->name('socks_code.find_socks_code');


    // lot brands 

     Route::get('lot-brands', [ReportController::class, 'lot_brands'])->name('lot_brands');   
     Route::post('lot-brands-report-table', [ReportController::class, 'lot_brands_report_table'])->name('lot_brands_report_table');   
    

    //end lot brands 

    
     //start rack product
     
     //start rack product

        Route::get('rack-product', [ReportController::class, 'rack_product'])->name('rack_product');   
        Route::post('rack-product-table', [ReportController::class, 'rack_product_table'])->name('rack_product_table'); 

     //end rack product 


     //start rack product

        Route::get('rack-refil-voucher', [ReportController::class, 'rack_refil_voucher'])->name('rack_refil_voucher');   
        Route::post('rack-refil-voucher-table', [ReportController::class, 'rack_refil_voucher_table'])->name('rack_refil_voucher_table'); 
        Route::get('rack-current-socks', [ReportController::class, 'rack_current_socks'])->name('rack.currentsocks'); 
        Route::post('rack-current-socks-submit', [ReportController::class, 'rack_current_socks_submit'])->name('rack.rack_current_socks_submit'); 

     
    
        
        
        // bill authorize report
        Route::get('bill-authorize-report', [ReportController::class, 'bill_authorize_report'])->name('bill_authorize_report'); 
        Route::post('bill-authorize-report-details', [ReportController::class, 'bill_authorize_report_details'])->name('bill_authorize_details'); 

     //socks_log_history report
     Route::get('socks-log-report', [ReportController::class, 'socks_log_report'])->name('socks_log_report'); 
     Route::post('socks-log-report-submit', [ReportController::class, 'socks_log_report_submit'])->name('socks_log_report_submit');
     
     Route::get('shop-visit', [ShopVisitController::class, 'shop_visit'])->name('shop_visit'); //shop visit report  
     
     Route::get('shop-visit', [ShopVisitController::class, 'shop_visit'])->name('shop_visit'); //shop visit report  
     Route::post('socks-log-report-submit', [ReportController::class, 'socks_log_report_submit'])->name('socks_log_report_submit'); 
     
     Route::get('shop-visit', [ShopVisitController::class, 'shop_visit'])->name('shop_visit'); //shop visit report  
     Route::post('socks-log-report-submit', [ReportController::class, 'socks_log_report_submit'])->name('socks_log_report_submit'); 
     
     Route::get('shop-visit', [ShopVisitController::class, 'shop_visit'])->name('shop_visit'); //shop visit report  

});

################################## product report #########################################
Route::group(['prefix' => 'report/product', 'middleware' => 'auth', 'namespace' => '', 'as' => 'report.'], function(){

    Route::get('product', [ProductReport::class, 'product'])->name('product');

});

################################## product report #########################################

################################################# packet code generetor ##########################################
Route::group(['prefix' => 'report/', 'middleware' => 'auth', 'namespace' => '', 'as' => 'report.'], function(){

    //socks code generate 
    Route::get('packet-code-generate', [PacketCodeController::class, 'socks_code_generate'])->name('packet_code_generate');   
    Route::post('generate-pdf', [PacketCodeController::class, 'generate_pdf'])->name('generate_pdf');   
    //end socks code generate
});


#################################################
# Report section Section End
#################################################


Route::get('/brand', function(){
    $handle = fopen("./rr.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
           $line_array                 = explode(",", $line);
           $brand_id                   = trim($line_array[1]);
           $brand_size_id              = trim($line_array[3]);
           $type_id                    = trim($line_array[2]);
           $packet_socks_pair_quantity = $line_array[4];
           $packet_buying_price        = $line_array[5];
           $packet_selling_price       = $line_array[6];
           $individual_buying_price    = $line_array[7];
           $individual_selling_price   = $line_array[8];
           $sale_type                  = $line_array[9];
        
           $brands = DB::select(DB::raw("SELECT id FROM brands where  name like '%$brand_id%' limit 1"))[0];
           $brand_sizes = DB::select(DB::raw("SELECT id FROM brand_sizes where  name like '%$brand_size_id%' limit 1"))[0];
           $types = DB::select(DB::raw("SELECT id FROM types where types_name like '$type_id%' limit 1"))[0];
                
           $insert = [
               "brand_id"                   => (empty($brands->id) ? '' : $brands->id),
               "brand_size_id"              => (empty($brand_sizes->id) ? '' : $brand_sizes->id),
               "type_id"                    => (empty($types->id) ? '' : $types->id),
               "packet_socks_pair_quantity" => $packet_socks_pair_quantity,
               "packet_buying_price"        => $packet_buying_price,
               "individual_buying_price"       => $packet_selling_price,
               "packet_selling_price"    => $individual_buying_price,
               "individual_selling_price"   => $individual_selling_price,
               "sale_type"                  => $sale_type,
               "entry_user_id"              => 1,
               "entry_date"                 => "2021-11-25",
               "entry_time"                 => "5:00:39",
           ];
           echo "<pre>";
           print_r($insert);
          // DB::table('products')->insert($insert);
        }
    
        fclose($handle);
    }
    
});

#################################################
# React Fillup Section Start
#################################################
Route::group(['prefix' => 'rack/rack-fillup', 'namespace' => 'Rack', 'middleware' => 'auth', 'as' => 'rack.rack-fillup.'], function(){
    Route:: get('index', [RackFillupController::class, 'index'])->name('index');
    Route:: get('create', [RackFillupController::class, 'create'])->name('create');
    Route:: post('rack-socks-history', [RackFillupController::class, 'rackSocksHistory'])->name('rack_socks_history');
    Route:: post('add-new-row', [RackFillupController::class, 'addNewRow'])->name('add_new_row');
    Route:: post('types-find-packet', [RackFillupController::class, 'socksTypeFindPacket'])->name('types_find_packet');
    Route:: post('findCatType', [RackFillupController::class, 'findCatType'])->name('findCatType');
    Route:: post('style-remaining-product', [RackFillupController::class, 'styleCodeRemainingProduct'])->name('style_remaining_product');   
    Route:: post('store', [RackFillupController::class, 'store'])->name('store');
    Route:: get('show-details/{id}', [RackFillupController::class, 'showDetails'])->name('show.details');
    Route:: get('generate-pdf-socks-code/{id}', [RackFillupController::class, 'generate_pdf_socks_code'])->name('generate_pdf_socks_code');

    Route:: POST('rack-socks-details', [RackFillupController::class, 'rack_socks_details'])->name('rack_socks_details');


});
#################################################
# React Fillup Section Start
#################################################



#################################################
# Direct Product Sales Section Start
#################################################
Route::group(['namespace' => 'DirectSale', 'prefix' => 'direct-sale', 'middleware' => 'auth', 'as' => 'direct_sale.'], function(){
    Route::get('/index', [DirectProductSalesController::class, 'index'])->name('index');
    Route::get('/sale', [DirectProductSalesController::class, 'saleForm'])->name('sale_form');
    Route::post('/add-new-row', [DirectProductSalesController::class, 'addNewRow'])->name('add_new_row');
    Route::post('/store', [DirectProductSalesController::class, 'store'])->name('store');
});
#################################################
# Direct Product Sales Section End
#################################################


#################################################
# Direct Product Sales Authorization Decline Section Start
#################################################
Route::group(['namespace' => 'DirectSale', 'prefix' => 'direct-sale/auth-decline', 'middleware' => 'auth', 'as' => 'direct_sale.auth_decline.'], function(){
    Route::get('/index', [DirectSaleAuthDeclineController::class, 'index'])->name('index');
    Route::get('/voucher-details/{voucher_no}', [DirectSaleAuthDeclineController::class, 'voucherDetails'])->name('voucher_detatils');
    Route::post('voucher-authorize', [DirectSaleAuthDeclineController::class, 'voucherAuthorize'])->name('voucher_authorize');
    Route::post('voucher-decline', [DirectSaleAuthDeclineController::class, 'voucherDeclined'])->name('voucher_decline');
    Route::get('voucher-download/{voucher_no}',  [DirectSaleAuthDeclineController::class, 'voucherDownload'])->name('voucher_download');
});
#################################################
# Direct Product Sales Section End
#################################################


#################################################
# Direct Product Sales Bill Collection Start by halim 12/04/2022
#################################################
Route::group(['namespace' => 'DirectSale', 'prefix' => 'direct-sale/bill-collection', 'middleware' => 'auth', 'as' => 'direct_sale.bill-collection.'], function(){
    Route::get('/index', [DirectSaleBillCollectionController::class, 'index'])->name('index');
    Route::post('/get-voucher', [DirectSaleBillCollectionController::class, 'get_voucher'])->name('get_voucher');
    Route::post('/get-amount', [DirectSaleBillCollectionController::class, 'get_amount'])->name('get_amount');
    Route::post('/bill-store', [DirectSaleBillCollectionController::class, 'bill_store'])->name('bill_store');
    Route::get('/bill-authorize', [DirectSaleBillCollectionController::class, 'bill_authorize'])->name('bill_authorize');
    Route::post('/bill-voucher-authorize', [DirectSaleBillCollectionController::class, 'bill_voucher_authorize'])->name('bill_voucher_authorize');
    
});
#################################################
# Direct Product  Bill Collection Start End by halim
#################################################



#################################################
# Direct Product Sales Report Start
#################################################
Route::group(['namespace' => 'DirectSale', 'prefix' => 'direct-sale/report', 'middleware' => 'auth', 'as' => 'direct_sale.report.'], function(){
    Route::get('/index', [DirectSaleReportController::class, 'index'])->name('index');
});
#################################################
# Direct Product Sales Report End
#################################################



#################################################
# Rac Bill Collection Section Start
#################################################
Route::group(['namespace' => 'Agent\Rack', 'prefix' => 'agent/rack/bill-collection/', 'middleware' => 'auth', 'as' => 'agent.rack.bill_collection.'], function(){
    Route::get('/rack-list', [RackBillCollectionController::class, 'rackList'])->name('rack_list');
    Route::get('/reack-details/{rack_id}', [RackBillCollectionController::class, 'rackDetails'])->name('rack_details');
    Route::post('/calculate-commission', [RackBillCollectionController::class, 'calculateCommission'])->name('calculate_commission');
    Route::post('/socks-bill-collection', [RackBillCollectionController::class, 'socksBillCollection'])->name('socks_bill_collection');
});



######################################## Ramjan ##########################################
Route::group(['prefix'=> 'bill', 'as' => 'bill.collection.'], function(){

    Route::get('/racklist', [BillCollectionController::class, 'rackList'])->name('racklist');
    Route::post('/all_due', [BillCollectionController::class, 'GetAllDue'])->name('all_due');
    Route::post('/pay_all_due', [BillCollectionController::class, 'pay_all_due'])->name('pay_all_due');    
    Route::get('/allRack', [BillCollectionController::class, 'allRack'])->name('allRack');
    Route::get('/month-wise/{rack_code}', [BillCollectionController::class, 'month_wise'])->name('month-wise');
    Route::post('/show_bill',  [BillCollectionController::class, 'show_bill'])->name('show-bill');
    Route::post('/monthly',  [BillCollectionController::class, 'monthlyBillPay'])->name('monthly');



    Route::post('/check_bill', [BillCollectionController::class, 'check_bill'])->name('check_bill');
    Route::post('/single_month_due', [BillCollectionController::class, 'single_month_due'])->name('single_month_due');

    Route::post('all_month', [BillCollectionController::class, 'all_month'])->name('all_month');
   
   

});

######################################## Ramjan ##########################################


######################################## Halim ##########################################
Route::group(['prefix'=> 'bill-authorize', 'namespace' => 'BillPaymentAuthorize', 'as' => 'bill.authorize.'], function(){

    Route::get('/index', [BillPaymentAuthorizeController::class, 'index'])->name('index');
    Route::post('/single-submit', [BillPaymentAuthorizeController::class, 'single_submit'])->name('single_submit');
    Route::get('/show-details/{shocks_bill_no}', [BillPaymentAuthorizeController::class, 'show_details'])->name('show_details');
    Route::post('/agent-or-officer-conveynce-bill-submit', [BillPaymentAuthorizeController::class, 'agent_or_officer_conveynce_bill_submit'])->name('agent_or_officer_conveynce_bill_submit');


});



Route::group(['prefix'=> 'bill-return', 'namespace' => 'Bill_Return', 'as' => 'bill.return.'], function(){

    Route::get('/index', [BillReturnController::class, 'index'])->name('index');
    Route::get('/show-details/{shocks_bill_no}', [BillReturnController::class, 'show_details'])->name('show-details');
    Route::post('single-bill-return-submit', [BillReturnController::class, 'single_bill_return_submit'])->name('single-bill-return-submit');
  
});

######################################## Halim ##########################################



#################################################
# Rac Bill Collection Section Start
#################################################



Route::get('rack-bill/voucher-stream/{bill_no}', function($bill_no){
    $pdf = public_path("backend/assets/voucher/rack-bill/$bill_no"); 

    return response()->file(
        public_path("backend/assets/voucher/rack-bill/$bill_no")
    );
});



#################################################
# Product Status Change Section Start
#################################################
Route::group(['namespace' => 'Agent\Rack', 'prefix' => 'agent/rack/product-status-change/', 'middleware' => 'auth', 'as' => 'agent.rack.product_status_change.'], function(){
    Route::get('index', [ProductStatusChangeController::class, 'index'])->name('index');
    Route::post('find-product', [ProductStatusChangeController::class, 'findProduct'])->name('find_product');
    Route::post('status-update', [ProductStatusChangeController::class, 'statusUpdate'])->name('status_update');
});
#################################################
# Product Status Change Section Start
#################################################



#################################################
# Rack Mapping Section Start
#################################################
Route::group(['namespace' => 'Rack', 'prefix' => 'rack/mapping', 'middleware' => 'auth', 'as' => 'rack.mapping.'], function(){
   
    Route::get('index', [RackMappingController::class, 'index'])->name('index');
    Route::get('create', [RackMappingController::class, 'create'])->name('create');
    Route::post('store', [RackMappingController::class, 'store'])->name('store');
});
#################################################
# Rack Mapping Section End
#################################################

################################################# packet code generetor ##########################################
Route::group(['prefix' => 'report/', 'middleware' => 'auth', 'namespace' => '', 'as' => 'report.'], function(){

    //socks code generate 
    Route::get('packet-code-generate', [PacketCodeController::class, 'socks_code_generate'])->name('packet_code_generate');   
    Route::post('packet/generate-pdf', [PacketCodeController::class, 'generate_pdf'])->name('packet.generate_pdf');   
    //end socks code generate
});


#################################################
# Shop Keeper Dashboard Section Start
#################################################
Route::group(['prefix' => 'shop-keeper', 'namespace' => 'Shopkeeper', 'as' => 'shopkeeper.', 'middleware' => 'auth'], function(){
    Route::get('home', [ShopkeeperSingleRackController::class, 'home'])->name('home');
    Route::post('/calculate-commission', [ShopkeeperSingleRackController::class, 'calculateCommission'])->name('calculate_commission');
    Route::post('/socks/sold', [ShopkeeperSingleRackController::class, 'socksSold'])->name('socks.sold');
});
#################################################
# Shop Keeper Dashboard Section End
#################################################


#################################################
# Rack Product Delete Section Start
#################################################
Route::group(['prefix' => 'rack/socks-return', 'namespace' => 'Rack', 'as' => 'rack.socks_return.', 'middleware' => 'auth'], function(){
    Route::get('index', [RackProductDeleteController::class, 'index'])->name('index');
    Route::get('socks_return_voucher', [RackProductDeleteController::class, 'socks_return_voucher'])->name('socks_return_voucher');
    Route::post('generate_socks_return_voucher', [RackProductDeleteController::class, 'generate_socks_return_voucher'])->name('generate_socks_return_voucher');
    Route::post('find-socks-list', [RackProductDeleteController::class, 'findSocksList'])->name('find_socks_list');
    Route::post('find-socks', [RackProductDeleteController::class, 'findSocks'])->name('find_socks');
    Route::post('delete-socks', [RackProductDeleteController::class, 'deleteSocks'])->name('delete_socks');
});

#################################################
# Rack Product Delete Section End
#################################################





#################################################
# FInance BIll COllection Section Start
#################################################

Route::group(['prefix' => 'finance/rack/bill-collection', 'namespace' => 'Finance\Rack', 'as' => 'finance.rack.bill-collection.', 'middleware' => 'auth'],function(){

          Route::get('search', [FinaceRackBillCollectionController::class, 'search'])->name('search');
          Route::get('search-result', [FinaceRackBillCollectionController::class, 'search_result'])->name('search_result');
          Route::post('approved-amount', [FinaceRackBillCollectionController::class, 'approved_amount'])->name('approved_amount');

    });


#################################################
# FInance BIll COllection End Start
#################################################







#################################################
# Search Socks From Rack
#################################################
Route::group(['prefix' => 'shopkeeper', 'namespace' => 'Shopkeeper', 'as' => 'shopkeeper.', 'middleware' => 'auth'], function(){
    Route::post('/search-socks', [SearchRackSocksController::class, 'searchSocks'])->name('search_socks');
});

#################################################
# Search Socks From Rack
#################################################



#################################################
# Bill Collection Voucher Section Start
#################################################

Route::group(['prefix' => 'voucher', 'namespace' => 'voucher', 'as' => 'voucher.', 'middleware' => 'auth'], function(){
    Route::get('/shop/rack-bill-info/{voucher_no}', [ShopRackBillCollectionVoucherController::class, 'voucherInfo'])->name('voucher_info');
    Route::get('/shop/rack-bill-voucher/{voucher_no}', [ShopRackBillCollectionVoucherController::class, 'voucherShow'])->name('rack_bill_collection.voucher_show');
});
#################################################
# Bill Collection Voucher Section End
#################################################

#################################################
# Shopkeeper message Collection Section Start
#################################################

Route::group(['prefix' => 'shopkeeper', 'namespace' => 'Shopkeeper', 'as' => 'shopkeeper.', 'middleware' => 'auth'], function(){
    Route::post('message-send', [CustomMessageController::class, 'messageSend'])->name('message_send');
});
#################################################
# Shopkeeper message Collection Section End
#################################################


########################################### report stock summary ##############################
Route::group(['prefix'=>'report', 'namespace'=>'Report', 'as'=>'report.stock.',], function(){

    Route::get('stock/summary', [StockSumarryController::class, 'index'])->name('summary');
    Route::post('stock/details', [StockSumarryController::class, 'details'])->name('summary-details');

});
########################################### report stock summary ##############################

####################################################### Account route #########################################
###############################################################################################################


################################################## transaction route ############################################

 Route::group(['prefix' => 'gl/account', 'namespace' => 'Accounts', 'as' => 'gl.account.transaction.'], function(){
    Route:: get('transaction/create', [GlTransactionController::class, 'create'])->name('create');
    Route:: post('transaction/find-mother-gl', [GlTransactionController::class, 'findMotherGl'])->name('find_mother_gl');
    Route:: post('transaction/store', [GlTransactionController::class, 'store'])->name('store');
    Route:: get('transaction/pending', [GlTransactionController::class, 'pendingTransaction'])->name('pending');
    Route:: post('transaction/authorize', [GlTransactionController::class, 'authorizeTransaction'])->name('authorize');
    Route:: post('transaction/decline', [GlTransactionController::class, 'declineTransaction'])->name('decline');
 });

 Route::group(['prefix' => 'gl/account', 'namespace' => 'Accounts\Report', 'as' => 'gl.account.transaction.report.'], function(){
     Route::get('balance-sheet', [GlBalanceReportController::class, 'glIndex'])->name('gl_balance_sheet');
     Route::get('balance', [GlBalanceReportController::class, 'gl_balance'])->name('gl_balance');
     Route::post('balance-sheet', [GlBalanceReportController::class, 'glBalanceSheet'])->name('gl_balance_sheet');
 });

################################################## end  transaction route #######################################

########################################################## Report ###############################################
Route::group(['prefix' =>'account/report/transfer/', 'namespace'=>'Accounts/Report', 'as' => 'account.report.transfer.' ], function(){
    Route::get('index', [TransferReport::class, 'index'])->name('index');
    Route::post('details', [TransferReport::class, 'details'])->name('details');
    
 });

 Route::group(['prefix' =>'account/report/balance/', 'namespace'=>'Accounts/Report', 'as' => 'account.report.gl.' ], function(){

    Route::get('balance', [TransferReport::class, 'balance'])->name('balance');
    Route::get('balance_2', [TransferReport::class, 'balance_2'])->name('balance_2');
    Route::get('list', [TransferReport::class, 'glList'])->name('list');
   
    

 });
########################################################## Report ###############################################

####################################################### Account route #########################################
#########################################################################################################



#################################### Commission SetUp ###############################################
Route::group(['prefix'=>'parameter-setup/',  'as'=>'parameter_setup.commission.'], function(){

    Route::get('commission', [CommissionSetUpController::class, 'create'])->name('create');
    Route::post('commission', [CommissionSetUpController::class, 'store'])->name('store');
    

});
#################################### End Commission SetUp ###########################################


########################################### report Commission  ##############################
Route::group(['prefix'=>'report', 'namespace'=>'Report', 'as'=>'report.commission.',], function(){

    Route::get('commission/index', [CommissionReport::class, 'index'])->name('index');
    Route::post('commission/details', [CommissionReport::class, 'details'])->name('details');

});
########################################### report Commission  ##############################

########################################### report rack fill up  ##############################
Route::group(['prefix'=>'report', 'namespace'=>'Report', 'as'=>'report.rackfill.',], function(){

    Route::get('Rack-fill/index', [RackFillUpReport::class, 'index'])->name('index');
    Route::post('Rack-fill/details', [RackFillUpReport::class, 'details'])->name('details');

});
########################################### report rack fill up  ##############################


########################################### report Product   ##############################
Route::group(['prefix'=>'report', 'namespace'=>'Report', 'as'=>'report.Rack-product.',], function(){

    Route::get('Rack-product/index', [RackProductDetailsReport::class, 'index'])->name('index');
    Route::post('Rack-product/details', [RackProductDetailsReport::class, 'details'])->name('details');

});
########################################### report Product  ##############################



####################################################### Account route #########################################
###############################################################################################################


################################################## transaction route ############################################

 Route::group(['prefix' =>'account', 'namespace'=>'Accounts', 'as' => 'account.transaction.' ], function(){

    Route::get('transaction/create', [TransactionController::class, 'create'])->name('create');
    Route::post('transaction/store', [TransactionController::class, 'store'])->name('store');
    Route::get('transaction/auth', [TransactionController::class, 'transaction_auth'])->name('auth');
    Route::post('transaction/auth_process', [TransactionController::class, 'auth_process'])->name('auth_process');
    Route::post('transaction/decline', [TransactionController::class, 'decline'])->name('decline');

 });


################################################## end  transaction route #######################################

########################################################## Report ###############################################
Route::group(['prefix' =>'account/report/transfer/', 'namespace'=>'Accounts/Report', 'as' => 'account.report.transfer.' ], function(){

    Route::get('index', [TransferReport::class, 'index'])->name('index');
    Route::post('details', [TransferReport::class, 'details'])->name('details');
    
    

 });



 Route::group(['prefix' =>'account/report/balance/', 'namespace'=>'Accounts/Report', 'as' => 'account.report.gl.' ], function(){

    Route::get('balance', [TransferReport::class, 'balance'])->name('balance');
    Route::get('balance_2', [TransferReport::class, 'balance_2'])->name('balance_2');
    Route::get('pdf', [TransferReport::class, 'generatePdt'])->name('pdf');
   
    

 });
########################################################## Report ###############################################

####################################################### Account route #########################################
#########################################################################################################


##### Rack Wrong Sold Item Controller #######
Route::group(['prefix' => 'agent/sold-delete', 'namespace' => 'Agent\SoldDelete', 'as' => 'agent.sold_delete.', 'middleware' => 'auth'], function(){
    Route:: get('rack-list', [RackWrongSoldItemDeteController::class, 'rackList'])->name('rack_list');
    Route:: get('rack-sold-information/{rack_code}', [RackWrongSoldItemDeteController::class, 'rackSoldInformation'])->name('rack_sold_information');
    Route:: post('calculate-socks', [RackWrongSoldItemDeteController::class, 'calculateSocks'])->name('single_rack.calculateSocks');
    Route:: post('unsold-sold-items', [RackWrongSoldItemDeteController::class, 'unsoldSoldItems'])->name('single_rack.unsold_sold_items');

    Route:: post('search_shop', [RackWrongSoldItemDeteController::class, 'search_shop'])->name('search_shop');
});
##### Rack Wrong Sold Item Controller ########



#################################################
# Account Manager Dashboard Section Start
#################################################
Route::group(['prefix' => 'account-manager', 'namespace' => 'AccountManager', 'as' => 'account_manager.', 'middleware' => 'auth'], function(){
    
    Route::get('/home', [AccountManagerController::class, 'home'])->name('account_manager.home');
   
});
#################################################
# Account Manager Dashboard Section End


#################################### Shop voucher report  ###############################################

Route::group(['prefix'=>'report/shop', 'as'=>'report.shop.voucher.', 'middleware'=>'auth'], function(){

    Route::get('/voucher', [ShopVoucherReport::class, 'index'])->name('index');

});

#################################### end  Shop voucher report  ###########################################



################################################  Bill Authorize ####################################

Route::group(['prefix'=>'bill/authorize', 'as'=>'bill.'], function(){

    Route::get('/index', [BillAuthorizeController::class, 'index'])->name('authorize.index');

});
################################################  Bill Authorize ####################################







################################### master Dashboard ##########################################

Route::group(['prefix'=>'dashboard'], function(){

    Route::get('index', [MasterDashboardController::class, 'index']);
    Route::get('details/{type}', [MasterDashboardController::class, 'details']);
    Route::post('shop_details', [MasterDashboardController::class, 'shop_details']);

});
################################### master Dashboard ##########################################



#################################### Bill payment dashboard ###################################
Route::group(['prefix'=>'bill/dashboard'], function(){

    Route::get('index', [BillDashboarController::class, 'index']);
    Route::get('details/{type}', [BillDashboarController::class, 'details']);
    Route::post('shop_details', [BillDashboarController::class, 'shop_details']);

});

#################################### Bill payment dashboard ###################################





################################### master Dashboard ##########################################
#################################### Bill Due report  ###############################################

Route::group(['prefix'=>'report','namespace'=>'Accounts/Report', 'as'=>'report.billdue.', 'middleware'=>'auth'], function(){

    Route::get('/bill-due-report', [BillDueController::class, 'index'])->name('index');

});

#################################### end  Shop voucher report  ###########################################







####################################### Cash Report #############################################
Route::group(['prefix'=> 'report/cash-report', 'as'=>'report.cash_report.' ], function(){

    Route::get('/lot-report', [LotReportController::class, 'index'])->name('lot');
    Route::post('/lot-report', [LotReportController::class, 'lot_info'])->name('lot-info');
    Route::post('/lot-info-details', [LotReportController::class, 'lotInfoDetails'])->name('lot-info-details');
    
    
    Route::get('/lot-details-data-edit/{lot_no}/{cat_id}/{product_id}/{type_id}', [LotReportController::class, 'lotDataEdit'])->name('lot-details-data-edit');
    Route::post('/lot-details-data-update', [LotReportController::class, 'lotDataUpdate'])->name('lot-details-data-update');


});


#################################### Status Wise report  ###############################################

Route::group(['prefix'=>'report','namespace'=>'/Report', 'as'=>'report.', 'middleware'=>'auth'], function(){

    Route::get('/status-wise-report', [StatusWiseReportController::class, 'status_wise_report'])->name('status_wise_report');
    Route::post('/get-shop-id', [StatusWiseReportController::class, 'get_shop_id'])->name('get_shop_id');
    Route::post('/data-show', [StatusWiseReportController::class, 'data_show'])->name('data_show');

});

#################################### end Status Wise report ###########################################

################################### agent shop tag controller #########################################
Route::group(['prefix'=> 'report/agent', 'as'=> 'report.agent.'], function(){

    Route::get('shop-tag', [AgentShopTagReportContoller::class, 'index'])->name('shop-tag');
    Route::post('details', [AgentShopTagReportContoller::class, 'TagDetails'])->name('details');
    Route::post('shop_details', [AgentShopTagReportContoller::class, 'shop_details'])->name('shop_details');

});
################################### agent shop tag controller #########################################


####################################### Cash Report #############################################


################################### Stock Product Summation Report #########################################
Route::group(['prefix'=> 'report/stock/product-summation', 'namespace' => 'Report', 'as'=> 'report.stock.product_summation.'], function(){

    Route::get('index', [StockProductSummationController::class, 'index'])->name('index');
    Route::post('generate', [StockProductSummationController::class, 'generate'])->name('generate');

});
################################### Stock Product Summation Report #########################################
################################### bill ###############################################################


Route::group(['prefix'=> 'report/cash-report/bill', 'as'=>'report.cash_report.'], function(){

    Route::get('index', [BillReportController::class, 'index'])->name('bill');
    Route::post('details', [BillReportController::class, 'details'])->name('bill-info');
    Route::post('rack_details', [BillReportController::class, 'rack_details'])->name('rack_details');

});


####################################### Cash Report #############################################

################################## Rack Transfer ###############################################
Route::group(['prefix'=> 'rack/transfer', 'as'=> 'rack.transfer.'], function(){

    Route::get('create', [RackTransferController::class, 'create'])->name('create');
    Route::post('store', [RackTransferController::class, 'store'])->name('store');

});
################################## Rack Transfer ###############################################


####################################### Tshirt -route ##############################################
Route::group(['prefix'=> 'stock/tshirt', 'as'=> 'stock.tshirt.'], function(){

    Route::get('create', [TshirtStockController::class, 'creat'])->name('create');
    Route::post('stock-creat', [TshirtStockController::class, 'store'])->name('store');


    //vailation route
    Route::post('tshirt-product-check', [TshirtStockController::class, 'ProductCheck'])->name('product-check');
    Route::post('type-info', [TshirtStockController::class, 'typeCheck'])->name('type-info');
    Route::post('size-info', [TshirtStockController::class, 'sizeCheck'])->name('size-info');


    Route::get('lot-voucher', [TshirtStockController::class, 'lot_voucher_index'])->name('lot_voucher');
    Route::get('lot-voucher-create', [TshirtStockController::class, 'lot_voucher_create'])->name('lot_voucher.create');
    Route::post('lot-voucher-store', [TshirtStockController::class, 'lot_voucher_store'])->name('lot_voucher.lot_voucher_store');

    Route::post('getLotNumber', [TshirtStockController::class, 'getLotNumber'])->name('getLotNumber');
    Route::post('getBrands', [TshirtStockController::class, 'getBrands'])->name('getBrands');
    

});
####################################### Tshirt -route ##############################################

################################## Rack Transfer ###############################################
Route::group(['prefix'=> 'rack/transfer', 'as'=> 'rack.transfer.'], function(){

    Route::get('create', [RackTransferController::class, 'create'])->name('create');
    Route::post('store', [RackTransferController::class, 'store'])->name('store');

});
################################## Rack Transfer ###############################################



Route::group(['prefix'=> 'report/cash-report/bill', 'as'=>'report.cash_report.'], function(){

    Route::get('index', [BillReportController::class, 'index'])->name('bill');
    Route::post('details', [BillReportController::class, 'details'])->name('bill-info');
    Route::post('rack_details', [BillReportController::class, 'rack_details'])->name('rack_details');

});


################################################# agent bill voucher #############

Route::group([ 'prefix'=> 'agent/bill/voucher', 'as'=>'agent.bill.'], function(){

    Route::get('list', [AgentBillVoucherController::class, 'voucher_list'])->name('voucher_list');
    Route::get('details/{voucher_no}', [AgentBillVoucherController::class, 'voucherShow'])->name('details');

});

##############################  agent bill voucher ###########################

################################### Stock Product Summation Report #########################################
Route::group(['prefix'=> 'report/stock/product-summation', 'namespace' => 'Report', 'as'=> 'report.stock.product_summation.'], function(){

    Route::get('index', [StockProductSummationController::class, 'index'])->name('index');
    Route::post('generate', [StockProductSummationController::class, 'generate'])->name('generate');

});
################################### Stock Product Summation Report #########################################

################################################# agent bill voucher #############

Route::group(['prefix'=> 'report/rack/product', 'as'=>'report.Rack.product.'], function(){

 Route::get('index', [RackProductReport::class, 'index'])->name('index');
 Route::post('index', [RackProductReport::class, 'details'])->name('details');

});

##############################  agent bill voucher ###########################



################################################# Socks Return Report #############

Route::group(['prefix'=> 'report/return-socks-report/','namespace' => 'Report/SocksReturnReportController/', 'as'=>'report.socks_return_report.'], function(){

    Route::get('index', [SocksReturnReportController::class, 'index'])->name('index');
    Route::post('show', [SocksReturnReportController::class, 'show'])->name('show');

    Route::get('socks_return_voucher/{shop_id}/{rack_code}/{return_date}', [SocksReturnReportController::class, 'socks_return_voucher'])->name('socks_return_voucher');
   
   });
   
   ##############################  Socks Return Report ###########################
   

############################# Report agnet Commission #########################

Route::group(['prefix'=> 'report/agent/commission', 'as'=>'report.agent.commission.'], function(){

    Route::get('index', [AgentCommissionReportController::class, 'index'])->name('index');
    Route::post('agent_shop_list', [AgentCommissionReportController::class, 'agent_shop_list'])->name('agent_shop_list');
    Route::post('shop_list', [AgentCommissionReportController::class, 'shop_list'])->name('shop_list');
    Route::get('shop_details/{url_array}', [AgentCommissionReportController::class, 'shopDetails'])->name('shop_details');
 
   
   });

############################# Report agnet Commission #########################



Route::group(['prefix'=>'report/status-wise-summation/','namespace'=>'Report', 'as'=>'report.status_wise_summation.', 'middleware'=>'auth'], function(){
    Route::get('index', [StatusWiseSummationController::class, 'index'])->name('index');
    Route::post('generate', [StatusWiseSummationController::class, 'generate'])->name('generate');
});


Route::group(['prefix'=>'report/user-wise-summation/','namespace'=>'Report', 'as'=>'report.user_wise_summation.', 'middleware'=>'auth'], function(){
    Route::get('index', [UserWiseSummationController::class, 'index'])->name('index');
    Route::post('generate', [UserWiseSummationController::class, 'generate'])->name('generate');
});



################################################# agent bill voucher #############

Route::group([ 'prefix'=> 'agent/bill/voucher', 'as'=>'agent.bill.'], function(){

    Route::get('list', [AgentBillVoucherController::class, 'voucher_list'])->name('voucher_list');
    Route::get('details/{voucher_no}', [AgentBillVoucherController::class, 'voucherShow'])->name('details');

});

##############################  agent bill voucher ###########################

######################################## Paremete set up company #################################

Route::group(['prefix'=>'parameter-setup/company',  'as'=>'parameter_setup.company.'], function(){

    Route::get('index', [CompanyController::class, 'index'])->name('index');
    Route::get('create', [CompanyController::class, 'create'])->name('create');
    Route::post('store', [CompanyController::class, 'store'])->name('store');

    Route::get('edit/{id}', [CompanyController::class, 'edit'])->name('edit');
    Route::post('update', [CompanyController::class, 'update'])->name('update');
});
######################################## Paremete set up company #################################

######################################## Paremete set up company #################################

Route::group(['prefix'=>'parameter-setup/category',  'as'=>'parameter_setup.category.'], function(){

    Route::get('index', [CategoryController::class, 'index'])->name('index');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('update', [CategoryController::class, 'update'])->name('update');
});
######################################## Paremete set up company #################################

############################################# Dashbord Report ###########################################
Route::group(['prefix'=>'Dashboard/report', 'as'=>'dashboard.report.'], function(){
    Route::get('rack/{date}', [DashboardReportController::class, 'rack_info'])->name('rack');
    Route::get('close_shop', [DashboardReportController::class, 'close_shop'])->name('close_shop');
    Route::get('socks_bill/{date}', [DashboardReportController::class, 'socks_bill'])->name('socks_bill');
    Route::get('pant_bill/{date}', [DashboardReportController::class, 'pant_bill'])->name('pant_bill');
    Route::get('tshirt_bill/{date}', [DashboardReportController::class, 'tshirt_bill'])->name('tshirt_bill');
    Route::get('due_shop', [DashboardReportController::class, 'due_shop'])->name('due_shop');
   

});
############################################# Dashbord Report  ###########################################


################################ Corporate route #################################################
Route::group(['prefix'=>'corporate/order', 'as'=>'corporate.Order.'], function(){
    Route::get('create', [OrderCreateController::class, 'create'])->name('create');
    Route::Post('single_row', [OrderCreateController::class, 'single_row'])->name('single_row');
    Route::Post('store', [OrderCreateController::class, 'store'])->name('store');
    Route::get('order-list', [OrderCreateController::class, 'order_list'])->name('order_list');
    Route::get('authorize/{chalan_no}', [OrderCreateController::class, 'order_authorize'])->name('authorize');
    Route::post('confrim_auth', [OrderCreateController::class, 'confrim_auth'])->name('confrim.auth');
    Route::get('voucher_list', [OrderCreateController::class, 'voucher_list'])->name('voucher_list');
    Route::get('show_voucher/{chalan_no}', [OrderCreateController::class, 'show_voucher'])->name('show_voucher');


});

Route::group(['prefix'=>'corporate/bill', 'as'=>'corporate.bill.'], function(){
    Route::get('index', [CorporateBillController::class, 'index'])->name('index');
    Route::Post('challan_no', [CorporateBillController::class, 'get_challan_no'])->name('challan_no');
    Route::Post('amount', [CorporateBillController::class, 'get_amount'])->name('amount');
    Route::Post('bill_store', [CorporateBillController::class, 'bill_store'])->name('bill_store');
    Route::get('auth_index', [CorporateBillController::class, 'auth_index'])->name('auth.index');
    Route::get('bill_authorize/{id}', [CorporateBillController::class, 'bill_authorize'])->name('bill.authorize');
    Route::get('voucher/list', [CorporateBillController::class, 'bill_voucher'])->name('voucher.list');

});


################################ Corporate route #################################################

Route::get('overview-dashboard', [DashboardOverViewController::class, 'index'])->name('report.dashboard.over_view');

######################################### User wise Activit report ###################################
Route::group(['prefix'=>'report/user-wise-activity/', 'as'=>'report.user_wise_activity.', 'middleware'=>'auth'], function(){
    Route::get('index', [UserWiseActivityReportController::class, 'index'])->name('index');
    Route::post('summary', [UserWiseActivityReportController::class, 'summary'])->name('summary');
    Route::get('details/{sts}/{data}', [UserWiseActivityReportController::class, 'details'])->name('details');
});
######################################### User wise Activit report ###################################

########################################## Area wise shop report #####################################
Route::group(['prefix'=>'report/area', 'as'=>'report.area.'], function(){
    Route::get('index', [AreaWiseReportController::class, 'index'])->name('index');
    Route::post('index', [AreaWiseReportController::class, 'show'])->name('show');
});
########################################## Area wise shop report #####################################


########################################## Average  shop report #####################################
Route::group(['prefix'=>'report/average', 'as'=>'report.average.'], function(){
    Route::get('index', [AverageReportController::class, 'index'])->name('index');
    Route::post('index', [AverageReportController::class, 'show'])->name('show');
});
########################################## Average  shop report #####################################


########################################### Salary Disburse Route ####################################
Route::group(['prefix'=>'salary/disburse', 'as'=> 'salary.disburse.'], function(){
    Route::get('create', [EmployeeSalaryController::class, 'create'])->name('create');
    Route::post('create', [EmployeeSalaryController::class, 'store'])->name('store');
    Route::get('pay', [EmployeeSalaryController::class, 'disbursement'])->name('pay');
    Route::post('getSalaryInfo', [EmployeeSalaryController::class, 'getSalaryInfo'])->name('getSalaryInfo');
    Route::post('getMonthwiseSalary', [EmployeeSalaryController::class, 'getMonthwiseSalary'])->name('getMonthwiseSalary');
    Route::post('success', [EmployeeSalaryController::class, 'disburse_store'])->name('success');
    Route::get('authorize', [EmployeeSalaryController::class, 'authorize_index'])->name('authorize_index');
    Route::post('authorize', [EmployeeSalaryController::class, 'authorize_salary'])->name('authorize');
    Route::post('decline', [EmployeeSalaryController::class, 'decline_salary'])->name('decline');
    Route::get('amendment/{id}', [EmployeeSalaryController::class, 'amendment'])->name('amendment');
    Route::post('amendment_update', [EmployeeSalaryController::class, 'amendment_update'])->name('amendment_update');
});

Route::group(['prefix'=>'salary/list', 'as'=>'salary.setup.'], function(){
    Route::get('index', [UpdateEmployeeSalaryController::class, 'index'])->name('index');
    Route::get('edit/{id}', [UpdateEmployeeSalaryController::class, 'edit'])->name('edit');
    Route::post('edit', [UpdateEmployeeSalaryController::class, 'update'])->name('update');
});


########################################### Salary Disburse Route ####################################




Route::get('overview-dashboard', [DashboardOverViewController::class, 'index'])->name('report.dashboard.over_view');

############################################# Dashbord Report  ###########################################



 Route::group(['prefix' => 'account/report/gl-transaction/', 'namespace' => 'Accounts/Report', 'as' => 'account.report.gl_transaction.'], function(){
    Route::get('index', [GlTransactionsReportController::class, 'index'])->name('index');
    Route::post('generate', [GlTransactionsReportController::class, 'generate'])->name('generate');
 });


 ###################################### Shop due  Bill Report #######################################
 Route::group(['prefix'=>'report/bill/due', 'as'=> 'report.bill.due.'], function(){

    Route::get('index', [ShopDueBillReportController::class, 'index'])->name('index');
    Route::post('index', [ShopDueBillReportController::class, 'details'])->name('details');

 }); 
 ###################################### Shop due  Bill Report ####################################### 



 ################################################## Corporate client create #############################
Route::group(['prefix' => 'parameter-setup/employee',   'as' => 'parameter_setup.employee.'], function(){
    Route::get('index', [EmployeeSetupController::class, 'index'])->name('index');
    Route::get('create', [EmployeeSetupController::class, 'create'])->name('create');
    Route::post('store', [EmployeeSetupController::class, 'store'])->name('store');
    Route::get('edit/{id}', [EmployeeSetupController::class, 'edit'])->name('edit');
    Route::post('update', [EmployeeSetupController::class, 'update'])->name('update');
  });
  ################################################## Corporate client create #############################

  
  ############################################ Salary Disburse Report ####################################
   Route::group(['prefix'=>'report/salary/disburse', 'as'=> 'report.salary.disburse.'], function(){
    Route::get('index', [SalaryDisburseReportController::class,'index'])->name('index');
    Route::post('index', [SalaryDisburseReportController::class,'summary'])->name('summary');
    Route::get('details/{emp_id}/{frm}/{to}', [SalaryDisburseReportController::class,'details'])->name('details');
   ;
    
 });
 ############################################ Salary Disburse Report ####################################


 ############################################# Lead route ###############################################
 Route::group(['prefix'=> 'lead', 'as'=> 'lead.'], function(){
    Route::get('index', [LeadController::class, 'index'])->name('index');
    Route::get('create', [LeadController::class, 'create'])->name('create');
    Route::post('getHtmlForm', [LeadController::class, 'getHtmlForm'])->name('getHtmlForm');
    Route::post('store', [LeadController::class, 'store'])->name('store');

    Route::post('update', [LeadController::class, 'update'])->name('update');
 });
/* -----------------------------Report url ---------------------------------------------------*/
Route::group(['prefix'=> 'report/lead', 'as'=> 'report.lead.'], function(){
    Route::get('index', [LeadReportController::class, 'index'])->name('index');
    Route::post('summary', [LeadReportController::class, 'summary'])->name('summary');
    Route::post('details', [LeadReportController::class, 'details'])->name('details');
   
 });
/* -----------------------------Report url ---------------------------------------------------*/
 ############################################# Lead route ###############################################



################### partial bill authorize report ##########################
Route::group(['prefix'=> 'report/partial/bill', 'as'=> 'report.partial.bill.'], function(){
    Route::get('index', [PartialReportController::class, 'index'])->name('index');
    Route::post('details', [PartialReportController::class, 'details'])->name('details');
});
################### partial bill authorize report ##########################




