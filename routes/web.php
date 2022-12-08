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

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', ['uses'=> 'authController@register']);
    $router->post('/login', ['uses'=> 'authController@login']);

});

$router->group(['prefix' => 'mahasiswa'], function () use ($router) {
    $router->get('/profile', ['middleware' => 'jwt.auth', 'uses' => 'MahasiswaController@getProfile']);
    $router->post('/{nim}/matakuliah/{mkId}', ['middleware' => 'jwt.auth','uses' => 'MahasiswaController@tambahMatakuliah']);
    $router->put('/{nim}/matakuliah/{mkId}', ['middleware' => 'jwt.auth','uses' => 'MahasiswaController@deleteMatakuliah']);
    $router->get('/', ['uses'=> 'mahasiswaController@getallmahasiswa']);
    $router->get('/{nim}', ['uses' => 'MahasiswaController@getMahasiswaByNIM']);
    
    

});

$router->group(['prefix' => 'matakuliah'], function () use ($router) {
    $router->post('/creatematakuliah',['uses'=>'MatakuliahController@creatematkul']);
    $router->get("/", "MatakuliahController@getallmatakuliah");
    
});

$router->group(['prefix' => 'prodi'], function () use ($router) {
    $router->post('/createprodi',['uses'=>'ProdiController@createprodi']);
    $router->get("/", "ProdiController@getallprodi"); 
});