<?php

class Offer_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOffersType()
    {
        return $this->db->get('offers')
            ->result_array();
    }

    public function getOfferType($offer_id)
    {

        return $this->db->where('offer_id', $offer_id)
            ->get('offers')
            ->row_array();

    }

    public function addOffersType($data)
    {
        $set = array(
            'name'     => $data['name'],
            'store_id' => $data['store_id'],
            'status'   => $data['status']
        );
        $this->db->set($set)->insert('offers_type');
        return $this->db->insert_id();
    }

    public function addOffer($data)
    {
        $set = array(
            'offer_type_id' => 2,   //hard coded will be changed in future
            'store_id'      => 1,   //hard coded will be changed in future
            'start_time'    => $data['startTime'],
            'end_time'      => $data['endTIme'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'url'           => $data['url'],
            'category'      => $data['category'],
            'availability'  => $data['availability'] == 'TRUE' ? 1 : 0
        );
        $this->db->set($set)->insert('offers');
        $offer_id = $this->db->insert_id();

        $data['imageUrls'] = array();
        $insert = array();
        foreach ($data['imageUrls'] as $imageUrl) {
            $insert[] = array(
                'offer_id'        => $offer_id,
                'url'             => $imageUrl['url'],
                'resolution_type' => $imageUrl['resolutionType']
            );
        }
        $this->db->set($insert)->insert('offers_image');
        return $offer_id;
    }

    public function editOffersType($offer_id, $data)
    {
        $set = array(
            'name'     => $data['name'],
            'store_id' => $data['store_id'],
            'status'   => $data['status']
        );
        $this->db->where('offer_id', $offer_id)
            ->update('offers', $set);
    }

    public function offersType()
    {
        return $this->db->get('offers_type')
            ->result_array();
    }
}