<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicile extends MY_Controller {

    private $loginId  = '';
    protected $params = array();
    protected $data   = array();

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Vehicile_Model', 'Vehicile');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
    }

    /**
     * @name index
     * @description This method is used to login the admin.
     *
     */
    public function index() {
           $get = $this->input->get();
          // filter &search
        $this->data['search'] = $this->params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $this->data['status'] = $this->params['status'] = isset($get['status']) ? trim($get['status']) : '';
        $this->data['from']   =   $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to']     =     $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';

        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';
        $isExport = (isset($get['export']) && !empty($get['export'])) ? $get['export'] : "";
        
        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;

        //fetching category list Data.
        
        $this->data['vehicile'] = $this->Vehicile->getVehicileList($this->params, $limit, $offset = ($page - 1) * $limit);
        

        $pageurl = 'admin/vehicile';
       
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['vehicile']['count'], $pageurl, $limit, $page);
        
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('vehicile/vehicile_list', $this->data);
    }

     public function detail() {
        
        $get = $this->input->get();

        $vehicileId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();
        
        if (is_numeric($vehicileId) && $this->data['detail'] = $this->getVehicileDetail($vehicileId)) {
            //pr($this->data['detail']);
            $this->loadAdminProfile('vehicile/vehicile_detail', $this->data);
        } else {

            show_404();
        }
    }
    public function getVehicileDetail($vehicileId)
    {
       return $this->Vehicile->fetchVehicileDetail($vehicileId, true);
    }

}
?>