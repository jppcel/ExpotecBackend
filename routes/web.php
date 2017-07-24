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

Route::get("/", "ControlPanelController@index");
Route::get("/login", "AdminController@login");
Route::get("/logout", "AdminController@logout");
Route::post("/login", "AdminController@logar");

Route::group(['prefix' => "person"], function(){
  Route::get("/new", "ControlPanelController@person_new");
  Route::get("/list", "ControlPanelController@person_list");
});
