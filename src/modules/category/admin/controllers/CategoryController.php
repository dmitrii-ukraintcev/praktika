<?php

namespace modules\category\admin\controllers;

use modules\category\models\Category;
use src\Controller;

class CategoryController extends Controller
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
        $categoryObj = new Category($GLOBALS['db_conn']);
        $data['categories'] = $categoryObj->getAll();

        $this->template->renderView('category/admin/views/category_list', $data);
    }

    function editCategoryAction(): void
    {
        $categoryId = $_GET['id'];
        $categoryObj = new Category($GLOBALS['db_conn']);
        $categoryObj->getByField('id', $categoryId);

        if ($_POST['action'] ?? 0) {
            $categoryObj->updateCategory($_POST);
        }

        $data['category'] = $categoryObj;
        $data['categories'] = $categoryObj->getAll();
        // $data['child_categories'] = $categoryObj->getChildCategories();
        $this->template->renderView('category/admin/views/category_edit', $data);
    }

    function addCategoryAction(): void
    {
        if ($_POST['action'] ?? 0 == 1) {
            $categoryObj = new Category($GLOBALS['db_conn']);
            $categoryObj->addCategory($_POST);

            header('Location: /admin/index.php?module=category');
            exit();
        }

        $categoryObj = new Category($GLOBALS['db_conn']);
        $data['categories'] = $categoryObj->getAll();
        $this->template->renderView('category/admin/views/category_add', $data);
    }

    function deleteCategoryAction(): void
    {
        $categoryId = $_GET['id'];
        $categoryObj = new Category($GLOBALS['db_conn']);
        $categoryObj->getByField('id', $categoryId);
        $categoryObj->delete();

        header('Location: /admin/index.php?module=category');
    }
}
