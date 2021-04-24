<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller {

    public $header_user = '';
    public $header_password = '';
 
    /**
     * Constructor for the Doctor API
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

    public function index_post() {

        $postData = $this->input->post();

        // validate for empty parameters

        if ((isset($postData['social_id']) && $postData['social_id'] != '') && (isset($postData['social_type']) && $postData['social_type'] != '')) {

            // go to check user social login.

            $this->processSocialLogin($postData);
        } else {

            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|min_length[8]|max_length[15]');

            if ($this->form_validation->run() == FALSE) {

                $this->setErrorJson(['email', 'password']);
            }

            // processing login
            $userData = $this->checkEmailExists($postData);


            //check for valid password.
            $this->validatePassword($postData, $userData);

            // check account status

            $this->checkUserAccountStatus($userData);


            $isSessionExists = [];
            if (isset($postData['device_token']) && isset($postData['device_type'])) {

                $isSessionExists = $this->Common_model->fetch_data('users_login_session', 'user_id', ['where' => ['user_id' => $userData['user_id'], 'device_token' => $postData['device_token']]], true);
            }

            if (is_array($isSessionExists) && !empty($isSessionExists)) {

                $access_token = $this->getUniqueAlphaNumericCode(22);
                $this->Common_model->update_single("users_login_session", ['access_token' => $access_token], ['where' => ['user_id' => $userData['user_id'], 'device_token' => $postData['device_token']]]);
            } else {

                $access_token = $this->getUniqueAlphaNumericCode(22);
                $this->Common_model->insert_single("users_login_session", ['user_id' => $userData['user_id'], 'access_token' => $access_token, 'device_token' => isset($postData['device_token']) ? $postData['device_token'] : 0, 'device_type' => isset($postData['device_type']) ? $postData['device_type'] : 0, 'device_id' => isset($postData['device_id']) ? $postData['device_id'] : 0, 'created_at' => DEFAULT_DB_DATE_TIME_FORMAT]);
            }

            //  updating user type when logged in

            //$this->Common_model->update_single('users', ['user_type' => $postData['user_type']], ['where' => ['user_id' => $userData['user_id']]]);

            //creating response array
            $params['user_id'] = $userData['user_id'];
            $this->load->model('User_Model', 'Users');
            $registerData = $this->Users->getUserData($params, true);
            $responseArr = $this->responseReturn($registerData);
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => $responseArr]]);
        }
    }

    /**
     *
     * @name processSocialLogin
     * @param type $postData
     * @description This method is used to process social login for the user.
     *
     */
    private function processSocialLogin($postData) {


        
        $socialUserData = $this->Common_model->fetch_data('users', '*', ['where' => ['social_id' => $postData['social_id'],'social_type'=>$postData['social_type']]], TRUE);
            
         

        if (empty($socialUserData)) {
            if (!isset($postData['email'])) {

                $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('NO_SOCIAL_EMAIL')]);
            }
            $saveData['social_type'] = isset($postData['social_type']) ? $postData['social_type'] : '';
            $saveData['social_id'] = isset($postData['social_id']) ? $postData['social_id'] : '';
            $saveData['name'] = isset($postData['name']) ? $postData['name'] : '';
            $saveData['email'] = isset($postData['email']) ? $postData['email'] : '';
            $saveData['image'] = isset($postData['profile_image']) ? $postData['profile_image'] : "";
            $saveData['country_code'] = isset($postData['country_code']) ? $postData['country_code'] : "";
            $saveData['mobile'] = isset($postData['mobile']) ? $postData['mobile'] : "";
            $saveData['lat '] = isset($postData['latitude']) ? $postData['latitude'] : '';
            $saveData['lng '] = isset($postData['longitude']) ? $postData['longitude'] : '';
            $saveData['status'] = ACTIVE;
            $saveData['is_verified'] = ACTIVE;
            $saveData['created_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
            $saveData['updated_at'] = DEFAULT_DB_DATE_TIME_FORMAT;

            $this->db->trans_begin();
            $userData = [];

            // checking if account already registered with the same social email address then update only the social id's.

            if (isset($postData['email']) && $postData['email']) {
                $userData = $this->Common_model->fetch_data('users', 'user_id', ['where' => ['email' => $postData['email'], 'status !=' => DELETED]], TRUE);
            }

            if ($userData) {
                $updateId = $this->Common_model->update_single('users', $saveData, ['where' => ['user_id' => $userData['user_id']]]);
                $socialUserId = $userData['user_id'];
            } else {
                $socialUserId = $this->Common_model->insert_single('users', $saveData);
            }


            if ($socialUserId) {

                $userData['user_id'] = $socialUserId;
                $userData['access_token'] = $this->getUniqueAlphaNumericCode(32);
                $userData['device_token'] = isset($postData['device_token']) ? $postData['device_token'] : '';
                $userData['device_type'] = isset($postData['device_type']) ? $postData['device_type'] : '';
                $userData['created_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
                $this->Common_model->insert_single('users_login_session', $userData);
            }

            if ($this->db->trans_status() == true) {
                $this->db->trans_commit();
                $params['user_id'] = $socialUserId;
                $this->load->model('User_Model', 'Users');
                $registerData = $this->Users->getUserData($params, true);

                //creating response array
                $responseArr = $this->responseReturn($registerData, true);
                $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => $responseArr]]);
            } else {
                $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
            }
        } else {

            $saveData['name '] = isset($postData['name']) ? $postData['name'] : '';
            $saveData['lat '] = isset($postData['latitude']) ? $postData['latitude'] : '';
            $saveData['lng '] = isset($postData['longitude']) ? $postData['longitude'] : '';
            $saveData['updated_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
            
            $this->db->trans_begin();
            $updateId = $this->Common_model->update_single('users', $saveData, ['where' => ['user_id' => $socialUserData['user_id']]]);

            if ($updateId) {

                $userData['user_id'] = $socialUserData['user_id'];
                $userData['access_token'] = $this->getUniqueAlphaNumericCode(32);
                $userData['device_token'] = isset($postData['device_token']) ? $postData['device_token'] : '';
                $userData['device_type'] = isset($postData['device_type']) ? $postData['device_type'] : '';
                $userData['created_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
                $this->Common_model->insert_single('users_login_session', $userData);
            }

            if ($this->db->trans_status() == true) {
                $this->db->trans_commit();
                $params['user_id'] = $socialUserData['user_id'];
                $this->load->model('User_Model', 'Users');
                $registerData = $this->Users->getUserData($params, true);

                //creating response array
                $responseArr = $this->responseReturn($registerData, true);

                $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => $responseArr]]);
            } else {
                $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
            }
        }
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

            if ($emailExists) {

                return $emailExists;
            } else {

                $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('email_pass_invalid')]);
            }
        } catch (Exception $e) {

            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }
    }

    /**
     * @name validatePassword
     * @description to check and validate password.
     * @param type $postedRecord
     * @param type $dbrecord
     */
    private function validatePassword($postedRecord, $dbrecord) {

        if (isset($postedRecord['password']) && hash('sha256', $postedRecord['password']) == $dbrecord['password']) {

            return true;
        } else {

            $this->response(['status_code' => FAILED, 'status_message' => $this->lang->line('email_pass_invalid')]);
        }
    }
    /**
     *
     * @name checkUserAccountStatus
     * @description This method is used to check the status of the user account.
     * @param type $userData
     *
     */
    private function checkUserAccountStatus($userData) {
        if ((isset($userData['status']) && $userData['status'] == INACTIVE)) {

            $otp = $this->Common_model->generateOtp(6);
            //$otp = 123456;
            $param['name'] = $userData['name'];
            $param['email'] = $userData['email'];
            $param['OTP'] = $otp;
            $param['BASE_URL'] = base_url();
            //$this->post_otp_curl($param);
            
            $this->response(['status_code' =>NOT_VERIFIED, 'status_message' => $this->lang->line('not_verified')]);
        }

        if (isset($userData['status']) && $userData['status'] == INACTIVE || isset($userData['status']) && $userData['status'] == BLOCKED) {

            $this->response(['status_code' => USER_NOT_ACTIVE, 'status_message' => $this->lang->line('not_active')]);
        }
    }

    /**
     * @name post_otp_curl
     * @param type $params
     * @return type
     */
    private function post_otp_curl($params) {

        $url = base_url() . "api/mail/sendOtpMail";
        $post_fields = array('email' => $params['email'], 'name' => $params['name'], 'BASE_URL' => base_url(), 'OTP' => $params['OTP']);
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
     * @name getUniqueAlphaNumericCode
     * @param type $length
     * @return type
     */
    public function getUniqueAlphaNumericCode($length = "") {
        return md5(time());
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
     * @name responseReturn
     * @description This method is used to return response array for login and signup methods.
     * @param type $registerData
     * @param type $key
     * @return type
     */
    public function responseReturn($registerData) {


        $responseArr['user_id'] = (int) $registerData['user_id'];
        $responseArr['name'] = $registerData['name'];
        $responseArr['email'] = $registerData['email'];
        $responseArr['mobile'] = $registerData['mobile'];
        $responseArr['country_code'] = $registerData['country_code'];
        //$responseArr['gender'] = $registerData['gender'];
        $responseArr['image'] = !empty($registerData['image']) ? $registerData['image'] : '';
        $responseArr['status'] = $registerData['status'];
        $responseArr['latitude'] = isset($registerData['lat']) ? $registerData['lat'] : '';
        $responseArr['longitude'] = isset($registerData['lng']) ? $registerData['lng'] : '';
        
        $responseArr['access_token'] = $registerData['access_token'];
        $responseArr['device_token'] = isset($registerData['device_token']) ? $registerData['device_token'] : '';
        $responseArr['device_type'] = isset($registerData['device_type']) ? $registerData['device_type'] : '';

        $responseArr['created_date'] = $registerData['created_at'];
        $responseArr['wallet_credit_point'] = $registerData['wallet_credit_point'];
        return $responseArr;
    }

}
