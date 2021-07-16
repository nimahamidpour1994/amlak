<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


// ******************************* CACHE *******************************
Route::prefix('cache')->group(function() {

    Route::get('/config', function () {
        $exit_code = Artisan::call('config:cache');
        return 'true';
    });

    Route::get('/view', function () {
        $exit_code = Artisan::call('view:cache');
        return 'true';
    });

    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });
});



// ******************************* API *******************************
Route::prefix('Api')->namespace('Api')->name('api.')->group(function() {

    // IN NAVBAR WHEN CITY CHANGE
    Route::post('/changeCity', 'LocationController@changeCity')->name('changeCity');

    // WHEN ADD ADVERTISMENT WHEN CITY CHANGE SO THE STATE NEED CHANGE
    Route::post('/changeState', 'LocationController@changeState')->name('changeState');

    // GET LAT AND LNG WHEN CITY OR STATE CHANGE
    Route::post('/getLocation', 'LocationController@getLocation')->name('getLocation');

    // LOAD ADVERTISMENT AND CATEGORY NAME
    Route::post('/moreAdvertisment', 'HomeController@MoreAdvertisment')->name('moreAdvertisment');
    Route::post('/SubCategoryName', 'HomeController@SubCategoryName')->name('subCategoryName');

    // ACTION DO IN DESKTOP
    Route::prefix('Desktop')->name('desktop.')->group(function() {

        Route::post('/changeCategory', 'DesktopHomeController@changeCategory')->name('changeCategory');
        Route::post('/nodeList', 'DesktopHomeController@nodeList')->name('nodeList');
        Route::post('/hoverSuggest', 'DesktopHomeController@hoverSuggest')->name('hoverSuggest');
        Route::post('/nodeListSuggest', 'DesktopHomeController@nodeListSuggest')->name('nodeListSuggest');
        Route::post('/search', 'DesktopHomeController@searchWord')->name('search');
    });

    // ACTION DO IN MOBILE
    Route::prefix('Mobile')->name('mobile.')->group(function() {
        Route::post('/changeCategory', 'MobileHomeController@changeCategory')->name('changeCategory');
        Route::post('/nodeList', 'MobileHomeController@nodeList')->name('nodeList');
        Route::post('/nodeListSuggest', 'MobileHomeController@nodeListSuggest')->name('nodeListSuggest');
        Route::post('/search', 'MobileHomeController@searchWord')->name('search');
    });

    // BOOK MARK
    Route::post('/mark/store','MarkController@store');

    // REPORT
    Route::post('/report/store', 'ReportController@store')->name('report.store');

    //UPLOAD IMAGE AND DELETE IN ADD ADVERTISMENT
    Route::prefix('Image')->name('image.')->group(function() {
        Route::post('/save', 'ImageController@save')->name('save');
        Route::post('/delete', 'ImageController@delete')->name('delete');
    });


    Route::post('/Blog/search', 'BlogController@search')->name('blog.search');

    // LIKE AND DISLIKE COMMENT
    Route::post('/Comment/like', 'CommentController@like')->name('comment.like');
    Route::post('/Comment/dislike', 'CommentController@dislike')->name('comment.dislike');

    // SENDCODE
    Route::get('/sendCode/{mobile}', 'LoginController@sendCode')->name('sendCode');

    // VERIFYAJAX
    Route::post('/submit_login_ajax', 'LoginController@submit_login_ajax')->name('submit.login');
});



// ******************************* APP *******************************
Route::namespace('App')->name('app.')->group(function() {

    // HOME
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/back', 'AdvertismentController@backUrl')->name('home.back');
    Route::get('/category/{id}', 'AdvertismentController@categoryBack')->name('home.category.back');
    Route::get('/category_state_desktop/{advertisment}', 'AdvertismentController@categoryStateBackDesktop')->name('desktop.home.category.state.back');
    Route::get('/category_state_mobile/{advertisment}', 'AdvertismentController@categoryStateBackMobile')->name('mobile.home.category.state.back');

    // SHOW ADVERTISMENT
    Route::get('/v/{slug}', 'AdvertismentController@show')->name('show.advertisment');


    // OTHER PAGE
    Route::get('/aboutus', 'AboutUsController@index')->name('aboutus');
    Route::get('/contactus', 'AboutUsController@contactus')->name('contactus');
    Route::get('/page/{slug}', 'PageController@index')->name('page');
    Route::get('/404', 'NotFoundController@index')->name('notfound');

    // BLOG
    Route::get('/blog/{slug}', 'BlogController@index')->name('blog');
    Route::get('/blog/article/{slug}', 'BlogController@show')->name('blog.show');
    Route::post('/blog/search', 'BlogController@search')->name('blog.search');


    Route::post('/comment/store', 'CommentController@store')->name('comment.store');
});



// ******************************* USER PANEL *******************************
Route::prefix('user')->namespace('User')->name('user.')->group(function() {

    // Verify login
    Route::post('/login/verfication', 'LoginController@submit_login')->name('verify.mobile');

    // DASHBOARD
    Route::get('/dashboard', 'AdvertismentController@index')->name('dashboard');

    // BELL
    Route::get('/bell/list', 'ListenBellController@index')->name('bell.list');
    Route::get('/bell/destroy/{bell}', 'ListenBellController@destroy')->name('bell.destroy');


    // RECENT SEEN
    Route::get('/recent-seen', 'ActivityController@recent_seen')->name('recentseen');

    // BOOKMARK
    Route::get('/bookmarks', 'ActivityController@bookmark')->name('bookmarks');
    Route::get('/bookmarks/destroy/{meta}', 'ActivityController@bookmark_destroy')->name('bookmark.destroy');

    // CHAT
    Route::prefix('chat')->name('chat.')->group(function() {
        Route::get('/create/{advertisment}', 'ChatController@create')->name('create');

        Route::get('/list', 'ChatController@index')->name('list');
        Route::get('/show/{id}', 'ChatController@show')->name('show');
        Route::post('/reply', 'ChatController@reply')->name('reply');
    });

    // ADVERTISMENT
    Route::prefix('advertisment')->name('advertisment.')->group(function() {

        // SEARCH
        Route::post('/search/', 'AdvertismentController@search')->name('search');

        // ADD
        Route::any('/add/{slug}', 'AdvertismentController@create')->name('add');
        Route::post('/store', 'AdvertismentController@store')->name('store');

        // PREVIEW
        Route::get('/preview/{advertisment}', 'AdvertismentController@show')->name('preview');

        // EDIT AND UPDATE
        Route::get('/edit/{slug}', 'AdvertismentController@edit')->name('edit');
        Route::post('/update/{advertisment}', 'AdvertismentController@update')->name('update');

        // DESTROY
        Route::get('/destroy/{advertisment}', 'AdvertismentController@destroy')->name('destroy');

    });

    // LISTEN BELL
    Route::prefix('listenbell')->name('listenbell.')->group(function() {

        // ADD
        Route::any('/add/{slug}', 'ListenBellController@create')->name('add');
        Route::post('/store', 'ListenBellController@store')->name('store');

    });

    // PLAN
    Route::prefix('advertisment')->name('order.')->group(function() {
        Route::get('/plan/{slug}', 'OrderController@create')->name('create');

        Route::post('/plan/store/{slug}', 'OrderController@store')->name('store');
        Route::any('/pay', 'PayController@callBackBank')->name('pay');
    });

});



// ******************************* ADMIN LOGIN *******************************
Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    // verfication code
});



// ******************************* ADMIN PANEL *******************************
Route::prefix('admin')->namespace('Admin')->middleware('auth:admin')->name('admin.')->group(function() {

     Route::get('/', 'IndexController@index');
     Route::get('/dashboard', 'IndexController@index')->name('dashboard');

    //*************** Category ******************
    Route::prefix('category')->name('category.')->group(function() {

        Route::get('list', 'CategoryController@index')->name('list');
        Route::get('show/{category}', 'CategoryController@show')->name('show');

        Route::get('add', 'CategoryController@create')->name('create');
        Route::post('stroe', 'CategoryController@store')->name('store');

        Route::get('edit/{category}', 'CategoryController@edit')->name('edit');
        Route::post('update/{category}', 'CategoryController@update')->name('update');

        Route::get('destroy/{category}', 'CategoryController@destroy')->name('destroy');
    });


    //*************** Form ******************
    Route::prefix('form')->name('form.')->group(function() {

        // list and create
        Route::get('list/{category}', 'FormController@create')->name('list');
        Route::post('store/', 'FormController@store')->name('store');

        // edit
        Route::get('edit/{form}', 'FormController@edit')->name('edit');
        Route::post('update/{form}', 'FormController@update')->name('update');

        // delete
        Route::get('/delete/{form}', 'FormController@destroy')->name('delete');
    });


    //*************** Filter ******************
    Route::prefix('filter')->name('filter.')->group(function() {
        Route::get('list/{form}', 'FilterController@show')->name('list');
        Route::post('add/{form}', 'FilterController@store')->name('add');
        Route::get('destroy/{id}', 'FilterController@destroy')->name('destroy');
    });


    // ****************** advertisment ******************
    Route::prefix('advertisment')->name('advertisment.')->group(function() {

        Route::get('list/{status}', 'AdvertismentController@index')->name('list');
        Route::any('search', 'AdvertismentController@search')->name('search');

        Route::get('preview/{advertisment}', 'AdvertismentController@show')->name('preview');

        Route::get('edit/{advertisment}', 'AdvertismentController@edit')->name('edit');
        Route::post('update/{advertisment}', 'AdvertismentController@update')->name('update');

        Route::get('destroy/{advertisment}', 'AdvertismentController@destroy')->name('destroy');

    });


    // ****************** report admin ******************
    Route::prefix('report')->name('report.')->group(function() {
        Route::get('/list', 'ReportController@index')->name('list');
        Route::get('/edit/{report}', 'ReportController@edit')->name('edit');
        Route::post('/update/{report}', 'ReportController@update')->name('update');

        Route::get('/add', 'ReportController@create')->name('create');
        Route::post('/store', 'ReportController@store')->name('store');
        Route::get('/destroy/{id}', 'ReportController@destroy')->name('destroy');
    });


    // ****************** plan ************************
    Route::prefix('plan')->name('plan.')->group(function() {
            Route::get('list', 'PlanController@index')->name('list');
            Route::get('edit/{plan}', 'PlanController@edit')->name('edit');
            Route::post('update/{plan}', 'PlanController@update')->name('update');
        });


    // ****************** city ************************
    Route::prefix('city')->name('city.')->group(function() {

            Route::get('list', 'CityController@index')->name('list');
            Route::post('store', 'CityController@store')->name('store');
            Route::get('edit/{city}', 'CityController@edit')->name('edit');
            Route::post('update/{city}', 'CityController@update')->name('update');
            Route::get('destroy/{city}', 'CityController@destroy')->name('destroy');

            Route::prefix('state')->name('state.')->group(function() {
                Route::get('list/{city}', 'StateController@show')->name('list');
                Route::post('store', 'StateController@store')->name('store');
                Route::get('edit/{state}', 'StateController@edit')->name('edit');
                Route::post('update/{state}', 'StateController@update')->name('update');
                Route::get('destroy/{state}', 'StateController@destroy')->name('destroy');
            });
        });


    // ****************** order ************************
    Route::prefix('order')->name('order.')->group(function() {
        Route::get('list/{pay}', 'OrderController@index')->name('list');
        Route::get('show/{order}', 'OrderController@show')->name('show');

    });

    //************ blog admin *************
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/list', 'BlogController@index')->name('list');
        Route::get('/add', 'BlogController@create')->name('create');
        Route::post('/store', 'BlogController@store')->name('store');
        Route::get('/edit/{id}', 'BlogController@edit')->name('edit');
        Route::post('/update/{id}', 'BlogController@update')->name('update');
        Route::get('/destroy/{id}', 'BlogController@destroy')->name('destroy');
    });

    //************ seo *************
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/list', 'SeoController@index')->name('list');
        Route::get('/show/{meta}', 'SeoController@show')->name('show');
        Route::post('/store/{meta}', 'SeoController@store')->name('store');
        Route::get('/destroy/{meta}', 'SeoController@destroy')->name('destroy');
    });

    //************ setting admin *************
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/edit', 'SettingController@edit')->name('edit');
        Route::post('/update', 'SettingController@update')->name('update');
    });

    // ****************** social ************************
    Route::prefix('social')->name('social.')->group(function() {
        Route::get('list', 'SocialController@index')->name('list');
        Route::post('store', 'SocialController@store')->name('store');
        Route::get('destroy/{setting}', 'SocialController@destroy')->name('destroy');
    });

    //************ otherpage admin *************
    Route::prefix('page')->name('page.')->group(function () {
        Route::get('/list', 'PageController@index')->name('list');
        Route::get('/edit/{category}', 'PageController@edit')->name('edit');
        Route::post('/update/{category}', 'PageController@update')->name('update');
    });

});




