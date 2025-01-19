<h1>Главная</h1>

<section class="groups">
    <div class="groups__buttons">
        <a class="button" href="<?= app()->route->getUrl('/groups/add') ?>">Добавить группу</a>
        <a class="button" href="<?= app()->route->getUrl('/students/add') ?>">Добавить студента</a>
        <a class="button" href="<?= app()->route->getUrl('/disciplines/add') ?>">Добавить дисциплину</a>
    </div>
    <?php foreach ($groups as $key => $group): ?>
    <article class="groups__item">
        <h2>Группа <?= htmlspecialchars($key) ?></h2>
        <div class="group__semesters">
            <?php foreach ($group as $semester): ?>
                <div>
                    <h3 style="color: #875e0e;">
                        <span>Курс: <?= htmlspecialchars($semester['course']) ?></span>
                        <span>Семестр: <?= htmlspecialchars($semester['semester']) ?></span>
                    </h3>
                    <div>
                        <?php if (count($semester['students'])): ?>
                        <h3>
                            Студенты:
                        </h3>
                        <table>
                            <thead>
                            <tr>
                                <th style="width: 50px;">&#8470;</th>
                                <th>ФИО</th>
                                <?php foreach ($semester['disciplines'] as $discipline): ?>
                                <th><?= $discipline['discipline']['title'] . '(' . $discipline['discipline']['hours'] . ' ч.)' ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($semester['students'] as $key => $student): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= htmlspecialchars(
                                            $student['student']['last_name'] . ' ' .
                                            $student['student']['first_name'] . ' ' .
                                            $student['student']['middle_name'])
                                        ?>
                                    </td>
                                    <?php foreach ($semester['disciplines'] as $discipline): ?>
                                        <td>
                                            <form class="form__mark" method="post">
                                                <span>
                                                    <?php
                                                    $currentMark = current(
                                                        array_filter(
                                                            $student['student']->studentMarks->toArray() ?? [],
                                                            fn($studentMark) => $studentMark['discipline_id'] === $discipline['discipline_id']
                                                        ));


                                                    echo $currentMark ? $currentMark['mark']['value'] . ' (' . $currentMark['mark']['control_type'] . ')' : 'Не оценено'
                                                    ?>
                                                </span>
                                                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                                                <input name="student_id" type="hidden" value="<?= $student['student_id'] ?>">
                                                <input name="discipline_id" type="hidden" value="<?= $discipline['discipline_id'] ?>">
                                                <select name="mark_id">
                                                    <?php foreach ($marks as $mark): ?>
                                                        <option value="<?= $mark['id'] ?>">
                                                            <?= $mark['value'] . ' ' . $mark['control_type'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button>ОЦЕНИТЬ</button>
                                            </form>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <h3>Студентов нет.</h3>
                        <?php endif ?>
                    </div>
                </div>
            <div style="border: 1px solid rgba(71,40,14,0.51)"></div>
            <?php endforeach; ?>
        </div>
        <div class="groups__buttons">
            <a class="button" href="<?= app()->route->getUrl('/students/add?group_id=' . $key) ?>">Добавить студента в группу</a>
            <a class="button" href="<?= app()->route->getUrl('/disciplines/add?group_id=' . $key) ?>">Прикрепить дисциплину в группу</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>