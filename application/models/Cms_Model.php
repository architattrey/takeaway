<?php

class Cms_Model extends CI_MODEL
{
	
    public function __construct() {
        $this->load->database();
    }
    
     public function fetchTermsAndConditions(){
        try{
            $this->db->select('terms_and_conditions,id');
            $this->db->from('cms');
            $query = $this->db->get();
            
            return $query->row_array();

        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }


     public function fetchContactUs(){
        try{
            $this->db->select('contact_us,email,country_code,phone,id');
            $this->db->from('cms');
            $query = $this->db->get();
            return $query->row_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }



     public function fetchAboutUs(){
        try{
            $this->db->select('about_us,id');
            $this->db->from('cms');
            $query = $this->db->get();
            return $query->row_array();
        }  catch (Exception $e){
            
            echo json_encode($e->getTraceAsString());
   
        }
    }
}






?>