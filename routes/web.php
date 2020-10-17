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

Route::get('/', 'HomeController@index')->name('welcome');
/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/admin_save_main_topics_name', 'Admin@admin_save_main_topics_name');
Route::post('/admin_save_topics_name', 'Admin@admin_save_topics_name');
Route::get('/admin_main_topics_list', 'Admin@admin_main_topics_list');
Route::get('/topics_list', 'HomeController@topics_list');
Route::post('/topics_al_list', 'HomeController@topics_al_list');

Route::get('/admin', function(){
  if(isset(Auth::user()->admin) && Auth::user()->admin == true){
    return view('admin');
  }else{
    return redirect('/');
  }
});
