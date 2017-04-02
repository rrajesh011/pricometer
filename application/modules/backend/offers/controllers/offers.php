<?php

class Offers extends Back_controller
{

    private $error = '';

    public function __construct()
    {

        parent::__construct();

        $this->load->model('offer_m');
        $this->lang->load('offer');
    }

    public function index()
    {

        $this->template->title($this->lang->line('heading_title'));

        $this->getOfferList();
    }

    public function add()
    {
        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateOfferForm()) {

            $this->offer_m->addOffer($this->input->post());

            $this->session->set_flashdata('success', $this->lang->line('text_success'));

            redirect(base_url('admin/offers?token=' . $this->token));
        }
        $this->getOfferForm();
    }

    public function edit()
    {
        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateOfferForm()) {
            $this->offer_m->editOffer($this->input->get('offer_id'), $this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            redirect(base_url('admin/offers?token=' . $this->token));
        }
        $this->getOfferForm();

    }

    public function delete()
    {

    }

    public function store_add()
    {
        if ($this->input->post('data')) {
            parse_str($this->input->post('data'), $form);

            $this->load->model('stores/store_m');
            $this->store_m->addStore($form['stores']);
            echo 1;
        }
        exit;
    }

    protected function getOfferList()
    {
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/offers?token=' . $this->token)
            )
        );

        $data['add'] = base_url('admin/offers/add?token=' . $this->token);
        $data['sync'] = base_url('admin/offers/sync?token=' . $this->token);
        $data['cancel'] = base_url('admin/offers?token=' . $this->token);
        $data['delete'] = base_url();
        $data['offers'] = $this->offer_m->getOffers();

        $this->load->model('stores/store_m');
        $temp = $this->store_m->getStores();
        $stores = [];
        foreach ($temp as $item) {
            $stores[$item['store_id']] = $item['name'];
        }

        $data['stores'] = $stores;


        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_list'] = $this->lang->line('text_list');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');
        $data['column_name'] = $this->lang->line('column_name');
        $data['column_store'] = $this->lang->line('column_store');
        $data['column_status'] = $this->lang->line('column_status');
        $data['column_action'] = $this->lang->line('column_action');

        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');
        $data['button_sync'] = $this->lang->line('button_sync');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->userdata('success')) {
            $data['success'] = $this->session->userdata('success');

            $this->session->unset_userdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->input->post('selected')) {
            $data['selected'] = (array)$this->input->post('selected');
        } else {
            $data['selected'] = array();
        }

        $data['token'] = $this->token;
        $this->template->build('offer_list', $data);
    }

    protected function getOfferForm()
    {
        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = !$this->input->get('offer_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');


        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_store'] = $this->lang->line('entry_store');
        $data['entry_status'] = $this->lang->line('entry_status');
        $data['entry_store_placeholder'] = $this->lang->line('entry_store_placeholder');
        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';
        $data['error_store'] = isset($this->error['store']) ? $this->error['store'] : '';


        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/offers?token=' . $this->token)
            ),
        );

        if ($this->input->get('offer_id')) {
            $data['action'] = base_url('admin/offers/edit?offer_id=' . $this->input->get('offer_id') . '&token=' . $this->token);
        } else {
            $data['action'] = base_url('admin/offers/add?token=' . $this->token);
        }
        $data['cancel'] = base_url('admin/offers?token=' . $this->token);


        if ($this->input->get('offer_id') && !$this->input->post()) {
            $offer_info = $this->offer_m->getOffer($this->input->get('offer_id'));
        }

        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
        } elseif (!empty($offer_info['name'])) {
            $data['name'] = $offer_info['name'];
        } else {
            $data['name'] = '';
        }


        $this->load->model('stores/store_m');
        $stores = $this->store_m->getStores();
        if ($this->input->post('store_id')) {
            $data['store_id'] = $this->input->post('store_id');
        } elseif (!empty($offer_info['store_id'])) {
            $data['store_id'] = $offer_info['store_id'];
            $data['stores'] = $stores;
        } else {
            $data['stores'] = $stores;
        }


        if ($this->input->post('status')) {
            $data['status'] = $this->input->post('status');
        } elseif (!empty($offer_info['status'])) {
            $data['status'] = $offer_info['status'];
        } else {
            $data['status'] = true;
        }
        $data['token'] = $this->token;

        $this->template->build('offer_form', $data);
    }

    protected function validateOfferForm()
    {
        $value = $this->input->post();

        if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
            $this->error['name'] = $this->lang->line('error_name');
        }
        if ($value['store_id'] == '') {
            $this->error['store'] = $this->lang->line('error_store');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }

        return !$this->error;
    }
}