<?php
use App\Http\Middleware\HasPermission_Person;
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

Route::group(['prefix' => "person", 'middleware' => ['HasPermission_Person']], function(){
  Route::get("/new", "ControlPanelController@person_new");
  Route::post("/new", "ControlPanelController@person_new_post");
  Route::get("/list", "ControlPanelController@person_list");


  Route::get("/dashboard/{id}", "ControlPanelController@person_dashboard");
  Route::get("/payment/confirm/{Person_id}/{Subscription_id}", "PaymentController@confirmSubscription")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  Route::get("/payment/cancel/{Person_id}/{Subscription_id}", "PaymentController@cancelSubscription")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  Route::group(["prefix"=>"update"],function(){
    Route::post("/phone", "ControlPanelController@person_phone_save")->middleware(["HasPermission_Person"]);
    Route::post("/password", "ControlPanelController@person_password_save")->middleware(["HasPermission_Person"]);
    Route::post("/register", "ControlPanelController@person_register_save")->middleware(["HasPermission_Person"]);
    Route::post("/address", "ControlPanelController@person_address_save")->middleware(["HasPermission_Person"]);
    Route::post("/admin", "ControlPanelController@person_admin_save")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  });
});

Route::group(['prefix' => "label"], function(){
  Route::get("/qrcode/{qrcode}", "InscricaoController@qrcode");
  Route::get("/intern_generate", "InscricaoController@label_intern_generate");
  Route::get("/generate", "ControlPanelController@label_generate");
});
