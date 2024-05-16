<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/admin/js/menu.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Страницы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Посты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Категории</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Теги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Меню</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Темы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Настройки</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">Главная</a>
                    <a href="/admin/index.php?module=page" class="list-group-item list-group-item-action">Страницы</a>
                    <a href="/admin/index.php?module=post" class="list-group-item list-group-item-action">Посты</a>
                    <a href="/admin/index.php?module=category" class="list-group-item list-group-item-action">Категории</a>
                    <a href="#" class="list-group-item list-group-item-action">Теги</a>
                    <a href="/admin/index.php?module=menu" class="list-group-item list-group-item-action">Меню</a>
                    <a href="#" class="list-group-item list-group-item-action">Темы</a>
                    <a href="#" class="list-group-item list-group-item-action">Пользователи</a>
                    <a href="#" class="list-group-item list-group-item-action">Настройки</a>
                </div>
            </div>
            <div class="col-lg-9">
                <!-- <h2></h2> -->
                <?php include MODULES_PATH . $view . '.php'; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>