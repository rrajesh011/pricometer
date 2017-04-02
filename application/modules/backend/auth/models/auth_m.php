<?php

class Auth_m extends MY_Model
{
    private $user_id;
    private $user_group_id;
    private $username;
    private $permission = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function checkLogin($username, $password)
    {

        $column = 'username';
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $column = 'email';
        }
        $row = $this->db->where(
            array(
                'status' => 1,
                $column => $username,
                'password' => $password
            )
        )->get('users')->row_array();

        if ($row) {
            $sessionData = array(
                'isLogged' => true,
                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'user_group_id' => $row['user_group_id']
            );

            $this->session->set_userdata($sessionData);
            $user_group = $this->db->where('user_group_id', (int)$row['user_group_id'])
                ->get('users_group')
                ->row_array();

            $permission = @json_decode($user_group, true);
            if (is_array($permission)) {
                foreach ($permission as $key => $value) {
                    $this->permission[$key] = $value;
                }
            }
            return true;
        }
        return false;
    }

}