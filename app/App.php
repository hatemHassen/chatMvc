<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 30/01/18
 * Time: 17:56
 */

class App
{

    static public function handleRequest()
    {
        if(!isset($_SESSION)) {
            session_start();
        }

        $uri = $_SERVER['REQUEST_URI'];

        // try to extract the controller and action from uri string //
        list(, $controller, $action) = explode('/', $uri);

        self::runAction($controller, $action);
    }

    public static function runAction($controller, $action)
    {
        $controller=($controller)?:'default';
        $action=($action)?:'index';

        $controller = "Chat\Controllers\\".ucfirst($controller)."Controller";
        $action = "{$action}Action";

        //validate requested controller and action //
        if (class_exists($controller)) {
            $controller = new $controller();

            if (method_exists($controller, $action)) {

                $controller->$action();
                die();
            }

        }
        // if the controller doesn't exist then we redirect to not found action //
        self::runAction("error", "notFound");
    }

}