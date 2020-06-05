<?php
/**
 * Web route file
 * php version 7.2
 *
 * @category Routes
 * @package  Kasabov
 * @author   Ilko Ivanov <ilko.iv@gmail.com>
 * @license  http://avalonbg.com Avalon Licence
 * @link     http://avalonbg.com
 */

Auth::routes();

// Frontend
Route::group(
    ['middleware' => ['frontUserLogin']],
    function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::match(['get', 'post'], '/home-settings', 'HomeController@settings')->name('home-settings');
        Route::get('/home-adds', 'HomeController@adds')->name('home-adds');
        Route::get('/home-favorites', 'HomeController@favorites')->name('home-favorites');
        Route::get('/favorite-delete/{product_id}/{user_id}', 'FavoriteController@deleteFavorite')->name('favorite-delete');
        Route::match(['get', 'post'], '/home-privacy', 'HomeController@privacy')->name('home-privacy');
        Route::post('/add-favorite', 'ProductController@addFavoriteProduct')->name('add-favorite');
        Route::get('/delete-user-image/{id}', 'HomeController@deleteUserImage')->name('delete-user-image');
        Route::post('/delete-user', 'HomeController@privacyDelete')->name('delete-user');
        Route::post('/add-order', 'OrderController@addOrder')->name('add-order');
        Route::get('/delete-order/{id}', 'OrderController@deleteOrder')->name('delete-order');
    }
);
Route::group(
    ['middleware' => ['frontFirmLogin']],
    function () {
        Route::get('/home-firm', 'HomeController@index_firm')->name('home-firm');
        Route::match(['get', 'post'], '/home-firm-settings', 'HomeController@firmSettings')->name('home-firm-settings');
        Route::get('/home-firm-adds/{payed}', 'HomeController@firmAdds')->name('home-firm-adds');
        Route::get('/home-firm-add-delete/{id}', 'HomeController@deleteFirmAdd')->name('home-firm-add-delete');
        Route::get('/home-firm-orders', 'HomeController@firmOrders')->name('home-firm-orders');
        Route::get('/home-firm-payments', 'PaymentsController@firmPayments')->name('home-firm-payments');
        Route::match(['get', 'post'], '/home-firm-payment-new', 'PaymentsController@addFirmPayment')->name('home-firm-payment-new');
        Route::get('/delete-firm-payment/{id}', 'PaymentsController@deleteFrontPayment')->name('delete-firm-payment');
        Route::match(['get', 'post'], '/home-firm-privacy', 'HomeController@firmPrivacy')->name('home-firm-privacy');
        Route::get('/delete-firm-order/{id}', 'OrderController@deleteFirmOrder')->name('delete-firm-order');
        Route::post('/delete-firm-user', 'HomeController@privacyFirmDelete')->name('delete-firm-user');
        Route::match(['get', 'post'], '/home-firm-product-edit/{id}', 'HomeController@firmProductEdit')->name('home-firm-product-edit');
        Route::match(['get', 'post'], '/home-firm-product-new', 'HomeController@firmProductNew')->name('home-firm-product-new');
        Route::get('/home-delete-product-image/{id}', 'HomeController@deleteProductImage')->name('home-delete-product-image');
        Route::match(['get', 'post'], '/home-add-product-images/{id}', 'HomeController@addImages')->name('home-add-product-images');
    }
);
Route::get('/logout-front-user', 'UsersController@logoutUser')->name('logout-front-user');
Route::get('/logout-front-firm', 'UsersController@logoutFirm')->name('logout-front-firm');

// Admin
Route::match(['get', 'post'], '/admin', 'AdminController@login')->name('admin');
Route::group(
    ['middleware' => ['auth']],
    function () {
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
        Route::post('/admin/populate-categories', 'CategoryController@populateCategories')->name('admin.populate-categories');
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
        Route::post('/admin/delete-products-tags', 'TagController@deleteProductsTags')->name('admin.delete-products-tags');
        // Product routes
        Route::match(['get', 'post'], '/admin/add-product', 'ProductController@addProduct')->name('admin.add-product');
        Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductController@editProduct')->name('admin.edit-product');
        Route::get('/admin/delete-product/{id}', 'ProductController@deleteProduct')->name('admin.delete-product');
        Route::get('/admin/view-products', 'ProductController@viewProducts')->name('admin.view-products');
        Route::get('/admin/delete-product-image/{id}', 'ProductController@deleteProductImage')->name('admin.delete-product-image');
        Route::get('/admin/check-product', 'ProductController@checkProduct');
        // Products Images routes
        Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductController@addImages')->name('admin.add-images');
        Route::get('/admin/delete-product-images/{id}', 'ProductController@deleteProductImages')->name('admin.delete-product-images');
        // Speditor routes
        Route::match(['get', 'post'], '/admin/add-speditor', 'SpeditorController@addSpeditor')->name('admin.add-speditor');
        Route::match(['get', 'post'], '/admin/edit-speditor/{id}', 'SpeditorController@editSpeditor')->name('admin.edit-speditor');
        Route::get('/admin/delete-speditor/{id}', 'SpeditorController@deleteSpeditor')->name('admin.delete-speditor');
        Route::get('/admin/view-speditors', 'SpeditorController@viewSpeditors')->name('admin.view-speditors');
        // City routes
        Route::match(['get', 'post'], '/admin/add-city', 'CityController@addCity')->name('admin.add-city');
        Route::match(['get', 'post'], '/admin/edit-city/{id}', 'CityController@editCity')->name('admin.edit-city');
        Route::get('/admin/delete-city/{id}', 'CityController@deleteCity')->name('admin.delete-city');
        Route::get('/admin/view-cities', 'CityController@viewCities')->name('admin.view-cities');
        // Firm routes
        Route::match(['get', 'post'], '/admin/add-firm', 'UsersController@addFirm')->name('admin.add-firm');
        Route::match(['get', 'post'], '/admin/edit-firm/{id}', 'UsersController@editFirm')->name('admin.edit-firm');
        Route::get('/admin/delete-firm/{id}', 'UsersController@deleteFirm')->name('admin.delete-firm');
        Route::get('/admin/view-firms', 'UsersController@viewFirms')->name('admin.view-firms');
        Route::get('/admin/delete-firm-image/{id}', 'UsersController@deleteFirmImage')->name('admin.delete-firm-image');
        Route::get('/admin/view-payments', 'PaymentsController@viewPayments')->name('admin.view-payments');
        Route::match(['get', 'post'], '/admin/add-payment', 'PaymentsController@addPayment')->name('admin.add-payment');
        Route::match(['get', 'post'], '/admin/edit-payment/{id}', 'PaymentsController@editPayment')->name('admin.edit-payment');
        Route::get('/admin/delete-payment/{id}', 'PaymentsController@deletePayment')->name('admin.delete-payment');
        // User routes
        Route::match(['get', 'post'], '/admin/add-user', 'UsersController@addUser')->name('admin.add-user');
        Route::match(['get', 'post'], '/admin/edit-user/{id}', 'UsersController@editUser')->name('admin.edit-user');
        Route::get('/admin/delete-user/{id}', 'UsersController@deleteUser')->name('admin.delete-user');
        Route::get('/admin/view-users', 'UsersController@viewUsers')->name('admin.view-users');
        Route::get('/admin/delete-user-image/{id}', 'UsersController@deleteUserImage')->name('admin.delete-user-image');
        // Orders routes
        Route::match(['get', 'post'], '/admin/edit-order/{id}', 'OrderController@editOrder')->name('admin.edit-order');
        Route::get('/admin/delete-order/{id}', 'OrderController@deleteAdminOrder')->name('admin.delete-order');
        Route::get('/admin/view-orders', 'OrderController@viewOrders')->name('admin.view-orders');
        // Reklama
        Route::match(['get', 'post'], '/admin/add-reklama', 'ReklamaController@addReklama')->name('admin.add-reklama');
        Route::match(['get', 'post'], '/admin/edit-reklama/{id}', 'ReklamaController@editReklama')->name('admin.edit-reklama');
        Route::get('/admin/delete-reklama/{id}', 'ReklamaController@deleteReklama')->name('admin.delete-reklama');
        Route::get('/admin/view-reklami', 'ReklamaController@viewReklami')->name('admin.view-reklami');
        Route::get('/admin/delete-reklama-image-small/{id}', 'ReklamaController@deleteReklamaImageSmall')->name('admin.delete-reklama-image-small');
        Route::get('/admin/delete-reklama-image-large/{id}', 'ReklamaController@deleteReklamaImageLarge')->name('admin.delete-reklama-image-large');
        // LandingPage routes
        Route::match(['get', 'post'], '/admin/edit-landing-page', 'IndexController@editLandingPage')->name('admin.edit-landing-page');
        Route::match(['get', 'post'], '/admin/edit-price-page', 'IndexController@editPricePage')->name('admin.edit-price-page');
        Route::match(['get', 'post'], '/admin/edit-payment-packages', 'IndexController@editPaymentPackages')->name('admin.edit-payment-packages');
        Route::match(['get', 'post'], '/admin/edit-maintenance-page', 'IndexController@editMaintenancePage')->name('admin.edit-maintenance-page');
        // Other pages
        Route::match(['get', 'post'], '/admin/edit-obshti-uslovia', 'PagesController@editObshtiUslovia')->name('admin.edit-obshti-uslovia');
        Route::match(['get', 'post'], '/admin/edit-politika', 'PagesController@editPolitika')->name('admin.edit-politika');
        Route::match(['get', 'post'], '/admin/edit-help', 'PagesController@editHelp')->name('admin.edit-help');
    }
);
Route::get('/logout', 'AdminController@logout')->name('logout');

// Frontend routes
//Maintenance
Route::get('/maintenance', 'IndexController@maintenance')->name('maintenance');

Route::get('/', 'IndexController@index')->name('index');
Route::match(['get', 'post'], '/products', 'ProductController@frontViewProducts')->name('products');
Route::get('/product/{id}', 'ProductController@frontGetProduct')->name('product');
Route::post('/like-product', 'ProductController@likeProduct')->name('like-product');
Route::get('/sms', 'IndexController@sms')->name('sms');
Route::get('/sms1', 'IndexController@sms1')->name('sms1');
Route::get('/sms2', 'IndexController@sms2')->name('sms2');
Route::post('/abonament', 'IndexController@abonament')->name('abonament');
Route::post('/contact', 'IndexController@contact')->name('contact');

// Users routes
Route::get('/users-login-register', 'UsersController@loginRegisterUsers')->name('users-login-register');
Route::post('/user-register', 'UsersController@registerUser')->name('user-register');
Route::post('/user-login', 'UsersController@loginUser')->name('user-login');
Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');

// Firms routes
Route::get('/firms-login-register', 'UsersController@loginRegisterFirms')->name('firms-login-register');
Route::post('/firm-register', 'UsersController@registerFirm')->name('firm-register');
Route::post('/firm-login', 'UsersController@loginFirm')->name('firm-login');

// Other routes
Route::get('/obshti-uslovia', 'PagesController@obshtiUslovia')->name('obshti-uslovia');
Route::get('/politika', 'PagesController@politika')->name('politika');
Route::get('/help', 'PagesController@help')->name('help');