<?php

declare(strict_types=1);

namespace modules\user\admin\controllers;

use src\Controller;
use modules\user\admin\models\User;

class UserController extends Controller
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
        $userObj = new User($GLOBALS['db_conn']);
        $data['users'] = $userObj->getAll();

        $this->template->renderView('page/admin/views/user_list', $data);
    }
}
