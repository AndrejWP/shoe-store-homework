<?php
session_start();

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

function getErrorMessage(string $code): string
{
    if ($code === 'empty') {
        return 'Введите логин и пароль.';
    }

    if ($code === 'invalid') {
        return 'Неверный логин или пароль.';
    }

    if ($code === 'auth_required') {
        return 'Сначала выполните вход.';
    }

    return '';
}

function getSuccessMessage(string $code): string
{
    if ($code === 'logout') {
        return 'Вы успешно вышли из системы.';
    }

    return '';
}

$errorMessage = getErrorMessage($error);
$successMessage = getSuccessMessage($success);
$isLoggedIn = isset($_SESSION['user_id']);
$login = $_SESSION['login'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="container">
        <ul>
            <li><a href="index.html">Главная</a></li>
            <li><a href="catalog.html">Каталог товаров</a></li>
            <li><a href="login.php">Вход</a></li>
        </ul>
    </header>

    <main class="container auth-page">
        <section class="auth-card">
            <h1>Вход в BLACK STORE</h1>

            <?php if ($isLoggedIn): ?>
                <p class="success-message">Вы уже вошли как <?php echo htmlspecialchars($login, ENT_QUOTES, 'UTF-8'); ?>.</p>
                <div class="auth-links">
                    <a href="cabinet.php">Перейти в личный кабинет</a>
                    <a href="logout.php">Выйти</a>
                </div>
            <?php else: ?>
                <?php if ($errorMessage !== ''): ?>
                    <p class="error-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <?php if ($successMessage !== ''): ?>
                    <p class="success-message"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <form class="auth-form" action="process_login.php" method="post">
                    <label for="login">Логин</label>
                    <input id="login" type="text" name="login" required autocomplete="username">

                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">

                    <button type="submit">Войти</button>
                </form>

                <p class="demo-login">Тестовые данные: admin / password или user / password</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="container">
        <small>&copy; 2026 BLACK STORE. Все права защищены.</small>
    </footer>
</body>
</html>
