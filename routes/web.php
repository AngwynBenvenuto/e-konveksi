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

/* User */
Auth::routes();
Route::get('/auth/register_success', 'Auth\RegisterController@registerSuccess')->name('auth.register_success');
Route::match(array('GET', 'POST'), '/auth/password/reset', 'Auth\ForgotPasswordController@forgotPasswordForm')->name('auth.password.reset');
Route::match(array('GET', 'POST'), '/auth/password/reset/{token}', 'Auth\ResetPasswordController@resetPasswordForm')->name('auth.password.change');
Route::get('/auth/verify', 'Auth\VerificationController@sendVerification')->name('auth.verify.send');
Route::get('/auth/verify/{token}', 'Auth\VerificationController@confirmVerification')->name('auth.verify.confirm');

//front route custom
Route::namespace('Front')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/test', 'HomeController@testdirect');

    //page
    Route::prefix('/page')->group(function() {
        Route::get('/intro', 'PagesController@intro')->name('page.intro');
        Route::get('/terms', 'PagesController@terms')->name('page.terms');
        Route::get('/faq', 'PagesController@faq')->name('page.faq');
        Route::get('/privacy', 'PagesController@privacy')->name('page.privacy');
        Route::get('/contact', 'PagesController@contact')->name('page.contact');
        Route::get('/about', 'PagesController@about')->name('page.about');
    });

    //project
    Route::match(array('GET', 'POST'), '/project', 'ProjectController@index')->name('project');
    Route::get('/project/view/{url}', 'ProjectController@detail')->name('project.view');
    Route::match(array('GET', 'POST'), '/bid/{param}/create', 'ProjectController@bid')->name('project.bid')->middleware('auth');
    Route::get('ikm/{id}/detail', 'ProjectController@ikm_detail')->name('ikm.view');

    //nego
    // Route::match(array('GET', 'POST'), '/nego/{param}/create', 'ProjectController@nego')->name('project.nego');
    // Route::match(array('GET', 'POST'), '/nego/approve', 'ProjectController@negoApprove')->name('project.nego.approve');
    // Route::match(array('GET', 'POST'), '/nego/last', 'ProjectController@negoLast')->name('project.nego.last');

    Route::group(['middleware' => 'auth', 'revalidate'], function() {
        // Route::group(['prefix' => '/checkout', 'namespace' => 'Checkout'], function() {
        //     Route::get('/', 'AddressController@index')->name('checkout');
        //     Route::get('/address', 'AddressController@index')->name('checkout.address');
        //     Route::post('/address/store', 'AddressController@store')->name('checkout.address.store');
        //     Route::get('/shipping', 'ShippingController@index')->name('checkout.shipping');
        //     Route::post('/shipping/store', 'ShippingController@store')->name('checkout.shipping.store');
        //     Route::get('/payment', 'PaymentController@index')->name('checkout.payment');
        // });

        //user
        Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/user/update', 'AccountController@update')->name('user.update');
        Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/user/change_password', 'AccountController@changePassword')->name('user.change_password');
        Route::group(['namespace' => 'Account', 'prefix' => '/user'], function() {
            //address
            Route::match(array('GET', 'POST'), '/address', 'AddressController@index')->name('user.address');
            Route::match(array('GET', 'POST'), '/address/create', 'AddressController@create')->name('user.address.create');
            Route::match(array('GET', 'POST'), '/address/edit/{billingAddressId}/{shippingAddressId?}', 'AddressController@edit')->name('user.address.edit');
            Route::match(array('GET', 'POST'), '/address/delete/{billingAddressId}/{shippingAddressId?}', 'AddressController@delete')->name('user.address.delete');
            Route::match(array('GET', 'POST'), '/address/setmain/{billingAddressId}/{shippingAddressId?}', 'AddressController@setmain')->name('user.address.setmain');

            //transaksi
            Route::match(array('GET', 'POST'), '/transaksi', 'TransactionController@list')->name('transaction.list');
            //Route::match(array('GET', 'POST'), '/transaksi/table', 'TransactionController@transaksiList')->name('transaction.list.table');
            //Route::match(array('GET', 'POST'), '/transaksi/{transaksi_id}/show', 'TransactionController@transaksiShow')->name('transaction.show');
            //Route::post('/transaksi/{transaksi_id}/approve', 'TransactionController@approve')->name('transaction.approve');
            //Route::match(array('GET', 'POST'), '/transaction/print_form_kerjasama', 'TransactionController@print_form_kerjasama')->name('print_form_kerjasama');
            //Route::match(array('GET', 'POST'), '/transaksi/update_progress', 'TransactionController@updateProgress')->name('transaction.progress');
            //Route::match(array('GET', 'POST'), '/transaction/checkout', 'TransactionController@checkout')->name('transaction.checkout');
            //Route::post('/transaksi/{transaksi_id}/confirm_transfer', 'TransactionController@confirm_transfer')->name('transaction.confirm_transfer');
            //Route::post('/detail_checkout', 'TransactionController@detail_checkout')->name('detail_checkout');

            //penawaran
            Route::match(array('GET', 'POST'), '/offer', 'OfferController@offer')->name('transaction.offer');
            //Route::match(array('GET', 'POST'), '/offer/table', 'OfferController@offerList')->name('transaction.offer.table');
            //Route::match(array('GET', 'POST'), '/offer/{offer_id}/show', 'OfferController@offerShow')->name('offer.show');
            //Route::match(array('GET', 'POST'), '/offer/{offer_id}/approve', 'OfferController@approve')->name('offer.approve');
            //Route::match(array('GET', 'POST'), '/offer/kerja_sama', 'OfferController@kerja_sama')->name('offer.kerja_sama');
        });

        //penjahit
        //Route::match(array('GET', 'POST'), '/transaksi/save_session', 'PenjahitActionController@transaksi_session')->name('transaksi_session');

        //checkout
        Route::prefix('/checkout')->group(function() {
            Route::match(array('GET', 'POST'), '/address', 'CheckoutController@address')->name('checkout.address');
            Route::match(array('GET', 'POST'), '/shipping', 'CheckoutController@shipping')->name('checkout.shipping');
            Route::match(array('GET', 'POST'), '/payment', 'CheckoutController@payment')->name('checkout.payment');
        });
    });

    //chat
    //Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/getChat', 'ChatController@getChat')->name('chat.all');
    //Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/sendChat', 'ChatController@sendChat')->name('chat.send');
});
Route::prefix('/penjahit')->group(function() {
    Route::group(['middleware' => 'auth', 'revalidate'], function() {
        Route::match(array('GET', 'POST'), '/review', 'Action\PenjahitActionController@review')->name('review');
    });
});



/* ADMIN ROUTE */
Route::prefix('/admin')->name('admin.')->group(function() {
    Route::group([], function() {
        Route::get('/login','Admin\Auth\LoginController@showLoginForm')->name('login');
        Route::post('/login','Admin\Auth\LoginController@login');
        Route::get('/logout','Admin\Auth\LoginController@logout')->name('logout');
        Route::get('/forgot/password','Admin\Auth\ForgotPasswordController@requestForget')->name('forgot');
        Route::get('/reset/password/{token}','Admin\Auth\ResetPasswordController@requestChangePassword')->name('forgot.password');
        Route::get('/reset/success','Admin\Auth\ResetPasswordController@success')->name('forgot.success');
        Route::get('/reset/fail','Admin\Auth\ResetPasswordController@fail')->name('forgot.fail');

    });

    Route::middleware('admin', 'revalidate')->group(function(){
        Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
        Route::match(array('GET', 'POST'), '/list', 'Admin\DashboardController@list');
        Route::match(array('GET', 'POST'), '/chat', 'Admin\DashboardController@chat')->name('chat');

        //master
        Route::prefix('/master')->group(function() {
            //project
            Route::get('project', 'Admin\Master\ProjectController@index')->name('master.project');
            Route::get('project/show', 'Admin\Master\ProjectController@show')->name('master.project.show');
            Route::match(array('GET', 'POST'), 'project/create', 'Admin\Master\ProjectController@create')->name('master.project.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'project/{product_id}/edit', 'Admin\Master\ProjectController@edit')->name('master.project.edit');
            Route::match(array('GET','POST'), 'project/image/upload', 'Admin\Master\ProjectController@upload')->name('master.project.image.upload');
            Route::match(array('GET','POST'), 'project/image/delete', 'Admin\Master\ProjectController@delete')->name('master.project.image.delete');

            //ikm
            Route::get('ikm', 'Admin\Master\IkmController@index')->name('master.ikm');
            Route::get('ikm/all', 'Admin\Master\IkmController@ikmList')->name('master.ikm.list');
            Route::match(array('GET', 'POST'), 'ikm/{ikm_id}/show', 'Admin\Master\IkmController@ikmShow')->name('master.ikm.show');
            Route::match(array('GET', 'POST'), 'ikm/create', 'Admin\Master\IkmController@create')->name('master.ikm.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'ikm/{ikm_id}/edit', 'Admin\Master\IkmController@edit')->name('master.ikm.edit');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'ikm/{ikm_id}/delete', 'Admin\Master\IkmController@delete')->name('master.ikm.delete');

            //bank
            Route::get('bank', 'Admin\Master\BankController@index')->name('master.bank');
            Route::get('bank/show', 'Admin\Master\BankController@show')->name('master.bank.show');
            Route::match(array('GET', 'POST'), 'bank/create', 'Admin\Master\BankController@create')->name('master.bank.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'bank/{bank_id}/edit', 'Admin\Master\BankController@edit')->name('master.bank.edit');
            
            //barang
            Route::get('barang', 'Admin\Master\BarangController@index')->name('master.barang');
            Route::get('barang/show', 'Admin\Master\BarangController@show')->name('master.barang.show');
            Route::match(array('GET', 'POST'), 'barang/create', 'Admin\Master\BarangController@create')->name('master.barang.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'barang/{barang_id}/edit', 'Admin\Master\BarangController@edit')->name('master.barang.edit');

            Route::get('courier', 'Admin\Master\CourierController@index')->name('master.courier');
            Route::get('courier/show', 'Admin\Master\CourierController@show')->name('master.courier.show');
            Route::match(array('GET', 'POST'), 'courier/create', 'Admin\Master\CourierController@create')->name('master.courier.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'courier/{courier_id}/edit', 'Admin\Master\CourierController@edit')->name('master.courier.edit');

            //kota
            Route::get('kota', 'Admin\Master\CityController@index')->name('master.kota');
            Route::get('kota/show', 'Admin\Master\CityController@show')->name('master.kota.show');
            Route::match(array('GET', 'POST'), 'kota/create', 'Admin\Master\CityController@create')->name('master.kota.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'kota/{kota_id}/edit', 'Admin\Master\CityController@edit')->name('master.kota.edit');
            // Route::match(array('GET', 'POST'), 'kota/generate', 'Admin\Master\CityController@generate_city_data')->name('master.kota.generate');

            //provinsi
            Route::get('provinsi', 'Admin\Master\ProvinceController@index')->name('master.provinsi');
            Route::get('provinsi/show', 'Admin\Master\ProvinceController@show')->name('master.provinsi.show');
            Route::match(array('GET', 'POST'), 'provinsi/create', 'Admin\Master\ProvinceController@create')->name('master.provinsi.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'provinsi/{provinsi_id}/edit', 'Admin\Master\ProvinceController@edit')->name('master.provinsi.edit');

            //jasa pengiriman
            Route::get('jasa', 'Admin\Master\JasaController@index')->name('master.jasa');
            Route::get('jasa/show', 'Admin\Master\JasaController@show')->name('master.jasa.show');
            Route::match(array('GET', 'POST'), 'jasa/create', 'Admin\Master\JasaController@create')->name('master.jasa.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'jasa/{jasa_id}/edit', 'Admin\Master\JasaController@edit')->name('master.jasa.edit');
        });

        //cms
        Route::prefix('/cms')->group(function() {
            //cms page
            Route::match(array('GET','POST'), 'page/about', 'Admin\CMS\Page\CmsAboutController@create')->name('cms.page.about');
            Route::match(array('GET','POST'), 'page/contact', 'Admin\CMS\Page\CmsContactController@create')->name('cms.page.contact');
            Route::match(array('GET','POST'), 'page/privacy', 'Admin\CMS\Page\CmsPrivacyController@create')->name('cms.page.privacy');
            Route::match(array('GET','POST'), 'page/terms', 'Admin\CMS\Page\CmsTermsController@create')->name('cms.page.terms');

            //cms slide
            Route::match(array('GET','POST'), 'home/slide', 'Admin\CMS\Home\CmsSlideController@create')->name('cms.home.slide');
            Route::match(array('GET','POST'), 'home/slide/upload', 'Admin\CMS\Home\CmsSlideController@upload')->name('cms.home.slide.upload');
            Route::match(array('GET','POST'), 'home/slide/delete', 'Admin\CMS\Home\CmsSlideController@delete')->name('cms.home.slide.delete');
            Route::match(array('GET','POST'), 'home/slide/init', 'Admin\CMS\Home\CmsSlideController@init')->name('cms.home.slide.init');
        });

        //penawaran
        Route::get('/offer', 'Admin\OfferController@offer')->name('transaction.offer');
        // Route::match(array('GET', 'POST'), '/offer/all', 'Admin\OfferController@offerList')->name('offer.showall');
        // Route::match(array('GET', 'POST'), '/offer/{offer_id}/show', 'Admin\OfferController@offerShow')->name('offer.show');
        // Route::post('/offer/{offer_id}/approve', 'Admin\OfferController@approve')->name('offer.approve');
        // Route::match(array('GET', 'POST'), '/offer/{offer_id}/getPenawaran', 'Admin\OfferController@getPenawaran')->name('offer.getPenawaran');
        // Route::post('/offer/{offer_id}/cancel', 'Admin\OfferController@cancel')->name('offer.cancel');


        //transaction
        Route::get('/transaksi', 'Admin\TransactionController@list')->name('transaction.list');
        //Route::get('/transaksi', 'Admin\TransactionController@list')->name('transaction');
        //Route::match(array('GET', 'POST'), '/transaksi/table', 'Admin\TransactionController@transaksiList')->name('transaction.showall');
        //Route::match(array('GET', 'POST'), '/transaksi/{transaksi_id}/show', 'Admin\TransactionController@transaksiShow')->name('transaction.show');
        //Route::post('/transaksi/{transaksi_id}/approve', 'Admin\TransactionController@approve')->name('transaction.approve');
        //Route::post('/transaksi/{transaksi_id}/upload_transfer', 'Admin\TransactionController@upload_transfer')->name('transaction.upload_transfer');
        //Route::match(array('GET', 'POST'), '/transaction/checkout', 'Admin\TransactionController@checkout')->name('transaction.checkout');
        //Route::match(array('GET', 'POST'), '/transaction/check_review', 'Admin\TransactionController@checkReview')->name('transaction.check_review');


        //setting
        Route::prefix('/setting')->group(function() {
            //user
            Route::get('user', 'Admin\Setting\UserController@index')->name('setting.user');
            Route::get('user/show', 'Admin\Setting\UserController@show')->name('setting.user.show');
            Route::match(array('GET', 'POST'), 'user/create', 'Admin\Setting\UserController@create')->name('setting.user.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'user/{user_id}/edit', 'Admin\Setting\UserController@edit')->name('setting.user.edit');

            //role
            Route::get('role', 'Admin\Setting\RoleController@index')->name('setting.role');
            Route::get('role/show', 'Admin\Setting\RoleController@show')->name('setting.role.show');
            Route::match(array('GET', 'POST'), 'role/create', 'Admin\Setting\RoleController@create')->name('setting.role.create');
            Route::match(array('GET', 'POST', 'PUT', 'PATCH'), 'role/{user_id}/edit', 'Admin\Setting\RoleController@edit')->name('setting.role.edit');
        });

        //ikm
        Route::get('penjahit/{id}/show', 'Action\IkmActionController@penjahit_detail')->name('penjahit.view');
        Route::match(array('GET','POST'), 'penjahit/{id}/hire', 'Action\IkmActionController@hire')->name('hire');
        Route::get('project/{id}/show', 'Action\IkmActionController@project_detail')->name('project.view');
        //Route::match(array('GET', 'POST'), '/kerjasama/save_session', 'Admin\IkmActionController@kerjasama_session')->name('kerjasama_session');
        Route::match(array('GET', 'POST'), '/kerjasama', 'Action\IkmActionController@kerjasama')->name('kerjasama');
        //Route::match(array('GET', 'POST'), '/review/save_session', 'Admin\IkmActionController@review_session')->name('review_session');
        //Route::match(array('GET', 'POST'), '/review', 'Admin\IkmActionController@insert_review')->name('review');
        Route::match(array('GET', 'POST'), '/review', 'Action\IkmActionController@review')->name('review');
        Route::match(array('GET', 'POST'), '/{project_data_id}/project_data', 'Action\IkmActionController@project_data')->name('project_data');
        Route::match(array('GET', 'POST'), '/{project_data_id}/project_data_detail', 'Action\IkmActionController@project_data_detail')->name('project_data_detail');

        //transaksi ikm
        Route::get('/ikm/transaksi', 'Action\IkmActionController@transaksi_ikm')->name('transaksi.ikm');
        //Route::match(array('GET','POST'),'/ikm/transaksi/byid', 'Admin\IkmActionController@transaksi_ikm_byid')->name('transaksi.ikm.byid');
        //Route::match(array('GET','POST'),'/ikm/transaksi/upload', 'Admin\IkmActionController@transaksi_ikm_upload_transfer')->name('transaksi.ikm.upload_transfer');

        //penawaran ikm
        Route::get('/ikm/penawaran', 'Action\IkmActionController@penawaran_ikm')->name('penawaran.ikm');
        //Route::match(array('GET','POST'),'/ikm/penawaran/byid', 'Admin\IkmActionController@penawaran_ikm_byid')->name('penawaran.ikm.byid');
        //Route::match(array('GET','POST'),'/ikm/penawaran/get_data_forchat', 'Admin\IkmActionController@penawaran_ikm_getdata')->name('penawaran.ikm.get_data');
        //Route::match(array('GET','POST'),'/ikm/penawaran/approve', 'Admin\IkmActionController@penawaran_ikm_approve')->name('penawaran.ikm.approve');
        //Route::match(array('GET','POST'),'/ikm/penawaran/cancel', 'Admin\IkmActionController@penawaran_ikm_cancel')->name('penawaran.ikm.cancel');

        //system & account
        Route::match(array('GET', 'POST'), '/system', 'Admin\AccountController@systemRate')->name('setting.system');
        Route::match(array('GET', 'POST'), '/change_password', 'Admin\AccountController@changePassword')->name('setting.change_password');
        Route::match(array('GET', 'POST'), '/profile', 'Admin\AccountController@profile')->name('setting.profile');

        //checkout
        Route::prefix('/checkout')->group(function() {
            Route::match(array('GET', 'POST'), '/address', 'Admin\CheckoutController@address')->name('checkout.address');
            Route::match(array('GET', 'POST'), '/shipping', 'Admin\CheckoutController@shipping')->name('checkout.shipping');
            Route::match(array('GET', 'POST'), '/payment', 'Admin\CheckoutController@payment')->name('checkout.payment');
        });


        //chat
        //Route::match(array('GET', 'POST'), '/chat/send', 'ChatController@chatSend')->name('chat.send');
        //Route::match(array('GET', 'POST'), '/chat/list', 'ChatController@chatList')->name('chat.list');//list user sender
        //Route::match(array('GET', 'POST'), '/chat/user', 'ChatController@chatUser')->name('chat.user');//show user by id
        //Route::match(array('GET', 'POST'), '/chat/message', 'ChatController@chatMessage')->name('chat.message');//show message by id
    });
});
