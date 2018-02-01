<?php
namespace Chat\Controllers;

abstract class BaseController
{


    protected function renderView($template, array $vars = array())
    {
        extract($vars);
        include '../src/Views/'.$template;

    }

    protected function redirectUrl($url)
    {
        header("location: $url",true,302);
        exit();
    }
}

?>
