<?php

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

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', function () { return view('dashboard');})->name('dashboard');

    Route::resource('goods', 'BarangController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('user', 'UserController');
    Route::resource('kanban', 'KanbanController');
    Route::resource('order', 'OrderController');
    Route::resource('purchase', 'PurchaseController');
    Route::resource('transaction', 'TransactionController');

});