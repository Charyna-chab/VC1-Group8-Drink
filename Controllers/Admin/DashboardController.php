<?php
require_once './Controllers/BaseController.php';
class DashboardController extends BaseController{
    function index()
    {
        
        $this->views('dashboard/list.php');
    }
}
?>