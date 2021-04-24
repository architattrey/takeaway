<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charges extends MY_Controller {

    private $loginId  = '';
    protected $params = array();
    protected $data   = array();
    protected $form   = array();

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('CabCharges_Model','Charges');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
    }

    /**
     * @name index
     * @description This method is used to login the admin and save the charges as well to the database
     */
    public function index() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();

            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('base_fare',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($req['car_type'], $req['charge_type']);
                    if($charges) {
                        $req['id'] =  $charges['id'];
                        // need to update the existing entry
                        $req['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($req);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $req['created_at'] = date('Y-m-d H:i:s');
                        $req['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($req);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

    /**
     * @description function to save the data for the shown cab and traffic type...
     * @return View
     */
    public function showntraffic() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();

            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('base_fare_shown_traffic',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('shown_traffic_after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    $data = $req;
                    $data['base_fare'] = $req['base_fare_shown_traffic'];
                    $data['after_kms'] = $req['shown_traffic_after_kms'];
                    unset($data['base_fare_shown_traffic']);
                    unset($data['shown_traffic_after_kms']);
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($data['car_type'], $data['charge_type']);
                    if($charges) {
                        $data['id'] =  $charges['id'];
                        // need to update the existing entry
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

    /**
     * @description function to save the data for the shown cab and traffic type...
     * @return View
     */
    public function shownnight() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();


            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

        
            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('base_fare_shown_night',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('shown_night_after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    $data = $req;
                    $data['base_fare'] = $req['base_fare_shown_night'];
                    $data['after_kms'] = $req['shown_night_after_kms'];
                    unset($data['base_fare_shown_night']);
                    unset($data['shown_night_after_kms']);
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($data['car_type'], $data['charge_type']);
                    if($charges) {
                        $data['id'] =  $charges['id'];
                        // need to update the existing entry
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

    /**
     * @description function to save the space cab type data for the normal charges.....
     * @return View
     */
    public function space() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();

            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('space_base_fare',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('space_after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    $data = $req;
                    $data['base_fare'] = $req['space_base_fare'];
                    $data['after_kms'] = $req['space_after_kms'];
                    unset($data['space_base_fare']);
                    unset($data['space_after_kms']);
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($data['car_type'], $data['charge_type']);
                    if($charges) {
                        $data['id'] =  $charges['id'];
                        // need to update the existing entry
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

    /**
     * @description function to save the space traffic charges ....
     * @return View
     */
    public function spacetraffic() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();

            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('base_fare_space_traffic',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('space_traffic_after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    $data = $req;
                    $data['base_fare'] = $req['base_fare_space_traffic'];
                    $data['after_kms'] = $req['space_traffic_after_kms'];
                    unset($data['base_fare_space_traffic']);
                    unset($data['space_traffic_after_kms']);
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($data['car_type'], $data['charge_type']);
                    if($charges) {
                        $data['id'] =  $charges['id'];
                        // need to update the existing entry
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

    /**
     * @description function to save the data for the space cab and  night type...
     * @return View
     */
    public function spacenight() {
        try{
            //fetch the charges to be shown on the form..
            $this->data['shown_charges'] = array();
            $this->data['space_charges'] = array();


            $this->data['shown_charges_traffic'] = array();
            $this->data['space_charges_traffic'] = array();

        
            $this->data['shown_charges_night'] = array();
            $this->data['space_charges_night'] = array();

            $shown_charges = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "normal"]);
            if(!empty($shown_charges) && count($shown_charges) == 1) {
                $this->data['shown_charges'] = $shown_charges[0];
            }
            
            $space_charges = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "normal"]);
            if(!empty($space_charges) && count($space_charges) == 1) {
                $this->data['space_charges'] = $space_charges[0];
            }

            $shown_charges_traffic = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "traffic"]);
            if(!empty($shown_charges_traffic) && count($shown_charges_traffic) == 1) {
                $this->data['shown_charges_traffic'] = $shown_charges_traffic[0];
            }
            
            $space_charges_traffic = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "traffic"]);
            if(!empty($space_charges_traffic) && count($space_charges_traffic) == 1) {
                $this->data['space_charges_traffic'] = $space_charges_traffic[0];
            }

            $shown_charges_night = $this->Charges->get_charges(["car_type" => "shown", "charge_type" => "night"]);
            if(!empty($shown_charges_night) && count($shown_charges_night) == 1) {
                $this->data['shown_charges_night'] = $shown_charges_night[0];
            }
            
            $space_charges_night = $this->Charges->get_charges(["car_type" => "space" , "charge_type" => "night"]);
            if(!empty($space_charges_night) && count($space_charges_night) == 1) {
                $this->data['space_charges_night'] = $space_charges_night[0];
            }

            $req = $this->input->post();
            if($req){
                $this->form_validation->set_rules('car_type',      $this->lang->line('car_type'),               'trim|required|xss_clean');
                $this->form_validation->set_rules('charge_type',   $this->lang->line('charge_type'),        'trim|required|xss_clean');
                $this->form_validation->set_rules('base_fare_space_night',     $this->lang->line('base_fare'),               'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('space_night_after_kms',$this->lang->line('after_kms'),               'trim|required|numeric|xss_clean' );

                if ($this->form_validation->run() == TRUE) {
                    $data = $req;
                    $data['base_fare'] = $req['base_fare_space_night'];
                    $data['after_kms'] = $req['space_night_after_kms'];
                    unset($data['base_fare_space_night']);
                    unset($data['space_night_after_kms']);
                    //save the data here to the data base and send the success message to the view file....
                    $charges = $this->Charges->get_charge_by_type($data['car_type'], $data['charge_type']);
                    if($charges) {
                        $data['id'] =  $charges['id'];
                        // need to update the existing entry
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->update($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    } else {
                        // need to create the new entry
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $return = $this->Charges->create($data);
                        if($return) {
                            $this->data['message'] = "Successfully Created";
                        }
                    }
                }
            }

            $this->loadAdminProfile('charges/manage_charges', $this->data);
        }catch (Exception $e){
            echo $ex->getMessage();
        }
    }

  }
?>