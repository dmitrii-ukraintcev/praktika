<h2>Посты</h2>
<hr>
<div class="mb-3">
    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=post&action=addPost">Добавить пост</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Название</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $p) : ?>
            <tr>
                <td>
                    <?= $p->title ?>
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="#">Просмотреть</a>
                    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=post&action=editPost&id=<?= $p->id ?>">Изменить</a>
                    <a class="btn btn-danger btn-sm" href="/admin/index.php?module=post&action=deletePost&id=<?= $p->id ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>