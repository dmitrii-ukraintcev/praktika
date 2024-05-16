<?php

namespace modules\post\admin\controllers;

use src\Controller;
use modules\post\models\Post;

class PostController extends Controller
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
        $postObj = new Post($GLOBALS['db_conn']);
        $data['posts'] = $postObj->getAll();

        $this->template->renderView('post/admin/views/post_list', $data);
    }

    function addPostAction(): void
    {
        if ($_POST['action'] ?? 0 == 1) {
            $postObj = new Post($GLOBALS['db_conn']);
            $_POST['author_id'] = $_SESSION['current_user_id'];
            $postObj->addPost($_POST);

            header('Location: /admin/');
            exit();
        }

        $postObj = new Post($GLOBALS['db_conn']);
        $this->template->renderView('post/admin/views/post_add', []);
    }

    function deletePostAction(): void
    {
        $postId = $_GET['id'];
        $postObj = new Post($GLOBALS['db_conn']);
        $postObj->getByField('id', $postId);
        $postObj->delete();

        header('Location: /admin/');
    }
}
