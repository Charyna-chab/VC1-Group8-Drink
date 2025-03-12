<?php
require_once 'BaseController.php';
class DashboardController extends BaseController{
    function index()
    {
        
        $this->views('dashboard/list.php');
    }
}
?>