<?php

class Offer_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOffersType()
    {
        return $this->db->get('offers_type')
            ->result_array();
    }

    public function getOfferType($offer_id)
    {

        return $this->db->where('offer_id', $offer_id)
            ->get('offers_type')
            ->row_array();

    }

    public function getOffers($offset=0,$limit=100)
    {

        return $this->db->select('offers.*,offers_image.url as image_url,offers_image.resolution_type')->join('offers_image', 'offers_image.offer_id=offers.offer_id','LEFT')
            ->group_by('offer_id')
            ->limit($offset,$limit)
            ->get('offers')
            ->result_array();
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
            'end_time'      => $data['endTime'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'url'           => $data['url'],
            'category'      => $data['category'],
            'availability'  => $data['availability'] == 'LIVE' ? 1 : 0,
            'updated_on'    => date('Y-m-d H:i:s')
        );

        $this->db->set($set)->insert('offers');
        $offer_id = $this->db->insert_id();

        foreach ($data['imageUrls'] as $imageUrl) {
            $insert = array(
                'offer_id'        => $offer_id,
                'url'             => $imageUrl['url'],
                'resolution_type' => $imageUrl['resolutionType']
            );
            $this->db->set($insert)->insert('offers_image');

        }
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

    public function get_offer_type_list(){
       $offersType= $this->db->get('offers_type')->result_array();

        $list=array();
       
        foreach ($offersType as $value) {
            $list[$value['offer_type_id']]=$value['name'];
        }
       
        return $list;
    }

    public function get_store_list(){
        $stores=$this->db->get('stores')->result_array();
        $list=[];
        foreach ($stores as $value) {
            $list[$value['store_id']]=$value['name'];
        }
        
        return $list;
    }
}