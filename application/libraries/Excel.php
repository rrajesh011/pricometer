<?php
if (!defined('BASEPATH')) exit('No Direct script allowed');

/**
 * Created by PhpStorm.
 * User: Rajesh
 * Date: 12/16/2016
 * Time: 10:15 AM
 */
require_once APPPATH . 'third_party/PHPExcel.php';

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
    }
}