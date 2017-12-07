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
Route::get('/contact','PagesController@Contact')->name('Contact');
   
Auth::routes();

Route::any('/home', 'HomeController@index')->name('home');
Route::get('/confirmation/{id}/{token}','Auth\RegisterController@confirmation');
Route::get('/creategroup','GroupController@create');
Route::post('/creategroup','GroupController@store');
Route::get('/group/{id}','GroupController@show')->where('id','[0-9]+')->name('group');
Route::post('/createPost/{id}', [
    'uses' =>'PostController@createPost',
    'as' => 'post.create'
]);

Route::get('/deletePost/{post_id}',[
    'uses' =>'PostController@deletePost',
    'as'  =>'post.delete'
]);

Route::post('/edit', [
    'uses' => 'PostController@editPost' , 
    'as'  => 'edit'
]);
