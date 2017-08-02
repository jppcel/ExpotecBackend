<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'web'], function(){
  Route::group(['prefix' => 'subscription'], function(){
    Route::post('/new', 'InscricaoController@postNew');
    Route::get('/person/{id}/{token}', 'InscricaoController@getPessoa');
    Route::post('/activate', 'InscricaoController@activateInscricao');
    Route::post('/package', 'InscricaoController@makeInscricao');
    Route::get('/zip', 'InscricaoController@listZips');
    Route::group(['prefix' => 'cart'], function(){
      Route::post('/add', 'CartController@new');
      Route::post('/delete', 'CartController@delete');
      Route::post('/get', 'CartController@get');
    });
  });
  Route::group(['prefix' => 'track'], function(){
    Route::post('/list', 'TrilhaController@listAll');
  });
  Route::group(['prefix' => 'package'], function(){
    Route::post('/list', 'PacoteController@listAll');
    Route::post('/listByEvent', 'EventController@listEvents');
    Route::post('/byCoupon', 'PacoteController@getPackageByCoupon');
  });
  Route::get('/states', 'CityController@listStates');
  Route::get('/cities/{id}', 'CityController@listCities');

  Route::group(['prefix' => 'zip'], function(){
    Route::get('/search/{ZIP}', 'ZIPController@search');
  });

  Route::get('/typestreet/list', 'AddressController@listTypeStreet');

  Route::post('/login', 'LoginController@toLogin');
  Route::post('/logout', 'LoginController@toLogout');
  Route::post('/request_reset_password', 'LoginController@askNewPassword');
  Route::post('/reset_password', 'LoginController@setNewPassword');

  Route::group(['prefix' => 'payment'], function(){
    Route::get('/getPagseguroPayments', 'PaymentController@getAllPagseguroPayments');
    Route::get('/searchPayments', 'PaymentController@searchPendingPayments');
    Route::post('/getReturn', 'PaymentController@getReturnPayment');
  });
});
Route::group(['prefix' => 'mobile'], function(){
  Route::group(['prefix' => 'events'], function(){
    Route::get("/", "CheckController@getEvents");
    Route::post("/subscriptions", "CheckController@getSubscriptions");
  });
  Route::group(['prefix' => 'check'], function(){
    Route::group(['prefix' => 'new'], function(){
      Route::post("/", "CheckController@newCheck");
      Route::post("/list", "CheckController@listCheck");
    });
  });
});
