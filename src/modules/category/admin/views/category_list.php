<h2>Категории</h2>
<hr>
<div class="mb-3">
    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=category&action=addCategory">Добавить категорию</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Название</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php unset($categories[0]);
        foreach ($categories as $c) : ?>
            <tr>
                <td>
                    <?= $c->title ?>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=category&action=editCategory&id=<?= $c->id ?>">Изменить</a>
                    <a class="btn btn-danger btn-sm" href="/admin/index.php?module=category&action=deleteCategorye&id=<?= $c->id ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>