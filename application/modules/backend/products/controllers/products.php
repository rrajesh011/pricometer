<?php

class Products extends Back_controller
{
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_m');


        if (!$this->isLogged()) {
            redirect($this->agent->referrer(), 'refresh');
        }

    }

    public function index()
    {
        $this->lang->load('product');
        $this->template->title($this->lang->line('heading_title'));
        $this->getProductList();
    }

    public function add()
    {
        $this->lang->load('product');

        $this->getProductForm();
    }

    public function edit()
    {

    }

    public function delete()
    {

    }

    protected function getProductList()
    {
        $url = '';
        if ($this->input->get('sort')) {
            $sort = $this->input->get('sort');
            $url .= '&sort=' . $this->input->get('sort');
        } else {
            $sort = 'name';
        }
        if ($this->input->get('order')) {
            $order = $this->input->get('order');
            $url .= '&order=' . $this->input->get('order');
        } else {
            $order = 'ASC';
        }


        //Breadcrumbs
        $data['breadcrumbs'][] = array();
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/products?token=' . $this->token)
            )
        );

        $data['add'] = base_url('admin/products/add?token=' . $this->token);
        $data['delete'] = base_url('admin/products/delete?token=' . $this->token);
        $data['import'] = base_url('admin/products/import?token=' . $this->token);
        $filter_data = array(
            'sort' => $sort,
            'order' => $order
        );

        $data['products'] = $this->product_m->getProducts($filter_data);


        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_list'] = $this->lang->line('text_list');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');

        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');

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


        $this->template->build('product_list', $data);
    }

    protected function getProductForm()
    {
        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_form'] = !($this->input->get('product_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');
        $data['text_none'] = $this->lang->line('text_none');
        $data['text_yes'] = $this->lang->line('text_yes');
        $data['text_no'] = $this->lang->line('text_no');
        $data['text_plus'] = $this->lang->line('text_plus');
        $data['text_minus'] = $this->lang->line('text_minus');
        $data['text_default'] = $this->lang->line('text_default');
        $data['text_option'] = $this->lang->line('text_option');
        $data['text_option_value'] = $this->lang->line('text_option_value');
        $data['text_select'] = $this->lang->line('text_select');
        $data['text_percent'] = $this->lang->line('text_percent');
        $data['text_amount'] = $this->lang->line('text_amount');

        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_description'] = $this->lang->line('entry_description');
        $data['entry_meta_title'] = $this->lang->line('entry_meta_title');
        $data['entry_meta_description'] = $this->lang->line('entry_meta_description');
        $data['entry_meta_keyword'] = $this->lang->line('entry_meta_keyword');
        $data['entry_keyword'] = $this->lang->line('entry_keyword');
        $data['entry_model'] = $this->lang->line('entry_model');
        $data['entry_sku'] = $this->lang->line('entry_sku');
        $data['entry_upc'] = $this->lang->line('entry_upc');
        $data['entry_ean'] = $this->lang->line('entry_ean');
        $data['entry_jan'] = $this->lang->line('entry_jan');
        $data['entry_isbn'] = $this->lang->line('entry_isbn');
        $data['entry_mpn'] = $this->lang->line('entry_mpn');
        $data['entry_location'] = $this->lang->line('entry_location');
        $data['entry_minimum'] = $this->lang->line('entry_minimum');
        $data['entry_shipping'] = $this->lang->line('entry_shipping');
        $data['entry_date_available'] = $this->lang->line('entry_date_available');
        $data['entry_quantity'] = $this->lang->line('entry_quantity');
        $data['entry_stock_status'] = $this->lang->line('entry_stock_status');
        $data['entry_price'] = $this->lang->line('entry_price');
        $data['entry_tax_class'] = $this->lang->line('entry_tax_class');
        $data['entry_points'] = $this->lang->line('entry_points');
        $data['entry_option_points'] = $this->lang->line('entry_option_points');
        $data['entry_subtract'] = $this->lang->line('entry_subtract');
        $data['entry_weight_class'] = $this->lang->line('entry_weight_class');
        $data['entry_weight'] = $this->lang->line('entry_weight');
        $data['entry_dimension'] = $this->lang->line('entry_dimension');
        $data['entry_length_class'] = $this->lang->line('entry_length_class');
        $data['entry_length'] = $this->lang->line('entry_length');
        $data['entry_width'] = $this->lang->line('entry_width');
        $data['entry_height'] = $this->lang->line('entry_height');
        $data['entry_image'] = $this->lang->line('entry_image');
        $data['entry_additional_image'] = $this->lang->line('entry_additional_image');
        $data['entry_store'] = $this->lang->line('entry_store');
        $data['entry_manufacturer'] = $this->lang->line('entry_manufacturer');
        $data['entry_download'] = $this->lang->line('entry_download');
        $data['entry_category'] = $this->lang->line('entry_category');
        $data['entry_filter'] = $this->lang->line('entry_filter');
        $data['entry_related'] = $this->lang->line('entry_related');
        $data['entry_attribute'] = $this->lang->line('entry_attribute');
        $data['entry_text'] = $this->lang->line('entry_text');
        $data['entry_option'] = $this->lang->line('entry_option');
        $data['entry_option_value'] = $this->lang->line('entry_option_value');
        $data['entry_required'] = $this->lang->line('entry_required');
        $data['entry_sort_order'] = $this->lang->line('entry_sort_order');
        $data['entry_status'] = $this->lang->line('entry_status');
        $data['entry_date_start'] = $this->lang->line('entry_date_start');
        $data['entry_date_end'] = $this->lang->line('entry_date_end');
        $data['entry_priority'] = $this->lang->line('entry_priority');
        $data['entry_tag'] = $this->lang->line('entry_tag');
        $data['entry_customer_group'] = $this->lang->line('entry_customer_group');
        $data['entry_reward'] = $this->lang->line('entry_reward');
        $data['entry_layout'] = $this->lang->line('entry_layout');
        $data['entry_recurring'] = $this->lang->line('entry_recurring');

        $data['help_keyword'] = $this->lang->line('help_keyword');
        $data['help_sku'] = $this->lang->line('help_sku');
        $data['help_upc'] = $this->lang->line('help_upc');
        $data['help_ean'] = $this->lang->line('help_ean');
        $data['help_jan'] = $this->lang->line('help_jan');
        $data['help_isbn'] = $this->lang->line('help_isbn');
        $data['help_mpn'] = $this->lang->line('help_mpn');
        $data['help_minimum'] = $this->lang->line('help_minimum');
        $data['help_manufacturer'] = $this->lang->line('help_manufacturer');
        $data['help_stock_status'] = $this->lang->line('help_stock_status');
        $data['help_points'] = $this->lang->line('help_points');
        $data['help_category'] = $this->lang->line('help_category');
        $data['help_filter'] = $this->lang->line('help_filter');
        $data['help_download'] = $this->lang->line('help_download');
        $data['help_related'] = $this->lang->line('help_related');
        $data['help_tag'] = $this->lang->line('help_tag');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');
        $data['button_attribute_add'] = $this->lang->line('button_attribute_add');
        $data['button_option_add'] = $this->lang->line('button_option_add');
        $data['button_option_value_add'] = $this->lang->line('button_option_value_add');
        $data['button_discount_add'] = $this->lang->line('button_discount_add');
        $data['button_special_add'] = $this->lang->line('button_special_add');
        $data['button_image_add'] = $this->lang->line('button_image_add');
        $data['button_remove'] = $this->lang->line('button_remove');
        $data['button_recurring_add'] = $this->lang->line('button_recurring_add');

        $data['tab_general'] = $this->lang->line('tab_general');
        $data['tab_data'] = $this->lang->line('tab_data');
        $data['tab_attribute'] = $this->lang->line('tab_attribute');
        $data['tab_option'] = $this->lang->line('tab_option');
        $data['tab_recurring'] = $this->lang->line('tab_recurring');
        $data['tab_discount'] = $this->lang->line('tab_discount');
        $data['tab_special'] = $this->lang->line('tab_special');
        $data['tab_image'] = $this->lang->line('tab_image');
        $data['tab_links'] = $this->lang->line('tab_links');
        $data['tab_reward'] = $this->lang->line('tab_reward');
        $data['tab_design'] = $this->lang->line('tab_design');
        $data['tab_openbay'] = $this->lang->line('tab_openbay');

        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)

            ), array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/products/add?token=' . $this->token)

            )
        );

        if ($this->input->get('product_id')) {
            $data['action'] = base_url('admin/products/edit?product_id=' . $this->input->get('product_id') . '&token=' . $this->token);
        } else {
            $data['action'] = base_url('admin/products/add?token=' . $this->token);
        }

        $data['cancel'] = base_url('admin/products?token=' . $this->token);


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        if (isset($this->error['sku'])) {
            $data['error_sku'] = $this->error['sku'];
        } else {
            $data['error_sku'] = array();
        }
    }

    protected function validateForm()
    {
        if (utf8_strlen($this->input->post('name')) < 3 || utf8_strlen($this->input->post('name')) > 255) {
            $this->error['name'] = $this->lang->line('error_name');
        }
    }

}
