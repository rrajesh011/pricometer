<?php

/**
 * Class Categories
 * @property Category_m $category_m
 */
class Categories extends Back_controller
{

    private $error = array();
    private $upload_dir = FCPATH . '../assets/uploads/excels/categories/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_m');
        if (!$this->isLogged()) {
            redirect(base_url('admin/auth/login'));
        }

        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0777, true);
            chmod($this->upload_dir, 0777);
        }
    }

    public function index()
    {
        $this->lang->load('category');
        $this->template->title($this->lang->line('heading_title'));
        $this->getCategoryList();
    }

    public function add()
    {
        $this->lang->load('category');
        if ($this->input->post() && $this->validateForm()) {
            $this->category_m->addCategory($this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            $url = '';
            if ($this->input->get('sort')) {
                $url .= '&sort=' . $this->input->get('sort');
            }

            if ($this->input->get('order')) {
                $url .= '&order=' . $this->input->get('order');
            }
            redirect(base_url('admin/categories?token=' . $this->token . $url));
        }
        $this->getCategoryForm();
    }

    public function edit()
    {
        $this->lang->load('category');
        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateForm()) {
            $this->category_m->editCategory($this->input->get('category_id'), $this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            redirect(base_url('admin/categories?token=' . $this->token));
        }
        $this->getCategoryForm();
    }

    public function delete()
    {
        $this->lang->load('category');
        $this->template->title($this->lang->line('heading_title'));
        if ($this->input->get('category_id')) {
            $this->category_m->deleteCategory($this->input->get('category_id'));
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
        }
        if ($this->input->post('selected') && $this->validateForm()) {
            foreach ($this->input->post('selected') as $category_id) {
                $this->category_m->deleteCategory($category_id);
                $this->session->set_flashdata('success', $this->lang->line('text_success'));
            }
        }
        redirect(base_url('admin/categories?token=' . $this->token));
    }

    public function import()
    {
        $this->lang->load('category');

        if ($this->input->post('upload') && $this->validateUploadForm()) {
            $this->uploadFile($_FILES['files']);
            $this->session->set_flashdata('success', $this->lang->line('text_upload_success'));
            redirect('admin/categories/import?token=' . $this->token);
        }
        if ($this->input->post('file_import')) {
            $this->category_m->importCategory($this->upload_dir, $this->input->post('file'));
            $this->session->set_flashdata('success', $this->lang->line('text_success_import_success'));
            redirect(base_url('admin/categories?token=' . $this->token));
        }

        if ($this->input->post('file_update')) {
            $files = $this->input->post('fileName');
            foreach ($files as $file) {
                $filePath = realpath($this->upload_dir . $file);
                $array['attr'] = json_encode(array(
                    'size' => filesize($filePath),
                    'sha1' => sha1_file($filePath),
                    'last_modified' => filemtime($filePath)
                ));
                $array['date_modified'] = date('Y-m-d H:i:s');
                $this->category_m->updateExcelEntries($file, $array);
            }

            exit;
        }

        if ($this->input->post('file_remove_local')) {
            $files = $this->input->post('file');
            if ($files) {
                foreach ($files as $file) {
                    unlink($this->upload_dir . $file);
                }
                $this->session->set_flashdata('success', $this->lang->line('text_file_success_deleted'));
            }
        }

        if ($this->input->post('file_remove_db')) {
            $file_name = $this->input->post('fileName');
            $this->category_m->deleteExcelEntry($file_name);
            $this->session->set_flashdata('success', $this->lang->line('text_file_success_deleted'));
            redirect('admin/categories/import?token=' . $this->token);
        }

        $this->getFileList();
        $this->getUploadForm();
    }

    public function getFileList()
    {
        $data['error_file'] = isset($this->error['error_file']) ? $this->error['error_file'] : '';

        $temp = $this->category_m->getUploadedFile();
        $dbExcel = array();
        if ($temp) {
            foreach ($temp as $value) {
                $dbExcel[] = $value['name'];
            }
        }

        $uploaded = $available = array();
        foreach (glob($this->upload_dir . '*.{xlsx,xls,csv}', GLOB_BRACE) as $v) {
            $name = pathinfo($v)['basename'];

            //checking if file is in use
            $file_status = $this->check_file_status('categories', $this->upload_dir, $name);


            if (in_array($name, $dbExcel) == FALSE) {
                $available[] = $name;
            } else {
                $uploaded[] = array('name' => $name, 'status' => $file_status);
            }
        }

        $data['available_files'] = $available;
        $data['uploaded_files'] = $uploaded;

        $this->template->build('upload_form', $data, true);
    }

    public function getUploadForm()
    {
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/categories?token=' . $this->token)
            )
        );
        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = $this->lang->line('form_excel_upload');

        $data['button_upload'] = $this->lang->line('button_upload');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $data['error_file'] = isset($this->error['file']) ? $this->error['file'] : '';

        $data['accept_type'] = '.csv,.xlsx,.xls';
        $data['action'] = base_url('admin/categories/import?token=' . $this->token);
        $data['cancel'] = base_url('admin/categories?token=' . $this->token);

        $data['action_file_update'] = base_url('admin/categories/import?token=' . $this->token);
        $data['action_file_import'] = base_url('admin/categories/import?token=' . $this->token);

        $this->template->build('upload_form', $data);
    }

    protected function getCategoryList()
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
                'href' => base_url('admin/categories?token=' . $this->token)
            )
        );


        $data['add'] = base_url('admin/categories/add?token=' . $this->token);
        $data['delete'] = base_url('admin/categories/delete?token=' . $this->token);
        $data['rebuild'] = base_url('admin/categories/rebuild?token=' . $this->token);
        $data['import'] = base_url('admin/categories/import?token=' . $this->token);
        $filter_data = array(
            'sort' => $sort,
            'order' => $order
        );

        $data['categories'] = $this->category_m->getCategories($filter_data);


        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_list'] = $this->lang->line('text_list');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');
        $data['column_name'] = $this->lang->line('column_name');
        $data['column_sort_order'] = $this->lang->line('column_sort_order');
        $data['column_action'] = $this->lang->line('column_action');

        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');
        $data['button_rebuild'] = $this->lang->line('button_rebuild');

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

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        $data['token'] = $this->token;
        $data['sort_name'] = base_url('admin/categories?token=' . $this->token . '&sort=name' . $url);
        $data['sort_sort_order'] = base_url('admin/categories?token=' . $this->token . '&sort=sort_order' . $url);


        $this->template->build('category_list', $data);
    }

    protected function getCategoryForm()
    {
        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = !$this->input->get('category_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_none'] = $this->lang->line('text_none');
        $data['text_default'] = $this->lang->line('text_default');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');

        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_description'] = $this->lang->line('entry_description');
        $data['entry_meta_title'] = $this->lang->line('entry_meta_title');
        $data['entry_meta_description'] = $this->lang->line('entry_meta_description');
        $data['entry_meta_keyword'] = $this->lang->line('entry_meta_keyword');
        $data['entry_keyword'] = $this->lang->line('entry_keyword');
        $data['entry_parent'] = $this->lang->line('entry_parent');
        $data['entry_filter'] = $this->lang->line('entry_filter');
        $data['entry_store'] = $this->lang->line('entry_store');
        $data['entry_image'] = $this->lang->line('entry_image');
        $data['entry_top'] = $this->lang->line('entry_top');
        $data['entry_column'] = $this->lang->line('entry_column');
        $data['entry_sort_order'] = $this->lang->line('entry_sort_order');
        $data['entry_status'] = $this->lang->line('entry_status');
        $data['entry_layout'] = $this->lang->line('entry_layout');

        $data['help_filter'] = $this->lang->line('help_filter');
        $data['help_keyword'] = $this->lang->line('help_keyword');
        $data['help_top'] = $this->lang->line('help_top');
        $data['help_column'] = $this->lang->line('help_column');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');

        $data['tab_general'] = $this->lang->line('tab_general');
        $data['tab_meta'] = $this->lang->line('tab_meta');
        $data['tab_extra'] = $this->lang->line('tab_extra');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';

        $data['error_parent'] = isset($this->error['parent']) ? $this->error['parent'] : '';

        $url = '';

        if ($this->input->get('sort')) {

            $url .= '&sort=' . $this->input->get('sort');
        }

        if ($this->input->get('order')) {

            $url .= '&order=' . $this->input->get('order');
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
                'href' => base_url('admin/categories?token=' . $this->token)
            )
        );

        if ($this->input->get('category_id')) {
            $data['action'] = base_url('admin/categories/edit?category_id=' . $this->input->get('category_id') . '&token=' . $this->token . $url);
        } else {
            $data['action'] = base_url('admin/categories/add?token=' . $this->token . $url);
        }

        $data['cancel'] = base_url('admin/categories?token=' . $this->token);

        if ($this->input->get('category_id') && !$this->input->post()) {
            $category_info = $this->category_m->getCategory($this->input->get('category_id'));
        }

        if ($this->input->post('categories_description')) {
            $data['categories_description'] = $this->input->post('categories_description');
        } elseif ($this->input->get('category_id')) {
            $data['categories_description'] = $this->category_m->getCategoryDescription($this->input->get('category_id'));
        } else {
            $data['categories_description'] = array();
        }

        if ($this->input->post('path')) {
            $data['path'] = $this->input->post('path');
        } elseif (!empty($category_info)) {
            $data['path'] = $category_info['path'];
        } else {
            $data['path'] = '';
        }

        if ($this->input->post('parent_id')) {
            $data['parent_id'] = $this->input->post('parent_id');
        } elseif (!empty($category_info)) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($this->input->post('sort_order')) {
            $data['sort_order'] = $this->input->post('sort_order');
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->input->post('status')) {
            $data['status'] = $this->input->post('status');
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = true;
        }


        if ($this->input->post('image')) {
            $data['image'] = $this->input->post('image');
        } elseif (!empty($category_info)) {
            $data['image'] = $category_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/Image_m');
        if ($this->input->post('image') && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $data['thumb'] = $this->Image_m->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
            $data['thumb'] = $this->Image_m->resize($category_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->Image_m->resize('no_image.png', 100, 100);
        }
        $data['token'] = $this->token;


        $this->template->build('category_form', $data);
    }

    protected function validateUploadForm()
    {
        if (isset($_FILES['files']) && count($_FILES['files']['error']) == 1 && $_FILES['files']['error'][0] > 0) {
            $this->error['file'] = $this->lang->line('error_file');
        }
        return !$this->error;
    }

    protected function validateForm()
    {
        if ($value = $this->input->post('categories_description')) {
            if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'] = $this->lang->line('error_name');
            }
        }
        if ($this->input->get('category_id') && $this->input->post('parent_id')) {
            $results = $this->category_m->getCategoryPath($this->input->post('parent_id'));

            foreach ($results as $result) {
                if ($result['path_id'] == $this->input->get('category_id')) {
                    $this->error['parent'] = $this->lang->line('error_parent');
                    break;
                }
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        return !$this->error;
    }

    protected function validateCheckboxList()
    {
        if (!$this->input->post('files')) {
            $this->error['error_file'] = $this->lang->line('error_file');
        }
        return !$this->error;
    }

    public function autocomplete()
    {
        $json = array();
        if ($this->input->get('filter_name')) {
            $filter_data = array(
                'filter_name' => $this->input->get('filter_name'),
                'sort' => 'name',
                'order' => 'ASC'
            );
            $results = $this->category_m->getCategories($filter_data);
            foreach ($results as $result) {
                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }
        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    private function uploadFile($data = array())
    {
        $files = $name = array();
        for ($i = 0; $i < count($data['name']); $i++) {
            $files[$i]['name'] = $data['name'][$i];
            $files[$i]['type'] = $data['type'][$i];
            $files[$i]['tmp_name'] = $data['tmp_name'][$i];
            $files[$i]['error'] = $data['error'][$i];
            $files[$i]['size'] = $data['size'][$i];
        }

        foreach ($files as $file) {
            move_uploaded_file($file['tmp_name'], $this->upload_dir . '/' . $file['name']);
            $name[] = $file['name'];
        }
        return $name;
    }

}
