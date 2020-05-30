<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

header('Content-Type: application/json; charset=UTF-8', true);


/** Start Auth Route **/

Route::middleware('auth:api')->group(function () {
    //Auth_private
    Route::prefix('Auth_private')->group(function()
    {
        Route::post('/change_password', 'Api\UserController@change_password')->name('user.change_password');
        Route::post('/edit_profile', 'Api\UserController@edit_profile')->name('user.edit_profile');
        Route::get('/my_info', 'Api\UserController@my_info')->name('user.my_info');
        Route::post('/resend_code', 'Api\UserController@resend_code')->name('user.resend_code');
        Route::post('/logout', 'Api\UserController@logout')->name('user.logout');
        Route::post('/check_code', 'Api\UserController@check_code')->name('user.check_code');
        Route::post('/change_lang', 'Api\UserController@change_lang')->name('user.change_lang');
    });

    /** home_service Route */
    Route::prefix('home_service')->group(function()
    {
        Route::get('/car_electrician', 'Api\Home_serviceController@car_electrician')->name('home_service.car_electrician');
        Route::get('/home_services/{car_electrician_id}', 'Api\Home_serviceController@home_services')->name('home_service.home_services');
        Route::post('/rate/{service_id}', 'Api\Home_serviceController@rate')->name('home_service.rate');
        Route::get('/single_home_services/{service_id}', 'Api\Home_serviceController@single_home_services')->name('home_service.single_home_services');
    });

    /** industrial Route */
    Route::prefix('industrial')->group(function()
    {
        Route::get('/Province', 'Api\IndustrialController@Province')->name('industrial.Province');
        Route::get('/car_models', 'Api\IndustrialController@car_models')->name('industrial.car_models');
        Route::get('/work_shops', 'Api\IndustrialController@work_shops')->name('industrial.work_shops');
        Route::get('/industrial_services', 'Api\IndustrialController@industrial_services')->name('industrial.industrial_services');
        Route::get('/single_industrial_services/{service_id}', 'Api\IndustrialController@single_industrial_services')
            ->name('industrial.single_industrial_services');
        Route::post('/rate/{service_id}', 'Api\IndustrialController@rate')->name('industrial.rate');

    });

    /** live_services Route */
    Route::prefix('live_services')->group(function()
    {
        Route::get('/live_services', 'Api\LiveServiceController@live_services')->name('live_services.live_services');
        Route::get('/single_live_services/{service_id}', 'Api\LiveServiceController@single_live_services')
            ->name('live_services.single_live_services');
        Route::post('/rate/{service_id}', 'Api\LiveServiceController@rate')->name('live_services.rate');

    });

});
/** End Auth Route **/

//general Auth
Route::prefix('Auth_general')->group(function()
{
    Route::post('/register', 'Api\UserController@register')->name('user.register');
    Route::post('/login', 'Api\UserController@login')->name('user.login');
    Route::get('/check_virfuy/{id}', 'Api\UserController@check_virfuy')->name('user.check_virfuy');
    Route::post('/forget_password', 'Api\UserController@forget_password')->name('user.forget_password');
    Route::post('/reset_password', 'Api\UserController@reset_password')->name('user.reset_password');
    Route::post('/delete_user/{id}', 'Api\UserController@delete_user')->name('user.delete_user');

});