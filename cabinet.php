<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=auth_required');
    exit;
}

$login = $_SESSION['login'] ?? '';
$name = $_SESSION['name'] ?? 'Пользователь';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="container">
        <ul>
            <li><a href="index.html">Главная</a></li>
            <li><a href="catalog.html">Каталог товаров</a></li>
            <li><a href="cabinet.php">Личный кабинет</a></li>
            <li><a href="logout.php">Выход</a></li>
        </ul>
    </header>

    <main class="container auth-page">
        <section class="auth-card">
            <h1>Личный кабинет</h1>
            <p>Здравствуйте, <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>.</p>
            <p>Ваш логин: <strong><?php echo htmlspecialchars($login, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <p>Эта страница доступна только после успешной авторизации.</p>

            <div class="auth-links">
                <a href="catalog.html">Перейти в каталог</a>
                <a href="logout.php">Выйти из аккаунта</a>
            </div>
        </section>
    </main>

    <footer class="container">
        <small>&copy; 2026 BLACK STORE. Все права защищены.</small>
    </footer>
</body>
</html>
