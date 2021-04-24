
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class DriverLogout extends AutheticationLib {

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

   
    public function index_post() {
        $accessToken = $this->getAccessToken();
        $userId = $this->checkLogin($accessToken);

        $this->db->trans_begin();

        $this->Common_model->delete_data('drivers_login_session', ['where' => ['access_token' => $accessToken,'user_id'=>$userId]]);

        if ($this->db->trans_status() == true) {
            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        } else {
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }


}
