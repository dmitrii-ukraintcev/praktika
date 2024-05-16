<?php

namespace modules\menu\admin\models;

use src\Entity;

class Menu extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'menus');
    }

    function initFields()
    {
        $this->fields = [
            'name'
        ];
    }
}
