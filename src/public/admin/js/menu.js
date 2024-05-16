$(document).ready(function () {

    $("ul.menu-list").sortable({
        update: function (event, ui) {
            var newOrder = getAllItemIds($(this));
            $.ajax({
                url: "/admin/index.php?module=menu&action=updateMenuOrder",
                type: "POST",
                data: { order: newOrder }
            });
        }
    });

});

function getAllItemIds($element) {
    var itemIds = [];
    $element.find('li').each(function () {
        var id = $(this).attr('id');
        if (id && !itemIds.includes(id)) {
            itemIds.push(id);
        }
        if ($(this).find('ul').length) {
            itemIds = itemIds.concat(getAllItemIds($(this).find('ul')));
        }
    });
    return itemIds;
}
