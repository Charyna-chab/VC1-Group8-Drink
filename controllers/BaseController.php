<?php

class BaseController{

    protected function view($view, $data = []){

        extract($data);
        ob_start();
        require "views/{$view}.php";
        $content = ob_get_clean();
        require "views/layout.php";
    }
    protected function redirect($url){

        header("location: $url");
        exit();
    }
}