<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

/**
 * Define a routes protected by the 'auth' middleware.
 * These routes are authenticated
 */
Route::middleware(['auth'])->group(function() {
    Route::get('home', 'HomeController@index')->name('home');
    Route::resource('customers', 'CustomerController')->names('customers');
    Route::get('customers-json', 'CustomerController@json')->name('customers.json');
    Route::resource('loans', 'LoanController')->names('loans');
    Route::get('loans-json', 'LoanController@json')->name('loans.json');
    Route::resource('payments', 'PaymentController')->names('payments');
    Route::resource('transactions', 'TransactionController')->names('transactions');
    Route::get('transactions-json', 'TransactionController@json')->name('transactions.json');
    Route::resource('fundings', 'LoanFundingController')->names('fundings');
});
