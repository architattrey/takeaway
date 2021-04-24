<?php

class Restaurent_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    
    /**
     * @name getrestaurantHomeData
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getRestaurentHomeData($params=[],$limit=false){

        $this->db->select("a.restaurant_id,a.name,a.banner_img_path as banner_image");
        
        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }else{
            $this->db->select("0 distance");
        }

        $this->db->from('restaurant a');
        
        if(isset($params['search']) && $params['search']!=""){
            $this->db->group_start();
            $this->db->like('a.name',$params['search']);
            $this->db->or_like('a.name'," ".$params['search']);
            $this->db->group_start();
        }

        $this->db->having("distance<10");
        $query = $this->db->get();

        if($limit){

            $this->db->limit($limit);
        }
       return $query->result_array();
    }
    
   /**
     * @name getMartDetail
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getResDetail($params=[],$limit=false,$offset=false,$isArray=false){

        $this->db->select("a.restaurant_id,a.name,a.banner_img_path as banner_image,a.logo_img_path as logo_image,a.address,a.country_code,a.phone,a.opening_time,a.closing_time,a.banner_img_path",false);

        if(isset($params['latitude']) && isset($params['longitude'])){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) ) ) as distance",false);

        }else{

            $this->db->select("0 distance");
        }

        

        $this->db->from('restaurant a');
        
        if(isset($params['restaurent_id']) && $params['restaurent_id']!=""){
            $this->db->where("a.restaurant_id",$params['restaurent_id']); 
        }
        
        $query = $this->db->get();

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

            $this->db->limit($offset,$limit);
        }
       return ($isArray)?$query->row_array():$query->result_array();
    }


    public function getResDishes($params=[],$limit=false,$offset=false){

        $this->db->select('d.*');

        $this->db->from('restaurant a');
        $this->db->join("res_cat_cusines b","b.restaurant_id = b.restaurant_id","INNER");
        $this->db->join("restaurant_dishes c","b.res_cat_cusine_id = c.res_cat_cusine_id","INNER");
        $this->db->join("dishes d","c.dish_id = d.dish_id","INNER");
        

        //if(isset($params['cusine_id']))

        /*if(isset($params['category_id']) && $params['category_id']!=""){
            $this->db->where("FIND_IN_SET(".$params['category_id'].",a.category_id)",NULL,false); 
        }*/
        
        if(isset($params['restaurent_id']) && $params['restaurent_id']!=""){
            $this->db->where("a.restaurant_id",$params['restaurent_id']); 
        }

        if(isset($params['cusine_id']) && $params['cusine_id']!=""){

            $params['cusine_id']  =explode(",",$params['cusine_id']);
            $this->db->where_in("b.cusine_id",$params['cusine_id']);

        }

        if(isset($params['dish_type']) && $params['dish_type']!=""){
            $this->db->where("d.type",$params['dish_type']); 
        }

        $query = $this->db->get();

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

            $this->db->limit($offset,$limit);
        }
       return $query->result_array();
    }

    /**
     * @name getRestaurentsBanners
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getRestaurentsBanners($params=[],$limit=false){

        $this->db->select("a.restaurant_id,a.banner_img_path banner_img_path,a.name");
        
        $this->db->from('restaurant a');
        
        $this->db->order_by("created_at","DESC");
        $this->db->limit(10);
        $query = $this->db->get();

        if($limit){

            $this->db->limit($limit);
        }

       return $query->result_array();
    }
}


