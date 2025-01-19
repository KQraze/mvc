<h2>Добавление группы</h2>

<pre><?= $message ?? ''; ?></pre>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Название группы <input type="text" name="title"></label>
    <label>
        Кол-во курсов
        <select name="course_count">
            <option disabled selected value="">Выберите кол-во:</option>
            <?php foreach ([1, 2, 3, 4, 5] as $value): ?>
                <option value="<?= $value ?>"><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button>Добавить</button>
</form>
