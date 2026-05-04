<?php

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$apiPosition = strpos($uri, '/api');
$path = $apiPosition !== false ? substr($uri, $apiPosition + 4) : $uri;
$path = '/' . trim($path, '/');

if (str_starts_with($path, '/index.php')) {
    $path = substr($path, strlen('/index.php'));
    $path = '/' . trim($path, '/');
}

$body = file_get_contents('php://input');
$input = json_decode($body, true);

if ($body !== '' && $input === null) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректный JSON'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!is_array($input)) {
    $input = [];
}

require __DIR__ . '/routes.php';
