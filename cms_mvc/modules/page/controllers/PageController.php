<?php

declare(strict_types=1);

namespace modules\page\controllers;

use src\Controller;
use modules\page\models\Page;
use src\Template;

class PageController extends Controller
{
    function defaultAction(): void
    {
        $pageObj = new Page($GLOBALS['db_conn']);
        $pageObj->getByField('id', $this->entity_id);
        $data['page'] = $pageObj;

        $template = new Template('templates/default');
        $template->renderView('page/views/static_page', $data);
    }
}
