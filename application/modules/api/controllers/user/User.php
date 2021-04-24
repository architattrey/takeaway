
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class User extends AutheticationLib {

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
/**
*@name updateProfile
*@description This method is used to update profile of user.
*
*/
	public function updateProfile_post(){
		
		$postData = $this->input->post();
		
		// validate user login access token.
		$accessToken  = $this->getAccessToken();
		$driverId = $this->checkLogin($accessToken);

        // validate for empty parameters
        
        $this->form_validation->set_rules('user_id', "User Id", 'trim|required');
        $this->form_validation->set_rules('name', "Name", 'trim|required');
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|callback_check_email_exists');
        $this->form_validation->set_rules('country_code', $this->lang->line('country_code'), 'required');
        $this->form_validation->set_rules('mobile', $this->lang->line('mobile'), 'required|regex_match[/^[0-9]\d{5,16}$/]|callback_check_mobile_exists');
        

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['user_id','email','mobile','name','country_code']);
        }
        // process singup for the next step, for inserting into db.
        $this->db->trans_begin();

        $driverId = $this->updateUserValues($postData);

        if($this->db->trans_status()==TRUE){
            $this->db->trans_commit();
           	
            	//preparing for response

            $userData   =$this->responseReturn($this->Common_model->fetch_data("users","*",['where'=>['user_id'=>$postData['user_id']]],true));
            
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['users'=>$userData]]);
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
      $isExists  = $this->Common_model->fetch_data('users','email',['where'=>['email'=>$postData['email'],'user_id !='=>$postData['user_id']],'where_in'=>['status'=>[ACTIVE,INACTIVE,BLOCKED]]],true);
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
      $isExists  = $this->Common_model->fetch_data('users','mobile',['where'=>['mobile'=>$postData['mobile'],'country_code'=>$this->input->post('country_code'),'user_id !='=>$postData['user_id']],'where_in'=>['status'=>[ACTIVE,INACTIVE,BLOCKED]]],true);
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
    private function updateUserValues($postData){
        try{

                $savedata = [
                'name' => $postData['name'],
                'country_code' => $postData['country_code'],
                'mobile' => $postData['mobile'],
                'email' => $postData['email'],
                'image' => isset($postData['user_imae'])?$postData['user_imae']:"",
                'updated_at' => DEFAULT_DB_DATE_TIME_FORMAT
            ];

        return $this->Common_model->update_single('users',$savedata,['where'=>['user_id'=>$postData['user_id']]]);

        }  catch (Exception $e){
            echo json_encode($e->getMessage());
            exit;
        }

    }

    //upload user image
    private function uploadUserImage($files){
    	//upload driving licenses
		if(isset($files['user_image']) && $files['user_image']!=""){

			return $this->Common_model->uploadfile('user_image',$files,'url','api/user');
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


        $responseArr['user_id'] = (int)$registerData['user_id'];
        $responseArr['name'] = $registerData['name'];
        
        
        $responseArr['email'] = $registerData['email'];
        $responseArr['mobile'] = $registerData['mobile'];
        $responseArr['country_code'] =$registerData['country_code'];
        $responseArr['image'] =$registerData['image'];
        
        $responseArr['status'] = $registerData['status'];
        $responseArr['latitude'] = isset($registerData['lat']) ? $registerData['lat'] : '';
        $responseArr['longitude'] = isset($registerData['lng']) ? $registerData['lng'] : '';
        return $responseArr;
    }



    public function changePassword_post(){
			$postData = $this->input->post();


		// validate user login access token.
			$accessToken  = $this->getAccessToken();

			$userId = $this->checkLogin($accessToken); 

			$this->form_validation->set_rules('old_password', 'old password', 'required|min_length[8]|max_length[15]|callback_check_old_password');
			$this->form_validation->set_rules('new_password','new password', 'required|min_length[8]|max_length[15]');

			if ($this->form_validation->run() == FALSE) {

				$this->setErrorJson(['old_password','new_password']);
			}
		//calling method to get comments list
			$this->db->trans_begin();
			$this->_updatePassword($postData,$userId);

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
		$isExists  = $this->Common_model->fetch_data('users','user_id',['where'=>['password'=>hash('sha256', $key)]],true);
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
	private function _updatePassword($postData,$userId){
		try{
			
			return $this->Common_model->update_single('users',['password'=>hash('sha256', $postData['new_password'])],['where'=>['user_id'=>$userId]]);

		}catch(Exception $e){
			$this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
		}
	}
}   

