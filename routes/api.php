<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// This thing basically loads all the "functions" from the controller...I think
// Which then prevents the need to write every since function the controller has
// Route::resource('customers', 'CustomersController'); 
// But since I'm learning...I'll just write everything down.
Route::get('customers', 'CustomersController@index');
Route::get('customer/{id}', 'CustomersController@show');
Route::post('customer', 'CustomersController@store'); //create
Route::put('customer', 'CustomersController@store'); //update
Route::delete('customer/{id}', 'CustomersController@destroy'); //delete
