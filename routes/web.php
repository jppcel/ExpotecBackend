<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'api'], function(){
  Route::group(['prefix' => 'web'], function(){
    Route::group(['prefix' => 'subscription'], function(){
      Route::post('/new', 'InscricaoController@postNew');
      Route::get('/person/{id}/{token}', 'InscricaoController@getPessoa');
      Route::post('/activate', 'InscricaoController@activateInscricao');
      Route::post('/package', 'InscricaoController@makeInscricao');
      Route::get('/city', 'InscricaoController@listCities');
    });
    Route::group(['prefix' => 'track'], function(){
      Route::post('/list', 'TrilhaController@listAll');
    });
    Route::group(['prefix' => 'package'], function(){
      Route::post('/list', 'PacoteController@listAll');
    });
    Route::get('/states', 'CityController@listStates');
    Route::get('/cities/{id}', 'CityController@listCities');

    Route::group(['prefix' => 'zip'], function(){
      Route::get('/search/{ZIP}', 'ZIPController@search');
    });

    Route::post('/login', 'LoginController@toLogin');
    Route::post('/logout', 'LoginController@toLogout');

    Route::group(['prefix' => 'payment'], function(){
      Route::post('/searchPayments', 'PaymentController@searchPendingPayments');
    });
  });
});
