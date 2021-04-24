<?php

class Usermart_Model extends CI_Model {

    public $finalrole = array();

    public function __construct() {
        $this->load->database();
    }

    public function getUsers(){

      $this->db->select('*');
      $this->db->from('users');
      $query = $this->db->get();
      return $query->result_array();


    }

    /**
     * @name getMartHomeData
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getMartHomeData($params=[],$limit=false){

        $this->db->select("a.mart_id,a.mart_name,a.lat as lattitude,a.lng as longitude,CONCAT('".IMAGE_URL."',logo_img_path) as logo_image");
        //$this->db->select("GROUP_CONCAT(DISTINCT b.mart_id SEPARATOR ',  ') as mart_id",false);
        //$this->db->select("GROUP_CONCAT(DISTINCT b.mart_name SEPARATOR ',  ') as mart_name",false);
        //$this->db->select("GROUP_CONCAT(DISTINCT b.logo_image SEPARATOR ',  ') as logo_image",false);
        if(isset($params['latitude']) && $params['latitude']!="" && isset($params['longitude']) && $params['longitude']!=""){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) )) as distance",false);
        }else{
            $this->db->select("0 distance");
        }
        $this->db->from('mart a');
        $this->db->join('category b','a.category_id  = b.category_id','INNER');

        if(isset($params['search']) && $params['search']!=""){
            $this->db->group_start();
            $this->db->like('a.mart_name',$params['search']);
            $this->db->or_like('a.mart_name'," ".$params['search']);
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
     * @name getMartHomeDataByCategory
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getMartHomeDataByCategory($params=[],$limit=false){

        $this->db->select("a.mart_id,a.mart_name,a.lat as lattitude,a.lng as longitude,CONCAT('".IMAGE_URL."',logo_img_path) as logo_image",false);
        //$this->db->select("GROUP_CONCAT(DISTINCT b.mart_id SEPARATOR ',  ') as mart_id",false);
        //$this->db->select("GROUP_CONCAT(DISTINCT b.mart_name SEPARATOR ',  ') as mart_name",false);
        //$this->db->select("GROUP_CONCAT(DISTINCT b.logo_image SEPARATOR ',  ') as logo_image",false);
        $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) ) ) as distance",false);

        $this->db->from('mart a');
        $this->db->join('category b','a.category_id  = b.category_id','INNER');
        $this->db->where("a.category_id",2);  // 2 for mart category
        $this->db->having("distance<10");
        
        $query = $this->db->get();

        if($limit){

            $this->db->limit($limit);
        }
       return $query->result_array();
    }

    /**
     * @name getLatestMartBanners
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getLatestMartBanners($params=[],$limit=false){

        $this->db->select("a.mart_id,a.mart_name,CONCAT('".IMAGE_URL."',banner_img_path) as logo_image",false);
        
        $this->db->from('mart a');
        $this->db->join('category b','a.category_id  = b.category_id','INNER');
        
        $this->db->order_by("total_rating","DESC");
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
    public function getMartDetail($params=[],$limit=false,$offset=false,$isArray=false){

        $this->db->select("a.mart_id,a.mart_name,CONCAT('".IMAGE_URL."',banner_img_path) as banner_image,CONCAT('".IMAGE_URL."',logo_img_path) as logo_image,a.total_rating,a.address,a.opening_time,a.closing_time,a.phone,a.email",false);

        if(isset($params['latitude']) && isset($params['longitude'])){

            $this->db->select("(3959 * acos( cos( radians(".$params['latitude'].") ) * cos( radians( a.lat) )* cos( radians( a.lng) - radians(".$params['longitude'].") ) + sin( radians(" . $params['latitude'] . ") ) * sin(radians(a.lat)) ) ) as distance",false);

        }else{

            $this->db->select("0 distance");
        }

        

        $this->db->from('mart a');
        
        if(isset($params['mart_id']) && $params['mart_id']!=""){
            $this->db->where("a.mart_id",$params['mart_id']); 
        }
        
        $query = $this->db->get();

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

            $this->db->limit($offset,$limit);
        }
       return ($isArray)?$query->row_array():$query->result_array();
    }


    public function getMartProducts($params=[],$limit=false,$offset=false){

        $this->db->select('d.product_id,d.product_name,d.image,d.status,d.amount');

        $this->db->from('mart a');
        $this->db->join("mart_category b","a.category_id = b.cat_id","INNER");
        $this->db->join("mart_products c","b.mart_cat_id = c.mart_cat_id","INNER");
        $this->db->join("products d","c.product_id = d.product_id","INNER");

        if(isset($params['mart_id']) && $params['mart_id']!=""){
            $this->db->where("a.mart_id",$params['mart_id']); 
        }
        if(isset($params['category_id']) && $params['category_id']!=""){
            $this->db->where("b.cat_id",$params['category_id']); 
        }
        
        $query = $this->db->get();

        if(isset($limit) && $limit!="" && isset($offset) && $offset!=""){

            $this->db->limit($offset,$limit);
        }
       return $query->result_array();
    }


}
