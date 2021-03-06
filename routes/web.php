<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@index')->name('login');
Route::get('/register', 'HomeController@index')->name('register');
//Route::post('/getuserdata', 'Auth\RegisterController@getUser')->name('getUser');
Route::get('/password/reset', 'HomeController@index')->name('password.request');
Route::get('/password/reset/{token}', 'HomeController@index')->name('password.reset');

//Route::get('/profile', 'ProfileController@index')->name('profile')->middleware('verified','auth');

Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'admin','middleware'=>['auth','verified']], function(){
	Route::get('dashboard','DashboardController@index')->name('dashboard');
	Route::post('newcategory', 'categoryController@create');
	Route::post('allcategories','categoryController@allcategories');
	Route::post('editcategory','categoryController@editcategory');
	//Post
	Route::post('newpost','PostContoller@newpost');
	Route::get('allposts','PostContoller@allpost');
	Route::get('getsinglepost','PostContoller@getsinglepost');
	Route::post('editpost','PostContoller@editpost');
});

Route::group(['as'=>'editor.','prefix'=>'editor','namespace'=>'admin','middleware'=>['auth']], function(){
	Route::get('dashboard','DashboardController@index')->name('dashboard');
});
//Master Route
Route::get('/admin/{all?}', 'admin\DashboardController@index')->where(['all' => '.*']);
//Master Route
Route::get('/{all?}', 'HomeController@index')->where(['all' => '.*']);