<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends  MY_Controller{

	protected $data = array();
	private $where = array();
	protected $params = array();


	function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
        $this->load->model('Orders_Model', 'Orders');
        $this->load->library('session');
        $this->lang->load('common', "english");
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->isLoggedIn();
        $this->_loginId = $this->getLoggedInId();
           
    }

	public function index()
	{
       $get = $this->input->get();
       
      // pr($get);
          
        $moduleType =  (isset($get['module_type']) && !empty($get['module_type'])) ? $this->Common_model->decrypt($get['module_type']) : show_404();
        $this->data['module_type'] = $this->where['module_type'] = isset($moduleType) ? trim($moduleType) : '';
         // filter &search
     
        $this->data['search'] =     $this->params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $this->data['status'] =     $this->params['status'] = isset($get['status']) ? trim($get['status']) : '';
        $this->data['from']   =     $this->params['from'] = isset($get['from']) ? $get['from'] : '';
        $this->data['to']     =     $this->params['to'] = isset($get['to']) ? $get['to'] : '';
        $this->params['from'] = !empty($this->params['from']) ? date("Y-m-d", strtotime($this->params['from'])) : '';
        $this->params['to'] = !empty($this->params['to']) ? date("Y-m-d", strtotime($this->params['to'])) : '';
        $isExport = (isset($get['export']) && !empty($get['export'])) ? $get['export'] : "";
        $this->data['limit'] = $limit = (isset($get['pagecount']) && !empty($get['pagecount'])) ? $get['pagecount'] : PAGE_LIMIT;
        $this->data['page'] = $page = (isset($get['per_page']) && !empty($get['per_page'])) ? $get['per_page'] : 1;
        //fetching category list Data.
        $this->data['orders'] = $this->Orders->getOrdersList($this->params, $limit, $offset = ($page - 1) * $limit,$this->where);
        $pageurl = 'admin/MartOrders';
       // $this->data["link"] = $this->Common_model->paginaton_link_custom($this->data['orders']['count'], $pageurl, $limit, $page);
        /* CSRF token */
        $this->data["csrfName"] = $this->security->get_csrf_token_name();
        $this->data["csrfToken"] = $this->security->get_csrf_hash();
       // pr($this->data['orders']);

        $this->loadAdminProfile('orders/orderslist', $this->data);

	}

    public function detail()
    {
        $req = $this->input->get();
    

        $orderId = (isset($req) && !empty($req))?$this->Common_model->decrypt($req['order_id']):show_404();
        if (is_numeric($orderId)&&  $this->data['detail'] = $this->getOrdersDetail($orderId)) {
                  
                  $this->loadAdminProfile('orders/ordersdetail', $this->data);
            }
            
         ///// error is founded page not found   url comes on this function but error occured 
          else {

             show_404();
         }
    }
    public function getOrdersDetail($orderId)
    {
       return $this->Orders->fetchOrdersDetail($orderId, true);
    } 
    
}
?>
