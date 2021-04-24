<?php

class Category_Model extends CI_MODEL
{
	
	 public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    
    public function getFoodCategoryList($params = array(), $limit = false, $offset = false) {
        try {

            $this->db->select();
            $this->db->from('mart_food_category');
            $this->db->where('category_type',1); //1 is for food and 2 for mart in the table 1 will carry all category of the food
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("category_name",$params['search']);
                $this->db->where("category_type",1);
                $this->db->group_end();
            }
           
           // $this->db->order_by("mart.created_at","DESC");

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
    
   
 public function getMartCategoryList($params = array(), $limit = false, $offset = false) {
        try {

            $this->db->select();
            $this->db->from('mart_food_category');
            $this->db->where('category_type',2); //1 is for food and 2 for mart in the table 1 will carry all category of the food
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("category_name",$params['search']);
                $this->db->where("category_type",2);
                $this->db->group_end();
            }
           
           // $this->db->order_by("mart.created_at","DESC");

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
    
   
   

}
?>