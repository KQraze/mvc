<h2>Авторизация</h2>
<h3><?= $message ?? ''; ?></h3>

<?php
if (!app()->auth::check()):
    ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input name="role_id" type="hidden" value="1"/>
        <label>Логин <input type="text" name="login"></label>
        <label>Пароль <input type="password" name="password"></label>
        <button>Войти</button>
    </form>
<?php endif;
