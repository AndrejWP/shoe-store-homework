<?php
session_start();

require __DIR__ . '/logger.php';

$login = $_SESSION['login'] ?? 'guest';

writeAuthLog($login, 'LOGOUT');

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

header('Location: login.php?success=logout');
exit;
