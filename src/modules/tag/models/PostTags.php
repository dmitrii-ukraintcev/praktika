<?php

namespace modules\tag\models;

use src\Entity;

class PostTags extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'post_tags');
    }

    function initFields()
    {
        $this->fields = [
            'post_id',
            'tag_id'
        ];
    }
}