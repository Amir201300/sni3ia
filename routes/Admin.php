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



        });
    });
});

