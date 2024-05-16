<?php

declare(strict_types=1);

namespace src;

use modules\page\models\Page;
use mysqli;

class Controller
{
    protected $entity_id;
    public $template;

    function __construct(Template $template = null, int $entity_id = null)
    {
        $this->template = $template;
        $this->entity_id = $entity_id;
    }

    function runAction(string $action): void
    {
        $runBeforeAction = 'runBeforeAction';
        if (method_exists($this, $runBeforeAction)) {
            if (!$this->$runBeforeAction()) {
                return;
            }
        }

        $action .= 'Action';
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            // 404
            $pageObj = new Page($GLOBALS['db_conn']);
            $pageObj->getByField('id', 6);
            $data['page'] = $pageObj;

            // $this->updateView('page/views/static_page', $data);
        }
    }
}
