
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class Mart extends AutheticationLib {

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
        $this->load->model('Usermart_Model','Mart');
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
        $martData['banners'] = $this->Mart->getLatestMartBanners($this->request);
        $martData['all']  =  $this->Mart->getMartHomeData($this->request);
        $martData['alchohal']  =  $this->Mart->getMartHomeDataByCategory($this->request);

        if(!empty($martData) && is_array($martData)){

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['mart'=>$martData]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>[]]);
        }
    }


    public function recommend_post(){

        $this->request  = $this->post();
        $this->form_validation->set_rules('mart_name','Mart Name','trim|required');
        $this->form_validation->set_rules('location','Location','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|regex_match[/^[0-9]\d{5,16}$/]');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['mart_name','location','mobile']);
        }

        $saveData['module_name'] = $this->request['mart_name'];
        $saveData['location'] = $this->request['location'];
        $saveData['mobile'] = $this->request['mobile'];
        $saveData['created_at'] = DEFAULT_DB_DATE_TIME_FORMAT;
        $saveData['module_type'] = MART;
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
        $accessToken  = $this->getAccessToken();

        $driverId = $this->checkLogin($accessToken);
        $categoryId="";
        if(isset($this->request['category_id']) && $this->request['category_id']!=""){
            $categoryId = $this->request['category_id'];
        }

        $martcategories  = $this->getCategories($this->request['mart_id']);

        $martDetail = $this->Mart->getMartDetail($this->request,false,false,true);

        $responseData = $this->Mart->getMartProducts($this->request,PAGE_LIMIT_APP,$this->request['offset']);

        if(!empty($martDetail) && is_array($martDetail)){

            $this->offset  = count($responseData)+$this->request['offset'];


            $this->is_more_data =  !empty($this->Mart->getMartProducts($this->request,PAGE_LIMIT_APP,$this->offset))?1:0;

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'category_id'=>$categoryId,'detail'=>$martDetail,'categories'=>$martcategories,'products'=>$responseData]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('NO_DATA'),'data'=>['offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'category_id'=>$categoryId,'detail'=>(object)[],'categories'=>$martcategories,'products'=>$responseData]]);
        }
    }

    private function getCategories($martId){

        $join = [['table'=>'mart_category b','condition'=>'a.category_id=b.cat_id','type'=>'INNER']];

        return $this->Common_model->fetch_using_join("a.category_id,a.category_name","mart_food_category a",$join,['a.category_type'=>2,'b.mart_id'=>$martId]);

    }



}   

