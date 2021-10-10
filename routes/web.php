<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/login/{vue_capture?}', function () {
    return view('auth/login');
})->where('vue_capture', '[\/\w\.-]*')->name('login');

Route::get('/register/{vue_capture?}', function () {
    return view('auth/register');
})->where('vue_capture', '[\/\w\.-]*')->name('register');

Route::get('/home/{vue_capture?}', function () {
    return view('back_officer/home');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/manage/{vue_capture?}', function () {
    return view('back_officer/clients/manage');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/zip_code/{vue_capture?}', function () {
    return view('back_officer/services/zip_code');
})->where('vue_capture', '[\/\w\.-]*');
