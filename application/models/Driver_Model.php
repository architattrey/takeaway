<?php



class Driver_Model extends CI_Model {

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
        $this->db->select("c.license_img,c.road_tax_cert_img,c.cert_img,c.id_card_img,c.vehicle_img,c.insurance_img,c.vechile_id,c.vechile_name,c.vechile_color,c.vechile_number,c.vechile_type,c.vechile_model,c.vechile_category");    
        $this->db->select('e.account_number,e.account_id,e.account_name,e.account_holder_name');
        $this->db->select("GROUP_CONCAT(DISTINCT d.category_id SEPARATOR ',  ') as category_id",false);
        $this->db->from('drivers a');
        $this->db->join('drivers_login_session b','a.driver_id  = b.user_id','INNER');
        $this->db->join('driver_vehicile c','a.driver_id  = c.driver_id','LEFT');
        $this->db->join('driver_category d','a.driver_id  = d.driver_id','LEFT');
        $this->db->join('driver_bank_account e','a.driver_id  = e.driver_id','LEFT');

        if(isset($params['driver_id']) && $params['driver_id']!=''){
            $this->db->where('a.driver_id',$params['driver_id']);
        }
        $query = $this->db->get();
       return !empty($array)?$query->row_array():$query->result_array();
   }
    /**
    *@name getDriverList
    *@description
    */

    public function getDriverList($params = array(), $limit = false, $offset = false,$isVerfied=true) {
        
        try {

            $this->db->select('a.name,a.email,a.country_code,a.mobile,a.wallet_credit,a.status,a.created_at,a.driver_id');
            $this->db->select('b.vechile_type');
            $this->db->select('c.title');
           // $this->db->select("GROUP_CONCAT(DISTINCT b.vechile_type SEPARATOR ',  ') as vechile_type",false);
            $this->db->from('drivers a');
            $this->db->join('driver_vehicile b','a.driver_id = b.driver_id','LEFT');
            $this->db->join('category c','a.category_id = c.category_id','LEFT');

            if($isVerfied){
              $this->db->where('is_verified',ACTIVE);  
            }else{
              $this->db->where('is_verified',INACTIVE);

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
                
                $this->db->where('a.status',$params['status']);
            }
            //using date filter
            if(isset($params['from']) && $params['from']!='' && isset($params['to']) && $params['to']!=''){
                
                $this->db->where("DATE(created_at) BETWEEN '".$params['from']."' AND '".$params['to']."'");
            }
           
            $this->db->order_by("a.created_at","DESC");

            $tempdb = clone $this->db;
            $num_results = $tempdb->count_all_results();

            if (isset($limit) && isset($start)) {
                $this->db->limit($limit, $start);

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
    
     public function getVerified($driverId){
        $this->db->set('is_verified',1);
        $this->db->where('driver_id', $driverId);
        $this->db->update('drivers');
     }
    
    
    /**
     * @name fetchdriverDetail
     * @description This method is used to fetch the udriver detail for the admin panel.
     * @param type $userId
     * @param type $array
     * @return type
     */
   

     public function fetchDriverDetail($driverId=FALSE,$array=TRUE){
        try{
              $this->db->select('a.*,b.access_token,b.device_type,b.device_token');
               $this->db->select("c.license_img,c.road_tax_cert_img,c.cert_img,c.id_card_img,c.vehicle_img,c.insurance_img,c.vechile_id,c.vechile_name,c.vechile_color,c.vechile_number,c.vechile_type,c.vechile_model,c.vechile_category,c.request_received,c.request_accepted,c.request_rejected,c.total_payment");    
              $this->db->select('e.account_number,e.account_id,e.account_name,e.account_holder_name');
             // $this->db->select("GROUP_CONCAT(DISTINCT d.category_id SEPARATOR ',  ') as category_id",false);
              $this->db->from('drivers a');
              $this->db->join('drivers_login_session b','a.driver_id  = b.user_id','INNER');
              $this->db->join('driver_vehicile c','a.driver_id  = c.driver_id','LEFT');
              $this->db->join('driver_category d','a.driver_id  = d.driver_id','LEFT');
              $this->db->join('driver_bank_account e','a.driver_id  = e.driver_id','LEFT');
                
            if($driverId){
                
                $this->db->where('a.driver_id',$driverId);
                
            }
            
            $query = $this->db->get();
            return !empty($array)?$query->row_array():$query->result_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }
   
}
