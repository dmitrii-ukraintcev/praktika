<?php

namespace modules\page\models;

use src\Entity;
use src\Route;

class Page extends Entity
{
    public $title;
    public $content;
    public $parent_page_id;
    function __construct($connection)
    {
        parent::__construct($connection, 'pages');
    }

    function initFields()
    {
        $this->fields = [
            'title',
            'content',
            'parent_page_id'
        ];
    }

    public function addPage($values)
    {
        $this->setValues($values);
        $this->insert();

        $pageUrl = $this->generateUrl();
        $pageId = $this->lastInsertedId;
        $route = new Route($this->db_conn);
        $controllerName = lcfirst(basename($this::class));
        $route->insertRoute($pageUrl, $controllerName, $controllerName, $pageId);
    }

    public function updatePage($values)
    {
        $this->setValues($values);
        $this->update();

        $pageUrl = $this->generateUrl();
        $route = new Route($this->db_conn);
        $route->getByField('page_id', $this->id);
        $route->updateRoutePath($pageUrl);

        $childPages = $this->getChildPages();
        foreach ($childPages as $page) {
            $pageUrl = $page->generateUrl();
            $route = new Route($this->db_conn);
            $route->getByField('page_id', $page->id);
            $route->updateRoutePath($pageUrl);
        }
    }

    public function getChildPages(): array
    {
        return $this->getAll('parent_page_id', $this->id);
    }

    // Метод для генерации URL страницы
    function generateUrl()
    {
        $url = strtolower(str_replace(' ', '-', $this->title));

        if ($this->parent_page_id !== null && $this->parent_page_id != 1) {
            $route = new Route($this->db_conn);
            $route->getByField('page_id', $this->parent_page_id);
            $parentUrl = $route->path;
            $url = $parentUrl . '/' . $url;
        } else {
            $url = 'page/' . $url;
        }

        // if ($this->parent_page_id !== null && $this->parent_page_id != 1) {
        //     $parentPage = new Page($GLOBALS['db_conn']);
        //     $parentPage->getByField('id', $this->parent_page_id);

        //     $parentUrl = $parentPage->generateUrl();

        //     $url = $parentUrl . '/' . $url;
        // }

        return $url;
    }
}
