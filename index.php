<?php

use engine\Route;

session_start();

define('ROOT', str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']));

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

Route::get('/', 'MainController');
Route::get('/user/login', 'MainController@login');
Route::post('/user/login', 'MainController@login');
Route::get('/user/logout', 'MainController@logout');
Route::get('/user/profile', 'MainController@profile');
Route::post('/user/profile', 'MainController@profile');

Route::run();

