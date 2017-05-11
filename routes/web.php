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
    });
    Route::get('/states', 'CityController@listStates');
    Route::get('/cities/{id}', 'CityController@listCities');
  });
});
