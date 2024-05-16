<form method="post">
    <input type="hidden" name="action" value="1">
    <label>Выберите страницы:</label><br>
    <?php foreach ($pages as $p) { ?>
        <input type="checkbox" id="page<?= $p->id ?>" name="pages[]" value="<?= $p->id ?>" <?php if (in_array($p->id, $added_page_ids)) echo 'checked disabled'; ?>>
        <label for="page<?= $p->id ?>"><?= $p->title ?></label><br>
    <?php } ?><br>
    <input type="submit" value="Добавить">
</form>