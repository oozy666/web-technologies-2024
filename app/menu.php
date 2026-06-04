<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/db.php';
}

function getMenuTree($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped = [];
    foreach ($items as $item) {
        $parent = $item['parent_id'];
        $key = ($parent === null) ? 'root' : $parent;
        $grouped[$key][] = $item;
    }

    return renderTreeLevel($grouped, 'root');
}

function renderTreeLevel($grouped, $parentId) {
    if (!isset($grouped[$parentId])) {
        return '';
    }

    $html = '';
    foreach ($grouped[$parentId] as $item) {
        $itemId = $item['id'];
        $hasChildren = isset($grouped[$itemId]);

        if ($hasChildren) {
            $html .= '<div class="tree-node tree-node_open" data-parent-node>';
            $html .= '<div class="tree-node__header">';
            $html .= '<span class="tree-node__trigger" data-toggle>▼</span>';
            $html .= '<span class="tree-node__icon">📁</span>';
            $html .= '<span class="tree-node__title">' . htmlspecialchars($item['name']) . '</span>';
            $html .= '</div>';
            $html .= '<div class="tree-node__children">';
            $html .= renderTreeLevel($grouped, $itemId);
            $html .= '</div>';
            $html .= '</div>';
        } else {
            $html .= '<div class="tree-node">';
            $html .= '<div class="tree-node__header">';
            $html .= '<span class="tree-node__trigger tree-node__trigger_empty"></span>';
            $html .= '<span class="tree-node__icon">📄</span>';
            $html .= '<span class="tree-node__title">' . htmlspecialchars($item['name']) . '</span>';
            $html .= '</div>';
            $html .= '</div>';
        }
    }
    return $html;
}
