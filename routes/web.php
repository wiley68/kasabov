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
Route::get('/admin/dashboard', 'AdminController@dashboard')->middleware('auth')->name('admin.dashboard');
Route::get('/admin/settings', 'AdminController@settings')->middleware('auth')->name('admin.settings');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::get('/admin/check-pwd', 'AdminController@chkPassword')->middleware('auth')->name('admin.check-pwd');
Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword')->middleware('auth')->name('admin.update-pwd');
