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
    return view('auth.login');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/progress', function () {
    return view('resignation.progress');
}); 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('resignation', 'ResignationController');

Route::get('updateDol' , 'ProcessController@updateDol')->name('updateDol');
Route::get('updateResignationComment' , 'ProcessController@updateResignationComment')->name('updateResignationComment');
Route::get('updateDowComment' , 'ProcessController@updateDowComment')->name('updateDowComment');

Route::resource('process', 'ProcessController');