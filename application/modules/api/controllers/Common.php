
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Common extends REST_Controller {


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

        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->lang->load('rest_controller', "english");
        $this->load->library('form_validation');
        $this->form_validation->CI = &$this;


        /* 
         * $uAccessToken = isset($this->input->request_headers()['uaccesstoken']) ? $this->input->request_headers()['uaccesstoken'] : $this->input->request_headers()['Uaccesstoken'];
         * $file = fopen(__DIR__."/debug.txt","a+");
          fwrite($file , PHP_EOL."===================INSERT FOR DOCTOR ==== ". $this->uri->segment(3)." === header ".$this->input->request_headers()['Uaccesstoken']." ===============".PHP_EOL.json_encode($this->input->post()).PHP_EOL."===TIME===".date("Y-m-d H:i:s").PHP_EOL);
          fclose($file); */
    }

    public function sourceList_get(){

        
        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'), 'data' => ['user' => sourceTypeList()]]);
    }
    
}
