<h3>Category id: <?= $category->id ?></h3>
<hr>
<form method="post">
    <input type="hidden" name="action" value="1">
    <label>Название:</label><br>
    <input type="text" name="title" value="<?= $category->title ?>" placeholder="Category name"><br><br>
    <label>Родительская категория:</label><br>
    <select name="parent_category_id">
        <option value="">Нет</option>
        <?php unset($categories[0]);
        foreach ($categories as $c) {
            if ($c != $category && $c->parent_category_id != $category->id) { ?>
                <option value=<?= $c->id ?> <?php if ($c->id == $category->parent_category_id) echo 'selected'; ?>><?= $c->title ?></option>
        <?php }
        } ?>
    </select><br><br>
    <input type="submit" value="Обновить">
</form>