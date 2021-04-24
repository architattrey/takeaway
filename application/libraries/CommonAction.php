<?php
class CommonAction{
	
	

	public static function checkValidUser($mobile){
		$CI =& get_instance();
		$isValid =  $CI->Common_model->fetch_data("users","user_id",["where"=>["mobile"=>$mobile]],true);

		if($isValid){
			return true;
		}else{
			return false;
		}

	}


	public static function checkAvailableCredit($userId,$credit){
		$CI =& get_instance();
		$creditData =  $CI->Common_model->fetch_data("users","wallet_credit_point as credit",["where"=>["user_id"=>$userId]],true);
		
		if(isset($credit) && $credit <= $creditData["credit"]){
			return true;
		}else{
			return false;
		}

	}


	public static function checkValidDriver($mobile){
		$CI =& get_instance();
		$isValid =  $CI->Common_model->fetch_data("drivers","driver_id",["where"=>["mobile"=>$mobile]],true);

		if($isValid){
			return true;
		}else{
			return false;
		}
	}


	public static function checkAvailableDriverCredit($userId,$credit){
		$CI =& get_instance();
		$creditData =  $CI->Common_model->fetch_data("drivers","wallet_credit as credit",["where"=>["driver_id"=>$userId]],true);
		
		if(isset($credit) && $credit <= $creditData["credit"]){
			return true;
		}else{
			return false;
		}

	}
}

?>