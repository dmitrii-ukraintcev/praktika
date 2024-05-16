<?php

namespace modules\user\admin\models;

use src\Entity;

class User extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'users');
    }

    function initFields()
    {
        $this->fields = [
            'id',
            'username',
            'password_hash'
        ];
    }
}
