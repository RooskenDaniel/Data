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

$router->get('json/voertuigen', 'voertuigenController@showAllevoertuigenJson');
$router->get('json/voertuigen/{kenteken}', 'voertuigenController@showEenvoertuigJson');
$router->post('json/voertuigen', 'voertuigenController@maakJson');
$router->delete('/voertuigen/{kenteken}', 'voertuigenController@delete');
$router->put('json/voertuigen/{kenteken}', 'voertuigenController@updateJson');

$router->get('json/assen', 'voertuigenController@showVoertuigenAssenJson');
$router->get('json/assen/{kenteken}', 'voertuigenController@showVoertuigenAssenJson');
$router->post('json/assen', 'voertuigenController@maakAssen');
$router->delete('/assen/{kenteken}', 'voertuigenController@deleteAssen');
$router->put('json/assen/{kenteken}', 'voertuigenController@updateAssenJson');

$router->get('json/brandstof', 'voertuigenController@showVoertuigenBrandstofJson');
$router->get('json/brandstof/{kenteken}', 'voertuigenController@showVoertuigenBrandstofJson');
$router->post('json/brandstof', 'voertuigenController@maakBrandstofJson');
$router->delete('/brandstof/{kenteken}', 'voertuigenController@deleteBrandstof');
$router->put('json/brandstof/{kenteken}', 'voertuigenController@updateBrandstof');


$router->get('xml/voertuigen', 'voertuigenController@showAllevoertuigenXml');
$router->get('xml/voertuigen/{kenteken}', 'voertuigenController@showEenvoertuigXml');
$router->post('xml/voertuigen', 'voertuigenController@maakXml');
$router->put('xml/voertuigen/{kenteken}', 'voertuigenController@update');

$router->get('xml/assen', 'voertuigenController@showVoertuigenAssenXml');
$router->get('xml/assen/{kenteken}', 'voertuigenController@showVoertuigenAssenXml');
$router->post('xml/assen', 'voertuigenController@maakAssen');
$router->put('xml/assen/{kenteken}', 'voertuigenController@updateAssenXml');

$router->get('xml/brandstof', 'voertuigenController@showVoertuigenBrandstofXml');
$router->get('xml/brandstof/{kenteken}', 'voertuigenController@showVoertuigenBrandstofXml');
$router->post('xml/brandstof', 'voertuigenController@maakBrandstofXml');
$router->put('xml/brandstof/{kenteken}', 'voertuigenController@updateBrandstof');
