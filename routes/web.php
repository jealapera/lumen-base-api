<?php

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


$router->post('login', 'UserController@authenticate');

$router->group(['prefix' => 'admin'], function() use($router) {
    // Users
    $router->post('users', 'UserController@store');
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserController@destroy');
});

$router->group(['prefix' => 'user'], function() use($router) {
    // Users
    $router->post('todos', 'TodoController@store');
    $router->get('todos', 'TodoController@index');
    $router->get('todos/{id}', 'TodoController@show');
    $router->put('todos/{id}', 'TodoController@update');
    $router->delete('todos/{id}', 'TodoController@destroy');
});