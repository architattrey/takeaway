<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends  MY_Controller
{
	protected $data = array();
	//protected $params = array();

	function __construct()
	{
	    parent::__construct();

	    $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Cms_Model', 'Cms');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
       
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
	}

    public function index ()
    {
        try{
        $this->data['para'] =  $this->Cms->fetchTermsAndConditions();
        if (is_array($this->data['para']) && !empty($this->data['para'])) {
             $this->loadAdminProfile('cms/terms_and_conditions', $this->data);
        }
        else{
            
             show_404();
        }
         }catch(Exception $e){
         echo $ex->getMessage();

    }
       
    }

    public function aboutUs ()
    {
      try{
        $this->data['para'] =  $this->Cms->fetchAboutUs();
        if (is_array($this->data['para']) && !empty($this->data['para'])) {
             $this->loadAdminProfile('cms/about_us', $this->data);
            
        }
        else{
            
             show_404();
        }
    }catch(Exception $e){
         echo $ex->getMessage();

    }
       
    }

    public function contactUs ()
    {
     try{
        $this->data['para'] =  $this->Cms->fetchContactUs();
         if (is_array($this->data['para']) && !empty($this->data['para'])) {
              $this->loadAdminProfile('cms/contact_us', $this->data);
            }else{
            
             show_404();
        }
       }catch(Exception $e){
         echo $ex->getMessage();

    }
    }
    
    public function updateContactUs()
    {
        // $this->data['para'] =  $this->Cms->fetchContactUs();
    try{
     $req = $this->input->post();
     $contactUsId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
     if ($req) {
         
         $this->form_validation->set_rules('email',          $this->lang->line('email'),               'trim|required|xss_clean');
         $this->form_validation->set_rules('country_code',   $this->lang->line('country_code'),        'trim|required|xss_clean');
         $this->form_validation->set_rules('phone',          $this->lang->line('phone'),               'trim|required|xss_clean');
         $this->form_validation->set_rules('contact_us',$this->lang->line('contact_us'),               'trim|required|min_length[150]|xss_clean' );
         
     if ($this->form_validation->run() == FALSE) {

          $this->data['para'] =  $this->Cms->fetchContactUs();
         
          $this->loadAdminProfile('cms/contact_us', $this->data);
     }else{

        $this->Common_model->update_single('cms',['contact_us'=>$req['contact_us'],'email'=>$req['email'],'country_code'=>$req['country_code'],'phone'=>$req['phone']],['where'=>['id'=> $contactUsId]]);
        $this->data['message'] = " Successfully Updated";
        $this->data['para'] =  $this->Cms->fetchContactUs();

        $this->loadAdminProfile('cms/contact_us', $this->data);
     }


      }else{

          show_404();
      }

    }catch (Exception $e){
         echo $ex->getMessage();

    }
   }

    public function updateAboutUs()
    {
          try{
        

          $req = $this->input->post();
           $aboutUsId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
          
     if ($req) {
         
         $this->form_validation->set_rules('about_us',$this->lang->line('about_us'),  'trim|required|min_length[350]|xss_clean' );
      
     if ($this->form_validation->run() == FALSE) {
         $this->data['para'] =  $this->Cms->fetchAboutUs();
         $this->loadAdminProfile('cms/about_us', $this->data);
     }else{

        $this->Common_model->update_single('cms',['about_us'=>$req['about_us']],['where'=>['id'=> $aboutUsId]]);

        $this->data['message'] = "Successfully Updated";
        $this->data['para'] =  $this->Cms->fetchAboutUs();
        $this->loadAdminProfile('cms/about_us', $this->data);

     }


      }else{

          show_404();
      }

    }catch (Exception $e){
         echo $ex->getMessage();

    }
   }


    public function updateTermsAndConditions()
    {

    try{
    
          $req = $this->input->post();
           $termsAndCoditionsId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
          
     if ($req) {
         
         $this->form_validation->set_rules('terms_and_conditions',$this->lang->line('terms_and_conditions'),  'trim|required|min_length[350]|xss_clean' );
      
     if ($this->form_validation->run() == FALSE) {
        $this->data['para'] =  $this->Cms->fetchTermsAndConditions();
         $this->loadAdminProfile('cms/terms_and_conditions', $this->data);
     }else{

        $this->Common_model->update_single('cms',['terms_and_conditions'=>$req['terms_and_conditions']],['where'=>['id'=> $termsAndCoditionsId]]);

        $this->data['message'] = "Successfully Updated";
        $this->data['para'] =  $this->Cms->fetchTermsAndConditions();
        $this->loadAdminProfile('cms/terms_and_conditions', $this->data);

     }


      }else{

          show_404();
      }

    }catch (Exception $e){
         echo $ex->getMessage();

    }
   }
}
?>
