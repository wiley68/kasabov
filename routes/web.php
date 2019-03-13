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
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory')->name('admin.edit-category');
    Route::get('/admin/delete-category/{id}', 'CategoryController@deleteCategory')->name('admin.delete-category');
    Route::get('/admin/view-categories', 'CategoryController@viewCategory')->name('admin.view-categories');
    // Holiday routes
    Route::match(['get', 'post'], '/admin/add-holiday', 'HolidayController@addHoliday')->name('admin.add-holiday');
    Route::match(['get', 'post'], '/admin/edit-holiday/{id}', 'HolidayController@editHoliday')->name('admin.edit-holiday');
    Route::get('/admin/delete-holiday/{id}', 'HolidayController@deleteHoliday')->name('admin.delete-holiday');
    Route::get('/admin/view-holidays', 'HolidayController@viewHolidays')->name('admin.view-holidays');
});
Route::get('/logout', 'AdminController@logout')->name('logout');
