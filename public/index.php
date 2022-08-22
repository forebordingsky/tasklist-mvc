<?php

use App\Controllers\AuthController;
use App\Core\Application;
use App\Controllers\TaskController;

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = '../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$app = new Application('../');

$app->router->get('/',[(new TaskController), 'index']);
$app->router->post('/',[(new TaskController), 'create']);
$app->router->post('/delete',[(new TaskController), 'delete']);
$app->router->post('/change-status',[(new TaskController), 'changeStatus']);
$app->router->post('/ready-all',[(new TaskController), 'readyAll']);
$app->router->post('/delete-all',[(new TaskController), 'deleteAll']);

$app->router->get('/login',[(new AuthController), 'loginOrRegisterPage']);
$app->router->post('/login',[(new AuthController), 'loginOrRegisterHandler']);
$app->router->get('/logout',[(new AuthController), 'logoutHandler']);

$app->run();