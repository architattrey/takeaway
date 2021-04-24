<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
     protected $postData = [];

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
       
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
    
    }

    /**
     * @name index
     * @description This method is used to login the admin.
     *
     */
    public function changePassword() {

        $data = [];
        $data['admin'] = $this->getProfileData();
    
         if($this->input->post()){
            $this->form_validation->set_rules('oldPassword', $this->lang->Line('old_password'),'trim|required|xss_clean');
            $this->form_validation->set_rules('confirmPassword', $this->lang->line('new_password'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('newPassword', $this->lang->line('confirm_password'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {

                 $this->loadAdminProfile('profile/change-password', $data);

            } else {

                $this->postData  = $this->input->post();
               
                //checking for the old password.

                $this->checkOldPassword($this->postData);
                

                //matching new & confirm password

                if($this->postData['confirmPassword']!= $this->postData['newPassword']){
                    $data['error']  = $this->lang->line('error_prefix')."Confirm password do not match.".$this->lang->line('error_suffix');
                    $this->loadAdminProfile('profile/change-password', $data);
                }else{
                    // method to check reset password of admin.
                    $this->doReset($this->postData,$data);
                }           
             }
        }else{

        $this->loadAdminProfile('profile/change-password', $data);
       }
    }

     private function doReset($postData,$data){
        
      // pr($data);die();


         try{
              $saveData['password']  = hash('sha256', $postData['confirmPassword']);
             $this->db->trans_start();
              $this->Common_model->update_single('admin',$saveData,['where'=>["admin_id"=>$this->_loginId]]);
              //$this->Common_model->update_single('admin',$saveData,['where'=>["token"=>$tokenArr['token']]]);
             if($this->db->trans_status()==true){
                  $this->db->trans_complete();
                  $this->session->set_flashdata('message',$this->lang->line('success_prefix')."your password has been successfully changed".$this->lang->line('success_suffix'));
                  //redirect(base_url() . "admin");
                   $this->loadAdminProfile('profile/change-password', $data);

              }else{
                  $this->db->trans_rollback();
                  $this->session->set_flashdata('message',$this->lang->line('success_prefix').$this->lang->line('reset_pass_success').$this->lang->line('success_suffix'));
                  $this->loadAdminProfile('profile/change-password', $data);
              }


          } catch (Exception $ex) {
              echo $ex->getTraceAsString();
          }

    }

    public function checkOldPassword($request)
    {
         try {
              $isExist =  $this->Common_model->fetch_data('admin', 'admin_id', ['where' => ['password' => hash('sha256',$request['oldPassword'])]], true); 
                if ($isExist) {
                    return true;
                }else
                {
                 $data['error'] = $this->lang->line('error_prefix')."old password is invalid.".$this->lang->line('error_suffix');
                 $this->loadAdminProfile('profile/change-password', $data);   
                }
             
          }catch (Exception $e) {
            echo json_encode($e->getTraceAsString());
        }
    }

    
    /**
     * @name getProfileData
     * @description This method is used to get profile data of admin.
     * @return type
     */
    private function getProfileData() {
        try {

            return $this->Common_model->fetch_data('admin', '*', ['where' => ['admin_id' => $this->_loginId]], true);
        } catch (Exception $e) {
            echo json_encode($e->getTraceAsString());
        }
    }
}
