<h3>Page id: <?= $page->id ?></h3>
<hr>
<form method="post">
    <input type="hidden" name="action" value="1">
    <label>Название:</label><br>
    <input type="text" name="title" value="<?= $page->title ?>" placeholder="Page name"><br><br>
    <label>Содержимое:</label><br>
    <textarea name="content" placeholder="Содержимое"><?= $page->content ?></textarea><br><br>
    <?php if ($page->id != 1) { ?>
        <label>Родительская страница:</label><br>
        <select name="parent_page_id">
            <option value=<?= $pages[0]->id ?> <?php //if (!$pages[0]->parent_page_id) echo 'selected'; ?>>Нет (Главная)</option>
            <?php unset($pages[0]);
            foreach ($pages as $p) {
                if ($p != $page && !in_array($p, $child_pages)) { ?>
                    <option value=<?= $p->id ?> <?php if ($p->id == $page->parent_page_id) echo 'selected'; ?>><?= $p->title ?></option>
            <?php }
            } ?>
        </select><br><br>
    <?php } ?>
    <input type="submit" value="Обновить">
</form>