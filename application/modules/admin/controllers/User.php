<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    private $loginId  = '';
    protected $params = array();
    protected $data   = array();

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('User_Model', 'User');
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
        $this->data['from'] = $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to'] = $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';
        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';
        $isExport = (isset($get['export']) && !empty($get['export'])) ? $get['export'] : "";
    
        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;

        //fetching category list Data.
        
        $this->data['users'] = $this->User->getUserList($this->params, $limit, $offset = ($page - 1) * $limit);


        $pageurl = 'admin/user';
        if ($isExport) {
            $this->exportUser($this->data['users']);
        }
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['users']['count'], $pageurl, $limit, $page);
        
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('user/list', $this->data);
    }

    /**
     * 
     * @name detail
     * @description This method is used to display the user details.
     * @access public
     * 
     */
    
    public function detail() {
        
        $get = $this->input->get();

        $userId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();
        
        if (is_numeric($userId) && $this->data['detail'] = $this->getUserProfileDetail($userId)) {
            
            $this->loadAdminProfile('user/detail', $this->data);
        } else {

            show_404();
        }
    }
   /**
     * @name followinglist
     * @param type 
     */

    

     public function followinglist() {
        $this->data = [];
        $this->params = [];
        $this->load->config("css");
        $this->data["css"] = $this->config->item("admin_profile");
        $this->data['js'] = "admin_forms";

        $this->data['id'] = $get = $this->input->get();
       
        $userId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();
 
        // filter &search
        $this->data['search'] = $this->params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $this->data['status'] = $this->params['status'] = isset($get['status']) ? trim($get['status']) : '';
        $this->data['from'] = $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to'] = $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';
        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';

        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;

        //fetching category list Data.
        $where = "status != " . DELETED . " AND user_type=" . USER;
        $this->data['users'] = $this->User->getFollwinguser($userId,$this->params, $limit, $offset = ($page - 1) * $limit, $where);
      
        $pageurl = 'admin/user/ratinglist?id='.$get['id'];
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['users']['count'], $pageurl, $limit, $page);

        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('user/ratinglist', $this->data);

    }

    /**
     * @name followinglist
     * @param type 
     */
     public function ratinglist() {
        $this->data = [];
        $this->params = [];
        $this->load->config("css");
        $this->data["css"] = $this->config->item("admin_profile");
        $this->data['js'] = "admin_forms";

        $this->data['id'] = $get = $this->input->get();
       
        $userId = (isset($get['id']) && !empty($get['id'])) ? $this->Common_model->decrypt($get['id']) : show_404();
 
        // filter &search
        $this->data['search'] = $this->params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $this->data['status'] = $this->params['status'] = isset($get['status']) ? trim($get['status']) : '';
        $this->data['from'] = $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to'] = $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';
        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';

        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;

        //fetching category list Data.
        $where = "status != " . DELETED . " AND user_type=" . USER;
        $this->data['users'] = $this->User->getRatinguser($userId,$this->params, $limit, $offset = ($page - 1) * $limit, $where);
      
        $pageurl = 'admin/user/ratinglist?id='.$get['id'];
        $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['users']['count'], $pageurl, $limit, $page);

        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();

        $this->loadAdminProfile('user/ratinglist', $this->data);
    }

    
    
    /**
     * @name getUserProfileDetail
     * @param type $userId
     */
    private function getUserProfileDetail($userId) {

        return $this->User->fetchUserDetail($userId, true);
    }
    /**
     * @name modifyArray
     * @description This method is used to modify user detail array for seprate sections
     * @param type $userOtherInfo
     * @param type $this->data
     * @return type
     */
    private function modifyArray($userOtherInfo,$data){
        $ratingArr = [];
        $checkinArr = [];
         $followingArr = [];
        foreach ($userOtherInfo as $key => $value) {

                    if (isset($value['rating_id']) && $value['rating_id'] != '') {

                        $rating['rating_id'] = $value['rating_id'];
                        $rating['rating'] = $value['rating'];
                        $rating['rating_time'] = $value['rating_time'];
                        $rating['comments'] = $value['comments'];
                        $rating['rated_name'] = $value['rated_name'];
                        $rating['rated_image'] = $value['rated_image'];

                        $ratingArr[] = $rating;
                    }


                    if (isset($value['check_in_id']) && $value['check_in_id'] != '') {
                        $check_in['check_in_id'] = $value['check_in_id'];
                        $check_in['check_in_time'] = $value['check_in_time'];
                        $check_in['checked_in_name'] = $value['checked_in_name'];
                        $check_in['checked_in_image'] = $value['checked_in_image'];


                        $checkinArr[] = $check_in;
                    }
                    
                    
               
        }
        $data['rating'] = $ratingArr;
        $data['check_in'] = $checkinArr;
        
        return $data;
    }
 /**
     * name : admin multiple action  blogs 
     * description :  multiple action   blogs 
     * @param array $ids
     * @return json
    */

    public function multiple_action(){

      
        $respone_code = '';
        $respone_msg  = '';
        //--------------
        if($this->input->post()){

            $postDataArr = $this->input->post();
            
            $ids    = $postDataArr['ids'];
            $action = $postDataArr['action'];

            if(!empty($ids) && $action!=''){
                
                //-------------------
                switch($action)
                {
                    case 'Delete':
                       
                        $respone_code = 200;
                        $this->db->where_in('user_id',$ids);
                        $blogData['status'] = 3;
                        $updated = $this->db->update('users', $blogData);
                        $respone_msg  = $this->lang->line("Record(s) removed successfully");
                       
                        break;
                    case 'Activate':

                        $this->db->where_in('user_id',$ids);
                        $blogData['status'] = 1;
                        $updated = $this->db->update('users', $blogData);
                        if($updated){
                            $respone_code = 200;
                            $respone_msg  =  $this->lang->line("Record(s) activated successfully");
                        }
                        break;
                    case 'Inactivate':
                        $this->db->where_in('user_id',$ids);
                        $blogData['status'] = 0;
                        $updated = $this->db->update('users', $blogData);
                        if($updated){
                            $respone_code = 200;
                            $respone_msg  =  $this->lang->line("Record(s) de-activated successfully");
                        }
                        break;
                    default:
                        $respone_code = 204;
                        $respone_msg  =  $this->lang->line("Request Action not found");
                        break;
                }

            }else{
                $respone_code = 203;
                $respone_msg  =  $this->lang->line("Required parameter is missing");
            }

        }
        else{
            $respone_code = 202;
            $respone_msg  =  $this->lang->line("Invalid access");
        }
        echo json_encode(array("code"=>$respone_code,"msg"=>$respone_msg));die;
    }

    public function exportUser($userData) {

        $fileName = 'userlist' . date('d-m-Y-g-i-h') . '.xls';
        // The function header by sending raw excel
        header("Content-type: application/vnd-ms-excel");
        // Defines the name of the export file
        header("Content-Disposition: attachment; filename=" . $fileName);
        $format = '<table border="1">'
                . '<tr>'
                . '<th width="25%">S.no</th>'
                . '<th>Name</th>'
                . '<th>Email</th>'
                . '<th>Phone Number</th>'
                . '<th>Age</th>'
                . '<th>Gender</th>'
                . '<th>Post</th>'
                . '<th>Follower</th>'
                . '<th>Rating</th>'
                . '<th>User Type</th>'
                . '<th>Registered on</th>'
                . '</tr>';

        $coun = 1;
        foreach ($userData AS $res) {

            
            $fld_1 = $coun;
            $fld_2 = (isset($res['name']) && ($res['name'] != '')) ? $res['name'] : '';
            $fld_3 = (isset($res['email']) && ($res['email'] != '')) ? $res['email'] : '';
            $fld_4 = (isset($res['mobile']) && ($res['email'] != '')) ? $res['country_code'] . '' . $res['mobile'] : '';
            $fld_5 = (isset($res['age']) && ($res['age'] != '')) ? $res['age'] . ' Years' : '';
            $fld_6 = //if($res['gender'] == MALE){ echo "Male";}else if($res['gender'] == FEMALE){echo "Female";}else{ echo "Other";}
            $fld_7 =  (isset($res['total_post'])?$res['total_post']:"0");
            $fld_8 = (isset($res['total_follower'])?$res['total_follower']:"0");
            $fld_9 = (isset($res['rating']) && ($res['rating'] != '')) ? $res['rating'] : '';
            $fld_10 = ($res['user_type'] == USER) ? "Normal" : (($res['user_type'] == BUSINESS) ? "Business" : "Other");
            $fld_11 = date('d/m/Y H:i:s', strtotime($res['created_at']));
            

            
            

            $format .= '<tr>
                        <td>' . $fld_1 . '</td>
                        <td>' . $fld_2 . '</td>
                        <td>' . $fld_3 . '</td>
                        <td>' . $fld_4 . '</td>
                        <td>' . $fld_5 . '</td>
                        <td>' . $fld_6 . '</td>
                        <td>' . $fld_7 . '</td>
                        <td>' . $fld_8 . '</td>
                        <td>' . $fld_9 . '</td>
                        <td>' . $fld_10 . '</td>
                       <td>' . $fld_11 . '</td>     
                      </tr>';
            $coun++;
        }

        echo $format;
        die;
    }

    
    
}
