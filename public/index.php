<?php

use App\Controllers\AuthController;
use App\Core\Application;
use App\Controllers\TaskController;

require_once '../vendor/autoload.php';

$app = new Application('../');

$app->router->get('/',[(new TaskController), 'index']);
$app->router->post('/',[(new TaskController), 'create']);

$app->router->get('/login',[(new AuthController), 'loginOrRegisterPage']);
$app->router->post('/login',[(new AuthController), 'loginOrRegisterHandler']);
$app->router->get('/logout',[(new AuthController), 'logoutHandler']);

$app->run();