<?php

class Statusupgrade_Model extends CI_MODEL
{
	
    public function __construct() {
        $this->load->database();
    }


     public function fetchstatusupgradeforuser(){
        try{
            $this->db->select();
            $this->db->from('status_upgrd_for_user');
            $query = $this->db->get();
            if(!empty($query)){
            return $query->row_array();
           }
        }  catch (Exception $e){
            echo json_encode($e->getTraceAsString());
   
        }
    }

     public function fetchstatusupgradefordriver(){
        try{
            $this->db->select();
            $this->db->from('status_upgrd_for_driver');
            $query = $this->db->get();
            if (!empty($query)) {
            return $query->row_array();
            }
           
        }  catch (Exception $e){
            echo json_encode($e->getTraceAsString());
   
        }
    }

}
    