<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Customers
Route::get('customers', 'ApiController@getCustomers');

Route::post('customers', 'ApiController@postCustomer');

Route::get('customers/{customer_id}', 'ApiController@getCustomer');

Route::put('customers/{customer_id}', 'ApiController@putCustomer');

Route::delete('customers/{customer_id}', 'ApiController@deleteCustomer');

// Reports
Route::get('reports', 'ApiController@getReports');

Route::post('reports', 'ApiController@postReport');

Route::get('reports/{report_id}', 'ApiController@getReport');

Route::put('reports/{report_id}', 'ApiController@putReport');

Route::delete('reports/{report_id}', 'ApiController@deleteReport');
