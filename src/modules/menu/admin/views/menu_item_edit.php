<form method="post">
    <input type="hidden" name="action" value="1">
    <label for="title">Текст ссылки:</label><br>
    <input type="text" id="title" name="title" value="<?= $menu_item->title ?>"><br><br>

    <label for="url">URL:</label><br>
    <input type="url" id="url" name="url" value="<?= $menu_item->url ?>"><br><br>

    <label for="parent_menu_item">Родительский пункт меню:</label><br>
    <select id="parent_menu_item" name="parent_menu_item_id">
        <option value="">Нет</option>
        <?php foreach ($menu_items as $item) {
            if ($item != $menu_item) { ?>
                <option value="<?= $item->id ?>" <?php if ($menu_item->parent_menu_item_id == $item->id) echo 'selected'; ?>><?= $item->title ?></option>
        <?php }
        } ?>
    </select><br><br>

    <input type="submit" value="Обновить">
</form>