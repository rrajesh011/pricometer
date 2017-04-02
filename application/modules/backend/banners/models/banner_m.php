<?php


if (!defined('BASEPATH')) exit('No Direct Script Allowed');

/**
 */
class  Banner_m extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    public function getBanner($banner_id)
    {
        return $this->db->where('banner_id', $banner_id)
            ->get('banners')
            ->row_array();
    }

    public function getBanners()
    {
        return $this->db->get('banners')->result_array();
    }

    public function getTotalBanners()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . $this->db->dbprefix("banners"));

        return $query->row['total'];
    }

    public function get_bannerById($id)
    {
        return $this->db->where('banner_id', $id)
            ->get('banners')
            ->row_array();
    }

    public function getBannerImages($banner_id)
    {
        return $this->db->where('banner_id', (int)$banner_id)
            ->get('banner_image')
            ->result_array();
    }

    public function addBanner($data)
    {
        $this->db->set(array(
            'name' => $data['name'],
            'status' => $data['status'],
            'date_added' => date('Y-m-d H:i:s')
        ))->insert('banners');

        $insert_id = $this->db->insert_id();

        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $value) {
                $set = array(
                    'banner_id' => $insert_id,
                    'title' => $value['title'],
                    'link' => $value['link'],
                    'image' => $value['image'],
                    'sort_order' => $value['sort_order'],
                );
                $this->db->set($set)->insert('banner_image');
            }
        }
        return $insert_id;
    }

    public function editBanner($banner_id, $data)
    {

    }
}

