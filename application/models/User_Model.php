<?php

class User_Model extends CI_Model {

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
     * @name getUserData
     * @param type $params
     * @param type $array
     * @return type
     */
    public function getUserData($params=[],$array = TRUE){

        $this->db->select('a.*,b.access_token,b.device_type,b.device_token');
        $this->db->from('users a');
        $this->db->join('users_login_session b','a.user_id  = b.user_id','INNER');

        if(isset($params['user_id']) && $params['user_id']!=''){
            $this->db->where('a.user_id',$params['user_id']);
        }
        $query = $this->db->get();
       return !empty($array)?$query->row_array():$query->result_array();

    }
    /**
     * @name getUserList
     * @description This method is used to get the user list in the admin panel user listing section.
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getUserList($params = array(), $limit = false, $offset = false,$where=false) {
        try {

            $this->db->select();
            $this->db->from('users');
            //getting total no of count
            
            if($where){
                
                $this->db->where($where);
            }
            
            //searching data
            if(isset($params['search']) && $params['search']!=''){
                $this->db->group_start();
                $this->db->like("name",$params['search']);
                $this->db->or_like("name"," ".$params['search']);
                $this->db->or_like("email",$params['search']);
                $this->db->or_like("name"," ".$params['search']);
                $this->db->group_end();
            }
            //using status filter
            
            if(isset($params['status']) && $params['status']!=''){
                
                $this->db->where('status',$params['status']);
            }else{
                $this->db->where('status !=',DELETED);
            }
            //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
             //checkin filter
            if(isset($params['checkinfrom']) && $params['checkinfrom']!='' && isset($params['checkinto']) && $params['checkinto']!=''){

                $this->db->where("total_checkin BETWEEN '".$params['checkinfrom']."' AND '".$params['checkinto']."'");
            }
             //follower filter
            if(isset($params['followerfrom']) && $params['followerfrom']!='' && isset($params['followerto']) && $params['followerto']!=''){

                $this->db->where("total_follower BETWEEN '".$params['followerfrom']."' AND '".$params['followerto']."'");
            }
           
             $this->db->order_by("users.created_at","DESC");

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
    
    /**
     * @name fetchUserDetail
     * @description This method is used to fetch the user detail for the admin panel.
     * @param type $userId
     * @param type $array
     * @return type
     */
    public function fetchUserDetail($userId=FALSE,$array=TRUE){
        try{
            $this->db->select("*",false);
            $this->db->from('users');
            
            if($userId){
                
                $this->db->where('user_id',$userId);
                
            }
            
            
            $query = $this->db->get();
            return !empty($array)?$query->row_array():$query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }
    /**
     * @name fetchUserDetailInfo
     * @description This method is used to fetch the user other detail for the admin panel.
     * @param type $userId
     * @param type $array
     * @return type
     */
    public function fetchUserDetailInfo($userId=FALSE,$array=TRUE,$limit=false){
        try{
            $this->db->select('b.rating_id,b.rating,b.comments,',false);
            $this->db->select('CASE WHEN b.created_at IS NULL THEN 0 ELSE extract(epoch from b.created_at) END  as rating_time',false);
            $this->db->select('CASE WHEN c.id IS NULL THEN d.name ELSE c.business_name END as rated_name',false);
            $this->db->select('CASE WHEN c.id IS NULL THEN d.image ELSE c.business_img END as rated_image',false);
            
            $this->db->select('f.check_in_id',false);
            $this->db->select('CASE WHEN f.created_at IS NULL THEN 0 ELSE extract(epoch from f.created_at) END  as check_in_time',false);
            $this->db->select('CASE WHEN g.id IS NULL THEN h.name ELSE g.business_name END as checked_in_name',false);
            $this->db->select('CASE WHEN g.id IS NULL THEN h.image ELSE g.business_img END as checked_in_image',false);
            
            //$this->db->select('e.follow_id,e.created_at,u.name as follwing_name,u.pf_image as following_image',false);
//            $this->db->select('CASE WHEN e.created_at IS NULL THEN "" ELSE extract(epoch from e.created_at) END  as following_time',false);
//            $this->db->select('CASE WHEN a.name IS NULL THEN 0, ELSE a.name END as follwing_name',false);
//            $this->db->select('CASE WHEN a.pf_image IS NULL THEN 0 ELSE  a.pf_image END as following_image',false);
////            
            
            $this->db->from('users a');
            $this->db->join('rating_review b','a.user_id =b.user_id','LEFT');
            $this->db->join('business c','b.module_id =c.id AND b.module_type='.RATE_BUSINESS.'','LEFT');
            $this->db->join('resources d','b.module_id =d.resource_id AND b.module_type='.RATE_RESOURCE.'','LEFT');
            //$this->db->join('followers e','a.user_id = e.follower_id ','LEFT');
            //$this->db->join('users u','u.user_id = e.follower_id AND e.module_id='.$userId.' AND e.module_type= 3','LEFT');
            $this->db->join('check_in f','a.user_id =f.user_id','LEFT');
            $this->db->join('business g','f.module_id =g.id AND f.module_type='.RATE_BUSINESS.'','LEFT');
            $this->db->join('resources h','f.module_id =h.resource_id AND f.module_type='.RATE_RESOURCE.'','LEFT');
            
            if($userId){
                
                $this->db->where('a.user_id',$userId);
                
            }
            if($limit){
                
                $this->db->limit($limit);
                
            }
            
            $query = $this->db->get();
            return $query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }

     /**
     * @name getFollwoinguser
     * @description This method is used to fetch the data of following user list
     * @param type $userId
     * @param type $array
     * @return type
     */
    
     public function getFollwinguser($userId=FALSE,$params,$limit=false,$offset){
        try{
             $this->db->select("e.follow_id,e.module_type,e.created_at,a.name,b.business_name,c.name as user_name ,c.pf_image,b.business_img,a.image",false); 
//            / $this->db->select('CASE WHEN a.name IS NULL THEN b.business_name ELSE c.name WHEN b.name IS NULL THEN c.name END as title_name',false);
            // $this->db->select('CASE WHEN b.business_name IS NULL THEN c.name ELSE a.name END as title_name',false);
             //$this->db->select('CASE WHEN c.name IS NULL THEN a.name ELSE b.business_name END as title_name',false);
           //  $this->db->select('CASE WHEN b.id IS NULL THEN d.image ELSE c.business_img END as rated_image',false);
             //$this->db->select('CASE WHEN c.id IS NULL THEN d.image ELSE c.business_img END as rated_image',false);
            
             $this->db->from('followers e');
             $this->db->join('resources a','e.module_id = a.resource_id AND e.module_type = 2','LEFT');
             $this->db->join('business b','e.module_id = b.id AND e.module_type = 1','LEFT');
             $this->db->join('users c','c.user_id = e.module_id AND e.module_type = 3','LEFT');
             
             $this->db->where('e.follower_id',$userId);
             //$this->db->where(' e.module_type',3);
             if(isset($params['search']) && $params['search']!=''){
                $this->db->like("LOWER(u.name)",  strtolower($params['search']));
            }
            if ($limit == 6) {
            $this->db->limit($limit);
            }else{
            if (isset($limit) && isset($start)) {
                $this->db->limit($limit, $start);
            }
            if (isset($limit) && $limit != false) {
               // $this->db->limit($limit, $offset);
            }
            }
             //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                $this->db->where("DATE(e.created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
            $this->db->order_by("e.created_at", "DESC");
            
            $query = $this->db->get();
            $result = $query->result_array();
            $result['count'] = count($result);
            return $result;
        } catch (Exception $e) {
            echo json_encode($e->getTraceAsString());
        }
        
    }
     
      /**
     * @name getRatinguser
     * @description This method is used to fetch the data of rating user list
     * @param type $userId
     * @param type $array
     * @return type
     */
     
      public function getRatinguser($userId=FALSE,$params,$limit=false,$offset=false){
        try{
             $this->db->select('r.user_id,r.module_type,r.rating,r.comments,r.created_at,b.business_name ,',false); 
             $this->db->from('rating_review as r');
             $this->db->join('business as b','b.id = r.module_id','LEFT');
             $this->db->where('r.user_id',$userId);
             $this->db->where('r.module_type',1);
            if(isset($params['search']) && $params['search']!=''){
                $this->db->like("LOWER(b.business_name)",  strtolower($params['search']));
            }
            if (isset($limit) && isset($start)) {
                $this->db->limit($limit, $start);
            }
            if (isset($limit) && $limit != false) {
               // $this->db->limit($limit, $offset);
            }
             //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(r.created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
            
             $this->db->order_by("r.created_at","DESC");
       
        $query = $this->db->get();
       
        $result = $query->result_array();
        $result['count'] = count($result);
        return $result;
           }  catch (Exception $e){
            echo json_encode($e->getTraceAsString());
           }
     }
}
