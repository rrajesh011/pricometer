<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/4/2016
 * Time: 7:30 PM
 */

/**
 * Class Dashboard
 */
class Dashboard extends Back_controller
{

    public function __construct()
    {
        parent::__construct();

        //Checking User is loggedIN
         if (!$this->isLogged()) {
            redirect(base_url('admin/auth/login'));
        }
    }


    public function index()
    {

        $this->template->build('index');
    }
}
