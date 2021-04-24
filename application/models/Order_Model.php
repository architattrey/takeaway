<?php
  class Order_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }


    public function getAllNearByDrivers($params=[]){
    	
    	$this->db->select('a.driver_id,b.device_token,b.device_type',false);

        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }
        $this->db->from('drivers a');
        $this->db->join('drivers_login_session b','a.driver_id  = b.user_id','INNER');

       

        $this->db->having("distance<10");
        $query = $this->db->get();

       return $query->result_array();
    }

    public function getOrderForNotification($params=[]){
    	
    	$this->db->select('a.order_id,a.user_id,c.mart_name',false);

        
        $this->db->from('orders a');
        $this->db->join('users b','a.user_id  = b.user_id','INNER');
        $this->db->join('mart c','a.module_id  = c.mart_id AND a.module_type=1','INNER');

       	if(isset($params['order_id']) && $params['order_id']!=""){

       		$this->db->where("a.order_id",$params['order_id']);
       	}

        $query = $this->db->get();

       	return $query->row_array();
    }


    //get order detail
    public function getOrderDetail($params=[]){
    	
    	$this->db->select('a.*,d.item_id,d.item_qty,d.item_amount,a.user_id,b.name,b.country_code,b.mobile,5 as rating,b.image',false);
    	$this->db->select("e.name as driver_name,e.image as driver_image,e.mobile as driver_mobile,5 as driver_rating,f.vechile_id,f.vechile_name,f.vechile_color,f.vechile_number,f.vechile_type,f.vechile_model,f.vechile_category,g.product_name",false);

    	$this->db->select("IF((a.is_current_address)>0,b.address,a.user_address) as user_address",false);
        
        $this->db->from('orders a');
        $this->db->join('users b','a.user_id  = b.user_id','INNER');
        $this->db->join('order_items d','a.order_id  = d.order_id','LEFT');
        $this->db->join('drivers e','a.driver_id  = e.driver_id','LEFT');
        $this->db->join('driver_vehicile f','e.driver_id  = f.driver_id','LEFT');
        $this->db->join('products g','d.item_id  = g.product_id','LEFT');
       	if(isset($params['order_id']) && $params['order_id']!=""){

       		$this->db->where("a.order_id",$params['order_id']);
       	}

        $query = $this->db->get();

       	return $query->result_array();

    }

    //get toral mart category orders
    public function getMartOrderCount($params){

    	$this->db->select('IF(count(a.order_id)>0,count(a.order_id),0) as mart_order',false);

        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }
        $this->db->from('orders a');

       

        $this->db->having("distance<10");
        $this->db->where("a.module_type",1);
        $this->db->where("a.status !=3");

        $this->db->group_by("a.order_id");
        $query = $this->db->get();

       return $query->row_array();
    }


    public function getResOrderCount($params){

    	$this->db->select('IF(count(a.order_id)>0,count(a.order_id),0) as mart_order',false);

        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }
        $this->db->from('orders a');

       

        $this->db->having("distance<10");
        $this->db->where("a.module_type",2);
        $this->db->where("a.status !=3");

        $this->db->group_by("a.order_id");
        $query = $this->db->get();

       return $query->row_array();
    }


    //get order list
    public function getOrderList($params = [],$limit=false,$offset=false){

    	$this->db->select('a.order_id,a.user_id,b.name,b.image,a.created_at,a.total_amount,a.module_type',false);
    	$this->db->select('IF(c.mart_id>0,c.total_rating,0) as rating',false);
        
        $this->db->from('orders a');
        $this->db->join('users b','a.user_id  = b.user_id','INNER');
        $this->db->join('mart c','a.module_id  = c.mart_id AND a.module_type=1','LEFT');
        
        
       	if(isset($params['user_id']) && $params['user_id']!=""){

       		$this->db->where("a.user_id",$params['user_id']);
       	
       	}

       	if(isset($params['order_type']) && $params['order_type']!=""){

       		//$this->db->where("a.status",$params['order_type']);
       	
       	}	

       	if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

       		$this->db->limit($limit,$offset);
       	}

        $query = $this->db->get();

       	return $query->result_array();

    }

}
?>