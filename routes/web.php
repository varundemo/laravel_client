<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContractorProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware'=>['guest']], function (){
    Route::get('/', function () {
        return redirect('login');
        // return view('login');
    });
});

// Auth::routes((['verify' => true]));
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['can:super-admin'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['middleware'=>['auth','verified']], function (){
Route::group(['middleware'=>['auth']], function (){
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('profile',[ContractorProfileController::class,'show'])->name('profile');
    Route::get('contractors',[ContractorProfileController::class,'show_all_contractors'])->name('contractors');
    Route::get('contractors-list',[ContractorProfileController::class,'show_contractors_list'])->name('contractors-list');
    Route::get('edit-contractor/{id}',[ContractorProfileController::class,'edit'])->name('edit-contractor');
    Route::post('update-contractor/{id}',[ContractorProfileController::class,'update'])->name('update-contractor');
    Route::post('contractors',[ContractorProfileController::class,'store'])->name('contractor.add');
    Route::delete('contractors',[ContractorProfileController::class,'distroy'])->name('contractor.distroy');
    
    Route::get('/get-contractor/{id}',[ContractorProfileController::class,'get_contractor'])->name('get-contractor');
    Route::get('add-raduis',[ContractorProfileController::class,'addraduis'])->name('add-raduis');

     Route::get('leads',[LeadController::class,'leadView'])->name('leads');	
     Route::delete('leads',[LeadController::class,'destroy'])->name('leads.distroy');
    Route::get('create-lead',[LeadController::class,'leadCreate'])->name('create-lead');	
    // Route::get('edit-lead',[LeadController::class,'editlead'])->name('edit-lead');	
    Route::post('save-lead',[LeadController::class,'savelead'])->name('save-lead');	
    Route::get('edit-lead/{id}',[LeadController::class,'leadEdit'])->name('edit-lead');
    Route::get('view-lead/{id}',[LeadController::class,'leadSingleView'])->name('view-lead');
    Route::post('update-lead/{id}',[LeadController::class,'updatelead'])->name('update-lead');

    Route::get('service', [DashboardController::class, 'service_view'])->name('services');
    Route::post('/update-prices', [DashboardController::class,'updatePrice'])->name('update-prices');


    Route::get('payment-wallet', [PaymentController::class, 'walletview'])->name('payment-wallet');

    Route::get('payment', [PaymentController::class, 'paymentview'])->name('payment');
    Route::post('payment', [PaymentController::class, 'payment'])->name('payment');
    Route::get('billing-invoice', [PaymentController::class, 'invoice'])->name('billing-invoice');

    Route::get('get-service/{id}',[LeadController::class,'get_service']);	
    Route::get('contractor-create',[ContractorProfileController::class,'contractCreate'])->name('contractor-create');
    Route::get('term-and-conditions',[DashboardController::class,'termcondition'])->name('term-and-conditions');

    Route::get('email', [DashboardController::class, 'email'])->name('email');
    Route::get('support', [DashboardController::class, 'support'])->name('support');
    Route::post('support', [DashboardController::class, 'supportmail'])->name('support');

});

Route::post('/store-data', [ApiController::class,'storeContractor']);
Route::post('/store-lead', [ApiController::class,'storeLead']);



Route::get("getpass", function(){
    $password = "varunvarun";
    $pass_value = Hash::make($password);
    dd($pass_value);
});


Route::get('test-email',[DashboardController::class,'testemail'])->name('test-email');


