<?php

//Hey Guy, I'm leaving some code here to show my progress, don't know if you'll ever read this but just incase.

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/about', function () {
//     return view('pages.about');
// });

// Route::get('/users/{id}', function ($id) {
//     return 'Selected user: ' . $id;
// });

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

//this is a controller I used for studying.
//ignore it
// Route::resource('posts', 'PostsController');
