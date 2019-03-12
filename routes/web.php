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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Admin
Route::match(['get', 'post'],'/admin', 'AdminController@login')->name('admin');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    // Settings routes
    Route::get('/admin/settings', 'AdminController@settings')->name('admin.settings');
    Route::get('/admin/check-pwd', 'AdminController@chkPassword')->name('admin.check-pwd');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword')->name('admin.update-pwd');
    // Categories routes
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory')->name('admin.add-category');
    Route::get('/admin/view-categories', 'CategoryController@viewCategory')->name('admin.view-categories');
});
Route::get('/logout', 'AdminController@logout')->name('logout');
