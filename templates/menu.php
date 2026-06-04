<ul class="nav-menu">
    <?php foreach ($menus as $item): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $item['link'] ?>"><?= $item['title'] ?></a>
            <?php if (!empty($item['children'])): ?>
                <ul class="submenu">
                    <?php foreach ($item['children'] as $child): ?>
                        <li class="submenu-item">
                            <a class="submenu-link" href="<?= $child['link'] ?>"><?= $child['title'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
