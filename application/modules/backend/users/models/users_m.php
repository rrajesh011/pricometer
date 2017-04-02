<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/4/2016
 * Time: 5:52 PM
 */
class Users_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers($data)
    {
        $sort_data = array('username', 'status', 'date_added');
        $sql = '';
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= $data['sort'];
        } else {
            $sql .= ' username';
        }

        if (isset($data['order']) && $data['order'] == 'DESC') {
            $sql .= ' DESC';
        } else {
            $sql .= ' ASC';
        }

        return $this->db->order_by($sql)
            ->get('users')
            ->result_array();

    }


    public function getUserByUsername($username)
    {
        return $this->db->where('username', $username)
            ->get('users')->row_array();
    }

    public function getUSerByEmail($email)
    {
        return $this->db->where('email', $email)
            ->get('users')
            ->row_array();
    }

    public function addUser($data)
    {
        $salt = $this->token(10);
        $password = $data['password'];
        $insertArray = array(
            'user_group_id' => $data['user_group_id'],
            'username' => $data['username'],
            'password' => $password,
            'salt' => $salt,
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
            'date_added' => date('Y-m-d H:i:s')
        );
        $this->output->enable_profiler();
        return $this->db->insert('users', $insertArray)
            ->insert_id;
    }


    public function getUser($user_id)
    {
        $query = $this->db->query("SELECT *, (SELECT ug.name FROM `users_group` ug WHERE ug.user_group_id = u.user_group_id) AS user_group FROM `users` u WHERE u.user_id = '" . (int)$user_id . "'");

        return $query->row_array();
    }

    public function editUser($user_id, $data)
    {
        $this->db->query("UPDATE `users` SET username = '" . $data['username'] . "', user_group_id = '" . (int)$data['user_group_id'] . "', NAME = '" . $data['name'] . "', email = '" . $data['email'] . "', STATUS = '" . (int)$data['status'] . "' WHERE user_id = '" . (int)$user_id . "'");

        if ($data['password']) {
            $this->db->query("UPDATE `users` SET salt = '" . $salt = $this->token(9) . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' WHERE user_id = '" . (int)$user_id . "'");
        }
    }

    public function deleteUser($user_id)
    {
        $this->db->where('user_id', $user_id)
            ->delete('users');
    }

    public function deleteUsers($users_id)
    {
        $this->db->where_in('user_id', $users_id)
            ->delete('users');
    }
}