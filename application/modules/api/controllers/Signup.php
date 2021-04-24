<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Signup extends REST_Controller {

    public $header_user = '';
    public $header_password = '';

    /**
     
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
        $this->form_validation->CI= &$this;


        /* $file = fopen(__DIR__."/debug.txt","a+");
          fwrite($file , PHP_EOL."===================INSERT FOR DOCTOR ==== ". $this->uri->segment(3)." === header ".$this->input->request_headers()['Uaccesstoken']." ===============".PHP_EOL.json_encode($this->input->post()).PHP_EOL."===TIME===".date("Y-m-d H:i:s").PHP_EOL);
          fclose($file); */
    }

    public function index_post() {
        
        $postData = $this->input->post();
        // validate for empty parameters
        
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|callback_check_email_exists');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|min_length[8]|max_length[15]');
        $this->form_validation->set_rules('country_code', $this->lang->line('country_code'), 'required');
        $this->form_validation->set_rules('mobile', $this->lang->line('mobile'), 'required|regex_match[/^[0-9]\d{5,16}$/]|callback_check_mobile_exists');
        //$this->form_validation->set_rules('bio', 'Bio', 'trim|required');
        //$this->form_validation->set_rules('gender', $this->lang->line('gender'), 'required|numeric');
        $this->form_validation->set_rules('user_type', $this->lang->line('user_type'), 'required|numeric');
        $this->form_validation->set_rules('device_type', "Device type", 'required|numeric');
        $this->form_validation->set_rules('mart_name', "Mart name", 'trim|callback_check_mart_name_or_address_required');
        $this->form_validation->set_rules('device_type', "Device type", 'required|numeric');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['email','mobile','password','name','country_code',"user_type","device_type","bio","address","mart_name"]);
        }
        // process singup for the next step, for inserting into db.
        $this->db->trans_begin();
        $userId = $this->insertUserValues($postData,'');

        //inserting user session value.
        $this->insertSessionValues($userId,$postData);

        if($this->db->trans_status()==TRUE){
            $this->db->trans_commit();
            $params['user_id']  =   $userId;
            $this->load->model('User_Model','Users');
            $registerData  = $this->Users->getUserData($params,true);

            //sending welcome mail and otp for verfication.
            $this->sendRegistrationOtp($registerData);

            // preparing array for response

            $responseArr = $this->responseReturn($registerData);
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => $responseArr]]);
        }else{
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }

    }
    /**
    *@name check_mart_name_required
    *@descroiption this is used to check mart name is required.
    **/

    public function check_mart_name_or_address_required(){
        $postedData  =$this->input->post();
        
        if($postedData['user_type']==MERCHANT  && empty($postedData['mart_name'])){
            
            $this->form_validation->set_message('check_mart_name_or_address_required', "The mart name field is required.");
            return false;
        }
        if($postedData['user_type']==MERCHANT && empty($postedData['address'])){
            
            $this->form_validation->set_message('check_mart_name_or_address_required', "The address field is required.");
            return false;
        }
        return true;
    }


    /**
     *
     * @name insertUserValues
     * @param type $postData
     *
     */
    private function insertUserValues($postData,$imageUrl){
        try{

                $savedata = [
                'name' => $postData['name'],
                'password' => hash('sha256', $postData['password']),
                'country_code' => $postData['country_code'],
                'mobile' => $postData['mobile'],
                'email' => $postData['email'],
                'user_type' => $postData['user_type'],
                'bio' => isset($postData['bio']) ? $postData['bio'] : '',
                'lat' => isset($postData['latitude']) ? $postData['latitude'] : '',
                'lng' => isset($postData['longitude']) ? $postData['longitude'] : '',
                'is_verified' => ACTIVE,
                'status' => ACTIVE,
                'created_at' => DEFAULT_DB_DATE_TIME_FORMAT,
                'updated_at' => DEFAULT_DB_DATE_TIME_FORMAT
            ];
            //if user is merchant
                if($postData['user_type']==MERCHANT){
                    $savedata['mart_name'] =$postData['mart_name'];
                    $savedata['address'] =$postData['address'];    
                }

            return $this->Common_model->insert_single('users',$savedata);

        }  catch (Exception $e){
            echo json_encode($e->getMessage());
            exit;
        }

    }
    /**
     *
     * @name insertSessionValues
     * @param type $userId
     * @param type $postData
     * @return type
     *
     */
    private function insertSessionValues($userId,$postData){
        try{
                $savedata = [
                'user_id' => $userId,
                'access_token' => $this->getUniqueAlphaNumericCode(22),
                'device_token' => isset($postData['device_token']) ? $postData['device_token'] : '',
                'device_type' => isset($postData['device_type']) ? $postData['device_type'] : '',
                'device_id' => isset($postData['device_id']) ? $postData['device_id'] : '',
                'created_at' => DEFAULT_DB_DATE_TIME_FORMAT,
            ];
            $this->Common_model->insert_single('users_login_session',$savedata);

        }  catch (Exception $e){
            echo json_encode($e->getMessage());
            exit;
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
    public function check_email_exists($key){

      $isExists  = $this->Common_model->fetch_data('users','email',['where'=>['email'=>$key],'where_in'=>['status'=>[ACTIVE,INACTIVE]]],true);
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
    public function check_mobile_exists($key){

      $isExists  = $this->Common_model->fetch_data('users','mobile',['where'=>['mobile'=>$key,'country_code'=>$this->input->post('country_code')],'where_in'=>['status'=>[ACTIVE,INACTIVE]]],true);
      if ($isExists){
        $this->form_validation->set_message('check_mobile_exists', $this->lang->line('mobile_exists'));
        return false;
      }
      else{
          return true;
      }
    }



    /**
     * @name sendRegistrationOtp
     * @param type $email
     * @param type $phone
     * @param type $country_code
     * @param type $name
     * @param type $insertId
     */
    private function sendRegistrationOtp($params) {

        $otp = $this->Common_model->generateOtp(OTP_LENGTH);
        //$otp = 123456;
        //$message = str_replace('OTP_CODE', $otp, $this->lang->line('SIGNUP_OTP'));
        $param['name'] = $params['name'];
        $param['email'] = $params['email'];
        $param['OTP'] = $otp;
        $param['BASE_URL'] = base_url();

        //for mobile sms
        //$this->Common_model->sendsmsbytwillio($params['country_code'] . $params['mobile'], $message);
        //for otp mail
        $this->post_otp_curl($param);

        $this->Common_model->update_single('users', ['otp' => $otp, 'otp_time' => time()], ['where' => ['user_id' => $params['user_id']]]);

        //for registration mail
        //$this->post_signup_curl($param);
    }

    /**
     * @name post_curl
     * @param type $params
     * @return type
     */
    private function post_signup_curl($params) {

        $url = base_url()."api/mail/sendregisterMail";
         $post_fields=array('email'=>$params['email'],'name'=>$params['name'],'BASE_URL'=>$params['BASE_URL']);
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_POST, count($post_fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

          curl_exec($ch);
          curl_close($ch);
          return;


    }

    /**
     * @name post_otp_curl
     * @param type $params
     * @return type
     */
    private function post_otp_curl($params) {

          /*$url = base_url()."api/mail/sendOtpMail";
          $post_fields=array('email'=>$params['email'],'name'=>$params['name'],'BASE_URL'=>$params['BASE_URL'],'OTP'=>$params['OTP']);
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_POST, count($post_fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

          curl_exec($ch);
          curl_close($ch);
          return;*/
        //exec("$url/sendOtpMail?email=$params[email]&$params[name]&$params[BASE_URL]&$params[name]&$params[OTP]");
        $mailData['name']  = $params['name'];
        
        $mailData['otp']  = $params['OTP'];
        $this->Common_model->sendmailnew($_POST['email'], 'One Time Password', '', true, $mailData, 'otp');  


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
        
        //if user is merchant
        if($registerData['user_type']==MERCHANT){
            $responseArr['mart_name'] =$registerData['mart_name'];
            $responseArr['address'] =$registerData['address'];    
        }
        $responseArr['image'] =$registerData['image'];
        $responseArr['user_type'] =$registerData['user_type'];
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
            }else{
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
     * @name validator
     * @description validates input array that value is set. Optionally checks
     *              for empty case.
     * @param array $param
     * @param array $data
     * @param boolean $checkEmpty
     * @return boolean
     */
    public function validator($param, $data, $checkEmpty = false) {

        if ($checkEmpty) {
            for ($i = 0; $i < count($param); $i++) {
                if (empty($data[$param[$i]])) {
                    $responseArr = array(
                        'status_code' => KEY_NOT_FOUND,
                        'status_message' => $this->Common_model->removeCharacter($param[$i]) . ' key can not be empty.',
                        'data' => new stdClass()
                    );
                    $this->response($responseArr);
                }
            }
        } else {
            for ($i = 0; $i < count($param); $i++) {
                if (!isset($data[$param[$i]])) {
                    $responseArr = array(
                        'status_code' => KEY_NOT_FOUND,
                        'status_message' => $this->Common_model->removeCharacter($param[$i]) . ' key can not be empty.',
                        'data' => new stdClass()
                    );
                    $this->response($responseArr);
                }
            }
        }
        return true;
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
    public function setErrorJson($errorArray=[]){

        if(!empty($errorArray)){

            for($i=0;$i<count($errorArray);$i++){

                if(!empty(form_error($errorArray[$i])) && form_error($errorArray[$i])!=''){

                    $this->response(['status_code' => FAILED, 'status_message' => strip_tags(form_error($errorArray[$i]))]);
                }
            }
        }
    }

    /**
     *
     * @param type $files
     * @param type $fieldName
     * @param type $fileSize
     * @param type $validImage
     * @return type
     */
    public function validateImage($files, $fieldName,$fileSize=2097152, $validImage=["image/jpg", "image/jpeg", "image/png"])
    {

        $image = getimagesize($files[$fieldName]["tmp_name"]);

        if ( ! $image ) {
            $this->response(['status_code' => INVALID_IMAGE, 'status_message' =>"Please enter a valid image"]);
        }

        if (!in_array($image["mime"], $validImage) ) {
            $this->response(['status_code' => INVALID_IMAGE, 'status_message' =>"Please enter supported image type."]);
        }

        if ( $files[$fieldName]["size"] > $fileSize) {
            $this->response(['status_code' => INVALID_IMAGE, 'status_message' =>"Please enter valid file size."]);
        }

    }


}
