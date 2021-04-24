<?php 
defined('BASEPATH') || exit('No direct script access allowed');

class Ajax extends MX_Controller
{
    public function __construct()
    {
        $this->load->model("Common_model");
        $this->load->library("session",'form_validation');
        
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        //echo base_url;
    }
    /**
     *AJAX Handler for email exists 
     */
    public function emailExistsAjax()
    {
        $postData = $this->input->post();
        if ( ! isset($postData["email"]) || empty($postData["email"]) ) {
            $errorData = [
                "error" => true,
                "message" => "fields are not set",
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($errorData);
        } else {
            if ( $userData = $this->CommonModel->fetchData(
                ["id"],
                "users",
                ["email" => $postData["email"]]
                ) 
            ) { 
                $errorData = [
                    "error" => true,
                    "message" => "Email already in use.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            } else {
                $errorData = [
                    "error" => false,
                    "message" => "Email available.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            }
                
        }
    }
    /**
     * AJAX HANDLER FOR MOBILE NUMBER EXISTS
     */
    public function mobileExistsAjax()
    {
        $postData = $this->input->post();
        if ( ! isset($postData["mobile_number"]) || empty($postData["mobile_number"]) ) {
            $errorData = [
                "error" => true,
                "message" => "fields are not set",
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($errorData);
        } else {
            if ( $userData = $this->CommonModel->fetchData(
                ["id"],
                "users",
                ["mobile_number" => $postData["mobile_number"]]
                ) 
            ) { 
                $errorData = [
                    "error" => true,
                    "message" => "Mobile number already in use.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            } else {
                $errorData = [
                    "error" => false,
                    "message" => "Mobile number available.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            }
                
        }
    }
    
  
    /* 
     *Profile Picture Upload using Amazon s3 storage
     *
     */
    public function profilePictureUpload() {
        
        $image = $_FILES['image'];
        $imageSize = getimagesize($image['tmp_name']);
        
        $validMimeTypes = ['image/png','image/jpg', 'image/jpeg'];

        if ( ! $imageSize || null === $imageSize) {
            $response = [
                "success" => false,
                "message" => $this->lang->line("not_an_image"),
                "code" => NOT_AN_IMAGE,
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($response);
        } else {

        }

        if ( ! in_array( $imageSize['mime'], $validMimeTypes ) ) {
            $response = [
                "success" => false,
                "message" => $this->lang->line("not_an_image"),
                "code" => NOT_AN_IMAGE,
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($response);
        } else {
            
        }

        if ( $image['size'] > MAX_IMAGE_SIZE ) {
            $response = [
                "success" => false,
                "message" => $this->lang->line("image_too_big"),
                "code" => IMAGE_TOO_BIG,
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($response);
        } else {
            
        }

        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = "Bonapp_" . time() . "." . $extension;

  $result=$this->Common_model->s3_uplode($imageName,$image['tmp_name']);
        if ($result) {
            $response = [
                "success" => true,
                "csrf_token" => $this->security->get_csrf_hash(),
                "data" => $result
            ];
        }
        $this->CommonModel->response($response);
    }
    /**  
     * Handles location for google maps
     * https://maps.googleapis.com/maps/api/geocode/json?key=API_KEY&address=appinventiv%20noida
     */
    public function getLocation()
    {
        $postData = $this->input->post();

    }

       /**
     *AJAX Handler for email exists 
     */
    public function oldpasswordExistsAjax()
    {
        $postData = $this->input->post();
        $id= decrypt_with_openssl(new OpenSSLEncrypt(),$postData['userid'],true);
        if ( (! isset($postData["oldpassword"]) || empty($postData["oldpassword"])) ) {
            $errorData = [
                "error" => true,
                "message" => "fields are not set",
                "csrf_token" => $this->security->get_csrf_hash()
            ];
          
            $this->CommonModel->response($errorData);
        } else {
            if ( $userData = $this->CommonModel->fetchData(
                ["admin_id"],
                "admin",
                ["password" => hash("sha256", base64_decode($postData["oldpassword"])),'admin_id'=>$id]
                ) 
            ) { 
               
                $errorData = [
                    "error" =>true,
                    "message" => "Old password matched.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            } else {
                $errorData = [
                    "error" => false,
                    "message" => "Old password not matched",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            }
                
        }
    }
    
    //check edit mobile number 
    public function editmobileExistsAjax()
    {
        $postData = $this->input->post();
        $id=decrypt_with_openssl(new OpenSSLEncrypt(), $postData['userid'],true);
        if ( ! isset($postData["mobile_number"]) || empty($postData["mobile_number"]) ) {
            $errorData = [
                "error" => true,
                "message" => "fields are not set",
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($errorData);
        } else {
            if ( $userData = $this->CommonModel->fetchData(
                ["id"],
                "users",
                ["mobile_number" => $postData["mobile_number"],'id!='=>$id]
                ) 
            ) { 
                $errorData = [
                    "error" => true,
                    "message" => "Mobile number already in use.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            } else {
                $errorData = [
                    "error" => false,
                    "message" => "Mobile number available.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            }
                
        }
    }
    
    /*Check for edit merchant email address*/
    /**
     *AJAX Handler for email exists 
     */
    public function editemailExistsAjax()
    {
        $postData = $this->input->post();
          $id=decrypt_with_openssl(new OpenSSLEncrypt(), $postData['userid']);
    
        if ( ! isset($postData["email"]) || empty($postData["email"]) ) {
            $errorData = [
                "error" => true,
                "message" => "fields are not set",
                "csrf_token" => $this->security->get_csrf_hash()
            ];
            $this->CommonModel->response($errorData);
        } else {
            if ( $userData = $this->CommonModel->fetchData(
                ["id"],
                "users",
                ["email" => $postData["email"],"id!="=>$id]
                ) 
            ) { 
                $errorData = [
                    "error" => true,
                    "message" => "Email already in use.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            } else {
                $errorData = [
                    "error" => false,
                    "message" => "Email available.",
                    "csrf_token" => $this->security->get_csrf_hash()
                ];
                $this->CommonModel->response($errorData);
            }
                
        }
    }
    
    /*
     * change the status of user to block or unblock
     */

    public function changestatus() {
        try {
            $resparr = array();
            $userid = $this->input->post('id');
            $id = decrypt_with_openssl(new OpenSSLEncrypt(), $userid);
            $status = $this->input->post('is_blocked');
            $table = 'cs_hf_users';
            $where = array('where' => array('id' => $id));
            $updateArr = array('user_status' => $status);
            $result = $this->Common_model->update_single('users', $updateArr, $where);
               $csrftoken=$this->security->get_csrf_hash();
            if ($result == true) {
                $resparr = array("code" => 200, 'msg' => SUCCESS,"csrf_token" => $csrftoken);
            } else {
                $resparr = array("code" => 201, 'msg' => TRY_AGAIN,"csrf_token" => $csrftoken);
            }
            echo json_encode($resparr);
            die;
        } catch (Exception $ex) {
            $resparr = array("code" => 201, 'msg' => $ex->getMessage());
        }
    }

    
    /*
     *Delete User from list
     */

    public function deleteuser() {
        try {
            $resparr = array();
            $userid = $this->input->post('id');
            $id = decrypt_with_openssl(new OpenSSLEncrypt(), $userid,true);
            $status = $this->input->post('is_deleted');
            $table = 'cs_hf_users';
            $where = array('where' => array('id' => $id));
            $updateArr = array('user_status' => $status);
   
            $result = $this->Common_model->update_single('users', $updateArr, $where);
            $csrftoken=$this->security->get_csrf_hash();
            if ($result == true) {
                $resparr = array("code" => 200, 'msg' => SUCCESS,"csrf_token" => $csrftoken);
            } else {
                $resparr = array("code" => 201, 'msg' => TRY_AGAIN,"csrf_token" => $csrftoken);
            }
            echo json_encode($resparr);
            die;
        } catch (Exception $ex) {
            $resparr = array("code" => 201, 'msg' => $ex->getMessage());
        }
    }
//-----------------------------------------------------------------------------------------
    /**
     * @name getStatesByCountry
     * @description This method is used to get all the states name via country using the get method.
     * @access public
     */
    public function getStatesByCountry(){
      try{  
        if ($this->input->is_ajax_request()){
             $req = $this->input->get();
             $statedata  = $this->Common_model->fetch_data('states','id,name',['where'=>['country_id'=>$req['id']]]);
             echo json_encode($statedata); exit;
         }
      }
      catch(Exception $e){
          echo json_encode($e->getTraceAsString());
      }
    }
//-----------------------------------------------------------------------------------------
    /**
     * @name getCityByState
     * @description This method is used to get all the cities as per the state using get method.
     * @access 
     */
    public function getCityByState(){
       try{  
        if ($this->input->is_ajax_request()){
             $req = $this->input->get();
             $citydata  = $this->Common_model->fetch_data('cities','id,name',['where'=>['state_id'=>$req['id']]]);
             echo json_encode($citydata); exit;
         }
      }
      catch(Exception $e){
          echo json_encode($e->getTraceAsString());
      }
    }
//-----------------------------------------------------------------------------------------
   /**
    * @name change-user-status
    * @description This action is used to handle all the block events.
    * 
    */
   public function changeUserStatus(){
       try{  
        
             $req = $this->input->post();

             $userId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             //$driverId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             
             
             switch($req['type']){
                case 'user': 
                        $updateId  =  $this->Common_model->update_single('users',['status'=>$req['new_status']],['where'=>['user_id'=>$userId]]);
                break;
                case 'driver': 
                        $updateId  =  $this->Common_model->update_single('drivers',['status'=>$req['new_status']],['where'=>['driver_id'=>$userId]]);
                break;
                case 'resource': 
                        $updateId  =  $this->Common_model->update_single('resources',['status'=>$req['new_status']],['where'=>['resource_id'=>$userId]]);
                break;
                case 'driver-verify': 
                        $updateId  =  $this->Common_model->update_single('drivers',['is_verified'=>$req['new_status']],['where'=>['driver_id'=>$userId]]);
                break;

                case 'vehicile': 
                        $updateId  =  $this->Common_model->update_single('driver_vehicile',['status'=>$req['new_status']],['where'=>['vechile_id'=>$userId]]);
                case 'mart': 
                        $updateId  =  $this->Common_model->update_single('mart',['status'=>$req['new_status']],['where'=>['mart_id'=>$userId]]);
                break;

                 case 'restaurant': 
                        $updateId  =  $this->Common_model->update_single('restaurant',['status'=>$req['new_status']],['where'=>['restaurant_id'=>$userId]]);
                break;
                case 'version': 
                        $this->db->where('vid', $userId);
                        $this->db->delete('app_version');
                        $updateId=true;
                break;
            }
            
            $csrftoken = $this->security->get_csrf_hash();
            
            if ($updateId) {
                $resparr = array("code" => 200, 'msg' => SUCCESS,"csrf_token" => $csrftoken,'id'=>$userId);
            } else {
                $resparr = array("code" => 201, 'msg' => TRY_AGAIN,"csrf_token" => $csrftoken,'id'=>$userId);
            }
            echo json_encode($resparr); exit;
            
      }
      catch(Exception $e){
          echo json_encode($e->getTraceAsString());
      }
   }

    public function verifyDriver(){
       try{  
        
             $req = $this->input->post();
             
             $userId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             //$driverId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             
             
             switch($req['type']){
               
                case 'driver': 
                        $updateId  =  $this->Common_model->update_single('drivers',['is_verified'=>$req['new_status'],'status'=>$req['new_status']],['where'=>['driver_id'=>$userId]]);
                 break;       
               
                case 'driver-verify': 
                        $updateId  =  $this->Common_model->update_single('drivers',['is_verified'=>$req['verify_status']],['where'=>['driver_id'=>$userId]]);
                  break;

                case 'version': 
                        $this->db->where('vid', $userId);
                        $this->db->delete('app_version');
                        $updateId=true;
                break;
            }
            
            $csrftoken = $this->security->get_csrf_hash();
            
            if ($updateId) {
                $resparr = array("code" => 200, 'msg' => SUCCESS,"csrf_token" => $csrftoken,'id'=>$userId);
            } else {
                $resparr = array("code" => 201, 'msg' => TRY_AGAIN,"csrf_token" => $csrftoken,'id'=>$userId);
            }
            echo json_encode($resparr); exit;
            
      }
      catch(Exception $e){
          echo json_encode($e->getTraceAsString());
      }
   }
   public function rejectDriver()
   {
     try { 
             $req = $this->input->post();
             pr($req);
             $driverId = isset($req['driver_id'])?$this->Common_model->decrypt($req['driver_id']):show_404();
             $where = array('where' => array('driver_id' =>$driverId ));
             $result = $this->Common_model->delete_data('drivers', $where);
    $result1 = $this->Common_model->sendmailnew($req['mailId'], "TakeAway - Reject Request", $req['reason'], true,$param=array(), 'admin_rejection_reason');
                   
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }



   public function deleteCategory()
   {
     try { 
             $req = $this->input->post();
             $categoryId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             $where = array('where' => array('category_id' =>$categoryId ));
             $result = $this->Common_model->delete_data('mart_food_category', $where);
  
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }


    public function deleteBanner()
   {
     try { 
             $req = $this->input->post();
             $bannerId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             $where = array('where' => array('banner_id' =>$bannerId ));
             $result = $this->Common_model->delete_data('banner', $where);
  
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }

    public function deleteVechile()
   {
     try { 
             $req = $this->input->post();
             //pr($req);
             $vechileId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             $where = array('where' => array('vechile_id' =>$vechileId ));
             $result = $this->Common_model->delete_data('driver_vehicile', $where);
  
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }


   public function deleteMart()
   {
     try { 
             $req = $this->input->post();
             //pr($req);
             $martId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             $where = array('where' => array('mart_id' =>$martId ));
             $result = $this->Common_model->delete_data('mart', $where);
  
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }


   public function deleteRestaurant()
   {
     try { 
             $req = $this->input->post();
             //pr($req);
             $restaurantId = isset($req['id'])?$this->Common_model->decrypt($req['id']):show_404();
             $where = array('where' => array('restaurant_id' =>$restaurantId ));
             $result = $this->Common_model->delete_data('restaurant', $where);
  
               
         } catch (Exception $e) {
            echo $ex->getMessage();
        }
   }




  
   
  


}
?>