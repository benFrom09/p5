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

Route::get('/', [
    'as'=> 'Home',
    'uses' => 'PagesController@home'
]);

Route::get('/about', 'PagesController@about')->name('About');
   
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/confirmation/{id}/{token}','Auth\RegisterController@confirmation');
Route::get('/creategroup','CreateGroupController@create');
Route::post('/creategroup','CreateGroupController@store');
Route::get('/group/{id}','GroupController@show');

