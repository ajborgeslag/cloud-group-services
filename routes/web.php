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
    return view('welcome');
});

/*Route::get('/login', function () {
    return view('auth/loguin');
});*/

Route::get('/login/{vue_capture?}', function () {
    return view('auth/loguin');
})->where('vue_capture', '[\/\w\.-]*')->name('login');

Route::get('/home/{vue_capture?}', function () {
    return view('back_officer/home');
})->where('vue_capture', '[\/\w\.-]*');
