<?php

namespace modules\dashboard\admin\controllers;

use src\Controller;
use src\Auth;

class DashboardController extends Controller
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

    function defaultAction()
    {
        header('Location: /admin/index.php?module=page');
        exit();
    }

    function loginAction()
    {
        if ($_POST['postAction'] ?? 0 == 1) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            if ($auth->checkLogin($username, $password)) {
                $_SESSION['is_admin'] = 1;
                header('Location: /admin/');
                exit();
            }
            // var_dump($password);
            $_SESSION['validation']['error'] = "Username or password is incorrect";
        }

        include VIEW_PATH . 'admin/login.php';
        unset($_SESSION['validation']['error']);
    }
}
