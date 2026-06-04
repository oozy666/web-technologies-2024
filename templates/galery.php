<?php if (!empty($upload_res)): ?>
    <div class="alert-box">
        <p><?= htmlspecialchars($upload_res) ?></p>
    </div>
<?php endif; ?>

<div class="upload-section">
    <h3>Загрузить картинку</h3>
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateSize()">
        <input type="file" name="image" id="fileField" required>
        <button type="submit">Загрузить</button>
    </form>
</div>

<script>
function validateSize() {
    const input = document.getElementById('fileField');
    const file = input.files[0];
    const limit = 10 * 1024 * 1024;
    if (file && file.size > limit) {
        alert("Ошибка: файл превышает 10 МБ.");
        return false;
    }
    return true;
}
</script>

<h3>Изображения</h3>
<div class="gallery-container">
    <?php
    $smallDir = BASE_PATH . '/images/small/';
    $bigDir = BASE_PATH . '/images/big/';

    if (is_dir($smallDir) && is_dir($bigDir)) {
        $smallList = array_values(array_diff(scandir($smallDir), ['.', '..']));
        $bigList = array_values(array_diff(scandir($bigDir), ['.', '..']));

        $count = count($smallList);
        for ($i = 0; $i < $count; $i++) {
            $smallUrl = "image.php?file=" . urlencode($smallDir . $smallList[$i]);
            $bigUrl = "image.php?file=" . urlencode($bigDir . $bigList[$i]);
            echo "<a href='$bigUrl' target='_blank' class='gallery-item'>
                    <img src='$smallUrl' alt='Фото'>
                  </a>";
        }
    } else {
        echo "<p>Галерея пуста.</p>";
    }
    ?>
</div>
