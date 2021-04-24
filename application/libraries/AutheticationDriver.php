<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class AutheticationDriver extends REST_Controller {

    protected $loginUser;
    protected $arabicLang;
    /**
     * Constructor for the AutheticationLib
     *
     * @access public
     * @param string $config (do not change)
     * @return void , EXIT_USER_INPUT on error
     */
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('Common_model');
        
//        set_error_handler([$this,'exceptions_error_handler']);
        /*$config_username = $this->config->item('username');
        $config_password = $this->config->item('password');
        if (!empty($config_username) && !empty($config_password)) {
            if ($config_username != $this->input->server('PHP_AUTH_USER') && $config_password != $this->input->server('PHP_AUTH_PW')) {
                $responseArr = array(
                    'status_code' => UNAUTHORIZED,
                    'status_message' => $this->lang->line('UNAUTH_CREDENTIAL')
                );
                $this->response($responseArr);
            }
        }*/
    }

     /**
     * @name exceptions_error_handler
     * @description Overwrites default PHP error functionality
     * @return array
     */
    public function exceptions_error_handler(){
        $this->response(["status_code" => INSERT_FAILURE,'status_message' => $this->lang->line('INSERT_FAILURE')]);
//        $this->response(["error from authenticationlib"]);
    }

    /**
     * @name checkLogin
     * @description checkes for login with accesstoken from header.
     * @param string $accessToken
     * @return int or error array
     */
    public function checkLogin($accessToken) {
      try{
        if (!empty($accessToken)) {

            // getting user details by the access token.
            
            $join  = [['table'=>'drivers b','condition'=>'a.user_id = b.driver_id','type'=>'INNER']];
            
            $this->loginUser = $this->Common_model->fetch_using_join('a.access_token,b.driver_id,b.status,b.lat,b.lng','drivers_login_session a',$join,['a.access_token'=>$accessToken],TRUE);
            
            if (!empty($this->loginUser)) {
                
                if ($this->loginUser->status != ACTIVE) {
                    
                    $this->response(['status_code' => FAILED,'status_message'=>"The login user is not active."]);
                }
                return $this->loginUser->driver_id;
            }
        }
        $this->response(['status_code' => FAILED,'status_message'=>"This login user is not authorized, Please send valid access token."]);
      }  catch (Exception $e){
          echo $e->getMessage(); exit;
      }
    }

    /**
     * @name getAccessToken
     * @description get token value from header.
     * @return string
     */
    public function getAccessToken(){
//        use this when using on server
        if (isset($this->input->request_headers()[USER_ACCESS_TOKEN_KEY]) || isset($this->input->request_headers()[USER_ACCESS_TOKEN_KEY])) {
            return isset($this->input->request_headers()[USER_ACCESS_TOKEN_KEY])?$this->input->request_headers()[USER_ACCESS_TOKEN_KEY]:$this->input->request_headers()[USER_ACCESS_TOKEN_KEY];
        } else{
            $this->response(['status_code' => NO_ACCESS_TOKEN,'status_message'=>$this->lang->line('ACCESS_TOKEN_MISSING')]);
        }
    }
    /**
     * @name checkRequiredParams
     * @param type $param
     * @return int
     */
    public function checkRequiredParams($param = array()) {
        if (isset($param) && is_array($param) && count($param)) {
            foreach ($param as $par) {
                if (empty($par)) {
                    return 0;
                }
            }
        }
        return 1;
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
    public function validator($param , $data , $checkEmpty = false){

        if ($checkEmpty) {
            for ($i = 0; $i < count($param); $i++) {
                if (empty($data[$param[$i]])) {
                    $responseArr = array(
                                    'status_code' => FAILED,
                                    'status_message' => $this->Common_model->removeCharacter($param[$i]).' key can not be empty.'
                                );
                    $this->response($responseArr);

                }
            }
        }else{
            for ($i = 0; $i < count($param); $i++) {
                if (!isset($data[$param[$i]])) {
                   $responseArr = array(
                                    'status_code' => FAILED,
                                    'status_message' => $this->Common_model->removeCharacter($param[$i]).' key can not be empty.'
                                );
                    $this->response($responseArr);
                }
            }
        }
        return true;
    }
    
    
     /**
     * @name setErrorJson
     * @description This method is used to set array messages of validations.
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
    /**
     * @name checkValidUserId
     * @param type $userId
     * @param type $userId2
     * @return boolean
     */
    public function checkValidUserId($userId,$userId2){
        
        if($userId === $userId2){
            return true;
        }else{
            $this->response(['status_code' => LOGIN_FAILED,'status_message'=>$this->lang->line('LOGIN_FAILED')]);
        }
    }
    
}
