<?php
namespace LocationsController\Controllers;

class LocationsController extends BaseController {
    public function index() {
        // Render the locations page
        $this->render('locations');
    }
}