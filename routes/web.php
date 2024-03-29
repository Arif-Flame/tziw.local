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
Route::get('/', "HomeController@index");
Route::get('downloadfile/{id}', "TaskController@downloadFile")->name("downloadFile");
Route::group(['prefix'=>'/'], function(){
    Route::resource('tasks', 'TaskController')->names('tasks');

});

Auth::routes();

