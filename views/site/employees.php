<h2>Сотрудники деканата: </h2>
<table class="table">
    <thead class="table-head">
        <tr>
            <?php foreach ($localize as $key => $label): ?>
                <th><?= htmlspecialchars($label) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php if (!empty($employees)): ?>
        <?php foreach ($employees as $key => $employee): ?>
            <tr>
                <td><?= htmlspecialchars($employee['id']) ?></td>
                <td><?= htmlspecialchars($employee['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?= count($localize) ?>">Сотрудников нет</td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>
<a class="button" href="<?= app()->route->getUrl('/employees/add') ?>">Добавить сотрудника</a>
