<?php

class WelcomeController extends BaseController {
    public function welcome() {
        $this->views('welcome/welcome');
    }
}