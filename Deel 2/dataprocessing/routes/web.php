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

$router->get('/', function () use ($router)
{
    echo 'Welkom bij mijn api';
});

$router->get('/voertuigen', 'voertuigenController@showAllevoertuigen');
$router->get('/voertuigen/{kenteken}', 'voertuigenController@showEenvoertuig');
$router->post('/voertuigen', 'voertuigenController@maak');
$router->delete('/voertuigen/{kenteken}', 'voertuigenController@delete');
$router->put('/voertuigen/{kenteken}', 'voertuigenController@update');

$router->get('/assen', 'voertuigenController@showAllevoertuigenAssen');
$router->get('/assen/{kenteken}', 'voertuigenController@showAllevoertuigenAssen');
$router->post('/assen', 'voertuigenController@maakAssen');
$router->delete('/assen/{kenteken}', 'voertuigenController@deleteAssen');
$router->put('/assen/{kenteken}', 'voertuigenController@updateAssen');
