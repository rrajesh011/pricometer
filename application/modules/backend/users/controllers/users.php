<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/4/2016
 * Time: 5:47 PM
 */

/**
 * Class Users
 @property Users_m $users_m Users Model
 */
class Users extends Back_controller
{

    private $error = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_m');
        if (!$this->isLogged()) {
            redirect(base_url('admin/auth/login'));
        }
    }

    public function index()
    {
        $this->lang->load('users');

        $this->getUsersList();
    }

    public function add()
    {
        $this->lang->load('users');

        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateForm()) {

            $this->users_m->addUser($this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));

            $url = '';
            if ($this->input->get('sort')) {
                $url .= '&sort=' . $this->input->get('sort');
            }
            if ($this->input->get('order')) {
                $url .= '&order=' . $this->input->get('order');
            }
            redirect(base_url('admin/users?token=' . $this->token . $url));
        }
        $this->getForm();
    }


    public function edit()
    {
        $this->lang->load('users');

        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateForm()) {
            $this->users_m->editUser($this->input->get('user_id'), $this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));

            $url = '';
            if ($this->input->get('sort')) {
                $url = '&sort=' . $this->input->get('sort');
            }
            if ($this->input->get('order')) {
                $url = '&order=' . $this->input->get('order');
            }
            redirect(base_url('admin/users?token=' . $this->token . $url));

        }
        $this->getForm();
    }


    public function delete()
    {
        $this->lang->load('users');
        $this->template->title($this->lang->line('heading_title'));
        if ($this->input->get('user_id')) {
            $this->users_m->deleteUser($this->input->get('user_id'));
            $this->session->set_flashdata('success', $this->lang->line('text_delete_success'));

            $url = '';
            if ($this->input->get('sort')) {
                $url = '&sort=' . $this->input->get('sort');
            }
            if ($this->input->get('order')) {
                $url = '&order=' . $this->input->get('order');
            }
            redirect(base_url('admin/users?token=' . $this->token . $url));
        }
        $this->getUsersList();
    }

    public function deleteMultiple()
    {
        $this->lang->load('users');
        if ($ids = $this->input->post('selected')) {
            $this->users_m->deleteUsers($ids);
            $this->session->set_flashdata('success', $this->lang->line('text_delete_success'));
            redirect(base_url('admin/users?token=' . $this->token));
        } else {
            $this->session->set_flashdata('error_warning', 'No row selected');
            redirect(base_url('admin/users?token=' . $this->token));
        }
    }

    protected function validateForm()
    {

        if ((utf8_strlen($this->input->post('username')) < 4) || (utf8_strlen($this->input->post('username')) > 20)) {
            $this->error['username'] = $this->lang->line('error_username');
        }
        $user_info = $this->users_m->getUserByUsername($this->input->post('username'));

        if (!$this->input->get('user_id')) {
            if ($user_info) {
                $this->error['warning'] = $this->lang->line('error_exists_username');
            }
        } else {
            if ($user_info && ($this->input->get('user_id') != $user_info['user_id'])) {
                $this->error['warning'] = $this->lang->line('error_exists_username');
            }
        }
        if ((utf8_strlen($this->input->post('email')) > 96) || !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $this->lang->line('error_email');
        }

        $user_info = $this->users_m->getUSerByEmail($this->input->post('email'));
        if (!$this->input->get('user_id')) {
            if ($user_info) {
                $this->error['warning'] = $this->lang->line('error_exists_email');
            }
        } else {
            if ($user_info && ($this->input->get('user_id') != $user_info['user_id'])) {
                $this->error['warning'] = $this->lang->line('error_exists_email');
            }
        }

        if ($this->input->post('password') || (!$this->input->get('user_id'))) {
            if ((utf8_strlen(html_entity_decode($this->input->post('password'), ENT_QUOTES, "UTF-8")) < 4) || (utf8_strlen(html_entity_decode($this->input->post('password'), ENT_QUOTES, "UTF-8")) > 20)) {
                $this->error['password'] = $this->lang->line('error_password');
            }

            if ($this->input->post('password') != $this->input->post('password_confirm')) {
                $this->error['confirm'] = $this->lang->line('error_confirm');
            }
        }
        return !$this->error;
    }


    protected function getUsersList()
    {
        if ($this->input->get('sort')) {
            $sort = $this->input->get('sort');
        } else {
            $sort = 'username';
        }

        if ($this->input->get('order')) {
            $order = $this->input->get('order');
        } else {
            $order = 'ASC';
        }


        $url = '';

        if ($this->input->get('sort')) {
            $url .= '&sort=' . $this->input->get('sort');
        }

        if ($this->input->get('order')) {
            $url .= '&order=' . $this->input->get('order');
        }


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('text_home'),
            'href' => base_url('admin/dashboard?token=' . $this->token)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('heading_title'),
            'href' => base_url('admin/users?token=' . $this->token . $url)
        );

        $data['add'] = base_url('admin/users/add?token=' . $this->token . $url);
        $data['delete'] = base_url('admin/users/delete?token=' . $this->token . $url);

        $data['users'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order
        );

        $data['token'] = $this->token;
        $data['users'] = $this->users_m->getUsers($filter_data);
        $data['heading_title'] = $this->lang->line('heading_title');
        $this->template->title($this->lang->line('heading_title'));
        $this->template->build('user_list', $data);
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_form'] = !($this->input->get('user_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');

        $data['entry_username'] = $this->lang->line('entry_username');
        $data['entry_user_group'] = $this->lang->line('entry_user_group');
        $data['entry_password'] = $this->lang->line('entry_password');
        $data['entry_confirm'] = $this->lang->line('entry_confirm');
        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_email'] = $this->lang->line('entry_email');
        $data['entry_image'] = $this->lang->line('entry_image');
        $data['entry_status'] = $this->lang->line('entry_status');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        isset($this->error['warning']) ? $data['error_warning'] = $this->error['warning'] : $data['error_warning'] = '';
        isset($this->error['username']) ? $data['error_username'] = $this->error['username'] : $data['error_username'] = '';
        isset($this->error['password']) ? $data['error_password'] = $this->error['password'] : $data['error_password'] = '';
        isset($this->error['confirm']) ? $data['error_confirm'] = $this->error['confirm'] : $data['error_confirm'] = '';
        isset($this->error['email']) ? $data['error_email'] = $this->error['email'] : $data['error_email'] = '';

        $url = '';
        if ($this->input->get('sort')) {
            $url .= '&sort=' . $this->input->get('sort');
        }

        if ($this->input->get('order')) {
            $url .= '&order=' . $this->input->get('order');
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('text_home'),
            'href' => base_url('admin/dashboard?token=' . $this->token)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('heading_title'),
            'href' => base_url('admin/users?token=' . $this->token . $url)
        );

        if (!$this->input->get('user_id')) {
            $data['action'] = base_url('admin/users/add?token=' . $this->token . $url);
        } else {
            $data['action'] = base_url('admin/users/edit?user_id=' . $this->input->get('user_id') . '&token=' . $this->token . $url);
        }
        $data['cancel'] = base_url('admin/users?token=' . $this->token);

        if ($this->input->get('user_id') && !$this->input->post()) {
            $user_info = $this->users_m->getUser($this->input->get('user_id'));
        }


        if ($this->input->post('username')) {
            $data['username'] = $this->input->post('username');
        } elseif (!empty($user_info)) {
            $data['username'] = $user_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($this->input->post('user_group_id')) {
            $data['user_group_id'] = $this->input->post('user_group_id');
        } elseif (!empty($user_info)) {
            $data['user_group_id'] = $user_info['user_group_id'];
        } else {
            $data['user_group_id'] = '';
        }


        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        } else {
            $data['password'] = '';
        }

        if ($this->input->post('confirm')) {
            $data['confirm'] = $this->input->post('confirm');
        } else {
            $data['confirm'] = '';
        }

        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
        } elseif (!empty($user_info)) {
            $data['name'] = $user_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->input->post('email')) {
            $data['email'] = $this->input->post('email');
        } elseif (!empty($user_info)) {
            $data['email'] = $user_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->input->post('image')) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($user_info)) {
            $data['image'] = $user_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->input->post('status')) {
            $data['status'] = $this->input->post('status');
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 0;
        }

        $this->template->build('user_form', $data);
    }

}