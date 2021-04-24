<?php

class Banner_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    
    public function getBannerList($params = array(), $limit = false, $offset = false) {
        try {

            $this->db->select();
            $this->db->from('banner');
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("name",$params['search']);
                $this->db->group_end();
            }
            
            //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
           
            $this->db->order_by("banner.created_at","DESC");

            $tempdb = clone $this->db;
            $num_results = $tempdb->count_all_results();

            if (isset($limit) && isset($start)) {
                $this->db->limit($limit, $start);
            }

            if (isset($limit) && $limit != false) {
                $this->db->limit($limit, $offset);
            }
        } catch (Exception $e) {
            echo json_encode($e->getTraceAsString());
        }
        $this->db->get();
        $query = $this->db->last_query();
        $res = $this->db->query($query);
        $result = $res->result_array();
        $result['count'] = $num_results;
        return $result;
    }
    
        
     public function fetchBannerDetail($bannerId=FALSE,$array=TRUE){
        try{
            $this->db->select('*');//('vechile_name','vechile_number','vechile_model','vechile_color','name');
            $this->db->from('banner');
            $this->db->where('banner_id', $bannerId);
            $query = $this->db->get();
            return !empty($array)?$query->row_array():$query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }



}


