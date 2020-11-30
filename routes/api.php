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

Route::get('customers', function () {
});

Route::post('customers', function () {
});

Route::get('customers/{customer_id}', function () {
});

Route::put('customers/{customer_id}', function () {
});

Route::delete('customers/{customer_id}', function () {
});
