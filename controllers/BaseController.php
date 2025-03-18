<?php
require_once 'Database/database.php';
class BaseController{

    
    public function views($views, $data = []){
        extract($data);
        ob_start();
        $content = ob_get_clean();
        require_once 'views/layout.php';
        // require_once 'views/layout-dashboard.php';
        require_once 'views/'.$views; 


    }
    
    public function redirect($uri){
        header('Location:' . $uri);
        exit();
    }
}