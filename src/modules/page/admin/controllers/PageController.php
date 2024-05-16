<?php

declare(strict_types=1);

namespace modules\page\admin\controllers;

use src\Controller;
use modules\page\models\Page;

class PageController extends Controller
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

    function defaultAction(): void
    {
        $pageObj = new Page($GLOBALS['db_conn']);
        $data['pages'] = $pageObj->getAll();

        $this->template->renderView('page/admin/views/page_list', $data);
    }

    function editPageAction(): void
    {
        $pageId = $_GET['id'];
        $pageObj = new Page($GLOBALS['db_conn']);
        $pageObj->getByField('id', $pageId);

        if ($_POST['action'] ?? 0) {
            $pageObj->updatePage($_POST);
        }

        // $data['page'] = $pageObj;
        // $data['pages'] = $pageObj->getAll();
        // $data['child_pages'] = $pageObj->getChildPages();
        $page = $pageObj;
        $pages = $pageObj->getAll();
        $child_pages = $pageObj->getChildPages();
        // $this->template->renderView('page/admin/views/page_edit', $data);
        include VIEW_PATH . 'admin/content_editor.php';
    }

    function addPageAction(): void
    {
        if ($_POST['action'] ?? 0 == 1) {
            $pageObj = new Page($GLOBALS['db_conn']);
            $pageObj->addPage($_POST);

            header('Location: /admin/');
            exit();
        }

        $pageObj = new Page($GLOBALS['db_conn']);
        $data['pages'] = $pageObj->getAll();
        $this->template->renderView('page/admin/views/page_add', $data);
    }

    function deletePageAction(): void
    {
        $pageId = $_GET['id'];
        $pageObj = new Page($GLOBALS['db_conn']);
        $pageObj->getByField('id', $pageId);
        $pageObj->delete();

        header('Location: /admin/');
    }
}
