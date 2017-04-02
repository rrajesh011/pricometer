<?php

class Offer_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOffers()
    {
        return $this->db->get('offers')
            ->result_array();
    }

    public function getOffer($offer_id)
    {

        return $this->db->where('offer_id', $offer_id)
            ->get('offers')
            ->row_array();

    }

    public function addOffer($data)
    {
        $set = array(
            'name' => $data['name'],
            'store_id' => $data['store_id'],
            'status' => $data['status']
        );
        $this->db->set($set)->insert('offers');
        return $this->db->insert_id();
    }


    public function editOffer($offer_id, $data)
    {
        $set = array(
            'name' => $data['name'],
            'store_id' => $data['store_id'],
            'status' => $data['status']
        );
        $this->db->where('offer_id', $offer_id)
            ->update('offers', $set);
    }
}