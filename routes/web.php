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


Route::group(['prefix' => "check", 'middleware' => ['HasPermission_Check']], function(){
  Route::get("/new", "ControlPanelController@check_new");
});

Route::group(['prefix' => "person", 'middleware' => ['HasPermission_Person']], function(){
  Route::get("/new", "ControlPanelController@person_new");
  Route::post("/new", "ControlPanelController@person_new_post");
  Route::get("/list", "ControlPanelController@person_list");
  Route::get("/subscriptions", "ControlPanelController@subscription_list");


  Route::get("/dashboard/{id}", "ControlPanelController@person_dashboard");
  Route::get("/payment/confirm/{Person_id}/{Subscription_id}", "PaymentController@confirmSubscription")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  Route::get("/payment/cancel/{Person_id}/{Subscription_id}", "PaymentController@cancelSubscription")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  Route::post("/payment/newSubscription", "PaymentController@newSubscription")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
  Route::group(["prefix"=>"update"],function(){
    Route::post("/phone", "ControlPanelController@person_phone_save")->middleware(["HasPermission_Person"]);
    Route::post("/password", "ControlPanelController@person_password_save")->middleware(["HasPermission_Person"]);
    Route::post("/register", "ControlPanelController@person_register_save")->middleware(["HasPermission_Person"]);
    Route::post("/address", "ControlPanelController@person_address_save")->middleware(["HasPermission_Person"]);
    Route::post("/admin", "ControlPanelController@person_admin_save")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
    Route::get("/activate/{Person_id}", "ControlPanelController@person_activate_save")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
    Route::get("/disable/{Person_id}", "ControlPanelController@person_disable_save")->middleware(["HasPermission_Person", "HasPermission_Admin"]);
    Route::get("/sendConfirmation/{Person_id}", "ControlPanelController@person_sendConfirmation_save")->middleware(["HasPermission_Person"]);
  });

  Route::group(['prefix' => "check", 'middleware' => ['HasPermission_Check','HasPermission_Person','HasPermission_Admin']], function(){
    Route::get("/delete/{id}", "CheckController@removeCheck");
  });
});

Route::group(['prefix' => "label"], function(){
  Route::get("/qrcode/{qrcode}", "InscricaoController@qrcode");
  Route::get("/generate/2", "ControlPanelController@label_intern_generate_pending");
  Route::get("/list/generate/2", "ControlPanelController@assign_intern_generate_pending");
  Route::get("/generate/3", "ControlPanelController@label_intern_generate");
  Route::get("/list/generate/3", "ControlPanelController@assign_intern_generate");
  Route::post("/generate/one/{id}", "ControlPanelController@label_subscription_generate");
});

Route::group(['prefix' => "certificate"], function(){
  Route::get("/growChecks", "CertificateController@growChecks")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/growChecks/{id}", "CertificateController@growChecks")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/calculateHours", "CertificateController@calculateHours")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/calculateHours/{id}", "CertificateController@calculateHours")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/deleteParticipations", "CertificateController@deleteParticipations")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/deleteParticipations/{id}", "CertificateController@deleteParticipations")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/generate", "CertificateController@generateCertificates")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/generate/{id}", "CertificateController@generateCertificates")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/delete", "CertificateController@deleteCertificate")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
  Route::get("/delete/{id}", "CertificateController@deleteCertificate")->middleware(["HasPermission_Certificate","HasPermission_Admin"]);
});
