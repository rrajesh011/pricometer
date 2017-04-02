<?php

/**
 * Class UsersGroup
 * @property Users_group_m $users_group_m
 */
class Users_group extends Back_controller
{
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_group_m');
    }

    public function index()
    {
        $this->lang->load('users_group');
        $this->template->title($this->lang->line('heading_title'));
        $this->getGroupList();
    }


    public function add()
    {
        $this->lang->load('users_group');

        if ($this->input->post() && $this->validateForm()) {

        }
        $this->getForm();
    }

    protected function getGroupList()
    {
        if ($this->input->get('sort')) {
            $sort = $this->input->get('sort');
        } else {
            $sort = 'name';
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
            'href' => base_url('admin/dashboard?token=' . $this->session->userdata('token'))
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('heading_title'),
            'href' => base_url('admin/users_group?token=' . $this->session->userdata('token') . $url)
        );

        $data['add'] = base_url('admin/users_group/add?token=' . $this->session->userdata('token') . $url);
        $data['delete'] = base_url('admin/users_group/delete?token=' . $this->session->userdata('token') . $url);

        $data['users_group'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order
        );

        $data['users_group'] = $this->users_group_m->getUsersGroup($filter_data);
        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_list'] = $this->lang->line('text_list');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');

        $data['column_name'] = $this->lang->line('column_name');
        $data['column_action'] = $this->lang->line('column_action');

        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');

        $this->template->build('users_group_list', $data);
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_form'] = !$this->input->get('user_group_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_select_all'] = $this->lang->line('text_select_all');
        $data['text_unselect_all'] = $this->lang->line('text_unselect_all');

        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_access'] = $this->lang->line('entry_access');
        $data['entry_modify'] = $this->lang->line('entry_modify');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
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
            'href' => base_url('admin/dashboard?token=' . $this->session->userdata('token'))
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('heading_title'),
            'href' => base_url('admin/users_group?token=' . $this->session->userdata('token') . $url)
        );

        if (!$this->input->get('user_group_id')) {
            $data['action'] = base_url('admin/users_group/add?token=' . $this->session->userdata('token') . $url);
        } else {
            $data['action'] = base_url('admin/users_group/edit?user_group_id=' . $this->input->get('user_group_id') . '&token = ' . $this->session->userdata('token') . $url);
        }

        $data['cancel'] = base_url('admin/users_group?token=' . $this->session->userdata('token') . $url);
        if ($this->input->get('user_group_id') && $this->input->post()) {
            $user_group_info = $this->users_group_m->getUsersGroup($this->input->get('user_group_id'));
        }

        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
        } elseif (!empty($user_group_info)) {
            $data['name'] = $user_group_info['name'];
        } else {
            $data['name'] = '';
        }

        $ignore = array(
            'admin/controllers/Auth',
            'admin/controllers/Users',
            'admin/controllers/Users_group',
        );

        $data['permissions'] = array();

        $files = array();

        // Make path into an array
        $path = array(APPPATH . 'modules/backend/*');

        // While the path array is still populated keep looping through
        while (count($path) != 0) {
            $next = array_shift($path);
            foreach (glob($next) as $file) {
                // If directory add to path array
                if (is_dir($file)) {
                    $path[] = $file . '/*';
                }

                // Add the file to the files to be deleted array
                if (is_file($file)) {
                    $files[] = $file;
                }
            }
        }

        // Sort the file array
        sort($files);

        foreach ($files as $file) {
            $controller = substr($file, strlen(APPPATH . 'modules/backend/'));

            if (preg_match('/controller/', $controller)) {
                $permission = substr($controller, 0, strrpos($controller, '.'));
            }

            if (!in_array($permission, $ignore)) {
                $data['permissions'][] = $permission;
            }

        }
        $data['permissions'] = array_values(array_unique($data['permissions']));

        if (isset($this->input->post('permission')['access'])) {
            $data['access'] = $this->input->post('permission')['access'];
        } elseif (isset($user_group_info['permission']['access'])) {
            $data['access'] = $user_group_info['permission']['access'];
        } else {
            $data['access'] = array();
        }

        if (isset($this->input->post('permission')['modify'])) {
            $data['modify'] = $this->input->post('permission')['modify'];
        } elseif (isset($user_group_info['permission']['modify'])) {
            $data['modify'] = $user_group_info['permission']['modify'];
        } else {
            $data['modify'] = array();
        }

        $this->template->build('users_group_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->hasPermission('modify', 'users_group')) {
            $this->error['warning'] = $this->lang->line('error_permission');
        }

        if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
            $this->error['name'] = $this->lang->line('error_name');
        }
        return !$this->error;

    }
}