<?php

/**
 * Created by PhpStorm.
 * User: Rajesh
 * Date: 12/10/2016
 * Time: 3:11 PM
 */
class Users_group_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsersGroup($data)
    {
        $sql = '';
        if (isset($data['order']) && $data['order'] == 'DESC') {
            $sql .= 'name DESC';
        } else {
            $sql .= 'name ASC';
        }

        return $this->db->order_by($sql)
            ->get('users_group')
            ->result_array();

    }
}