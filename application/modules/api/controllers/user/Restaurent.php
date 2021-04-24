
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class Restaurent extends AutheticationLib {

    protected  $request=[];
    protected  $offset  = 0;
    protected  $is_more_data  = 0;

	/**
	 * Constructor for the HashTag API
	 *
	 * @access public
	 * @param string $config
	 * @return void
	 */
	public function __construct($config = 'rest') {
		parent::__construct($config);

		$this->load->helper('url');
		// Authentication for header.

		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->model('Common_model');
        $this->load->model('Restaurent_Model','Restaurent');
		$this->load->library('session');
		$this->lang->load('rest_controller', "english");
		$this->load->library('form_validation');
		$this->form_validation->CI = &$this;

	}
    /**
    *@name home
    *@desccription This method is used to list all the mart along with the categories.
    *
    */

    public function home_get(){

        $this->request  = $this->get();
        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$driverId = $this->checkLogin($accessToken);
        
        //get banners
        $banners = $this->Restaurent->getRestaurentsBanners();

        $resData  =  $this->Restaurent->getRestaurentHomeData($this->request);
        
        if(!empty($resData) && is_array($resData)){

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['banners'=>$banners,'restaurent'=>$resData]]);
        }else{

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>[]]);
        }
    }


    public function recommend_post(){

        $this->request  = $this->post();
        $this->form_validation->set_rules('restaurent_name','Restaurent Name','trim|required');
        $this->form_validation->set_rules('location','Location','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|regex_match[/^[0-9]\d{5,16}$/]');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['restaurent_name','location','mobile']);
        }

        $saveData['module_name'] = $this->request['restaurent_name'];
        $saveData['location'] = $this->request['location'];
        $saveData['mobile'] = $this->request['mobile'];
        $saveData['module_type'] = RESTAURENT;
        $saveData['created_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
        $id = $this->Common_model->insert_single('recommend',$saveData);
        if($id){
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS')]);
        }else{
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED')]);
        }
    }


    public function detail_get(){

        $this->request  = $this->get();
        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$driverId = $this->checkLogin($accessToken);
        $categoryId="";
        if(isset($this->request['category_id']) && $this->request['category_id']!=""){
            $categoryId = $this->request['category_id'];
        }

        $categories  = $this->getCategories($this->request['restaurent_id']);
        
        $detail = $this->Restaurent->getResDetail($this->request,false,false,true);

        $responseData = $this->Restaurent->getResDishes($this->request,PAGE_LIMIT_APP,$this->request['offset']);

        if(!empty($responseData) && is_array($responseData)){

            $this->offset  = count($responseData)+$this->request['offset'];

            $this->request['offset'] = $this->offset;
            $this->is_more_data =  !empty($this->Restaurent->getResDishes($this->request,PAGE_LIMIT_APP,$this->offset))?1:0;

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'category_id'=>$categoryId,'detail'=>$detail,'categories'=>$categories,'products'=>$responseData]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'category_id'=>$categoryId,'detail'=>new stdClass(),'categories'=>$categories,'products'=>$responseData]]);
        }
    }

    private function getCategories($resId){

        $join = [
                   // ['table'=>'mart_food_category b','condition'=>'FIND_IN_SET(b.category_id,a.category_id)>0 AND b.category_type=1','type'=>'INNER']

                    ['table'=>'mart_food_category b','condition'=>'FIND_IN_SET(b.category_id,a.category_id)>0 AND b.category_type=1','type'=>'INNER']
                ];

        return $this->Common_model->fetch_using_join("b.category_id,b.category_name","restaurant a",$join,['a.restaurant_id'=>$resId]);
    }



}   

