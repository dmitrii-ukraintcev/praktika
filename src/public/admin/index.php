<?php

use src\DatabaseConnection;
use src\Template;

session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . 'views' . DIRECTORY_SEPARATOR);
define('MODULES_PATH', ROOT_PATH . 'modules' . DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class_name) {
    $file = ROOT_PATH . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

DatabaseConnection::connect('localhost', 'root', '', 'cms_db');
$db_conn = DatabaseConnection::getInstance()->getConnection();

$module = $_GET['module'] ?? $_POST['module'] ?? 'dashboard';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

$db_handler = DatabaseConnection::getInstance();
$db_conn = $db_handler->getConnection();

$template = new Template('admin/dashboard');
$controllerName = "modules\\$module\admin\controllers\\" . ucfirst($module) . 'Controller';
$controller = new $controllerName($template);
$controller->runAction($action);