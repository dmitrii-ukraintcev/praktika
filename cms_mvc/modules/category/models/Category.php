<?php

namespace modules\category\models;

use src\Entity;
use src\Route;

class Category extends Entity
{
    function __construct($connection)
    {
        parent::__construct($connection, 'categories');
    }

    function initFields()
    {
        $this->fields = [
            'title',
            'parent_category_id'
        ];
    }

    public function addCategory($values)
    {
        if (!$values['parent_category_id']){
            unset($values['parent_category_id']);
        }
        $this->setValues($values);
        $this->insert();

        $categoryUrl = $this->generateUrl();
        $categoryId = $this->lastInsertedId;
        $route = new Route($this->db_conn);
        $route->insertRoute($categoryUrl, 'post', 'category', $categoryId);
    }

    public function updateCategory($values)
    {
        if (!$values['parent_category_id']){
            unset($values['parent_category_id']);
        }
        $this->setValues($values);
        $this->update();

        $categoryUrl = $this->generateUrl();
        $route = new Route($this->db_conn);
        $route->getByField('category_id', $this->id);
        $route->updateRoutePath($categoryUrl);

        $childCategories = $this->getChildCategories();
        foreach ($childCategories as $category) {
            $categoryUrl = $category->generateUrl();
            $route = new Route($this->db_conn);
            $route->getByField('category_id', $category->id);
            $route->updateRoutePath($categoryUrl);
        }
    }

    public function getChildCategories(): array
    {
        return $this->getAll('parent_category_id', $this->id);
    }

    // Метод для генерации URL
    function generateUrl()
    {
        $url = strtolower(str_replace(' ', '-', $this->title));

        if ($this->parent_category_id !== null && $this->parent_category_id != 1) {
            $route = new Route($this->db_conn);
            $route->getByField('category_id', $this->parent_category_id);
            $parentUrl = $route->path;
            $url = $parentUrl . '/' . $url;
        } else {
            $url = 'category/' . $url;
        }
        return $url;
    }
}
