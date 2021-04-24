<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
    public function index() {
        $data = [];
        $data['admin'] = $this->getProfileData();

        $this->loadAdminProfile('dashboard/index', $data);
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
