<?php

namespace modules\tag\models;

use src\Entity;

class Tag extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'tags');
    }

    function initFields()
    {
        $this->fields = [
            'name',
        ];
    }
}
