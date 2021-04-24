<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

    private $loginId  = '';
    protected $params = array();
    protected $data   = array();
   
    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Category_Model', 'Category');
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
        
        $this->data['category'] = $this->Category->getFoodCategoryList($this->params, $limit, $offset = ($page - 1) * $limit);
        

        $pageurl = 'admin/category';
       
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['category']['count'], $pageurl, $limit, $page);
        
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('category/foodcategory', $this->data);
    }

     

    public function addCategory()

    {
        if ($this->input->post()){
         
             $this->form_validation->set_rules('category_name', $this->lang->line('category_name'), 'trim|required|min_length[4]|max_length[10]|alpha|xss_clean');

             if ($this->form_validation->run() == FALSE) {

                $this->loadAdminProfile('category/addfoodcategory',$this->data); 

             } else {

                         $this->data['category_type'] = $this->input->post('category_type');
                         $this->data['category_name'] = $this->input->post('category_name');

                         $this->processAddCategory($this->data);
                         $this->data['message']="Category successfully added";
                         $this->loadAdminProfile('category/addfoodcategory',$this->data);                     
                    }
        
           } else {
                    $this->loadAdminProfile('category/addfoodcategory',$this->data); 
                 }
        
    }
   
   
   private function processAddCategory($data){
  
     if (!empty($data)) {
          $this->Common_model->insert_single('mart_food_category',$data);
     }
     else{
             show_404(); 
     }
   }



 public function martCategoryList() {
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
        
        $this->data['category'] = $this->Category->getMartCategoryList($this->params, $limit, $offset = ($page - 1) * $limit);


        $pageurl = 'admin/category';
       
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['category']['count'], $pageurl, $limit, $page);
        
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('category/martcategory', $this->data);
    }

     

    public function addMartCategory()

    {
        if ($this->input->post()){
         
             $this->form_validation->set_rules('category_name', $this->lang->line('category_name'), 'trim|required|min_length[4]|max_length[10]|alpha|xss_clean');

             if ($this->form_validation->run() == FALSE) {

                $this->loadAdminProfile('category/addMartcategory',$this->data); 

             } else {

                         $this->data['category_type'] = $this->input->post('category_type');
                         $this->data['category_name'] = $this->input->post('category_name');

                         $this->processAddMartCategory($this->data);
                         $this->data['message']="Category successfully added";
                         $this->loadAdminProfile('category/addMartcategory',$this->data);                     
                    }
        
           } else {
                    $this->loadAdminProfile('category/addmartcategory',$this->data); 
                 }
        
    }
   
   
   private function processAddMartCategory($data){
  
     if (!empty($data)) {
          $this->Common_model->insert_single('mart_food_category',$data);
     }
     else{
             show_404(); 
     }
   }


    public function updateCategory()
   {
    try{

        $req = $this->input->post();
    
        $categoryId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
        if ($req) {
                     $updateId =  $this->Common_model->update_single('mart_food_category',['category_name'=>$req['name']],['where'=>['category_id'=> $categoryId]]);
                        
           } else {
                    show_404();
                 }
        }catch (Exception $e){
         echo $ex->getMessage();

    }
    }
 
}
?>