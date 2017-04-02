<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/4/2016
 * Time: 3:23 PM
 */

/**
 * Class MY_Controller
 * @property Template $template
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_Input $input
 */
class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helpers(array('my'));
       
    }

}
