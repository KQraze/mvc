<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pop it MVC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #220800;
        }

        main > .container {
            padding: 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .container {
            width: 100%;
            padding: 0 20px;
            max-width: 1660px;
            margin: 0 auto;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        header {
            display: flex;
            padding: 10px;
            gap: 20px;
            background: wheat;
        }

        nav {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        nav > div {
            display: flex;
            gap: 20px;
        }

        nav > a:first-child {
            font-size: 24px;
        }

        table {
            width: 100%;
        }

        table, th, td {
            border-collapse: collapse;
            border: 1px solid rgb(177, 177, 177);
            text-align: center;
        }

        th {
            background: wheat;
        }

        th, td {
            padding: 5px;
        }

        .groups {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .groups__buttons {
            width: 100%;
            align-self: end;
            display: flex;
            gap: 20px;
        }

        .groups__item {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(108, 101, 87, 0.3);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .groups__item > h2 {
            font-size: 32px;
        }

        .group__semesters {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 30px;
            border-top: 2px dashed #e6b557;
        }

        .group__semesters > div {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .group__semesters h3 {
            font-size: 20px;
        }

        .form__mark {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .button {
            width: fit-content;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            font-size: 16px;
            margin-top: 10px;
            padding: 10px;
            background: wheat;
            box-shadow: -5px 5px 8px rgba(99, 77, 37, 0.1);
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <nav>
            <a href="<?= app()->route->getUrl('/') ?>">Деканат</a>
            <div>
                <?php if (!app()->auth::check()): ?>
                    <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                    <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
                <?php else: ?>
                    <?php if (app()->auth::isAdmin()): ?>
                        <a href="<?= app()->route->getUrl('/employees') ?>">Главная</a>
                    <?php elseif (app()->auth::isEmployee()): ?>
                        <a href="<?= app()->route->getUrl('/groups')?>">Главная</a>
                    <?php endif; ?>
                    <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container">
        <?= $content ?? '' ?>
    </div>
</main>

</body>
</html>