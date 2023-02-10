<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\CustomerController::class, 'showCustomers'])->name('home')->middleware('auth');

// customer routes
Route::prefix('customer')->middleware(['auth'])->group(function () {
    Route::get('add-customer', function () {
        return view("addCustomer");
    })->name('add_customer');

    // routes to add the customer
    Route::post('add-customer', [CustomerController::class, "saveCustomer"])->name("register_customer");

    // routes to edit the customer
    Route::get('edit-customer/{customer_id}', [CustomerController::class, "editCustomer"])->name("edit_customer");
    Route::post('edit-customer', [CustomerController::class, "saveEditCustomer"])->name("save_edit_customer");

    // routes to delete the customer
    Route::get('delete-customer/{customer_id}', [CustomerController::class, "deleteCustomer"])->name("delete_customer");
});

// ->middleware('auth')