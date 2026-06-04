<div class="tasks-page">
    <h2>Практика 18: Выполненные задачи</h2>

    <?php if (!(isset($_GET['task']) && $_GET['task'] === 'three')): ?>
        <div class="tasks-list">
            <?php foreach ($tasks as $taskGroup): ?>
                <?php if (count($taskGroup) > 1): ?>
                    <div class="task-card">
                        <?php foreach ($taskGroup as $taskHtml): ?>
                            <div class="task-item"><?= $taskHtml ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ((isset($_GET['task']) && $_GET['task'] === 'three') || !isset($_GET['task'])): ?>
        <div class="task-card">
            <h3>Задание 3: Транслитерация строк</h3>
            <form method="POST" class="translit-form">
                <div class="form-group">
                    <label for="text-input">Введите текст на русском:</label><br>
                    <textarea name="text" id="text-input" rows="4" cols="50"><?= htmlspecialchars($text ?? '') ?></textarea>
                </div>
                <button type="submit" class="submit-btn">Выполнить транслит</button>
            </form>

            <?php if (!empty($translit)): ?>
                <div class="translit-result">
                    <strong>Результат транслитерации:</strong>
                    <p><?= nl2br(htmlspecialchars($translit)) ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
