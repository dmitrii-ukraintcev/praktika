<?php

declare(strict_types=1);

namespace src;

use modules\user\admin\models\User;

class Auth
{
    function checkLogin(string $username, string $password): bool
    {
        $user = new User($GLOBALS['db_conn']);
        $user->getByField('username', $username);

        if (!$user->id) {
            return false;
        }
        if (!password_verify($password, $user->password_hash)) {
            return false;
        }
        $_SESSION['current_user_id'] = $user->id;
        return true;
    }
}
