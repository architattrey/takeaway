<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
    }

    /**
     * @name index
     * @description This method is used to login the admin.
     * @access public
     */
    public function index() {
        $data = [];
        $this->alreadyLoggedIn();
        if ($this->input->post()) {
            
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {

                $this->loadAdmin('login/index', $data);

            } else {

                $postDataArr = $this->input->post();

                // method to check login of admin.
                $this->processLogin($postDataArr);

            }
        } else {


            $this->loadAdmin('login/login', $data);
        }
    }
    /**
     * @name processLogin
     * @param type $postDataArr
     * @description This method is used to do login process of admin.
     * @access private
     */
    private function processLogin($postDataArr) {
        
        $email = $postDataArr['email'];
        $password = $postDataArr['password'];
        $pass = hash('sha256', $password);
        
        try {
            $adminInfo = $this->Common_model->fetch_data('admin', '*', array('where' => array('email' => $email, 'password' => $pass,'status'=>ACTIVE)), true);
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        /*
         * If credentials are matched set the session
         */
        if (!empty($adminInfo)) {

            $admindata = array(
                "id" =>    $adminInfo['admin_id'],
                "name" =>  $adminInfo['name'],
                "email" => $adminInfo['email'],
                "isLoggedIn"=> TRUE
            );

            $this->session->set_userdata('admininfo', $admindata);
            redirect(base_url() .$this->uri->segment(1)."/user");
        } else {

            $this->session->set_flashdata('message',$this->lang->line('error_prefix').$this->lang->line('invalid_email_password').$this->lang->line('error_suffix'));
            redirect(base_url() . "admin");
        }
    }


    /**
     * @name forgetPassword
     * @description This method is used to forget password of admin.
     *
     */
    public function forgotPassword() {

        $data = [];
        $this->alreadyLoggedIn();
        if($this->input->post()){
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == FALSE) {

                $this->loadAdmin('login/forgot-password', $data);

            } else {

                $postDataArr = $this->input->post();

                // method to check login of admin.
                $this->processforgetPassword($postDataArr);

            }
        }else{
            $this->loadAdmin('login/forgot-password', $data);
        }

    }
    /**
     * @name processForgetPassword
     * @description
     * @param type $postDataArr
     */
    private function processForgetPassword($postDataArr){

        try {
            $adminInfo = $this->Common_model->fetch_data('admin', '*', array('where' => array('email' => $postDataArr['email'])), true);

                if(is_array($adminInfo) && !empty($adminInfo)){

                    $subject = "RESET PASSWORD";
                    $reset_token = hash('sha256', date("Y-m-d h:i:s"));
                    $timeexpire = time() + (24 * 60 * 60);
                    $url = 'token='.$reset_token;
                    $dataArr["link"] = base_url() . 'admin/reset-password?' .base64_encode($url);
                    $dataArr['name'] = $adminInfo['name'];
                    $insert['token'] = $reset_token;
                    $insert['token_time'] = $timeexpire;
                    
                    $update = $this->Common_model->update_single('admin',$insert, array("where" => array('email' => $adminInfo['email'])));
                    
                    //$templet = $dataArr["link"];
                    //$message = $dataArr["link"];
                    //$param['email'] = $adminInfo['email'];
                    $param['name'] = $adminInfo['name'];
                    $param['resetLink'] = $dataArr["link"];
                    $result1 = $this->Common_model->sendmailnew($adminInfo['email'], "TakeAway - Fogot password", '', true, $param, 'admin_forgot_password');
                    $this->session->set_flashdata('message',$this->lang->line('success_prefix').$this->lang->line('forgot_pass_success').$this->lang->line('success_suffix'));
                    redirect(base_url() . "admin/forgot-password");
                }else{

                    $this->session->set_flashdata('message',$this->lang->line('error_prefix')."Email address is invalid.".$this->lang->line('error_suffix'));
                    redirect(base_url() . "admin/forgot-password");
                }
         } catch (Exception $ex) {
            echo $ex->getMessage();
        }


    }
    /**
     * @name resetPassword
     * @desscription This method is used to reset the admin password.
     *
     */
    public function resetPassword() {

        $data = [];
        $postedData = [];
        $get  = $this->input->get();
        $decodedData  = !empty($get)?base64_decode(key($get), true):show_404();
        $data['key']  = key($get);
        !empty($decodedData)?parse_str($decodedData,$postedData):show_404();

        //process reset password
        $this->processResetPassword($postedData);

        if($this->input->post()){
            $this->form_validation->set_rules('confirmPassword', $this->lang->line('new_password'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('newPassword', $this->lang->line('confirm_password'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {

                $this->loadAdmin('login/reset-password', $data);

            } else {

                $postDataArr = $this->input->post();

                if($postDataArr['confirmPassword']!=$postDataArr['newPassword']){
                    $data['error']  = $this->lang->line('pass_do_not_match');
                    $this->loadAdmin('login/reset-password', $data);
                }else{
                    // method to check reset password of admin.
                    $this->doReset($postDataArr,$postedData,$data);
                }
            }

        }else{

            
            $this->loadAdmin('login/reset-password', $data);
        }
    }
    /**
     * @name processResetPassword
     * @description This method is used to process the reset password process.
     * @param type $postedData
     */
    private function processResetPassword($postedData){

        return $this->isValidToken(isset($postedData['token'])?$postedData['token']:'');

    }
    /**
     * @name isValidToken
     * @description To check the token is valid or not
     * @param type $token
     */
    private function isValidToken($token){
        try{

                $adminData  = $this->Common_model->fetch_data('admin','*',['where'=>['token'=>$token]],true);
                
                if(!empty($adminData)){
                    return $adminData;
                }else{
                    show_404();
                }

        }
        catch (Exception $e){
            echo $e->getTraceAsString();
        }
    }

    /**
     * @name doReset
     * @description this method is used to reset the password of admin.
     * @param type $postData
     */

    private function doReset($postData,$tokenArr,$data){

        try{
            $saveData['password']  = hash('sha256', $postData['confirmPassword']);
            $this->db->trans_start();
            $this->Common_model->update_single('admin',$saveData,['where'=>["token"=>$tokenArr['token']]]);
            if($this->db->trans_status()==true){
                $this->db->trans_complete();
                $this->session->set_flashdata('message',$this->lang->line('success_prefix').$this->lang->line('reset_pass_success').$this->lang->line('success_suffix'));
                redirect(base_url() . "admin");

            }else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message',$this->lang->line('success_prefix').$this->lang->line('reset_pass_success').$this->lang->line('success_suffix'));
                $this->loadAdmin('login/reset-password', $data);
            }


        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
        }

    }
     /**
     * @name logout
     * @description admin logout functionality
     * @param type $postData
     */


    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'admin/login');
    }

}
