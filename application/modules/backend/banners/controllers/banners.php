<?php


if (!defined('BASEPATH')) exit('No Direct Script Allowed');

/**
 * Class Banners
 * @property Banner_m $banner_m
 * @property Image_m $Image_m
 */
class Banners extends Back_controller
{

    private $error = '';

    public function __construct()
    {
        parent::__construct();
        if (!$this->isLogged()) {
            redirect('admin/auth/login');
        }
        $this->load->model('banner_m');

    }

    public function index()
    {
        $this->lang->load('banner');

        $this->template->title($this->lang->line('heading_title'));

        $this->getBannerList();
    }

    public function add()
    {
        $this->lang->load('banner');

        $this->template->title($this->lang->line('heading_title'));
        if ($this->input->post() && $this->validateForm()) {
            $this->banner_m->addBanner($this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('text_success'));
            redirect(base_url('admin/banners'));
        }
        $this->getBannerForm();
    }

    public function edit()
    {
        $this->lang->load('banner');
        $this->template->title($this->lang->line('heading_title'));

        if ($this->input->post() && $this->validateForm()) {
            $this->banner_m->editBanner($this->input->get('banner_id'), $this->input->post());
            $this->session->set_flashdata('success', $this->lang->line('heading_title'));
            redirect('admin/banners?token=' . $this->token);
        }
        $this->getBannerForm();
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = explode(',', $id);

            $this->db->where_in('banner_id', $id)->delete('banners');
            $this->db->where_in('banner_id', $id)->delete('banner_image');
            $this->session->set_flashdata('alert_success', $this->lang->line('text_success'));
        } else {
            $this->session->set_flashdata('alert_error', $this->lang->line('text_error'));
        }
        redirect('admin/banners');
    }

    public function getBannerList()
    {
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/banners?token=' . $this->token)
            )
        );

        $data['add'] = base_url('admin/banners/add?token=' . $this->token);

        $data['delete'] = base_url('admin/banners/delete?token=' . $this->token);

        $results = $this->banner_m->getBanners();

        $data['banners'] = array();


        foreach ($results as $result) {
            $data['banners'][] = array(
                'banner_id' => $result['banner_id'],
                'name' => $result['name'],
                'status' => $result['status'],
                'date_added' => $result['date_added'],
                'edit' => base_url('admin/banners/edit?banner_id=' . $result['banner_id'] . '&token=' . $this->token),
                'delete' => base_url('admin/banners/delete?banner_id=' . $result['banner_id'] . '&token=' . $this->token)
            );
        }

        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_list'] = $this->lang->line('text_list');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');

        $data['column_name'] = $this->lang->line('column_name');
        $data['column_status'] = $this->lang->line('column_status');
        $data['column_action'] = $this->lang->line('column_action');

        $data['button_add'] = $this->lang->line('button_add');
        $data['button_edit'] = $this->lang->line('button_edit');
        $data['button_delete'] = $this->lang->line('button_delete');
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

        if ($this->input->post('selected')) {
            $data['selected'] = (array)$this->input->post('selected');
        } else {
            $data['selected'] = array();
        }
        $data['token'] = $this->token;

        $this->template->build('banner_list', $data);
    }


    public function getBannerForm()
    {

        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_form'] = !$this->input->get('banner_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
        $data['text_enabled'] = $this->lang->line('text_enabled');
        $data['text_disabled'] = $this->lang->line('text_disabled');
        $data['text_default'] = $this->lang->line('text_default');

        $data['entry_name'] = $this->lang->line('entry_name');
        $data['entry_title'] = $this->lang->line('entry_title');
        $data['entry_link'] = $this->lang->line('entry_link');
        $data['entry_image'] = $this->lang->line('entry_image');
        $data['entry_status'] = $this->lang->line('entry_status');
        $data['entry_sort_order'] = $this->lang->line('entry_sort_order');
        $data['entry_action'] = $this->lang->line('entry_action');

        $data['button_save'] = $this->lang->line('button_save');
        $data['button_cancel'] = $this->lang->line('button_cancel');
        $data['button_banner_add'] = $this->lang->line('button_banner_add');
        $data['button_remove'] = $this->lang->line('button_remove');


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

        if (isset($this->error['banner_image'])) {
            $data['error_banner_image'] = $this->error['banner_image'];
        } else {
            $data['error_banner_image'] = array();
        }

        $data['breadcrumbs'] = array(
            array(
                'text' => $this->lang->line('text_home'),
                'href' => base_url('admin/dashboard?token=' . $this->token)
            ),
            array(
                'text' => $this->lang->line('heading_title'),
                'href' => base_url('admin/banners?token=' . $this->token)
            )
        );

        if ($this->input->get('banner_id')) {
            $banner_info = $this->banner_m->getBanner($this->input->get('banner_id'));

            $data['action'] = base_url('admin/banners/edit?banner_id=' . $this->input->get('banner_id') . '&token=' . $this->token);
        } else {
            $data['action'] = base_url('admin/banners/add?token=' . $this->token);
        }

        $data['cancel'] = base_url('admin/banners?token=' . $this->token);

        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
        } elseif (!empty($banner_info)) {
            $data['name'] = $banner_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->input->post('status')) {
            $data['status'] = $this->input->post('status');
        } elseif (!empty($banner_info)) {
            $data['status'] = $banner_info['status'];
        } else {
            $data['status'] = true;
        }


        if ($this->input->post('banner_image')) {
            $banner_images = $this->input->post('banner_image');
        } elseif ($this->input->get('banner_id')) {
            $banner_images = $this->banner_m->getBannerImages($this->input->get('banner_id'));
        } else {
            $banner_images = array();
        }

        $this->load->model('tool/Image_m');
        foreach ($banner_images as $banner_image) {
            if (is_file(DIR_IMAGE . $banner_image['image'])) {
                $image = $banner_image['image'];
                $thumb = $banner_image['image'];
            } else {
                $image = '';
                $thumb = 'no-image.png';
            }

            $data['banner_images'][] = array(
                'title' => $banner_image['title'],
                'link' => $banner_image['link'],
                'image' => $image,
                'thumb' => $this->Image_m->resize($thumb, 100, 100),
                'sort_order' => $banner_image['sort_order']
            );

        }

        $data['placeholder'] = $this->Image_m->resize('no-image.png', 100, 100);

        $this->template->build('banner_form', $data);
    }

    protected function validateForm()
    {
        if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
            $this->error['name'] = $this->lang->line('error_name');
        }

        if ($this->input->post('banner_image')) {
            foreach ($this->input->post('banner_image') as $banner_image_id => $banner_image) {
                if ((utf8_strlen($banner_image['title']) < 2) || (utf8_strlen($banner_image['title']) > 64)) {
                    $this->error['banner_image'][$banner_image_id] = $this->lang->line('error_title');
                }
            }
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }
        return !$this->error;
    }
}

