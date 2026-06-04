<div class="catalog-box">
    <h2>Каталог товаров</h2>
    <div class="catalog-grid">
        <?php foreach ($catalog as $item): ?>
            <div class="catalog-item-card">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <div class="item-img-container">
                    <img src="img/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="120">
                </div>
                <p class="item-price">Цена: <?= $item['price'] ?> руб.</p>
                <button class="buy-btn">Купить</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>
