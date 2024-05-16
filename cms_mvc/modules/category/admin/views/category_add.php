<form method="post">
    <input type="hidden" name="action" value="1">
    <label>Название:</label><br>
    <input type="text" name="title" placeholder="Category name"><br><br>
    <label>Родительская категория:</label><br>
    <select name="parent_category_id">
        <option value="">Нет</option>
        <?php unset($categories[0]);
        foreach ($categories as $c) { ?>
            <option value=<?= $c->id ?>><?= $c->title ?></option>
        <?php } ?>
    </select><br><br>
    <input type="submit" value="Добавить">
</form>