<?php

class Sidebar extends Back_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->lang->load('sidebar');
        if (($this->input->get('token') && $this->session->userdata('token')) && $this->input->get('token') == $this->session->userdata('token')) {
            $this->load->model('users/Users_m');
            $user_info = $this->Users_m->getUser($this->session->userdata('user_id'));
            if ($user_info) {
                $data['name'] = $user_info['name'];
                $data['username'] = $user_info['username'];
                $data['user_group'] = $user_info['user_group'];
                if (is_file(DIR_IMAGE . $user_info['image'])) {
                    $data['image'] = $user_info['image'];
                } else {
                    $data['image'] = '';
                }
            } else {
                $data['name'] = '';
                $data['username'] = '';
                $data['user_group'] = '';
            }

            //creating Menus
            $data['menus'] = array(
                array(
                    'class' => 'grey',
                    'id' => 'id-dashboard',
                    'icon' => 'fa fa-dashboard',
                    'name' => $this->lang->line('text_dashboard'),
                    'href' => base_url('admin/dashboard?token=' . $this->session->userdata('token')),
                    'children' => array()
                ),
                array(
                    'class' => 'brown with-sub',
                    'id' => 'id-user-mgmt',
                    'icon' => 'fa fa-users',
                    'name' => $this->lang->line('text_user_mgmt'),
                    'children' => array(
                        array(
                            'class' => 'grey',
                            'id' => 'id-users',
                            'icon' => 'fa fa-user',
                            'name' => $this->lang->line('text_users'),
                            'href' => base_url('admin/users?token=' . $this->session->userdata('token'))
                        ), array(
                            'class' => 'grey',
                            'id' => 'id-users-group',
                            'icon' => 'fa fa-users',
                            'name' => $this->lang->line('text_user_group'),
                            'href' => base_url('admin/users_group?token=' . $this->session->userdata('token'))
                        )
                    )
                ),
                array(
                    'class' => 'green',
                    'id' => 'id-categories',
                    'icon' => 'fa fa-tags',
                    'name' => $this->lang->line('text_category'),
                    'href' => base_url('admin/categories?token=' . $this->session->userdata('token')),
                    'children' => array()
                )
            );

            $this->session->set_userdata($data);
        }
    }
}