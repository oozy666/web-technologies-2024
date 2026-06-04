<h2><?= htmlspecialchars($product['name']) ?></h2>
<div class="product-detail" style="margin-bottom: 25px;">
    <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="200" style="border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px; background-color: #fff; margin-bottom: 15px;">
    <p><strong>Цена:</strong> <?= number_format($product['price'], 0, '.', ' ') ?> руб.</p>
    <p><strong>Описание:</strong> <?= htmlspecialchars($product['description']) ?></p>
</div>

<hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 30px 0;">

<h3>Отзывы</h3>
<div class="reviews-section" style="margin-bottom: 30px;">
    <?php if (empty($reviews)): ?>
        <p>Отзывов пока нет. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($reviews as $rev): ?>
            <div class="review-card" style="border: 1px solid #e5e7eb; padding: 15px; margin-bottom: 15px; border-radius: 6px; background-color: #f9fafb;">
                <p style="margin: 0 0 8px 0;"><strong><?= htmlspecialchars($rev['name']) ?></strong> <small style="color: #6b7280; margin-left: 8px;"><?= $rev['created_at'] ?></small></p>
                <p style="margin: 0 0 12px 0; color: #4b5563;"><?= nl2br(htmlspecialchars($rev['text'])) ?></p>

                <div class="review-actions">
                    <button onclick="showEditForm(<?= $rev['id'] ?>, '<?= htmlspecialchars($rev['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars(str_replace(["\r", "\n"], ['\r', '\n'], $rev['text']), ENT_QUOTES) ?>')" style="background-color: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Редактировать</button>
                    
                    <form method="POST" action="index.php?page=product&id=<?= $product['id'] ?>&action=delete_review" style="display: inline-block; margin-left: 8px;">
                        <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                        <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Удалить</button>
                    </form>
                </div>

                <div id="edit-form-container-<?= $rev['id'] ?>" style="display: none; margin-top: 15px; border-top: 1px solid #e5e7eb; padding-top: 15px;">
                    <form method="POST" action="index.php?page=product&id=<?= $product['id'] ?>&action=edit_review">
                        <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                        <div style="margin-bottom: 10px;">
                            <input type="text" name="name" id="edit-name-<?= $rev['id'] ?>" required style="width: 100%; max-width: 300px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <textarea name="text" id="edit-text-<?= $rev['id'] ?>" required style="width: 100%; height: 70px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
                        </div>
                        <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: bold;">Сохранить</button>
                        <button type="button" onclick="hideEditForm(<?= $rev['id'] ?>)" style="background-color: #6b7280; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-left: 8px;">Отмена</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 30px 0;">

<h3>Оставить отзыв</h3>
<form method="POST" action="index.php?page=product&id=<?= $product['id'] ?>&action=add_review" style="max-width: 500px; background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 20px; border-radius: 6px;">
    <div style="margin-bottom: 15px;">
        <label for="rev_name" style="display: block; margin-bottom: 6px; font-weight: bold; color: #4b5563;">Ваше имя:</label>
        <input type="text" name="name" id="rev_name" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="rev_text" style="display: block; margin-bottom: 6px; font-weight: bold; color: #4b5563;">Отзыв:</label>
        <textarea name="text" id="rev_text" required style="width: 100%; height: 120px; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; resize: vertical;"></textarea>
    </div>
    <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 15px;">Отправить</button>
</form>

<script>
function showEditForm(id, name, text) {
    document.getElementById('edit-form-container-' + id).style.display = 'block';
    document.getElementById('edit-name-' + id).value = name;
    document.getElementById('edit-text-' + id).value = text;
}
function hideEditForm(id) {
    document.getElementById('edit-form-container-' + id).style.display = 'none';
}
</script>
