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

Route::get('updateDol', 'ProcessController@updateDol')->name('updateDol');
Route::get('updateResignationComment', 'ProcessController@updateResignationComment')->name('updateResignationComment');
Route::get('updateDowComment', 'ProcessController@updateDowComment')->name('updateDowComment');

Route::resource('process', 'ProcessController');
Route::resource('questions','QuestionController');
Route::get('deleteQuestion/{key}','QuestionController@destroy');
Route::resource('addquestions', 'AddQuestionController');
Route::get('updateDol' , 'ProcessController@updateDol')->name('updateDol');
Route::get('updateResignationComment' , 'ProcessController@updateResignationComment')->name('updateResignationComment');
Route::get('updateDowComment' , 'ProcessController@updateDowComment')->name('updateDowComment');
Route::get('storeNodue' , 'ProcessController@storeNodue')->name('storeNodue');
Route::get('updateNodue' , 'ProcessController@updateNodue')->name('updateNodue');
Route::get('storeFeedback' , 'ProcessController@storeFeedback')->name('storeFeedback');
Route::get('updateFeedback' , 'ProcessController@updateFeedback')->name('updateFeedback');
Route::get('storeFinalCheckList' , 'ProcessController@storeFinalCheckList')->name('storeFinalCheckList');
Route::get('updateFinalCheckList' , 'ProcessController@updateFinalCheckList')->name('updateFinalCheckList');
Route::get('resignationDetails','ResignationController@index')->name('resignationDetails');
Route::get('acceptanceStatus','ResignationController@showAcceptanceStatus')->name('acceptanceStatus');
Route::get('noDueStatus','ResignationController@noDueStatus')->name('noDueStatus');
Route::get('withdrawForm','ResignationController@showWithdrawForm')->name('withdrawForm');
Route::resource('process', 'ProcessController');
