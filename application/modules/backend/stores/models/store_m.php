<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/18/2016
 * Time: 7:11 PM
 */
class Store_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getStores()
    {
        return $this->db->get('stores')
            ->result_array();
    }

    public function getStore($store_id)
    {
        return $this->db->where('store_id', $store_id)
            ->get('stores')
            ->row_array();

    }

    public function addStore($data)
    {
        $set = array(
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : '',
            'affiliate_id' => $data['affiliate_id'],
            'affiliate_url_alias' => $data['affiliate_url_alias'],
            'status' => isset($data['status']) ? $data['status'] : 1,
            'date_added' => date('Y-m-d H:i:s'),
            'date_modified' => date('Y-m-d H:i:s')
        );

        $this->db->set($set)->insert('stores');
        return $this->db->insert_id();
    }

    public function editStore($store_id, $data)
    {
        $set = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'affiliate_id' => $data['affiliate_id'],
            'affiliate_url_alias' => $data['affiliate_url_alias'],
            'status' => $data['status'],
            'date_modified' => date('Y-m-d H:i:s')
        );
        $this->db->where('store_id', $store_id)
            ->update('stores', $set);
    }

    public function deleteStore($ids)
    {
        if (is_array($ids)) {
            $this->db->where_in('store_id', $ids)
                ->delete('stores');
        }
        if (!is_array($ids)) {
            $this->db->where('store_id', $ids)
                ->delete('stores');
        }
    }
}