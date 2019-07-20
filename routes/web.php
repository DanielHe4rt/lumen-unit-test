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

$router->get('/users','UserController@getUsers');
$router->post('/users','UserController@postUser');
$router->get('/users/{id}','UserController@getUser');
$router->put('/users/{id}','UserController@putUser');
$router->delete('/users/{id}','UserController@deleteUser');
