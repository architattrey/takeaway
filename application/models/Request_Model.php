<?php

class Request_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }



    public function getDriverRequest($params=[],$limit=false,$offset=false){



        $this->db->select("a.order_id,a.module_id,a.module_type,a.total_amount,b.name as user_name,a.module_address,10 per_km",false); 
        $this->db->select("IF (b.image IS NULL ,'',b.image) as user_image"); 
        $this->db->select("IF(c.mart_name IS NULL,'',c.mart_name) as module_name",false);
        $this->db->select("IF(a.is_current_address >0,b.address,a.user_address) as user_address",false); 

        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }
        $this->db->from('orders a');

        $this->db->join("users b","a.user_id = b.user_id","INNER");
        $this->db->join("mart c","a.module_id = c.mart_id AND a.module_type=1","LEFT");

        $this->db->having("distance<10");

        if(isset($params['module_type']) && $params['module_type']!=""){
            $this->db->where("a.module_type",$params['module_type']);
            $this->db->where("a.driver_id","");    
        }
        
        
        $query = $this->db->get();

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

            $this->db->limit($offset,$limit);
        }
       return $query->result_array();
    }
}


?>