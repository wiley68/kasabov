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
    // Tag routes
    Route::match(['get', 'post'], '/admin/add-tag', 'TagController@addTag')->name('admin.add-tag');
    Route::match(['get', 'post'], '/admin/edit-tag/{id}', 'TagController@editTag')->name('admin.edit-tag');
    Route::get('/admin/delete-tag/{id}', 'TagController@deleteTag')->name('admin.delete-tag');
    Route::get('/admin/view-tags', 'TagController@viewTags')->name('admin.view-tags');
    Route::get('/admin/delete-products-tags', 'TagController@deleteProductsTags')->name('admin.delete-products-tags');
    // Product routes
    Route::match(['get', 'post'], '/admin/add-product', 'ProductController@addProduct')->name('admin.add-product');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductController@editProduct')->name('admin.edit-product');
    Route::get('/admin/delete-product/{id}', 'ProductController@deleteProduct')->name('admin.delete-product');
    Route::get('/admin/view-products', 'ProductController@viewProducts')->name('admin.view-products');
    Route::get('/admin/delete-product-image/{id}', 'ProductController@deleteProductImage')->name('admin.delete-product-image');
    // Products Images routes
    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductController@addImages')->name('admin.add-images');
    Route::get('/admin/delete-product-images/{id}', 'ProductController@deleteProductImages')->name('admin.delete-product-images');
    // Speditor routes
    Route::match(['get', 'post'], '/admin/add-speditor', 'SpeditorController@addSpeditor')->name('admin.add-speditor');
    Route::match(['get', 'post'], '/admin/edit-speditor/{id}', 'SpeditorController@editSpeditor')->name('admin.edit-speditor');
    Route::get('/admin/delete-speditor/{id}', 'SpeditorController@deleteSpeditor')->name('admin.delete-speditor');
    Route::get('/admin/view-speditors', 'SpeditorController@viewSpeditors')->name('admin.view-speditors');
});
Route::get('/logout', 'AdminController@logout')->name('logout');
