<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/{resource}', ['uses' => 'PrincipalController@getDataCollection', 'middleware' => 'prueba']);
$router->get('/{resource}[/{id}]', ['uses' => 'UrlController@url']);
// $router->get('/{resource}/{id}', ['uses' => 'PrincipalController@getDataObject']);