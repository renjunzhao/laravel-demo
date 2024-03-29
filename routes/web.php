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

Route::middleware('api')
    ->namespace('Backend')
    ->prefix('backend')
    ->group(function () {
    include_route_files(__DIR__.'/backend/');
});



Route::get('/', function () {
    return view('welcome');
});
