<h2>Страницы</h2>
<hr>
<div class="mb-3">
    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=page&action=addPage">Добавить страницу</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Название</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pages as $p) : ?>
            <tr>
                <td>
                    <?= $p->title ?>
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="#">Просмотреть</a>
                    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=page&action=editPage&id=<?= $p->id ?>">Изменить</a>
                    <a class="btn btn-danger btn-sm" href="/admin/index.php?module=page&action=deletePage&id=<?= $p->id ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>