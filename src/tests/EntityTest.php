<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use modules\page\models\Page;

class DatabaseConnection
{
    function prepare()
    {
        return new Statement();
    }
}

class Statement
{
    function bind_param()
    {
    }

    function execute()
    {
    }

    function get_result()
    {
        return new Data();
    }
}

class Data
{
    public $data = [
        ['id' => 1, 'title' => 'Home Page', 'content' => 'Home page content'],
        ['id' => 2, 'title' => 'About Us Page', 'content' => 'About us content']
    ];

    private $index = 0;

    function fetch_assoc()
    {
        if ($this->index < count($this->data)) {
            $row = $this->data[$this->index];
            $this->index++;
            return $row;
        } else {
            return false;
        }
    }
}

final class EntityTest extends TestCase
{
    public function testGetAll(): void
    {
        $db_conn = new DatabaseConnection();
        $page = new Page($db_conn);
        $pages = $page->getAll();

        $this->assertEquals(2, count($pages));
        $this->assertEquals(1, $pages[0]->id);
    }

    public function testGetByField(): void
    {
        $db_conn = new DatabaseConnection();
        $page = new Page($db_conn);
        $page->getByField('id', 1);

        $this->assertEquals(1, $page->id);
    }
}
