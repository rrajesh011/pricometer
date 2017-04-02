<?php

/**
 * Class Back_Controller
 * @property CI_Lang $lang
 * @property Image_m $Image_m
 */
class Back_controller extends MY_Controller {

    private $permission = array();
    public $token = '';

    public function __construct() {
        parent::__construct();
        $this->token = $this->session->userdata('token');
        $this->lang->load('common');


    }


    /**
     * @return bool|string
     */
    public function isLogged()
    {
        if ($this->session->userdata('isLogged') && $this->input->get('token')) {
            return $this->session->userdata('user_id');
        }
        return false;
    }

    public function token($length = 32)
    {
        // Create random token
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $max = strlen($string) - 1;

        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[mt_rand(0, $max)];
        }

        return $token;
    }

    public function hasPermission($key, $value)
    {
        if (isset($this->permission[$key])) {
            return in_array($value, $this->permission[$key]);
        } else {
            return false;
        }
    }


    public function check_file_status($entity, $path, $file)
    {

        $row = $this->db->where(array('entity' => $entity, 'name' => $file))
            ->get('excel_files')
            ->row_array();
        if (empty($row))
            return 'File Not Found';

        $filePath = realpath($path . $file);
        if (!$this->check_file_access($filePath))
            return 'Locked';


        $file_attr = json_decode($row['attributes'], true);
        if (sha1_file($filePath) != $file_attr['sha1'])
            return 'Modified';

        return false;
    }

    public function check_file_access($file)
    {
        $fp = @fopen($file, "r+");
        if (empty($fp)) {
            return false;
        }
        if (flock($fp, LOCK_EX)) {  // acquire an exclusive lock
            flock($fp, LOCK_UN);    // release the lock
            fclose($fp);
            return true;
        } else {
            fclose($fp);
            return false;
        }
    }
}
