<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends  MY_Controller
{
	protected $data = array();
	protected $params = array();

	function __construct()
	{
	    parent::__construct();


	    $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Banner_Model', 'Banner');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
	}

    function index ()
    {
    	$get = $this->input->get();
    	$this->data['search'] = $this->params['search'] = isset($get['search']) ? trim($get['search']) : '';
    	$this->data['from']   =   $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to']     =     $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';

        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';
        $isExport = (isset($get['export']) && !empty($get['export'])) ? $get['export'] : "";
        
        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;

        //fetching category list Data.
        
        $this->data['banner'] = $this->Banner->getBannerList($this->params, $limit, $offset = ($page - 1) * $limit);
        

        $pageurl = 'admin/banner';
       
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['banner']['count'], $pageurl, $limit, $page);
        
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('banner/bannerlist', $this->data);
    }
    
    public function detail() {
        
        $get = $this->input->get();
        $bannerId = (isset($get['banner_id']) && !empty($get['banner_id'])) ? $this->Common_model->decrypt($get['banner_id']) : show_404();
        
        if (is_numeric($bannerId) && $this->data['detail'] = $this->getBannerDetail($bannerId)) {
            
            $this->loadAdminProfile('banner/bannerdetail', $this->data);
        } else {

            show_404();
        }
    }

    public function getBannerDetail($bannerId)
    {
       return $this->Banner->fetchBannerDetail($bannerId, true);
    }

   
     
    public function addBanner()
    {
       // pr($this->input->post());
         if($this->input->post()){
            
             $this->form_validation->set_rules('name',         $this->lang->line('name'),          'trim|required|min_length[4]|max_length[20]|xss_clean');
             $this->form_validation->set_rules('image',        $this->lang->line('image'),         'trim|required|xss_clean');

           if ($this->form_validation->run() == FALSE) {

                 $this->loadAdminProfile('banner/addbanner',$this->data); 

             } else {
                      $this->data['name']   =         $this->input->post('name');
                      $this->data['image']  =         $this->input->post('image');
                      $this->data['image_path']  =    $this->input->post('image_path');


                      $this->processAddBanner($this->data);
                       $this->data['message']="Data successfully added";
                      //$this->loadAdminProfile('banner/addbanner', $this->data);
                      redirect(base_url().$this->uri->segment(1).'/Banner');
                    }
        } else {

            $this->loadAdminProfile('banner/addbanner',$this->data); 

            }      
    }
   
    private function processAddBanner($data){
       //pr($form);die();
       //Transfering data to Model
        //pr($data);
        if ($data) {
          $this->Common_model->insert_single('banner',$data);
        }
        else{
            show_404(); 
        }
    }


}





?>