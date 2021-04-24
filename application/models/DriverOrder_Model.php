<?php
  class DriverOrder_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }



    //get order detail
    public function getOrderDetail($params=[]){
    	
    	$this->db->select('a.*,d.item_id,d.item_qty,d.item_amount,a.user_id,b.name,b.country_code,b.mobile,5 as rating, 10 as per_km,b.image',false);
    	$this->db->select("g.product_name",false);

    	$this->db->select("IF((a.is_current_address)>0,b.address,a.user_address) as user_address",false);
        
        $this->db->from('orders a');
        $this->db->join('users b','a.user_id  = b.user_id','INNER');
        $this->db->join('order_items d','a.order_id  = d.order_id','LEFT');
        $this->db->join('products g','d.item_id  = g.product_id','LEFT');

       	if(isset($params['order_id']) && $params['order_id']!=""){

       		$this->db->where("a.order_id",$params['order_id']);
       	}

        if(isset($params['driver_id']) && $params['driver_id']!=""){

          $this->db->select("IF(a.driver_id>0 AND a.driver_id=".$params['driver_id'].",1,0) as is_accepted");
          //$this->db->where("a.driver_id",$params['driver_id']);
        }
        $query = $this->db->get();

       	return $query->result_array();

    }


    //get order list
    public function getDriverOrderHistory($params = [],$limit=false,$offset=false){

      $this->db->select('a.order_id,a.user_id,b.name,b.image,a.created_at,a.total_amount,a.module_type',false);
      $this->db->select('IF(c.mart_id>0,c.total_rating,0) as rating',false);
        
        $this->db->from('orders a');
        $this->db->join('users b','a.user_id  = b.user_id','INNER');
        $this->db->join('mart c','a.module_id  = c.mart_id AND a.module_type=1','LEFT');
        $this->db->join('driver_order_history d','a.order_id  = d.order_id','INNER');
        $this->db->join('restaurant e','a.module_id  = e.restaurant_id AND a.module_type=2','LEFT');
        
        if(isset($params['driver_id']) && $params['driver_id']!=""){

          $this->db->where("d.driver_id",$params['driver_id']);
        
        }

        if(isset($params['order_type']) && $params['order_type']!=""){

          $this->db->where("d.status",$params['order_type']);
        
        } 

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

          $this->db->limit($limit,$offset);
        }

        $query = $this->db->get();

        return $query->result_array();

    }

}
?>