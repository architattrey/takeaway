<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mart extends MY_Controller {

    private $loginId  = '';
    protected $params = array();
    protected $data   = array();
    protected $mart   = array();
    protected $product = array();


    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Mart_Model', 'Mart');
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
        $this->data['mart'] = $this->Mart->getMartList($this->params, $limit, $offset = ($page - 1) * $limit);
        $pageurl = 'admin/mart';
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['mart']['count'], $pageurl, $limit, $page);
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('mart/martlist', $this->data);
    }

     public function detail() {
        
        $get = $this->input->get();

        $martId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();
       // $categoryId = (isset($get['category_id']) && !empty($get['category_id'])) ? $this->Common_model->decrypt($get['category_id']) : show_404();

            if (is_numeric($martId)&&  $this->data['detail'] = $this->getMartDetail($martId)) {
                  
                  $this->loadAdminProfile('mart/martdetail', $this->data);
            }
            
         ///// error is founded page not found   url comes on this function but error occured 
          else {

             show_404();
         }
    }
    public function getMartDetail($martId)
    {
       return $this->Mart->fetchMartDetail($martId, true);
    }

    public function addMart(){
      
        $this->data['detail'] = $this->Mart->getMartCategories();
       // pr($this->input->post()); die();
        
         if($this->input->post()){
              $this->data['detail'] = $this->Mart->getMartCategories();

             $this->form_validation->set_rules('name',         $this->lang->line('name'),          'trim|required|min_length[4]|max_length[20]|xss_clean');
             $this->form_validation->set_rules('phone',        $this->lang->line('phone'),         'trim|required|max_length[13]|numeric|xss_clean');
             $this->form_validation->set_rules('email',        $this->lang->line('email'),         'trim|required|valid_email|xss_clean');
             $this->form_validation->set_rules('address',      $this->lang->line('address'),       'trim|required|max_length[30]|min_length[10]|xss_clean');
             $this->form_validation->set_rules('banner_image', $this->lang->line('banner_image'),  'trim|required|xss_clean');
             $this->form_validation->set_rules('logo_image',   $this->lang->line('logo_image'),    'trim|required|xss_clean');
             $this->form_validation->set_rules('opening_time', $this->lang->line('opening_time'),  'trim|required|max_length[7]|xss_clean');
             $this->form_validation->set_rules('closing_time', $this->lang->line('closing_time'),  'trim|required|xss_clean');
             $this->form_validation->set_rules('category_id',  $this->lang->line('food_type'),     'trim|required|xss_clean');
             $this->form_validation->set_rules('product_name', $this->lang->line('product_name'),  'trim|required|min_length[4]|max_length[30]|xss_clean');
             $this->form_validation->set_rules('quantity',     $this->lang->line('quantity'),      'trim|required|numeric|max_length[8]|min_length[1]|xss_clean');
             $this->form_validation->set_rules('price',        $this->lang->line('price'),         'trim|required|max_length[8]|min_length[1]|xss_clean');
             $this->form_validation->set_rules('food_image',   $this->lang->line('food_image'),    'trim|required|xss_clean');


           if ($this->form_validation->run() == FALSE) {

                 $this->loadAdminProfile('mart/addmart',$this->data); 

             } else {

                      $this->mart['name'] =            $this->input->post('name');
                      $this->mart['phone'] =           $this->input->post('phone');
                      $this->mart['email'] =           $this->input->post('email'); 
                      $this->mart['address'] =         $this->input->post('address');
                      $this->mart['lat']    =          $this->input->post('lat');
                      $this->mart['lng']    =          $this->input->post('lng');
                      $this->mart['banner_image'] =    $this->input->post('banner_image');
                      $this->mart['banner_img_path'] = $this->input->post('banner_img_path');
                      $this->mart['logo_image'] =      $this->input->post('logo_image');
                      $this->mart['logo_img_path'] =   $this->input->post('logo_img_path');
                      $this->mart['opening_time'] =    $this->input->post('opening_time');
                      $this->mart['closing_time'] =    $this->input->post('closing_time');
                      $this->mart['category_id'] =     $this->input->post('category_id');
                      $this->product['product_name'] = $this->input->post('product_name');
                      $this->product['quantity'] =     $this->input->post('quantity');
                      $this->product['price'] =        $this->input->post('price');
                      $this->product['food_image'] =   $this->input->post('food_image');
                      $this->product['food_img_path'] = $this->input->post('food_img_path'); 
                      //pr($this->mart);
                     //pr($this->product);
                        $this->processAddMart($this->mart,$this->product);
                        $this->data['message']="Data successfully added";
                        $this->loadAdminProfile('mart/addmart', $this->data);
                    }

        } else {

              $this->loadAdminProfile('mart/addmart',$this->data); 

            }
    }
   
   private function processAddMart($mart,$product){
   //pr($form);die();
   //Transfering data to Model
    if ($mart && $product) {
         $this->Common_model->insert_single('mart',$mart);
         $this->Common_model->insert_single('mart_products',$product);
    }
    else{
            show_404(); 
    }

 
  }


  public function addProduct(){
        $this->data['detail'] = $this->Mart->getMartCategories();
        $this->data['name'] = $this->input->get();
        //pr($this->data);
        
         if($this->input->post()){
             
             $this->data['detail'] = $this->Mart->getMartCategories();

             $this->form_validation->set_rules('category_id',  $this->lang->line('food_type'),     'trim|required|xss_clean');
             $this->form_validation->set_rules('product_name', $this->lang->line('product_name'),  'trim|required|min_length[4]|max_length[30]|xss_clean');
             $this->form_validation->set_rules('quantity',     $this->lang->line('quantity'),      'trim|required|numeric|max_length[8]|min_length[1]|xss_clean');
             $this->form_validation->set_rules('price',        $this->lang->line('price'),         'trim|required|max_length[8]|min_length[1]|xss_clean');
             $this->form_validation->set_rules('food_image',   $this->lang->line('food_image'),    'trim|required|xss_clean');

           if ($this->form_validation->run() == FALSE) {

                 $this->loadAdminProfile('mart/addproduct',$this->data); 

             } else {

                      $this->form['category_id'] =   $this->input->post('category_id');
                      $this->form['product_name'] =  $this->input->post('product_name');
                      $this->form['quantity'] =      $this->input->post('quantity');
                      $this->form['price'] =         $this->input->post('price');
                      $this->form['food_image'] =    $this->input->post('food_image');
                      $this->form['food_img_path'] =  $this->input->post('food_img_path');

                      $this->processAddProduct($this->form);
                       $this->data['message']="Data successfully added";
                      $this->loadAdminProfile('mart/addproduct', $this->data);
                    }

        } else {

              $this->loadAdminProfile('mart/addproduct',$this->data); 

            }         
    }
   
   private function processAddProduct($form){
   //pr($form);die();
   //Transfering data to Model
    if ($form) {
         $this->Common_model->insert_single('mart',$form);
    }
    else{
            show_404(); 
    }
 
  }


   public function FetchDataForUpdateMart(){

   $get =  $this->data['id'] = $this->input->get();
 
    $martId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();

     $this->data['detail'] = $this->getMartDetail($martId,true);

     if (is_array($this->data) && !empty($this->data)) {
       
        $this->loadAdminProfile('mart/updatemart', $this->data);
     }else{

       show_404();
     }
                          
  }


  public function updateMart()
  {

 // pr($this->input->post());die();
    $get =  $this->data['id'] = $this->input->post();
 
     $martId = (isset($get['id']) && !empty($get['id'])) ?  $this->Common_model->decrypt($get['id']): show_404();

    if($this->input->post()){
         // pr($this->input->post());die();
             $this->form_validation->set_rules('name',         $this->lang->line('name'),          'trim|required|min_length[4]|max_length[20]|xss_clean');
             $this->form_validation->set_rules('phone',        $this->lang->line('phone'),         'trim|required|max_length[11]|numeric|xss_clean');
             $this->form_validation->set_rules('email',        $this->lang->line('email'),         'trim|required|valid_email|xss_clean');
             $this->form_validation->set_rules('address',      $this->lang->line('address'),       'trim|required|max_length[30]|min_length[10]|xss_clean');
             $this->form_validation->set_rules('banner_image', $this->lang->line('banner_image'),  'trim|required|xss_clean');
             $this->form_validation->set_rules('logo_image',   $this->lang->line('logo_image'),    'trim|required|xss_clean');
             $this->form_validation->set_rules('opening_time', $this->lang->line('opening_time'),  'trim|required|max_length[7]|xss_clean');
             $this->form_validation->set_rules('closing_time', $this->lang->line('closing_time'),  'trim|required|xss_clean');
            
           if ($this->form_validation->run() == FALSE) {
               
                redirect(base_url().$this->uri->segment(1).'/mart/FetchDataForUpdateMart');

             } else {

                      $name         =       $this->input->post('name');
                      $phone        =       $this->input->post('phone');
                      $email        =       $this->input->post('email');
                      $lat          =       $this->input->post('lat');
                      $lng          =       $this->input->post('lng'); 
                      $address      =       $this->input->post('address');
                      $banner_image =       $this->input->post('banner_image');
                      $banner_img_path =    $this->input->post('banner_img_path');
                      $logo_image      =    $this->input->post('logo_image');
                      $logo_img_path   =     $this->input->post('logo_img_path');
                      $opening_time    =     $this->input->post('opening_time');
                      $closing_time    =     $this->input->post('closing_time');
                     
                     // pr($this->form);die();
                     $this->Common_model->update_single('mart',['name'=> $name,'phone'=> $phone,'email'=>$email,'lat'=>$lat,'lng'=>$lng,'address'=>$address,'banner_image'=>$banner_image,'banner_img_path'=>$banner_img_path,'logo_image'=>$logo_image,'logo_img_path'=>$logo_img_path,'opening_time'=>$opening_time,'closing_time'=>$closing_time],['where'=>['mart_id'=> $martId]]);

                       redirect(base_url().$this->uri->segment(1).'/mart');
                       
                    }

        } else {

                redirect(base_url().$this->uri->segment(1).'/mart/FetchDataForUpdateMart');

            }
             
  }

}

?>