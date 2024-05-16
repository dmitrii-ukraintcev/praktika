<?php

namespace src;

class Route extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'routes');
    }

    function initFields()
    {
        $this->fields = [
            'path',
            'controller',
            'action',
            'page_id',
            'post_id',
            'category_id',
            'tag_id'
        ];
    }

    function insertRoute($url, $controller, $entity, $entity_id)
    {
        $this->setValues([
            'path' => $url,
            'controller' => $controller,
            $entity . '_id' => $entity_id
        ]);
        $this->insert();
    }

    function updateRoutePath($url)
    {
        $this->setValues(['path' => $url]);
        $this->update();
    }
}
