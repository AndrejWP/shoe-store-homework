<?php

$controller = new UserController();

if (!preg_match('#^/v1(/|$)#', $path)) {
    $controller->send([
        'status' => 'error',
        'message' => 'Версия API не найдена'
    ], 404);
    exit;
}

if ($method === 'POST' && preg_match('#^/v1/register/?$#', $path)) {
    $controller->register($input);
    exit;
}

if ($method === 'POST' && preg_match('#^/v1/login/?$#', $path)) {
    $controller->login($input);
    exit;
}

if ($method === 'GET' && preg_match('#^/v1/users/?$#', $path)) {
    $controller->getAll();
    exit;
}

if ($method === 'GET' && preg_match('#^/v1/users/([0-9]+)/?$#', $path, $matches)) {
    $controller->getOne((int)$matches[1]);
    exit;
}

if (($method === 'PUT' || $method === 'PATCH') && preg_match('#^/v1/users/([0-9]+)/?$#', $path, $matches)) {
    $controller->changePassword((int)$matches[1], $input);
    exit;
}

if ($method === 'DELETE' && preg_match('#^/v1/users/([0-9]+)/?$#', $path, $matches)) {
    $controller->delete((int)$matches[1]);
    exit;
}

$controller->send([
    'status' => 'error',
    'message' => 'Маршрут не найден'
], 404);
exit;
