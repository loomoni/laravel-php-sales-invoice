<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', 'HomeController@index')->name('home');


Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);

Route::group(['middleware' => 'auth'], function() {

    Route::get('/dashboard', [HomeController::class, 'index']);

    // Tax Route
    Route::get('tax', [TaxController::class, 'index']);
    Route::get('tax/create', [TaxController::class, 'Create']);
    Route::post('tax/create', [TaxController::class, 'Store']);


    // Categories Route
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/create', [CategoryController::class, 'Create']);
    Route::post('category/create', [CategoryController::class, 'Store']);

    // Products Route
    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/create', [ProductController::class, 'Create']);
    Route::post('product/create', [ProductController::class, 'Store']);


    //Unit Route
    Route::get('unit', [UnitController::class, 'index']);
    Route::get('unit/create', [UnitController::class, 'Create']);
    Route::post('unit/create', [UnitController::class, 'Store']);

    //Invoice Route
    Route::get('invoice', [InvoiceController::class, 'index']);
    Route::get('invoice/create', [InvoiceController::class, 'Create']);
    Route::post('invoice/create', [InvoiceController::class, 'Store']);
    Route::get('findPrice', [InvoiceController::class, 'findPrice']);

    //Supplier Route
    Route::get('suppliers', [SupplierController::class, 'index']);
    Route::get('supplier/create', [SupplierController::class, 'Create']);
    Route::post('supplier/create', [SupplierController::class, 'Store']);

    //Customers Route
    Route::get('customer', [CustomerController::class, 'index']);
    Route::get('customer/create', [CustomerController::class, 'Create']);
    Route::post('customer/create', [CustomerController::class, 'Store']);

});

