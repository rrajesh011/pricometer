<?php

/**
 * 
 * 
 */
class Auth extends Back_controller
{
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_m');
    }

    public function login()
    {
        $this->lang->load('auth');


        //check if user is already logged in
        if ($this->isLogged() && $this->input->get('token') && $this->input->get('token') == $this->session->userdata('token')) {
            $url = 'admin/dashboard?token=' . $this->session->userdata('token');
            redirect(base_url($url));
        }


        //logging in
        if ($this->input->post() && $this->validate()) {
            $this->session->set_userdata('token', $this->token(32));
            $url = 'admin/dashboard?token=' . $this->session->userdata('token');
            redirect(base_url($url));
        }
        $this->template->title($this->lang->line('heading_title'));
        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_login'] = $this->lang->line('text_login');
        $data['text_forgotten'] = $this->lang->line('text_forgotten');

        $data['entry_username'] = $this->lang->line('entry_username');
        $data['entry_password'] = $this->lang->line('entry_password');

        $data['button_login'] = $this->lang->line('button_login');

        if (($this->session->userdata('token') && !$this->input->get('token')) || ($this->session->userdata('token') != $this->input->get('token'))) {
            $this->error['warning'] = $this->lang->line('error_token');
        }

        isset($this->error['warning']) ? $data['error_warning'] = $this->error['warning'] : $data['error_warning'] = '';

        $this->session->userdata('success') ? $data['success'] = $this->session->userdata('success') : $data['success'] = '';

        $data['action'] = base_url('admin/auth/login');

        $this->template->build('login', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('session_id');
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('isLogged');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_group_id');
        redirect(base_url('admin/auth/login'));
    }

    protected function validate()
    {
        if (!$this->input->post('username') || !$this->input->post('password') || !$this->auth_m->checkLogin($this->input->post('username'), $this->input->post('password'))) {
            $this->error['warning'] = $this->lang->line('error_login');
        }

        return !$this->error;
    }
}