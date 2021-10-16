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

\App\PetPassport\PetPassport::routes();

//$spa = function() {
//	return view('layouts.spa');
//};

//Route::get('/test', 'TestController@test');

//Route::get('/', $spa);
//Route::get('/login', $spa);
//Route::get('/register', $spa);
//Route::get('/about', $spa);

//Route::middleware('auth')->group(function() use ($spa) {
//	Route::get('/settings/{any}', $spa)->where(['any' => '.+']);
//});

//Route::get('/market/{any}', $spa)->where(['any' => '.+']);
//Route::get('{any}', $spa)->where(['any' => '.+']);
