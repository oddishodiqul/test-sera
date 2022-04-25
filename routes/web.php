<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


Route::group(['prefix' => 'api'], function ($router) {
    Route::get('index', 'UserController@index');
    Route::get('show/{id}', 'UserController@show');
    Route::get('denom', 'UserController@denom');
    
    Route::post('store', 'UserController@create');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('check-login', 'AuthController@check');

    Route::post('reqres-register', 'UserController@reqres_register');
    Route::post('reqres-login', 'UserController@reqres_login');

    Route::put('update/{id}', 'UserController@update');
    
    Route::delete('delete/{id}', 'UserController@delete');
});