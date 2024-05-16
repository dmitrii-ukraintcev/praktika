<?php

declare(strict_types=1);

namespace modules\menu\admin\controllers;

use modules\menu\admin\models\Menu;
use src\Controller;
use modules\menu\admin\models\MenuItem;
use modules\page\models\Page;
use src\Route;

class MenuController extends Controller
{
    function runBeforeAction(): bool
    {
        if ($_SESSION['is_admin'] ?? 0 == 1) {
            return true;
        }
        $action = $_GET['action'] ?? $_POST['action'] ?? 'default';
        if ($action != 'login') {
            header('Location: /admin/index.php?module=dashboard&action=login');
            return false;
        } else {
            return true;
        }
    }

    // Функция для получения списка меню
    function defaultAction(): void
    {
        $menuObj = new Menu($GLOBALS['db_conn']);
        $data['menus'] = $menuObj->getAll();

        $this->template->renderView('menu/admin/views/menu_list', $data);
    }

    // Функция для получения списка пунктов выбранного меню
    function editMenuAction(): void
    {
        $menuId = $_GET['id'];
        $menuItemObj = new MenuItem($GLOBALS['db_conn']);
        $menuObj = new Menu($GLOBALS['db_conn']);

        $data['menu_items'] = $menuItemObj->getAllMenuItems($menuId);
        $data['menu_id'] = $menuId;
        $menuObj->getByField('id', $menuId);
        $data['menu_name'] = $menuObj->name;

        $this->template->renderView('menu/admin/views/menu_edit', $data);
    }

    // Функция для обновления существующего пункта меню
    function editMenuItemAction(): void
    {
        $menuItemId = $_GET['id'];
        $menuItemObj = new MenuItem($GLOBALS['db_conn']);
        $menuItemObj->getByField('id', $menuItemId);

        if ($_POST['action'] ?? 0) {
            $menuItemObj->setValues($_POST);
            $menuItemObj->update();
        }

        $data['menu_item'] = $menuItemObj;
        $data['menu_items'] = $menuItemObj->getAll('menu_id', $menuItemObj->menu_id);
        $this->template->renderView('menu/admin/views/menu_item_edit', $data);
    }

    // Функция для добавления нового пункта меню
    function addMenuItemAction(): void
    {
        $menuId = $_GET['id'];
        $pageObj = new Page($GLOBALS['db_conn']);
        $menuItemObj = new MenuItem($GLOBALS['db_conn']);

        if ($_POST['action'] ?? 0) {
            if ($_GET['type'] == 'page') {
                foreach ($_POST['pages'] as $pageId) {
                    $menuItemObj->addPageMenuItem($menuId, $pageId);
                }
            }
            if ($_GET['type'] == 'link') {
                $menuItemObj->addLinkMenuItem($menuId, $_POST['title'], $_POST['url'], $_POST['parent_menu_item_id'] ?? null);
            }
            header("Location: /admin/index.php?module=menu&action=editMenu&id=$menuId");
            exit();
        }

        $data['pages'] = $pageObj->getAll();
        $data['menu_items'] = $menuItemObj->getAll('menu_id', $menuId);
        $data['added_page_ids'] = $menuItemObj->getAddedPageIds($menuId);

        if ($_GET['type'] == 'page') {
            $this->template->renderView('menu/admin/views/menu_item_add_page', $data);
        } else if ($_GET['type'] == 'link') {
            $this->template->renderView('menu/admin/views/menu_item_add', $data);
        }
    }

    // Функция для удаления пункта меню
    function deleteMenuItemAction(): void
    {
        $menuItemId = $_GET['id'];
        $menuItemObj = new MenuItem($GLOBALS['db_conn']);
        $menuItemObj->getByField('id', $menuItemId);
        $menuItemObj->delete();

        header("Location: /admin/index.php?module=menu&action=editMenu&id=$menuItemObj->menu_id");
    }

    // Функция для обновления порядка элементов меню
    function updateMenuOrderAction(): void
    {
        $newOrder = $_POST['order'];
        $menuItemObj = new MenuItem($GLOBALS['db_conn']);
        $menuItemObj->updateMenuOrder($newOrder);
    }
}
