<?php
namespace JoinTheTeamController\Controllers;

class JoinTheTeamController extends BaseController {
    public function index() {
        // Render the join the team page
        $this->render('join-the-team');
    }
}