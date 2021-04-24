
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class Credit extends AutheticationLib {

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
        $this->load->model('Usermart_Model','Mart');
		$this->load->library('session');
		$this->lang->load('rest_controller', "english");
		$this->load->library('form_validation');
		$this->form_validation->CI = &$this;

	}


    public function rechargeSelfWallet_post(){
        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$driverId = $this->checkLogin($accessToken);
        $this->request  = $this->post();
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('credit','Credit','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['user_id','credit']);
        }

        $walletCredit=  $this->Common_model->fetch_data("users","wallet_credit_point",['where'=>['user_id'=>$this->request['user_id']]],true);
       
       $this->Common_model->update_single("users",["wallet_credit_point"=>$walletCredit['wallet_credit_point'] + $this->request['credit']],['where'=>['user_id'=>$this->request['user_id']]]);

        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        
    }

    public function rechargeFriendWallet_post(){
        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$driverId = $this->checkLogin($accessToken);
        $this->request  = $this->post();
        
        $this->form_validation->set_rules('user_id','User Id','trim|required|callback_check_credit_available');
        $this->form_validation->set_rules('credit','Credit','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|callback_check_valid_user');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['user_id','credit','mobile']);
        }

        $walletCredit=  $this->Common_model->fetch_data("users","wallet_credit_point",['where'=>['mobile'=>$this->request['mobile']]],true);
       
       $this->Common_model->update_single("users",["wallet_credit_point"=>$walletCredit['wallet_credit_point'] + $this->request['credit']],['where'=>['mobile'=>$this->request['mobile']]]);


       $walletCredit=  $this->Common_model->fetch_data("users","wallet_credit_point",['where'=>['user_id'=>$this->request['user_id']]],true);
       
       $this->Common_model->update_single("users",["wallet_credit_point"=>$walletCredit['wallet_credit_point'] - $this->request['credit']],['where'=>['user_id'=>$this->request['user_id']]]);

        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        
    }


    public function check_valid_user(){
       $this->request  = $this->post();
       
       $isValid = CommonAction::checkValidUser($this->request['mobile']);
       if($isValid){
            return true;
       }else{

          $this->form_validation->set_message('check_valid_user', "This is user is not valid.");
            return false;  

       }
    }



    public function check_credit_available(){

        $this->request  = $this->post();

        $isValid = CommonAction::checkAvailableCredit($this->request['user_id'],$this->request['credit']);

       if($isValid){
            return true;
       }else{

          $this->form_validation->set_message('check_credit_available', "You do not have enough credits.");
            return false;  

       }
    }





}   

