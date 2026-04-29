<?php

function prepareLogValue(string $value): string
{
    $value = trim($value);
    $value = str_replace(["\r", "\n", "|"], ' ', $value);

    return $value === '' ? 'empty' : $value;
}

function writeAuthLog(string $login, string $action, string $info = ''): void
{
    $dir = __DIR__ . '/logs';

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $file = $dir . '/auth.log';
    $time = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    $line = $time
        . ' | ip=' . prepareLogValue($ip)
        . ' | login=' . prepareLogValue($login)
        . ' | action=' . prepareLogValue($action);

    if ($info !== '') {
        $line .= ' | info=' . prepareLogValue($info);
    }

    $line .= PHP_EOL;

    file_put_contents($file, $line, FILE_APPEND);
}
