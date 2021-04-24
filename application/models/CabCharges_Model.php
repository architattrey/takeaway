<?php

class CabCharges_Model extends CI_MODEL
{	
    public function __construct() {
        $this->load->database();
    }

    /**
     * @description function to fetch the cab charges...
     * @return CabCharges Model
     */
    public function get_charges($where = []){
    	$this->db->select("*");
    	$this->db->from("cab_charges");
    	if(!empty($where)){
    		foreach ($where as $key => $value) {
    			$this->db->where($key, $value);
    		}
    	}
    	$query = $this->db->get();
    	return $query->result();
    }

    /**
     * @param string $car_type type of the car
     * @param string $charge_type type of the charge
     * @return CabCharges Model
     */
    public function get_charge_by_type($car_type = null, $charge_type = null){
    	try{
    		if($car_type && $charge_type){
    			$this->db->select('*');
	            $this->db->from('cab_charges');
	            $this->db->where("car_type", $car_type);
	            $this->db->where("charge_type", $charge_type);
	            $query = $this->db->get();
	            return $query->row_array();
    		} else {
    			return false;
    		}
        }  catch (Exception $e){
            echo json_encode($e->getTraceAsString());
        }
    }

    /**
     * @param  array $data parameter to be saved to the database
     * @return Boolean
     */
    public function create($data = array()){
    	if(!empty($data)) {
    		$status = $this->db->insert('cab_charges', $data);
    		return $status;
    	} else {
    		return false;
    	}
    }

    /**
     * @param  array $data parameter to be updated to the database
     * @return Boolean
     */
    public function update($data = array()){
    	if(!empty($data)) {
    		$status = $this->db->update('cab_charges', $data, array('id' => $data['id']));
    		return $status;
    	} else {
    		return false;
    	}
    }
}