<h6>Пункты меню <span><?= $menu_name ?></span></h6>
<hr>

<div class="dropdown dropend mb-3">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        Добавить
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/admin/index.php?module=menu&action=addMenuItem&id=<?= $menu_id ?>&type=link">Произвольная ссылка</a></li>
        <li><a class="dropdown-item" href="/admin/index.php?module=menu&action=addMenuItem&id=<?= $menu_id ?>&type=page">Страница</a></li>
    </ul>
</div>

<ul class="menu-list list-group">
    <?php
    foreach ($menu_items as $menu_item) {
        if (!$menu_item->parent_menu_item_id) {
            echo $menu_item->renderMenuItem();
        }
    }
    ?>
</ul>