<?php

namespace modules\post\models;

use src\Entity;
use src\Route;

class Post extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'posts');
    }

    function initFields()
    {
        $this->fields = [
            'title',
            'content',
            'author_id',
            'updated_datetime'
        ];
    }

    public function addPost($values)
    {
        $this->setValues($values);
        $this->insert();

        $postUrl = $this->generateUrl();
        $postId = $this->lastInsertedId;
        $route = new Route($this->db_conn);
        $controllerName = lcfirst(basename($this::class));
        $route->insertRoute($postUrl, $controllerName, $controllerName, $postId);
    }

    public function updatePost($values)
    {
        $this->setValues($values);
        $this->update();

        $postUrl = $this->generateUrl();
        $route = new Route($this->db_conn);
        $route->getByField('post_id', $this->id);
        $route->updateRoutePath($postUrl);
    }

    // Метод для генерации URL
    function generateUrl()
    {
        return 'post/' . strtolower(str_replace(' ', '-', $this->title));
    }
}