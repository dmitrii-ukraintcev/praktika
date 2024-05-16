<h2>Меню навигации</h2>
<hr>
<table class="table">
    <thead>
        <tr>
            <th>Область меню</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menus as $menu) : ?>
            <tr>
                <td>
                    <?= $menu->name ?>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/index.php?module=menu&action=editMenu&id=<?= $menu->id ?>">Изменить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>