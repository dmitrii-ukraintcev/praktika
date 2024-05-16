<?php

declare(strict_types=1);
namespace src;

use modules\menu\admin\models\MenuItem;

class Template
{
    private $template;

    function __construct(string $template)
    {
        $this->template = $template;
    }

    function renderView(string $view, array $data) : void
    {
        extract($data);
        $menu = new MenuItem($GLOBALS['db_conn']);
        $menuItems = $menu->getAll();
        include VIEW_PATH . $this->template . ".php";
    }
}
