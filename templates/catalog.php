<h2>Каталог товаров</h2>
<div class="catalog-grid">
    <?php foreach ($catalog as $item): ?>
        <div class="catalog-card">
            <a href="index.php?page=product&id=<?= $item['id'] ?>" style="text-decoration: none; color: inherit;">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <img src="img/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="100">
                <p>Цена: <?= number_format($item['price'], 0, '.', ' ') ?> руб.</p>
            </a>
            <button class="buy-btn">Купить</button>
        </div>
    <?php endforeach; ?>
</div>
