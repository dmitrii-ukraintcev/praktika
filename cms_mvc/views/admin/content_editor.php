<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/admin/js/content_editor.js"></script>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-9">
                <!-- <button id="editButton" class="btn btn-primary">Edit</button> -->
                <button id="saveButton" class="btn btn-success btn-sm">Обновить</button>
                <button id="addParagraphButton" class="btn btn-primary btn-sm">Параграф</button>
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Заголовок</button>
                <ul id="headingSelection" class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">h1</a></li>
                    <li><a class="dropdown-item" href="#">h2</a></li>
                    <li><a class="dropdown-item" href="#">h3</a></li>
                    <li><a class="dropdown-item" href="#">h4</a></li>
                    <li><a class="dropdown-item" href="#">h5</a></li>
                    <li><a class="dropdown-item" href="#">h6</a></li>
                </ul>
                <button id="addListButton" class="btn btn-primary btn-sm">Список</button>
                <button id="addTableButton" class="btn btn-primary btn-sm">Таблица</button>

                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="imageDropdown" data-bs-toggle="dropdown" aria-expanded="false">Добавить изображение</button>
                <ul class="dropdown-menu" aria-labelledby="imageDropdown">
                    <li>
                        <label class="dropdown-item">
                            <input type="file" id="imageUpload" style="display: none;"> Загрузить изображение
                        </label>
                    </li>
                    <li>
                        <label class="dropdown-item">
                            <label for="imageUrl" class="form-label">Ссылка на изображение:</label>
                            <input type="text" class="form-control" id="imageUrl">
                            <button id="addImageButton" class="btn btn-primary btn-sm mt-2">Добавить</button>
                        </label>
                    </li>
                </ul>

                <h1>Page Title</h1>
                <div id="pageContent">
                    <?= $page->content ?>
                </div>
            </div>

            <div class="col-3">
                <h4>Настройки элемента</h4>
                <div id="elementSettings">
                    <p>Элемент не выбран.</p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>