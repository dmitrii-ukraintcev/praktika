<?php

namespace modules\menu\admin\models;

use modules\page\models\Page;
use src\Entity;
use src\Route;

class MenuItem extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'menu_items');
    }

    protected function initFields()
    {
        $this->fields = [
            'menu_id',
            'title',
            'url',
            'parent_menu_item_id',
            'route_id',
            'order_num'
        ];
    }

    public function getAllMenuItems($menuId)
    {
        $menuItems = $this->getAll('menu_id', $menuId);

        usort($menuItems, function ($a, $b) {
            return $a->order_num <=> $b->order_num;
        });

        return $menuItems;
    }

    public function getAddedPageIds($menu_id)
    {
        $sql = "SELECT page_id FROM routes INNER JOIN menu_items ON menu_items.route_id=routes.id WHERE menu_items.menu_id=$menu_id";
        $result = $this->db_conn->query($sql);

        $added_page_ids = [];
        while ($row = $result->fetch_assoc()) {
            $added_page_ids[] = $row['page_id'];
        }

        return $added_page_ids;
    }

    public function getChildMenuItems(): array
    {
        return $this->getAll('parent_menu_item_id', $this->id);
    }

    public function getNextOrderNum($menuId)
    {
        $sql = "SELECT MAX(order_num) AS max_order_num FROM menu_items WHERE menu_id=$menuId";
        $result = $this->db_conn->query($sql);
        $row = $result->fetch_assoc();
        $maxOrderNum = $row['max_order_num'];

        return $maxOrderNum !== null ? $maxOrderNum + 1 : 1;
    }

    public function addPageMenuItem($menuId, $pageId)
    {
        $pageObj = new Page($this->db_conn);
        $routeObj = new Route($this->db_conn);

        if (!in_array($pageId, $this->getAddedPageIds($menuId))) {
            $pageObj->getByField('id', $pageId);
            $routeObj->getByField('page_id', $pageId);
            $route_id = $routeObj->id;
            $url = $routeObj->path;
            $order_num = $this->getNextOrderNum($menuId);

            $this->setValues([
                'menu_id' => $menuId,
                'title' => $pageObj->title,
                'url' => $url,
                'route_id' => $route_id,
                'order_num' => $order_num
            ]);
            $this->insert();
        }
    }

    public function addLinkMenuItem($menuId, $title, $url, $parentMenuItemId)
    {
        $order_num = $this->getNextOrderNum($menuId);

        $this->setValues([
            'menu_id' => $menuId,
            'title' => $title,
            'url' => $url,
            'order_num' => $order_num
        ]);

        if ($parentMenuItemId) {
            $this->setValues(['parent_menu_item_id' => $parentMenuItemId]);
        }

        $this->insert();
    }

    function renderMenuItem()
    {
        $html = '<li class="list-group-item" id="' . $this->id . '">';
        $html .= $this->title;
        $html .= ' <a href="/admin/index.php?module=menu&action=editMenuItem&id=' . $this->id . '">Изменить</a> ';
        $html .= ' <a href="/admin/index.php?module=menu&action=deleteMenuItem&id=' . $this->id . '">Удалить</a> ';
        if ($this->getChildMenuItems()) {
            $html .= '<button class="btn btn-sm btn-primary float-end" data-bs-toggle="collapse" data-bs-target="#submenu' . $this->id . '">Подробнее</button>';
            $html .= '<ul class="menu-list list-group collapse" id="submenu' . $this->id . '">';
            foreach ($this->getChildMenuItems() as $child) {
                $html .= $child->renderMenuItem();
            }
            $html .= '</ul>';
        }
        $html .= '</li>';
        return $html;
    }

    public function updateMenuOrder($newOrder)
    {
        foreach ($newOrder as $index => $itemId) {
            $itemId = (int)$itemId;
            $sql = "UPDATE menu_items SET order_num = $index + 1 WHERE id=$itemId";
            $this->db_conn->query($sql);
        }
    }
}
