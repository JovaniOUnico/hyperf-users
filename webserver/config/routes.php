<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use App\Controller\UserController;
use App\Controller\AuthController;
use App\Middleware\AuthMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

/* AuthMiddleware Authorization - JWT token */
Router::addGroup('/users', function () {
    Router::post('/register', [AuthController::class, 'register']);
    //update
    Router::post('/login',    [AuthController::class, 'login']);
    //filter
    Router::get('',           [UserController::class, 'index'],  ['middleware' => [AuthMiddleware::class]]);
    Router::get('/{id}',      [UserController::class, 'show'],   ['middleware' => [AuthMiddleware::class]]);
    Router::delete('/{id}',   [UserController::class, 'delete'], ['middleware' => [AuthMiddleware::class]]);
});

Router::get('/favicon.ico', function () {
    return '';
});