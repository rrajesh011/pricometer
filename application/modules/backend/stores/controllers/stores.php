<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/18/2016
 * Time: 7:10 PM
 */

/**
 * Class Stores
 * @property  Store_m $store_m
 */
class Stores extends Back_controller
{
    private $error = '';

    public function __construct()
    {
        parent::__construct();

        if (!$this->isLogged()) {
            redirect(base_url('admin/auth/login'));
        }
        $this->load->model('store_m');
        $this->lang->load('store');
    }

    public function index()
    {
        $this->template->title($this->lang->line('heading_title'));

        $this->getStoreList();
    }

    public function add()
    {

        $this->template->title($this->lang->line('heading_title'));
        if ($this->input->post() && $this->validateStoreForm()) {
            $this->store_m->addStore($this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            redirect('admin/stores?token=' . $this->token);
        }
        $this->getStoreForm();
    }


    public function edit()
    {
        $this->template->title($this->lang->line('heading_title'));
        if ($this->input->post() && $this->validateStoreForm()) {
            $this->store_m->editStore($this->input->get('store_id'), $this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            redirect('admin/stores?token=' . $this->token);
        }
        $this->getStoreForm();
    }

    public function delete()
    {
        if ($id = $this->input->get('store_id')) {
            $this->store_m->deleteStore($id);
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
        }
        if ($ids = $this->input->post('selected')) {
            $this->store_m->deleteStore($ids);
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
        }
        redirect('admin/stores?token=' . $this->token);
    }

    public function getStoreList()
    {
        //Breadcrumbs
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/stores?token=' . $this->token)
            )
        );

        $data['add'] = base_url('admin/stores/add?token=' . $this->token);
        $data['delete'] = base_url('admin/stores/delete?token=' . $this->token);

        $results = $this->store_m->getStores();
        $data['stores'] = array();
        foreach ($results as $result) {
            $data['stores'][] = array(
                'store_id' => $result['store_id'],
                'name' => $result['name'],
                'affiliate_id' => $result['affiliate_id'],
                'affiliate_url_alias' => $result['affiliate_url_alias'],
                'date_modified' => $result['date_modified'],
                'status' => $result['status'],
                'edit' => base_url('admin/stores/edit?store_id=' . $result['store_id'] . '&token=' . $this->token),
                'delete' => base_url('admin/stores/delete?store_id=' . $result['store_id'] . '&token=' . $this->token),
            );
        }


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->flashdata('success')) {
            $data['success'] = $this->session->flashdata('success');
        } else {
            $data['success'] = '';
        }


        if ($this->input->post('selected')) {
            $data['selected'] = (array)$this->input->post('selected');
        } else {
            $data['selected'] = array();
        }

        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_list'] = $this->lang->line('text_list');
        $data['entry_status'] = $this->lang->line('entry_status');
        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');

        $this->template->build('store_list', $data);
    }

    public function getStoreForm()
    {
        //Breadcrumbs
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/stores?token=' . $this->token)
            )
        );

        if ($this->input->get('store_id')) {
            $data['action'] = base_url('admin/stores/edit?store_id=' . $this->input->get('store_id') . '&token=' . $this->token);
        } else {
            $data['action'] = base_url('admin/stores/add?token=' . $this->token);
        }

        $data['cancel'] = base_url('admin/stores?token=' . $this->token);

        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = !$this->input->get('store_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');

        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_description'] = $this->lang->line('entry_description');
        $data['entry_affiliate_id'] = $this->lang->line('entry_affiliate_id');
        $data['entry_affiliate_url_alias'] = $this->lang->line('entry_affiliate_url_alias');
        $data['entry_status'] = $this->lang->line('entry_status');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';

        if ($this->input->get('store_id') && !$this->input->post()) {
            $store_info = $this->store_m->getStore($this->input->get('store_id'));
        }

        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
        } elseif (!empty($store_info)) {
            $data['name'] = $store_info['name'];
        } else {
            $data['name'] = '';
        }
        if ($this->input->post('affiliate_id')) {
            $data['affiliate_id'] = $this->input->post('affiliate_id');
        } elseif (!empty($store_info)) {
            $data['affiliate_id'] = $store_info['affiliate_id'];
        } else {
            $data['affiliate_id'] = '';
        }

        if ($this->input->post('affiliate_url_alias')) {
            $data['affiliate_url_alias'] = $this->input->post('affiliate_url_alias');
        } elseif (!empty($store_info)) {
            $data['affiliate_url_alias'] = $store_info['affiliate_url_alias'];
        } else {
            $data['affiliate_url_alias'] = '';
        }

        if ($this->input->post('status')) {
            $data['status'] = $this->input->post('status');
        } elseif (!empty($store_info)) {
            $data['status'] = $store_info['status'];
        } else {
            $data['status'] = '';
        }


        if ($this->input->post('description')) {
            $data['description'] = $this->input->post('description');
        } elseif (!empty($store_info)) {
            $data['description'] = $store_info['description'];
        } else {
            $data['description'] = '';
        }

        $this->template->build('store_form', $data);
    }

    protected function validateStoreForm()
    {
        if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
            $this->error['name'] = $this->lang->line('error_name');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        return !$this->error;
    }
}