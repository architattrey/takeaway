<?php
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationDriver.php';

class Foodget extends AutheticationDriver {

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
		$this->form_validation->CI = &$this;
		}

		public function foodDetail_get(){

		$postData  = $this->get();
		// validate user login access token.
		$accessToken  = $this->getAccessToken();

		//$driverId = $this->checkLogin($accessToken);


		//here getting  the driver vehicle info.

		$foodDetail =  $this->_foodDetail(1);
		if(is_array($foodDetail) && !empty($foodDetail)){
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['food'=>$foodDetail]]);
		}else{
			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>(object)[]]);
		}
	}	
	
	/**
	*@name _vehicleDetail
	*
	*/
	private function _vehicleDetail($foodId){

		try{

			return $this->Common_model->fetch_data("restaurant","*",['where'=>['restaurant_id'=>$foodId,'status'=>ACTIVE]],true);

		}catch(Exception $e){
			$this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
		}

	}
}
?>