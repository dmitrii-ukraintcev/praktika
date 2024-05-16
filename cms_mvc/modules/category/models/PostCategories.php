<?php

namespace modules\category\models;

use src\Entity;

class PostCategories extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'post_categories');
    }

    function initFields()
    {
        $this->fields = [
            'post_id',
            'category_id'
        ];
    }
}