<?php

class Orders_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    
    public function getOrdersList($params = array(), $limit = false, $offset = false, $where = array()) {
        try {

            $this->db->select('o.total_amount,o.estimated_amt,o.gst,o.delivery_amount,o.module_address,o.user_address,o.status,o.order_id,o.module_id,o.is_current_address,o.module_type,o.order_id');
            $this->db->select('u.address,u.gender,u.country_code,u.mobile,u.name,u.email');
            $this->db->from('orders o');
            $this->db->join('users u','o.user_id = u.user_id','right');
            $this->db->where('module_type',$where['module_type']);
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("o.user_address",$params['search']);
                $this->db->or_like("o.module_address",$params['search']);
                $this->db->group_end();
            }
            //using status filter
            
            if(isset($params['status']) && $params['status']!=''){
                
                $this->db->where('o.status',$params['status']);
            }
            //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(a.created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
           
            $this->db->order_by("o.created_at","DESC");

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

    public function fetchOrdersDetail($orderId=FALSE,$array=TRUE)
    {
         try{
             $this->db->select('o.total_amount,o.estimated_amt,o.gst,o.delivery_amount,o.module_address,o.user_address,o.status,o.order_id,o.module_id,o.is_current_address,o.module_type,o.order_id');
            $this->db->select('u.address,u.gender,u.country_code,u.mobile,u.name,u.email');
            $this->db->from('orders o');
            $this->db->join('users u','o.user_id = u.user_id','right');
            $this->db->where('order_id',$orderId);
            $query = $this->db->get();
            return !empty($array)?$query->row_array():$query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }
}


?>