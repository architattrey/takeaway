
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationDriver.php';

class Driver extends AutheticationDriver {

	/**
	 * Constructor for the HashTag API
	 *
	 * @access public
	 * @param string $config
	 * @return void
	 */
	public function __construct($config = 'rest') {
		parent::__construct($config);

		$this->load->helper('url');
		// Authentication for header.

		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->model('Common_model');
		$this->load->library('session');
		$this->lang->load('rest_controller', "english");
		$this->load->library('form_validation');
		$this->form_validation->CI = &$this;


		/*
		 * $uAccessToken = isset($this->input->request_headers()['uaccesstoken']) ? $this->input->request_headers()['uaccesstoken'] : $this->input->request_headers()['Uaccesstoken'];
		 * $file = fopen(__DIR__."/debug.txt","a+");
		  fwrite($file , PHP_EOL."===================INSERT FOR DOCTOR ==== ". $this->uri->segment(3)." === header ".$this->input->request_headers()['Uaccesstoken']." ===============".PHP_EOL.json_encode($this->input->post()).PHP_EOL."===TIME===".date("Y-m-d H:i:s").PHP_EOL);
		  fclose($file); */
		}

		public function changePassword_post(){
			$postData = $this->input->post();


		// validate user login access token.
			$accessToken  = $this->getAccessToken();

			$driverId = $this->checkLogin($accessToken); 

			$this->form_validation->set_rules('old_password', 'old password', 'required|min_length[8]|max_length[15]|callback_check_old_password');
			$this->form_validation->set_rules('new_password','new password', 'required|min_length[8]|max_length[15]');

			if ($this->form_validation->run() == FALSE) {

				$this->setErrorJson(['old_password','new_password']);
			}
		//calling method to get comments list
			$this->db->trans_begin();
			$this->_updatePassword($postData,$driverId);

			if($this->db->trans_status()==true){
				$this->db->trans_commit();
				$this->response(['status_code' => SUCCESS, 'status_message' => 'Password changed successfully.']);
			}else{
				$this->db->trans_rollback();
				$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
			}
		}

	/**
	*@name _updatePassword
	*
	**/
	public function check_old_password($key){
		$isExists  = $this->Common_model->fetch_data('drivers','driver_id',['where'=>['password'=>hash('sha256', $key)]],true);
		if (!$isExists){
			$this->form_validation->set_message('check_old_password',"Old password is invalid." );
			return false;
		}
		else{
			return true;
		}
	}
	/**
	*@name _updatePassword
	*@description This method is use to update the new password of the user.
	**/
	private function _updatePassword($postData,$driverId){
		try{
			
			return $this->Common_model->update_single('drivers',['password'=>hash('sha256', $postData['new_password'])],['where'=>['driver_id'=>$driverId]]);

		}catch(Exception $e){
			$this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
		}
	}
	/**
	*@name addVechicle
	*@description This method is used to add vechicle for driver.
	*@access public
	**/
	public function addVechicle_post(){


		//$post =  file_get_contents('php://input');
		$post = $this->input->post();
		// validate user login access token.
		$accessToken  = $this->getAccessToken();

		$driverId = $this->checkLogin($accessToken); 

		$this->form_validation->set_rules('vehicle_type','Vehicle Type','trim|required');
		$this->form_validation->set_rules('vehicle_name','Vehicle Name','trim|required');
		$this->form_validation->set_rules('vehicle_color','Vehicle Number','trim|required');
		$this->form_validation->set_rules('vehicle_model','Vehicle Model','trim|required');
		$this->form_validation->set_rules('vehicle_category','Vehicle Category','trim|callback_check_vehicle_category');
		if ($this->form_validation->run() == FALSE) {

			$this->setErrorJson(['vehicle_type','vehicle_name','vehicle_color','vehicle_model','vehicle_category']);
		}
		// proccess this  baby

		$this->db->trans_begin();
		
		//$post  = $this->_uploadVehicleImage($_FILES,$post);


		$vehicleId = $this->savingValuesToTables($post,$driverId);

		if($this->db->trans_status() == true){
			$this->db->trans_commit();
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['vehicle_id'=>$vehicleId]]);
		}else{
			$this->db->trans_rollback();
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>[]]);
		}

	}

	public function check_vehicle_category(){

		$post = $this->input->post();
		if(isset($post['vehicle_type']) && $post['vehicle_type']==1 && $post['vehicle_category']==""){
			$this->form_validation->set_message('check_vehicle_category', "The vehicle category is required.");
			return false;
		}else{
			return true;
		}


	}



	/**
	*@name savingValuesToTables
	*@param $post
	*@param $driverId
	**/
	private function savingValuesToTables($post,$driverId){
		
		/*$vehicle['lincense_img'] = isset($post['driving_license'])?$post['driving_license']:"";
		$vehicle['id_card_img'] = isset($post['id_card'])?$post['id_card']:"";
		$vehicle['cert_img'] = isset($post['vehicle_cert'])?$post['vehicle_cert']:"";
		$vehicle['vehicle_img'] = isset($post['vehicle_image'])?$post['vehicle_image']:"";
		$vehicle['insurance_img'] = isset($post['vehicle_insurance'])?$post['vehicle_insurance']:"";
		$vehicle['road_tax_cert_img'] = isset($post['road_tax_cert'])?$post['road_tax_cert']:"";*/


		$vehicle['vechile_name'] = $post['vehicle_name'];
		$vehicle['vechile_model'] = $post['vehicle_model'];
		$vehicle['vechile_number'] = $post['vehicle_number'];
		$vehicle['vechile_color'] = $post['vehicle_color'];
		$vehicle['vechile_category'] = isset($post['vehicle_category'])?$post['vehicle_category']:""; 
		$vehicle['vechile_type'] = $post['vehicle_type'];
		$vehicle['driver_id'] = $driverId;
		$vehicle['status'] =ACTIVE;
		$vehicle['created_at'] =DEFAULT_DB_DATE_TIME_FORMAT;
		$vehicle['updated_at'] =DEFAULT_DB_DATE_TIME_FORMAT;


		return $this->Common_model->insert_single('driver_vehicile',$vehicle);

		       
	}

	/**
	*@name uploadDocument
	*@descriiption This is used to upload document for the driver vechile.
	*
	**/

	public function uploadDocument_post(){

		//$post =  file_get_contents('php://input');
		$post = $this->input->post();
		// validate user login access token.
		$accessToken  = $this->getAccessToken();

		$driverId = $this->checkLogin($accessToken); 
		$vehicleId = $post['vehicle_id'];
		unset($post['vehicle_id']);
		$post  = $this->_uploadVehicleImage($_FILES,$post);

		if($this->Common_model->update_single('driver_vehicile',$post,['where'=>['vechile_id'=>$vehicleId]])){

			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['vehicle_id'=>$vehicleId]]);

		}else{
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>[]]);
		}
	}


	private function _uploadVehicleImage($files,$post){

		//upload driving licenses
		if(isset($files['driving_license']) && $files['driving_license']!=""){

			$post['lincense_img'] =  $this->Common_model->uploadfile('driving_license',$files,'url','api/vehicle');
		}
		
		//upload id card
		if(isset($files['id_card']) && $files['id_card']!=""){

			$post['id_card_img'] =  $this->Common_model->uploadfile('id_card',$files,'url','api/vehicle');
		}
		//vehicle certification

		if(isset($files['vehicle_cert']) && $files['vehicle_cert']!=""){

			$post['cert_img'] =  $this->Common_model->uploadfile('vehicle_cert',$files,'url','api/vehicle');
		}

		//vehicle certification

		if(isset($files['road_tax_cert']) && $files['road_tax_cert']!=""){

			$post['road_tax_cert_img'] =  $this->Common_model->uploadfile('road_tax_cert',$files,'url','api/vehicle');
		}

		//vehicle im age

		if(isset($files['vehicle_image']) && $files['vehicle_image']!=""){

			$post['vehicle_img'] =  $this->Common_model->uploadfile('vehicle_image',$files,'url','api/vehicle');
		}

		//vehicle im age

		if(isset($files['vehicle_insurance']) && $files['vehicle_insurance']!=""){

			$post['insurance_img'] =  $this->Common_model->uploadfile('vehicle_insurance',$files,'url','api/vehicle');
		}

		return $post;
	}

	/**
	*@name addVechicle
	*@description This method is used to add vechicle for driver.
	*@access public
	**/

	public function addBankAccount_post(){
		$postData = $this->input->post();
		// validate for empty parameters
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken); 

		$this->form_validation->set_rules('account_name', "Account Namew", 'trim|required');
		$this->form_validation->set_rules('account_number', "Account Number", 'trim|required');
		$this->form_validation->set_rules('account_holder_name', "Account holder name", 'required');
		
		

		if ($this->form_validation->run() == FALSE) {

			$this->setErrorJson(['account_name','account_number','account_holder_name']);
		}

		$this->db->trans_begin();

		$this->_insertBankDetails($postData,$driverId);

		if($this->db->trans_status() == true){
			$this->db->trans_commit();
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
		}else{
			$this->db->trans_rollback();
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
		}
	}


	private function _insertBankDetails($postData,$driverId){


		$saveData['driver_id']   =$driverId;
		$saveData['account_number']   =$postData['account_number'];
		$saveData['account_name']   =$postData['account_name'];
		$saveData['account_holder_name']   =$postData['account_holder_name'];
		$saveData['status']   =ACTIVE;
		$saveData['created_at']   =DEFAULT_DB_DATE_TIME_FORMAT;
		return $this->Common_model->insert_single('driver_bank_account',$saveData);

	}



	public function addDriverCategory_post(){
		$postData = $this->input->post();
		// validate for empty parameters
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken); 

		$this->form_validation->set_rules('category', "Category", 'trim|required');
		
		

		if ($this->form_validation->run() == FALSE) {

			$this->setErrorJson(['category']);
		}

		$this->db->trans_begin();

		$this->_saveDrivercategory($postData,$driverId);

		if($this->db->trans_status() == true){
			$this->db->trans_commit();
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
		}else{
			$this->db->trans_rollback();
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
		}
	}


	private function _saveDrivercategory($postData,$driverId){

		
		if(isset($postData['category']) && $postData['category']){
			$post = explode(',',$postData['category']);
				
			for($i=0;$i<count($post);$i++){
				$category['driver_id'] = $driverId;
				$category['category_id'] = $post[$i]; 
				$category['status'] =ACTIVE;
				$allCategory[]  =$category;
			}
			$this->Common_model->insert_batch('driver_category',[],$allCategory);
		}
	}

	/**
	*@name home
	*
	*/
	public function home_get(){
		$postData = $this->input->post();
		// validate for empty parameters
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken);

		$homecategory = $this->getAllHomeCategory();
		if(is_array($homecategory) && !empty($homecategory)){

			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['category'=>$homecategory]]);	
		}else{
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>[]]);
		}
	}

	private function getAllHomeCategory(){
		try{

			return $this->Common_model->fetch_data("category","category_id,title,status,image,0 as count",['where'=>['status'=>ACTIVE]]);

		}catch(Exception $e){
			$this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
		}
	}

/**
*@name updateProfile
*@description use to update profile of doctor.
*
*
**/
	public function updateProfile_post(){
		
		$postData = $this->input->post();
		
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken);

        // validate for empty parameters
        
        $this->form_validation->set_rules('driver_id', "Driver Id", 'trim|required');
        $this->form_validation->set_rules('name', "Name", 'trim|required');
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|callback_check_email_exists');
        $this->form_validation->set_rules('country_code', $this->lang->line('country_code'), 'required');
        $this->form_validation->set_rules('mobile', $this->lang->line('mobile'), 'required|regex_match[/^[0-9]\d{5,16}$/]|callback_check_mobile_exists');
        

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email','mobile','name','country_code']);
        }
        // process singup for the next step, for inserting into db.
        $this->db->trans_begin();

        //checking & uploading driver profile image.
        $imageUrl="";
        if(isset($_FILES['driver_image']) && !empty($_FILES['driver_image'])){


        	$imageUrl = $this->uploadDriverImage($_FILES);
        }


        $driverId = $this->updateUserValues($postData,$imageUrl);

        if($this->db->trans_status()==TRUE){
            $this->db->trans_commit();
           	
            	//preparing for response

            $driverData   =$this->responseReturn($this->Common_model->fetch_data("drivers","*",['where'=>['driver_id'=>$postData['driver_id']]],true));
            
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['users'=>$driverData]]);
        }else{
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
	}

	/**
     *
     * @name check_email_exists
     * @description This method is used to check that email already exists.
     * @param type $key
     * @return boolean
     *
     */
    public function check_email_exists(){
      $postData = $this->input->post();
      $isExists  = $this->Common_model->fetch_data('drivers','email',['where'=>['email'=>$postData['email'],'driver_id !='=>$postData['driver_id']],'where_in'=>['status'=>[ACTIVE,INACTIVE]]],true);
      if ($isExists){
        $this->form_validation->set_message('check_email_exists', $this->lang->line('email_exists'));
        return false;
      }
      else{
          return true;
      }
    }

    /**
     *
     * @name check_mobile_exists
     * @descroiption This method is used to check mobile is exists or not.
     * @param type $key
     * @return boolean
     */
    public function check_mobile_exists(){
      $postData = $this->input->post();
      $isExists  = $this->Common_model->fetch_data('drivers','mobile',['where'=>['mobile'=>$postData['mobile'],'country_code'=>$this->input->post('country_code'),'driver_id !='=>$postData['driver_id']],'where_in'=>['status'=>[ACTIVE,INACTIVE]]],true);
      if ($isExists){
        $this->form_validation->set_message('check_mobile_exists', $this->lang->line('mobile_exists'));
        return false;
      }
      else{
          return true;
      }
    }

    /**
     *
     * @name insertUserValues
     * @param type $postData
     *
     */
    private function updateUserValues($postData,$imageUrl){
        try{

                $savedata = [
                'name' => $postData['name'],
                'country_code' => $postData['country_code'],
                'mobile' => $postData['mobile'],
                'email' => $postData['email'],
                'image' => $imageUrl,
                'updated_at' => DEFAULT_DB_DATE_TIME_FORMAT
            ];

            return $this->Common_model->update_single('drivers',$savedata,['where'=>['driver_id'=>$postData['driver_id']]]);

        }  catch (Exception $e){
            echo json_encode($e->getMessage());
            exit;
        }

    }

    private function uploadDriverImage($files){
    	//upload driving licenses
		if(isset($files['driver_image']) && $files['driver_image']!=""){

			return $this->Common_model->uploadfile('driver_image',$files,'url','api/driver');
		}
	
    }

    /**
     * @name responseReturn
     * @description Thie method is used to return response array for login and signup methods.
     * @param type $registerData
     * @param type $key
     * @return type
     */
    public function responseReturn($registerData) {


        $responseArr['user_id'] = (int)$registerData['driver_id'];
        $responseArr['name'] = $registerData['name'];
        
        
        $responseArr['email'] = $registerData['email'];
        $responseArr['mobile'] = $registerData['mobile'];
        $responseArr['country_code'] =$registerData['country_code'];
        $responseArr['driver_image'] =$registerData['image'];
        
        $responseArr['status'] = $registerData['status'];
        $responseArr['latitude'] = isset($registerData['lat']) ? $registerData['lat'] : '';
        $responseArr['longitude'] = isset($registerData['lng']) ? $registerData['lng'] : '';
        return $responseArr;
    }



    //==========================================================

    public function updateDriverCategory_post(){
		$postData = $this->input->post();
		// validate for empty parameters
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken); 
		
		$this->form_validation->set_rules('category', "Category", 'trim|required');
		
		

		if ($this->form_validation->run() == FALSE) {

			$this->setErrorJson(['category']);
		}

		$this->db->trans_begin();

		$this->_updateDrivercategory($postData,$driverId);

		if($this->db->trans_status() == true){
			$this->db->trans_commit();
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
		}else{
			$this->db->trans_rollback();
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
		}
	}


	private function _updateDrivercategory($postData,$driverId){

		
		if(isset($postData['category']) && $postData['category']){
			$post = explode(',',$postData['category']);
				
			for($i=0;$i<count($post);$i++){
				$category['driver_id'] = $driverId;
				$category['category_id'] = $post[$i]; 
				$category['status'] =ACTIVE;
				$allCategory[]  =$category;
			}
			$this->Common_model->delete_data('driver_category',['where'=>['driver_id'=>$driverId]]);
			$this->Common_model->insert_batch('driver_category',[],$allCategory);
		}
	}
}   

