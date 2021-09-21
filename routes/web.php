<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;

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


Auth::routes();


Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
Route::resource('resignation', 'ResignationController')->middleware('auth');

Route::resource('process', 'ProcessController')->middleware(['auth','backendAccess']);
Route::resource('questions','QuestionController')->middleware('auth');
Route::get('deleteQuestion/{key}','QuestionController@destroy')->middleware(['auth','backendAccess']);
Route::resource('addquestions', 'AddQuestionController')->middleware(['auth','backendAccess']);
Route::get('updateDol' , 'ProcessController@updateDol')->middleware(['auth','backendAccess'])->name('updateDol');
Route::get('updateResignationComment' , 'ProcessController@updateResignationComment')->middleware(['auth','backendAccess'])->name('updateResignationComment');
Route::get('addOrUpdateResignationAcceptance' , 'ProcessController@addOrUpdateResignationAcceptance')->middleware(['auth','backendAccess'])->name('addOrUpdateResignationAcceptance');
Route::get('addOrUpdateDolComments' , 'ProcessController@addOrUpdateDolComments')->middleware(['auth','backendAccess'])->name('addOrUpdateDolComments');
Route::get('addOrUpdateDowComment' , 'ProcessController@addOrUpdateDowComment')->middleware(['auth','backendAccess'])->name('addOrUpdateDowComment');
Route::get('updateDowComment' , 'ProcessController@updateDowComment')->middleware(['auth','backendAccess'])->name('updateDowComment');
Route::get('addOrUpdateFeedback' , 'ProcessController@addOrUpdateFeedback')->middleware(['auth','backendAccess'])->name('addOrUpdateFeedback');
Route::get('addOrUpdateHrInterview' , 'ProcessController@addOrUpdateHrInterview')->middleware(['auth','backendAccess'])->name('addOrUpdateHrInterview');
Route::get('addOrUpdateNodue' , 'ProcessController@addOrUpdateNodue')->middleware(['auth','backendAccess'])->name('addOrUpdateNodue');
Route::post('storeFinalCheckList' , 'ProcessController@storeFinalCheckList')->middleware(['auth','backendAccess'])->name('storeFinalCheckList');
Route::post('updateFinalCheckList' , 'ProcessController@updateFinalCheckList')->middleware(['auth','backendAccess'])->name('updateFinalCheckList');
Route::get('resignationDetails','ResignationController@index')->middleware('auth')->name('resignationDetails');
Route::get('progress','ResignationController@resignationProgress')->middleware('auth')->name('progress');
Route::get('acceptanceStatus','ResignationController@showAcceptanceStatus')->middleware('auth')->name('acceptanceStatus');
Route::get('noDueStatus','ResignationController@noDueStatus')->middleware('auth')->name('noDueStatus');
Route::get('withdrawForm','ResignationController@showWithdrawForm')->middleware('auth')->name('withdrawForm');
Route::get('getUser','UserDetailsController@index')->name('getUser');
Route::get('workflow','ProcessController@workflow')->middleware('auth')->name('workflow');
Route::post('workflowStore','ProcessController@workflowStore')->middleware('auth')->name('workflowStore');
Route::post('headSelectStore','ProcessController@headSelectStore')->middleware('auth')->name('headSelectStore');
Route::get('get/{filename}', 'ProcessController@downloadDocs')->name('downloadDocs');

Route::get('/sendMail',[ProcessController::class,'sendMail']);