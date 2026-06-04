<h2>Каталог товаров</h2>
<div class="catalog-grid">
    <?php foreach ($catalog as $item): ?>
        <div class="catalog-card">
            <h3><?= htmlspecialchars($item['name']) ?></h3>
            <img src="img/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="100">
            <p>Цена: <?= $item['price'] ?> руб.</p>
            <button class="buy-btn">Купить</button>
        </div>
    <?php endforeach; ?>
</div>
