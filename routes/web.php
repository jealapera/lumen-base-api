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

$router->get('/', function() use ($router) {
    return $router->app->version();
});

// $router->post('/login', 'AuthController@login');
// $router->get('/logout', 'AuthController@logout');

$router->group(['prefix' => 'admin'], function() use($router) {
    // Users
    $router->post('users', 'UserController@store');
    $router->get('users', 'UserController@index');
    $router->get('user/{id}', 'UserController@show');
    $router->put('user/{id}', 'UserController@update');
    $router->delete('user/{id}', 'UserController@destroy');
});

$router->get('user/{id}/todos-list', 'UserController@getUserTodosList');

$router->group(['prefix' => 'user'], function() use($router) {
    // Users
    $router->post('todos', 'TodoController@store');
    $router->get('todos', 'TodoController@index');
    $router->get('todo/{id}', 'TodoController@show');
    $router->put('todo/{id}', 'TodoController@update');
    $router->delete('todo/{id}', 'TodoController@destroy');
});

$router->get('users/todos-list', 'TodoController@getAllTodosWithUser');