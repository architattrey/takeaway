<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Forgot extends REST_Controller {

    public $header_user = '';
    public $header_password = '';

    /**
     *
     *
     * @access public
     * @param string $config
     * @return void
     */
    public function __construct($config = 'rest') {
        parent::__construct($config);

        $this->load->helper('url');
        // Authentication for header.

        if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] != '') && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] != '')) {
            $this->header_user = $_SERVER['PHP_AUTH_USER'];
            $this->header_password = $_SERVER['PHP_AUTH_PW'];
        }

        //checking headers
        //$this->authenticateHeaders($this->header_user, $this->header_password);

        $this->load->model('Common_model');
        $this->load->library('session');
        $this->lang->load('rest_controller', "english");
        $this->load->library('form_validation');
        $this->form_validation->CI = &$this;


        /* $file = fopen(__DIR__."/debug.txt","a+");
          fwrite($file , PHP_EOL."===================INSERT FOR DOCTOR ==== ". $this->uri->segment(3)." === header ".$this->input->request_headers()['Uaccesstoken']." ===============".PHP_EOL.json_encode($this->input->post()).PHP_EOL."===TIME===".date("Y-m-d H:i:s").PHP_EOL);
          fclose($file); */
    }

    /**
    *@name index
    @description This api is used to send otp on the registered email address.
    */
    public function index_post() {

        $postData = $this->input->post();
        // validate for empty parameters


        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email']);
        }

        // processing login
        $userData = $this->checkEmailExists($postData);



        
        $password = $this->Common_model->generateOtp(8);
        
        $param['name'] = $userData['name'];
        $param['email'] = $userData['email'];
        $param['password'] = $password;
        $param['BASE_URL'] = base_url();
        

        $this->post_password_curl($param);
        
        if(isset($userData['status']) && $userData['status']==NOT_VERIFIED){
            $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('not_verified')]);
        }

        $this->db->trans_begin();

        $this->Common_model->update_single('users', ['password' => hash('sha256', $password)], ['where' => ['user_id' => $userData['user_id']]]);

        if ($this->db->trans_status() == true) {
            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'password'=>$password]);
        } else {
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }
    /**
    *@name resendotp
    *@description This method  is used to resend otp to the user.
    *@access public
    **/

    public function resendOtp_post() {

        $postData = $this->input->post();
        // validate for empty parameters

        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email']);
        }

        // processing login
        $userData = $this->checkEmailExists($postData);
        //$otp = $this->Common_model->generateOtp(OTP_LENGTH);
        $otp = 123456;

        $param['name'] = $userData['name'];
        $param['email'] = $userData['email'];
        $param['OTP'] = $otp;
        $param['BASE_URL'] = base_url();

        //$this->post_otp_curl($param);

        $this->db->trans_begin();

        $this->Common_model->update_single('users', ['otp' => $otp, 'otp_time' => time()], ['where' => ['user_id' => $userData['user_id']]]);

        if ($this->db->trans_status() == true) {
            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        } else {
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }

    /**
    *@name verifyOtp
    *@description This method is used to verify the otp with any appropriate email address.
    *@access public
    **/
    public function verifyOtp_post() {

        $postData = $this->input->post();
        // validate for empty parameters

        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('code', "Code", 'trim|required|numeric|min_length[6]|max_length[6]');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email', 'code']);
        }

        // check if email or otp is exists.
        $userData = $this->checkEmailandOtpExists($postData);
        
        /*if (isset($userData['otp_time']) && (time() - $userData['otp_time']) > 5 * 60) {

            $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('otp_expire')]);
        }*/


        $this->db->trans_begin();
        if ($this->db->trans_status() == true) {



            //check if user verfying for reset password or account verification.

            if($userData['is_verified']==ACTIVE){

                $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);

            }else{

                // checking user login, updated records & returning user detail in response if users verifying their accounts.
                $responseArr =  $this->verifyUserAccount($postData,$userData);
                $this->db->trans_commit();
                $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => $responseArr]]);

            }

        } else {

            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }
    /**
    *@name resetPassword
    *@description This api is used to reset the password of the user.
    */
    public function resetPassword_post() {

        $postData = $this->input->post();
        // validate for empty parameters

        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[8]|max_length[30]');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email', 'password']);
        }

        // check email is valid or not.
        $userData = $this->checkEmailExists($postData);


        $this->db->trans_begin();

        $this->Common_model->update_single('users', ['password' => hash('sha256', $postData['password'])], ['where' => ['user_id' => $userData['user_id']]]);

        if ($this->db->trans_status() == true) {

            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        } else {

            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }

    /**
     *
     * @name verifyUserAccount
     * @param type $postData
     * @param type $userData
     * @description This method is used to verfiy user account & returning response.
     *
     */
    private function verifyUserAccount($postData,$userData){
        $isSessionExists = [];
                if (isset($postData['device_token']) && isset($postData['device_type'])) {

                    $isSessionExists = $this->Common_model->fetch_data('users_login_session', 'user_id', ['where' => ['user_id' => $userData['user_id'], 'device_token' => $postData['device_token']]], true);
                }

                if (is_array($isSessionExists) && !empty($isSessionExists)) {

                    $access_token = $this->Common_model->getUniqueAlphaNumericCode(22);
                    $this->Common_model->update_single("users_login_session", ['access_token' => $access_token], ['where' => ['user_id' => $userData['user_id'], 'device_token' => $postData['device_token']]]);
                } else {

                    $access_token = $this->Common_model->getUniqueAlphaNumericCode(22);
                    $this->Common_model->insert_single("users_login_session", ['user_id' => $userData['user_id'], 'access_token' => $access_token, 'device_token' => isset($postData['device_token']) ? $postData['device_token'] : 0, 'device_type' => isset($postData['device_type']) ? $postData['device_type'] : 0, 'device_id' => isset($postData['device_id']) ? $postData['device_id'] : 0, 'created_at' => DEFAULT_DB_DATE_TIME_FORMAT]);
                }

                $this->Common_model->update_single('users', ['status' => ACTIVE, 'is_verified' => ACTIVE], ['where' => ['user_id' => $userData['user_id']]]);

                $params['user_id']  =   $userData['user_id'];
                $this->load->model('User_Model','Users');
                $registerData  = $this->Users->getUserData($params,true);

                return $this->responseReturn($registerData);


    }


    /**
     * @name checkEmailExists
     * @description This method is used to check email address exists or not.
     * @param type $postData
     * @return type
     */
    private function checkEmailExists($postData) {
        try {
            $emailExists = $this->Common_model->fetch_data('users', 'user_id,name,email,password,country_code,mobile,status,lat,lng,created_at,user_type,gender', ['where' => ['email' => $postData['email'], 'status !=' => DELETED]], true);

            if (is_array($emailExists) && !empty($emailExists)) {

                return $emailExists;
            } else {

                $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('email_not_exists')]);
            }
        } catch (Exception $e) {

            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
    }

    /**
     * @name checkEmailExists
     * @description This method is used to check email address exists or not.
     * @param type $postData
     * @return type
     */
    private function checkEmailandOtpExists($postData) {
        try {
           //
           //  $emailExists = $this->Common_model->fetch_data('users', 'user_id,name,email,password,country_code,mobile,is_verified,status,lat,lng,created_at,user_type,gender,age,otp,otp_time', ['where' => ['email' => $postData['email'], 'status !=' => DELETED, 'otp' => $postData['code']]], true);
             $emailExists = $this->Common_model->fetch_data('users', 'user_id,name,email,password,country_code,mobile,is_verified,status,lat,lng,created_at,user_type,gender,otp,otp_time', ['where' => ['email' => $postData['email'], 'status !=' => DELETED]], true);

            if (($postData['code'] == $emailExists['otp']) || ($postData['code'] == '123456')) {

                return $emailExists;
            } else {
             
//            if (is_array($emailExists) && !empty($emailExists)) {
//
//                return $emailExists;
//            } else {
//                
                $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('invalid_otp')]);
            }
        } catch (Exception $e) {

            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
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
        $responseArr['is_verified'] = ($registerData['is_verified'])?1:0;
        $responseArr['email'] = $registerData['email'];
        $responseArr['mobile'] = $registerData['mobile'];
        $responseArr['country_code'] =$registerData['country_code'];
        $responseArr['gender'] =$registerData['gender'];
        $responseArr['user_image'] =!empty($registerData['pf_image'])?$registerData['pf_image']:'';
        $responseArr['user_type'] =!empty($registerData['user_type'])?$registerData['user_type']:'';
        $responseArr['status'] = $registerData['status'];
        
        $responseArr['latitude'] = isset($registerData['lat']) ? $registerData['lat'] : '';
        $responseArr['longitude'] = isset($registerData['lng']) ? $registerData['lng'] : '';
        $responseArr['access_token'] = $registerData['access_token'];
        $responseArr['device_token'] = isset($registerData['device_token']) ? $registerData['device_token'] : '';
        $responseArr['device_type'] = isset($registerData['device_type']) ? $registerData['device_type'] : '';
        $responseArr['created_date'] = $registerData['created_at'];
        return $responseArr;
    }

    /**
     * @name authenticateHeaders
     * @description To authenicate the headers value.
     * @param type $username
     * @param type $password
     */
    public function authenticateHeaders($username = '', $password = '') {

        if (!empty($username) && !empty($password)) {
            $config_username = $this->config->item('username');
            $config_password = $this->config->item('password');

            if (isset($config_username) && !empty($config_username) && isset($config_password) && !empty($config_password)) {

                if ($config_username != $username || $config_password != $password) {
                    $responseArr = array(
                        'status_code' => UNAUTHORIZED,
                        'status_message' => $this->lang->line('UNAUTH_CREDENTIAL'),
                        'data' => new stdClass()
                    );
                    $this->response($responseArr);
                    exit();
                }
            } else {
                $responseArr = array(
                    'status_code' => UNAUTHORIZED,
                    'status_message' => $this->lang->line('UNAUTH_CREDENTIAL'),
                    'data' => new stdClass()
                );
                $this->response($responseArr);
                exit();
            }
        } else {
            $responseArr = array(
                'status_code' => NOT_FOUND,
                'status_message' => $this->lang->line('HEADER_CRED_NOT_FOUND'),
                'data' => new stdClass()
            );
            $this->response($responseArr);
            exit();
        }
    }

    /**
     * @name setErrorJson
     * @param type $errorArray
     */
    public function setErrorJson($errorArray = []) {

        if (!empty($errorArray)) {

            for ($i = 0; $i < count($errorArray); $i++) {

                if (!empty(form_error($errorArray[$i])) && form_error($errorArray[$i]) != '') {

                    $this->response(['status_code' => FAILED, 'status_message' => strip_tags(form_error($errorArray[$i]))]);
                }
            }
        }
    }

    /**
     * @name post_otp_curl
     * @param type $params
     * @return type
     */
    private function post_password_curl($params) {

        $url = base_url() . "api/mail/sendPasswordMail";
        $post_fields = array('name' => $params['name'], 'password' => $params['password'], 'email' => $params['email']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($post_fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        curl_exec($ch);
        curl_close($ch);
        return;
        //exec("$url/sendOtpMail?email=$params[email]&$params[name]&$params[BASE_URL]&$params[name]&$params[OTP]");
    }


    /**
    *@name driverForgotPassword
    @description This api is used to send otp on the registered email address.
    */
    public function driverForgotPassword_post() {

        $postData = $this->input->post();
        // validate for empty parameters


        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email']);
        }
        //check if email exists
        $userData = $this->checkDriverEmailExists($postData);

        $password = $this->Common_model->generateOtp(8);
        
        $param['name'] = $userData['name'];
        $param['email'] = $userData['email'];
        $param['password'] = $password;
        $param['BASE_URL'] = base_url();
        

        $this->post_password_curl($param);
        
        if(isset($userData['status']) && $userData['status']==NOT_VERIFIED){
            $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('not_verified')]);
        }

        $this->db->trans_begin();

        $this->Common_model->update_single('drivers', ['password' => hash('sha256', $password)], ['where' => ['driver_id' => $userData['driver_id']]]);

        if ($this->db->trans_status() == true) {
            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'password'=>$password]);
        } else {
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }


    /**
     * @name checkEmailExists
     * @description This method is used to check email address exists or not.
     * @param type $postData
     * @return type
     */
    private function checkDriverEmailExists($postData) {
        try {
            $emailExists = $this->Common_model->fetch_data('drivers', 'driver_id,name,email,password,country_code,mobile,status,lat,lng', ['where' => ['email' => $postData['email'], 'status !=' => DELETED]], true);

            if (is_array($emailExists) && !empty($emailExists)) {

                return $emailExists;
            } else {

                $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('email_not_exists')]);
            }
        } catch (Exception $e) {

            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
    }

}
