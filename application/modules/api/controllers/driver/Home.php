
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationDriver.php';

class Home extends AutheticationDriver {


	protected $request  =[];
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
	}

	public function updateLatLng_post(){
		$this->request = $this->input->post();
		// validate for empty parameters
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken); 

		$this->form_validation->set_rules('latitude', "Latitude", 'trim|required');
		$this->form_validation->set_rules('longitude', "Longitude", 'trim|required');
		

		if ($this->form_validation->run() == FALSE) {

			$this->setErrorJson(['latitude,longitude']);
		}
		$this->request['driver_id'] = $driverId;
		$this->db->trans_begin();

		$this->updateLatLng($this->request);

		if($this->db->trans_status() == true){
			$this->db->trans_commit();

			// getting driver wallet or total order count.


			$response['credit']  =$this->getTotalCredit($this->request);
			$response['mart'] = !empty($this->getMartOrderCount($this->request))?$this->getMartOrderCount($this->request):0;
			$response['food'] = !empty($this->getResOrderCount($this->request))?$this->getResOrderCount($this->request):0;

			$response['take_sent']  =0;
			$response['take_car']  =0;

			$this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['drivers'=>$response]]);
		}else{
			$this->db->trans_rollback();
			$this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
		}
	}


	// update driver latitude longitude.
	private function updateLatLng($request){
		try{

			return $this->Common_model->update_single("drivers",['lat'=>$request['latitude'],'lng'=>$request['longitude']],['where'=>['driver_id'=>$request['driver_id']]],true);

        }catch(Exception $e){
            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
	}


	// get lat lng of driver
	private function getTotalCredit($request){
		try{

			return $this->Common_model->fetch_data("drivers","wallet_credit,lat as latitude,lng as longitude",['where'=>['driver_id'=>$request['driver_id']]]);

        }catch(Exception $e){
            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
	}


	// get lat lng of driver
	private function getMartOrderCount($request){
		try{
			$this->load->model("Order_Model","Order",True);
			return $this->Order->getMartOrderCount($request);

        }catch(Exception $e){
            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
	}


	// get lat lng of driver
	private function getResOrderCount($request){
		try{

			$this->load->model("Order_Model","Order",True);
			return $this->Order->getResOrderCount($request);

        }catch(Exception $e){
            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
	}

}   

