<?php

declare(strict_types=1);

namespace modules\contact\controllers;

use src\Controller;
use modules\page\models\Page;

class ContactController extends Controller
{
    function runBeforeAction(): bool
    {
        if ($_SESSION['has_submitted'] ?? 0 == 1) {
            $pageObj = new Page($GLOBALS['db_conn']);
            $pageObj->getByField('id', 5);
            $data['page'] = $pageObj;

            $this->updateView('page/views/static_page', $data);
            return false;
        }
        return true;
    }

    function defaultAction(): void
    {
        // if (!$this->runBeforeAction()) {
        //     return;
        // }

        $pageObj = new Page($GLOBALS['db_conn']);
        $pageObj->getByField('id', $this->entity_id);
        $data['page'] = $pageObj;

        $this->updateView('contact/views/contact_us', $data);
    }

    function submitAction(): void
    {
        // if (!$this->runBeforeAction()) {
        //     return;
        // }
        $_SESSION['has_submitted'] = 1;

        $pageObj = new Page($GLOBALS['db_conn']);
        $pageObj->getByField('id', $this->entity_id);
        $data['page'] = $pageObj;

        $this->updateView('page/views/static_page', $data);
    }
}
