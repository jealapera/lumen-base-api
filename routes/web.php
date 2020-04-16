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

$router->get('/', function() use($router) {
    return $router->app->version();
});

// For generating key to set your own APP_KEY and JWT_SECRET on your .env file
$router->get('generate-key', function() {
    return response()->json(['key' => \Illuminate\Support\Str::random(32)], 200);
});

// Your APIs goes here...
$router->group(['prefix' => 'api'], function() use($router) {
    // Register
    $router->post('register', 'UserController@store');
    
    $router->post('/login', 'AuthController@authenticate');
    // $router->get('/logout', 'AuthController@logout');

    $router->group(['middleware' => 'jwt.auth'], function() use ($router) {
        // Admin
        $router->group(['prefix' => 'admin'], function() use($router) {
            // Endpoints intended for the Admin-User-Access" goes here. (Only if necessary)
        }); 

        $router->get('todos', 'TodoController@index');
        $router->post('todos', 'TodoController@store');
        $router->get('todo/{id}', 'TodoController@show');
        $router->put('todo/{id}', 'TodoController@update');
        $router->delete('todo/{id}', 'TodoController@destroy');

        // Gets all todos with user (Can also override @index method on TodoController)
        $router->get('user-todos', 'TodoController@getAllTodosWithUser');
    });
});