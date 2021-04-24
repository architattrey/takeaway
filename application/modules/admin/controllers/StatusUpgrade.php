<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StatusUpgrade extends  MY_Controller
{
	protected $data = array();
	//protected $params = array();

	function __construct()
	{
	    parent::__construct();

	    $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Statusupgrade_Model', 'status');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
       
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
	}

  public function index ()
  {

  	try{
        $this->data['forUser']   =  $this->status->fetchstatusupgradeforuser();
        $this->data['forDriver'] =  $this->status->fetchstatusupgradefordriver();
        //pr($this->data);

        if ((is_array($this->data['forUser']) && !empty($this->data['forUser'])) && (is_array($this->data['forDriver']) && !empty($this->data['forDriver']))) {
             $this->loadAdminProfile('statusupgrade/statusupgrade', $this->data);
        }
        else{
            
             show_404();
        }
         }catch(Exception $e){
         echo $ex->getMessage();
    }
  	 
  }

  public function updateForUser()

  {  	
  	 try{
     $req = $this->input->post();

    $Id = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
   // pr($req);
     if ($req) {
         
         $this->form_validation->set_rules('usage',                   $this->lang->line('usage'),               'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('rvw_rate_by_drvr',        $this->lang->line('rvw_rate_by_drvr'),    'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('money_topup',             $this->lang->line('money_topup'),         'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('number_of_visit',         $this->lang->line('number_of_visit'),     'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('frnd_recmnd',             $this->lang->line('frnd_recmnd'),         'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('mrchnt_recmnd',           $this->lang->line('mrchnt_recmnd'),       'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('cncl_deals',              $this->lang->line('cncl_deals'),          'trim|required|min_length[1]|xss_clean');
         
     if ($this->form_validation->run() == FALSE) {

     	      $this->data['forUser']   =  $this->status->fetchstatusupgradeforuser();
              $this->data['forDriver'] =  $this->status->fetchstatusupgradefordriver();
              $this->loadAdminProfile('statusupgrade/statusupgrade', $this->data);
     }else{

        $this->Common_model->update_single('status_upgrd_for_user',['usage'=>$req['usage'],'rvw_rate_by_drvr'=>$req['rvw_rate_by_drvr'],'money_topup'=>$req['money_topup'],'number_of_visit'=>$req['number_of_visit'],'frnd_recmnd'=>$req['frnd_recmnd'],'mrchnt_recmnd'=>$req['mrchnt_recmnd'],'cncl_deals'=>$req['cncl_deals']],['where'=>['id'=> $Id]]);

            $this->data['message'] = " Successfully Updated";
            $this->data['forUser']   =  $this->status->fetchstatusupgradeforuser();
            $this->data['forDriver'] =  $this->status->fetchstatusupgradefordriver();
        
            $this->loadAdminProfile('statusupgrade/statusupgrade', $this->data);
     }


      }else{

          show_404();
      }

    }catch (Exception $e){
         echo $ex->getMessage();

    }
  }

public function updateForDriver()
  {
  	
  	 try{
     $req = $this->input->post();
      $Id = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
      //pr($req);
     if ($req) {
         
         $this->form_validation->set_rules('deliver',                 $this->lang->line('deliver'),             'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('rvw_rate_by_user',        $this->lang->line('rvw_rate_by_user'),    'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('credit_sell_back',        $this->lang->line('credit_sell_back'),    'trim|required|min_length[1]|xss_clean');
         $this->form_validation->set_rules('cancel_deals',            $this->lang->line('cancel_deals'),        'trim|required|min_length[1]|xss_clean');
         
     if ($this->form_validation->run() == FALSE) {

              $this->data['forUser']   =  $this->status->fetchstatusupgradeforuser();
              $this->data['forDriver'] =  $this->status->fetchstatusupgradefordriver();
               $this->loadAdminProfile('statusupgrade/statusupgrade', $this->data);
        }else{

        $this->Common_model->update_single('status_upgrd_for_driver',['deliver'=>$req['deliver'],'rvw_rate_by_user'=>$req['rvw_rate_by_user'],'credit_sell_back'=>$req['credit_sell_back'],'cancel_deals'=>$req['cancel_deals']],['where'=>['id'=> $Id]]);
         $this->data['message'] = " Successfully Updated";
         $this->data['forUser']   =  $this->status->fetchstatusupgradeforuser();
         $this->data['forDriver'] =  $this->status->fetchstatusupgradefordriver();
        

         $this->loadAdminProfile('statusupgrade/statusupgrade', $this->data);
     }


      }else{

          show_404();
      }

    }catch (Exception $e){
         echo $ex->getMessage();

    }
  }

}