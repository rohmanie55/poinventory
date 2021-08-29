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
    Route::get('notifications', function(){ 
        return view('notification'); 
    })->name('notification.index');

    Route::post('notifications/{notification}', function($id){
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);

        return redirect()->route('notification.index');
    })->name('notification.read');

    Route::delete('notifications/{notification}', function($id){
        auth()->user()->notifications()->where('id', $id)->delete();

        return redirect()->route('notification.index');
    })->name('notification.delete');

    Route::get('/', 'DashboardController')->name('dashboard');

    Route::get('report/stock', 'ReportController@stock')->name('report.stock');
    Route::get('report/kanban', 'ReportController@kanban')->name('report.kanban');
    Route::get('report/order', 'ReportController@order')->name('report.order');
    Route::get('report/trx', 'ReportController@trx')->name('report.trx');
    Route::get('report/payment', 'ReportController@payment')->name('report.payment');
    Route::get('report/tacking', 'ReportController@tacking')->name('report.tacking');

    Route::post('order/{order}/approve', 'OrderController@approve')->name('order.approve');

    Route::resource('goods', 'GoodsController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('user', 'UserController');
    Route::resource('kanban', 'KanbanController');
    Route::resource('order', 'OrderController');
    Route::resource('tackingout', 'TackingController');
    Route::resource('payment', 'PaymentController');
    Route::resource('transaction', 'TransactionController');
});
