<?php

Route::post('/admin/login','Manage\MainController@login')->name('admin.login');


Route::group(['prefix' => LaravelLocalization::setLocale(),

'middleware' => ['localeSessionRedirect','localizationRedirect','localeViewPath']] ,  function()

{
    Route::prefix('manage')->group(function()
    {
        Route::get('/login' , function(){
            return view('manage.loginAdmin');
          });
          Route::group(['middleware' => 'roles' , 'roles' => ['SuperAdmin','Admin','rant','daleel','house']], function ()
          {



            Route::get('/logout/logout','Manage\MainController@logout')->name('user.logout');
            Route::get('/home', 'Manage\MainController@index')->name('admin.dashboard');

            // Profile Route
            Route::prefix('profile')->group(function()
            {
                Route::get('/index', 'Manage\profileController@index')->name('profile.index');
                Route::post('/index', 'Manage\profileController@update')->name('profile.update');
            });

            //Car_model routes
          Route::prefix('Car_model')->group(function () {
              Route::get('/index', 'Manage\Car_modelController@index')->name('Car_model.index');
              Route::get('/view', 'Manage\Car_modelController@view')->name('Car_model.view');
              Route::post('/store', 'Manage\Car_modelController@store')->name('Car_model.store');
              Route::get('/show/{id}', 'Manage\Car_modelController@show')->name('Car_model.show');
              Route::post('/update', 'Manage\Car_modelController@update')->name('Car_model.update');
              Route::get('/delete/{id}', 'Manage\Car_modelController@delete')->name('Car_model.delete');
              Route::get('/search', 'Manage\Car_modelController@search')->name('Car_model.search');
          });
            //Province routs
              Route::prefix('Province')->group(function () {
                  Route::get('/index', 'Manage\ProvinceController@index')->name('Province.index');
                  Route::get('/view', 'Manage\ProvinceController@view')->name('Province.view');
                  Route::post('/store', 'Manage\ProvinceController@store')->name('Province.store');
                  Route::get('/show/{id}', 'Manage\ProvinceController@show')->name('Province.show');
                  Route::post('/update', 'Manage\ProvinceController@update')->name('Province.update');
                  Route::get('/delete/{id}', 'Manage\ProvinceController@delete')->name('Province.delete');
                  Route::get('/search', 'Manage\ProvinceController@search')->name('Province.search');
              });

              //Workshop_type routs
              Route::prefix('Workshop_type')->group(function () {
                  Route::get('/index', 'Manage\Workshop_typeController@index')->name('Workshop_type.index');
                  Route::get('/view', 'Manage\Workshop_typeController@view')->name('Workshop_type.view');
                  Route::post('/store', 'Manage\Workshop_typeController@store')->name('Workshop_type.store');
                  Route::get('/show/{id}', 'Manage\Workshop_typeController@show')->name('Workshop_type.show');
                  Route::post('/update', 'Manage\Workshop_typeController@update')->name('Workshop_type.update');
                  Route::get('/delete/{id}', 'Manage\Workshop_typeController@delete')->name('Workshop_type.delete');
                  Route::get('/search', 'Manage\Workshop_typeController@search')->name('Workshop_type.search');
              });

              //Car_electration routs
              Route::prefix('Car_electration')->group(function () {
                  Route::get('/index', 'Manage\Car_electrationController@index')->name('Car_electration.index');
                  Route::get('/view', 'Manage\Car_electrationController@view')->name('Car_electration.view');
                  Route::post('/store', 'Manage\Car_electrationController@store')->name('Car_electration.store');
                  Route::get('/show/{id}', 'Manage\Car_electrationController@show')->name('Car_electration.show');
                  Route::post('/update', 'Manage\Car_electrationController@update')->name('Car_electration.update');
                  Route::get('/delete/{id}', 'Manage\Car_electrationController@delete')->name('Car_electration.delete');
                  Route::get('/search', 'Manage\Car_electrationController@search')->name('Car_electration.search');
              });

          });
    });
});

