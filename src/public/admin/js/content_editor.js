$(document).ready(function() {
    let selectedElement = null;

    $("#pageContent").on("click", ":not(.controlContainer):not(.controlContainer *)", function(event) {
        // console.log(this);
        event.stopPropagation();

        $(".controlButtons").remove();
        $(selectedElement).removeAttr("contenteditable");
        $(selectedElement).unwrap();

        selectedElement = $(this);
        var container = $('<div class="controlContainer"></div>');
        var controlButtons = $('<div class="controlButtons btn-group"></div>');
        $(this).attr("contenteditable", true);

        if ($(this).is("ul")) {
            controlButtons.append('<a class="btn btn-link btn-sm addListItem">Добавить элемент</a>');
            controlButtons.append('<a class="btn btn-link btn-sm addListButton">Добавить вложенный список</a>');
        } else if ($(this).is("table")) {
            controlButtons.append('<a class="btn btn-link btn-sm addRowButton">Добавить строку</a>');
            controlButtons.append('<a class="btn btn-link btn-sm addColumnButton">Добавить столбец</a>');
        }
        controlButtons.append('<a type="button" class="btn btn-link btn-sm moveUpButton">Вверх</a>');
        controlButtons.append('<a type="button" class="btn btn-link btn-sm moveDownButton">Вниз</a>');
        controlButtons.append('<a type="button" class="btn btn-link btn-sm deleteButton">Удалить</a>');

        $(this).wrap(container);
        $(this).after(controlButtons);
        $(this).focus();

        var elementType = $(this).prop("tagName").toLowerCase();
        updateSettingsPanel(elementType);
    });

    $("#pageContent").on("blur", "*", function(event) {
        console.log(this);
        event.stopPropagation();
        // $(this).unwrap();
        // $(this).removeAttr("contenteditable");
        // $(".controlButtons").remove();
    });

    $("#pageContent").on("click", ".controlButtons .moveUpButton", function() {
        var container = $(this).parents('.controlContainer');
        selectedElement = container.children().first();
        container.insertBefore(container.prev());
    });

    $("#pageContent").on("click", ".controlButtons .moveDownButton", function() {
        var container = $(this).parents('.controlContainer');
        selectedElement = container.children().first();
        container.insertAfter(container.next());
    });

    $("#pageContent").on("click", ".deleteButton", function(event) {
        event.stopPropagation();
        var target = $(this).parent().prev();
        if (target.is("li") && target.siblings("li").length === 0 && target.parent().is("ul")) {
            target.parent().remove();
        } else {
            target.remove();
        }
        $(this).parents('.controlContainer').remove();
    });

    $("#pageContent").on("click", ".addListItem", function(event) {
        event.stopPropagation();
        $(this).parent().prev().append($("<li>Элемент списка</li>"));
    });

    $("#pageContent").on("click", ".addListButton", function(event) {
        event.stopPropagation();
        $(this).parent().prev().append(createList());
    });

    $("#pageContent").on("click", ".addRowButton", function(event) {
        event.stopPropagation();
        var table = $(this).parent();
        var newRow = $("<tr></tr>");
        var numColumns = table.find("tr").first().children("td").length;
        for (var i = 0; i < numColumns; i++) {
            newRow.append("<td>Ячейка</td>");
        }
        table.append(newRow);
    });

    $("#pageContent").on("click", ".addColumnButton", function(event) {
        event.stopPropagation();
        var table = $(this).parent();
        table.find("tr").each(function() {
            $(this).append("<td>Ячейка</td>");
        });
    });

    $("#addParagraphButton").click(function() {
        var paragraph = createContentElement("p", "Параграф");
        $("#pageContent").append(paragraph);
    });

    $("#headingSelection").on("click", ".dropdown-item", function() {
        var tag = $(this).text();
        var heading = createContentElement(tag, "Заголовок");
        $("#pageContent").append(heading);
    });

    $("#addListButton").click(function() {
        var list = createList();
        $("#pageContent").append(list);
    });

    $("#addTableButton").click(function() {
        var table = createTable();
        $("#pageContent").append(table);
    });

    $('#addImageByURL').on('click', function() {
        $('#imageUrlContainer').show();
        $('#imageUpload').val('');
    });

    $("#addImageButton").click(function() {
        var imageUrl = $("#imageUrl").val().trim();
        if (imageUrl) {
            var img = createContentElement("img");
            img.attr("src", imageUrl);
            $("#pageContent").append(img);
        } else {
            var input = document.getElementById('imageUpload');
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = createContentElement("img");
                    img.attr("src", e.target.result);
                    $("#pageContent").append(img);
                }
                reader.readAsDataURL(file);
            } else {
                alert("Пожалуйста, выберите файл изображения или введите URL.");
            }
        }
    });

    function createContentElement(tag, text = "") {
        return $("<" + tag + ">" + text + "</" + tag + ">");
    }

    function createList() {
        var list = createContentElement("ul");
        var listItem = createContentElement("li", "Элемент списка");
        list.append(listItem);
        return list;
    }

    function createTable() {
        var table = createContentElement("table");
        var row = createContentElement("tr");
        var cell = createContentElement("td", "Ячейка");
        row.append(cell);
        table.append(row);
        return table;
    }

    function addCommonSettings() {
        $("#elementSettings").append('<label for="textColor">Цвет текста:</label><br>');
        $("#elementSettings").append('<input type="color" id="textColor" value="#000000"><br>');

        $("#elementSettings").append('<label for="backgroundColor">Цвет фона:</label><br>');
        $("#elementSettings").append('<input type="color" id="backgroundColor" value="#000000"><br>');

        $("#elementSettings").append('<label for="fontSize">Размер шрифта:</label><br>');
        $("#elementSettings").append('<input type="number" id="fontSize" value="14" min="1"> px<br>');

        $("#elementSettings").append('<label for="padding">Внутренние отступы:</label><br>');
        $("#elementSettings").append('<input type="number" id="padding" value="10" min="0"> px<br>');

        $("#elementSettings").append('<label for="margin">Внешние отступы:</label><br>');
        $("#elementSettings").append('<input type="number" id="margin" value="10" min="0"> px<br>');
    }

    function updateSettingsPanel(elementType) {
        $("#elementSettings").empty();
        switch (elementType) {
            case "p":
                $("#elementSettings").append("<h5>Параграф</h5>");
                addCommonSettings();
                break;
            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
                $("#elementSettings").append("<h5>Заголовок</h5>");
                addCommonSettings();
                break;
            case "ul":
                $("#elementSettings").append("<h5>Список</h5>");
                addCommonSettings();
                break;
            case "table":
                $("#elementSettings").append("<h5>Таблица</h5>");
                break;
            default:
                $("#elementSettings").append("<p>Элемент не выбран.</p>");
        }
    }

    $("#elementSettings").on("change", "#textColor", function() {
        var color = $(this).val();
        $("#pageContent").find("[contenteditable=true]").css("color", color);
    });

    $("#elementSettings").on("change", "#backgroundColor", function() {
        var color = $(this).val();
        $("#pageContent").find("[contenteditable=true]").css("background-color", color);
    });

    $("#elementSettings").on("change", "#fontSize", function() {
        var size = $(this).val() + "px";
        $("#pageContent").find("[contenteditable=true]").css("font-size", size);
    });

    $("#elementSettings").on("change", "#padding", function() {
        var padding = $(this).val() + "px";
        $("#pageContent").find("[contenteditable=true]").css("padding", padding);
    });

    $("#elementSettings").on("change", "#margin", function() {
        var padding = $(this).val() + "px";
        $("#pageContent").find("[contenteditable=true]").css("margin", padding);
    });

    $("#saveButton").click(function() {
        var content = $("#pageContent").html();
        $.ajax({
            url: "/admin/index.php?module=page&action=editPage&id=<?= $page->id ?>",
            type: "POST",
            data: {
                content: content,
                action: 1
            }
        });
    });
});