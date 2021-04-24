<?php

class Mart_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    
    public function getMartList($params = array(), $limit = false, $offset = false) {
        try {

            $this->db->select();
            $this->db->from('mart a');
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("a.name",$params['search']);
                $this->db->or_like("a.email",$params['search']);
                $this->db->group_end();
            }
            //using status filter
            
            if(isset($params['status']) && $params['status']!=''){
                
                $this->db->where('a.status',$params['status']);
            }
            //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(a.created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
           
            $this->db->order_by("a.created_at","DESC");

            $tempdb = clone $this->db;
            $num_results = $tempdb->count_all_results();


            if (isset($limit) && $limit != "") {
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
    
        
     public function fetchMartDetail($martId=FALSE,$categoryId=FALSE,$array=TRUE){
        try{
            $this->db->select('*');//('vechile_name','vechile_number','vechile_model','vechile_color','name');
            $this->db->from('mart');
            $this->db->where('mart_id', $martId);
            $query = $this->db->get();
            return !empty($array)?$query->row_array():$query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }

    public function getMartCategories()
    {
         try{
            $this->db->select('*');//('vechile_name','vechile_number','vechile_model','vechile_color','name');
            $this->db->from('mart_food_category');
            $this->db->where('category_type',2);
            $query = $this->db->get();
            return $query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }


    public function getProductsOfMart(){

        try{

            $this->db->select();
            $this->from('mart m');
            $this->db->where();
            $this->db->join();

        }catch(Exception $e)
            {
             echo json_encode($e->getTraceAsString());   
            }
    }
}


