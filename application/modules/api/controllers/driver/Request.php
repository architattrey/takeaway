
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationDriver.php';

class Request extends AutheticationDriver {




    protected  $request=[];
    protected  $offset  = 0;
    protected  $is_more_data  = 0;

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


  public function index_get(){
        $this->request  = $this->get();

        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$userId = $this->checkLogin($accessToken);

        $this->validator(['latitude','longitude','module_type'],$this->request,true);
        $this->load->model("Request_Model","Request",true);

        $requestType =  [NOTIFY_MART_ORDER];

        $request =$this->Request->getDriverRequest($this->request,PAGE_LIMIT_APP,$this->request['offset'],$requestType);

        if(is_array($request) && !empty($request)){

            $this->offset = count($request) + $this->request["offset"];
            $this->request['offset'] = $this->offset;
            $this->is_more_data  =!empty($this->Request->getDriverRequest($this->request,PAGE_LIMIT_APP,$this->request['offset'],$requestType))?1:0;

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'request'=>$request]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'request'=>[]]]);
        }
  }


  // method to accept to order request for the driver
  public function acceptRequest_post(){

    $this->request = $this->post();

    

    $this->form_validation->set_rules('driver_id','Driver Id','trim|required');
    $this->form_validation->set_rules('order_id','Order_id','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['driver_id','order_id']);
        }
        // checking if order accepted or not.
        $this->checkAlradyAccepted($this->request);

        $this->db->trans_begin();


        $this->Common_model->update_single("orders",['driver_id'=>$this->request['driver_id']],['where'=>['order_id'=>$this->request['order_id']]]);


        //updating in order history

        $this->Common_model->update_single("orders",['status'=>1],['where'=>['order_id'=>$this->request['order_id'],'driver_id'=>$this->request['driver_id']]]);

        if($this->db->trans_status()==true){
          $this->db->trans_commit(); 
        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['requests'=>$this->request]]);

        }else{
          $this->db->trans_rollback();
          $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
        }


  }


  // to check if order is already accepted.
  private function checkAlradyAccepted($request){


      $orderAccepted =  $this->Common_model->fetch_data('orders','*',['where'=>['order_id'=>$request['order_id'],'driver_id >'=>0]],true);
      
      if(!empty($orderAccepted)){
        $this->response(['status_code' => FAILED, 'status_message' => "This order is already accepted by other driver."]);
      }

  }


  // method to accept to order request for the driver
  public function rejectRequest_post(){

    $this->request = $this->post();

    

    $this->form_validation->set_rules('driver_id','Driver Id','trim|required');
    $this->form_validation->set_rules('order_id','Order_id','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['driver_id','order_id']);
        }

        $this->db->trans_begin();


        //updating in order history

        $this->Common_model->update_single("orders",['status'=>2],['where'=>['order_id'=>$this->request['order_id'],'driver_id'=>$this->request['driver_id']]]);

        if($this->db->trans_status()==true){
          $this->db->trans_commit(); 
        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['requests'=>$this->request]]);

        }else{
          $this->db->trans_rollback();
          $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
        }


  }
}   

