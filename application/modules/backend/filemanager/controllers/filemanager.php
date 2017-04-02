<?php

if (!defined('BASEPATH')) exit('No Direct script allowed');

/**
 * Class Filemanager
 */
class Filemanager extends Back_controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->isLogged() || $this->input->get('token') && ($this->input->get('token') != $this->token)) {
            redirect('admin/auth/login');
        }

    }

    public function index()
    {
        $this->lang->load('filemanager');

        if ($this->input->get('filter_name')) {
            $filter_name = rtrim(str_replace(array('*', '/'), '', $this->input->get('filter_name')), '/');
        } else {
            $filter_name = null;
        }

        // Make sure we have the correct directory
        if ($this->input->get('directory')) {
            $directory = realpath(DIR_IMAGE . $this->input->get('directory')) . '\\';
        } else {
            $directory = DIR_IMAGE;
        }

        $directories = array();

        $files = array();

        $data['images'] = array();

        $this->load->model('tool/Image_m');

        if (substr($directory, 0, strlen(DIR_IMAGE)) == DIR_IMAGE) {

            // Get directories
            $directories = glob($directory . $filter_name . '*', GLOB_ONLYDIR);

            if (!$directories) {
                $directories = array();
            }

            // Get files
            $files = glob($directory . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

            if (!$files) {
                $files = array();
            }
        }

        // Merge directories and files
        $images = array_merge($directories, $files);

        // Get total number of files and directories
        $image_total = count($images);

        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {

                $url = '';

                if ($this->input->get('target')) {
                    $url .= '&target=' . $this->input->get('target');
                }

                if ($this->input->get('thumb')) {
                    $url .= '&thumb=' . $this->input->get('thumb');
                }

                $data['images'][] = array(
                    'thumb' => '',
                    'name' => implode(' ', $name),
                    'type' => 'directory',
                    'path' => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
                    'href' => base_url('admin/filemanager?token=' . $this->token . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE))) . $url)
                );
            } elseif (is_file($image)) {
                $data['images'][] = array(
                    'thumb' => $this->Image_m->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
                    'name' => implode(' ', $name),
                    'type' => 'image',
                    'path' => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
                    'href' => base_url() . 'assets/uploads/images/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
                );
            }

        }

        $data['heading_title'] = $this->lang->line('heading_title');

        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');

        $data['entry_search'] = $this->lang->line('entry_search');
        $data['entry_folder'] = $this->lang->line('entry_folder');

        $data['button_parent'] = $this->lang->line('button_parent');
        $data['button_refresh'] = $this->lang->line('button_refresh');
        $data['button_upload'] = $this->lang->line('button_upload');
        $data['button_folder'] = $this->lang->line('button_folder');
        $data['button_delete'] = $this->lang->line('button_delete');
        $data['button_search'] = $this->lang->line('button_search');

        $data['token'] = $this->token;

        if ($this->input->get('directory')) {
            $data['directory'] = urlencode($this->input->get('directory'));
        } else {
            $data['directory'] = '';
        }

        if ($this->input->get('filter_name')) {
            $data['filter_name'] = $this->input->get('filter_name');
        } else {
            $data['filter_name'] = '';
        }

        // Return the target ID for the file manager to set the value
        if ($this->input->get('target')) {
            $data['target'] = $this->input->get('target');
        } else {
            $data['target'] = '';
        }

        // Return the thumbnail for the file manager to show a thumbnail
        if ($this->input->get('thumb')) {
            $data['thumb'] = $this->input->get('thumb');
        } else {
            $data['thumb'] = '';
        }

        // Parent
        $url = '';

        if ($this->input->get('directory')) {
            $pos = strrpos($this->input->get('directory'), '/');
            if ($pos) {
                $url .= '&directory=' . urlencode(substr($this->input->get('directory'), 0, $pos));
            }
        }

        if ($this->input->get('target')) {
            $url .= '&target=' . $this->input->get('target');
        }

        if ($this->input->get('thumb')) {
            $url .= '&thumb=' . $this->input->get('thumb');
        }

        $data['parent'] = base_url('admin/filemanager?token=' . $this->token . $url);

        // Refresh
        $url = '';

        if ($this->input->get('directory')) {
            $url .= '&directory=' . urlencode($this->input->get('directory'));
        }

        if ($this->input->get('target')) {
            $url .= '&target=' . $this->input->get('target');
        }

        if ($this->input->get('thumb')) {
            $url .= '&thumb=' . $this->input->get('thumb');
        }

        $data['refresh'] = base_url('admin/filemanager?token=' . $this->token . $url);

        $this->load->view('filemanager_modal', $data);
    }

    public function folder()
    {
        $this->lang->load('filemanager');
        $json = array();

        //Make sure we are in correct directory
        if ($this->input->get('directory')) {
            $directory = rtrim(DIR_IMAGE . $this->input->get('directory') . '/');
        } else {
            $directory = DIR_IMAGE;
        }

        //Check if it is directory exist
        if (!is_dir($directory) || substr(realpath($directory), 0, strlen(DIR_IMAGE)) != rtrim(DIR_IMAGE, '\\')) {
            $json['error'] = $this->lang->line('error_directory');
        }

        if ($this->input->post()) {

            // Sanitize the folder name
            $folder = basename(html_entity_decode($this->input->post('folder'), ENT_QUOTES, 'UTF-8'));

            // Validate the filename length
            if ((utf8_strlen($folder) < 3) || (utf8_strlen($folder) > 128)) {
                $json['error'] = $this->lang->line('error_folder');
            }

            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = $this->lang->line('error_exists');
            }
        }
        if (!isset($json['error'])) {
            mkdir($directory . $folder, 0777);
            chmod($directory . $folder, 0777);

            //creating index.html file in new created folder
            @touch($directory . $folder . '/' . 'index.html');
            $json['success'] = $this->lang->line('text_directory');
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function upload()
    {
        $this->lang->load('filemanager');

        $json = array();

        //Make sure we are in correct directory
        if ($this->input->get('directory')) {
            $directory = DIR_IMAGE . $this->input->get('directory');
        } else {
            $directory = DIR_IMAGE;
        }

        if (!is_dir($directory) || substr(realpath($directory), 0, strlen(DIR_IMAGE)) != DIR_IMAGE) {
            $json['error'] = $this->lang->line('error_directory');
        }

        if (!isset($json['error'])) {
            //checking if multiple file is uploading
            $files = array();
            if (!empty($_FILES['file']['name']) && is_array($_FILES['file']['name'])) {
                foreach (array_keys($_FILES['file']['name']) as $key) {
                    $files[] = array(
                        'name' => $_FILES['file']['name'][$key],
                        'type' => $_FILES['file']['type'][$key],
                        'tmp_name' => $_FILES['file']['tmp_name'][$key],
                        'error' => $_FILES['file']['error'][$key],
                        'size' => $_FILES['file']['size'][$key]
                    );
                }
            }

            foreach ($files as $file) {
                if (is_file($file['tmp_name'])) {
                    // Sanitize the filename
                    $filename = basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8'));

                    // Validate the filename length
                    if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
                        $json['error'] = $this->lang->line('error_filename');
                    }

                    // Allowed file extension types
                    $allowed = array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png'
                    );

                    if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
                        $json['error'] = $this->lang->line('error_filetype');
                    }

                    // Allowed file mime types
                    $allowed = array(
                        'image/jpeg',
                        'image/pjpeg',
                        'image/png',
                        'image/x-png',
                        'image/gif'
                    );

                    if (!in_array($file['type'], $allowed)) {
                        $json['error'] = $this->lang->line('error_filetype');
                    }

                    // Return any upload error
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        $json['error'] = $this->lang->line('error_upload_' . $file['error']);
                    }
                } else {
                    $json['error'] = $this->lang->line('error_upload');
                }

                if (!$json) {
                    move_uploaded_file($file['tmp_name'], $directory . '/' . $filename);
                }
            }
        }
        if (!$json) {
            $json['success'] = $this->lang->line('text_uploaded');
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function delete()
    {
        $this->lang->load('filemanager');

        $json = array();

        if ($this->input->post('path')) {
            $paths = $this->input->post('path');
        } else {
            $paths = array();
        }


        // Loop through each path to run validations
        foreach ($paths as $path) {

            // Check path exists
            if ($path == DIR_IMAGE || substr(realpath(DIR_IMAGE . $path), 0, strlen(DIR_IMAGE)) != DIR_IMAGE) {

                $json['error'] = $this->lang->line('error_delete');

                break;
            }
        }
        if (!isset($json['error'])) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim(DIR_IMAGE . $path, '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);

                    // If path is a directory begging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = array();

                    // Make path into an array
                    $path = array($path . '*');


                    // While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            // If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

                            // Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

                    // Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
                        // If file just delete
                        if (is_file($file)) {
                            unlink($file);

                            // If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = $this->lang->line('text_delete');
        }
        echo json_encode($json);
    }
}