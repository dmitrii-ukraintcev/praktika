<form method="post">
    <input type="hidden" name="action" value="1">
    <label for="title">Текст ссылки:</label><br>
    <input type="text" id="title" name="title"><br><br>

    <label for="url">URL:</label><br>
    <input type="url" id="url" name="url"><br><br>

    <!-- <label for="entities">Выберите:</label>
    <select name="entities" id="entities">
        <option value="">Нет</option>
        <optgroup label="Страницы">
            <option value="volvo">Страница 1</option>
            <option value="saab">Страница 2</option>
        </optgroup>
        <optgroup label="Посты">
            <option value="mercedes">Пост 1</option>
            <option value="audi">Пост 2</option>
        </optgroup>
    </select>
    <br><br> -->

    <label for="parent_menu_item">Родительский пункт меню:</label><br>
    <select id="parent_menu_item" name="parent_menu_item_id">
        <option value="">Нет</option>
        <?php foreach ($menu_items as $menu_item) { ?>
            <option value="<?= $menu_item->id ?>"><?= $menu_item->title ?></option>
        <?php } ?>
    </select><br><br>

    <input type="submit" value="Добавить">
</form>