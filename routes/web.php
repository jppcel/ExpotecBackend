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
    Route::group(['prefix' => 'inscricao'], function(){
      Route::post('/new', 'InscricaoController@postNew');
      Route::get('/pessoa/{id}/{token}', 'InscricaoController@getPessoa');
      Route::post('/activate', 'InscricaoController@activateInscricao');
      Route::post('/pacote', 'InscricaoController@makeInscricao');
    });
    Route::group(['prefix' => 'trilha'], function(){
      Route::post('/list', 'TrilhaController@listAll');
    });
    Route::group(['prefix' => 'pacote'], function(){
      Route::post('/list', 'PacoteController@listAll');
    });
    Route::get('/states', 'CityController@listStates');
    Route::get('/cities/{id}', 'CityController@listCities');
  });
  Route::post('/pagseguro/notification', [
      'uses' => '\laravel\pagseguro\Platform\Laravel5\NotificationController@notification',
      'as' => 'pagseguro.notification',
  ]);
  Route::get('/pagseguro/redirect', ['uses' => 'CityController@listCities', 'as' => 'pagseguro.redirect']);
});
