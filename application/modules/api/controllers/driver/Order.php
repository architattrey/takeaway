
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationDriver.php';

class Order extends AutheticationDriver {

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
    *@name detail
    *@description This method is used to get details of the order.
    */
    public function detail_get(){
        
        $this->request  = $this->get();

        // validate user login access token.
        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);

        $this->validator(['order_id','driver_id'],$this->request,true);
        $this->load->model("DriverOrder_Model","Order",true);

        $orderDetails  = $this->Order->getOrderDetail($this->request);
        
        $order =$orderItems=$driver= [];
        if(!empty($orderDetails)){
            
            foreach($orderDetails as $key =>$value){

                $order = $value;
                if($value['item_id']!="" || $value['item_id']!=false ){

                       $items['item_id'] =$value['item_id'];
                        $items['item_qty'] =$value['item_qty'];
                        $items['item_amount'] =$value['item_amount'];
                        $items['item_name'] =$value['product_name']; 
                        $orderItems[] = $items;  

                }
                
                

                unset($order['item_id'],$order['item_qty'],$order['item_amount'],$order['item_name']);

            }
        }
        $order['cart'] = $orderItems;
        

        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['orders'=>$order]]);
    }


    //get order list of users
    public function history_get(){

        $this->request  = $this->get();

        // validate user login access token.
        //$accessToken  = $this->getAccessToken();

        //$userId = $this->checkLogin($accessToken);

        $this->validator(['driver_id'],$this->request,true);
        $this->load->model("DriverOrder_Model","Order",true);

        if(isset($this->request['order_type']) && $this->request['order_type']!=""){
            $this->request['order_type'] = $this->request['order_type'];
        }else{
            $this->request['order_type'] = DELIVERED;
        }

        $headers[0]['order_type'] = DELIVERED;
        $headers[0]['title'] = "Deals History";
        $headers[1]['order_type'] = 1;
        $headers[1]['title'] = "Upcoming Deals";
        $headers[2]['order_type'] = 2;
        $headers[2]['title'] = "Cancelled Deals";

        $orders =$this->Order->getDriverOrderHistory($this->request,PAGE_LIMIT_APP,$this->request['offset']);
        
        if(is_array($orders) && !empty($orders)){

            $this->offset = count($orders) + $this->request["offset"];
            $this->request['offset'] = $this->offset;
            $this->is_more_data  =!empty($this->Order->getDriverOrderHistory($this->request,PAGE_LIMIT_APP,$this->request['offset']))?1:0;

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['order_type'=>$this->request['order_type'],'offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'headers'=>$headers,'orders'=>$orders]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['order_type'=>$this->request['order_type'],'offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'headers'=>$headers,'orders'=>[]]]);
        }

    }



    // method to mark order as delivered by driver.
  public function markDelivered_post(){
    try{
        $this->request = $this->post();

        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);
        $this->form_validation->set_rules('driver_id','Driver Id','trim|required');
        $this->form_validation->set_rules('order_id','Order_id','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['driver_id','order_id']);
        }
        
        $this->db->trans_begin();

        $this->Common_model->update_single("orders",['status'=>3],['where'=>['order_id'=>$this->request['order_id'],'driver_id'=>$this->request['driver_id']]]);

        $this->Common_model->update_single("driver_order_history",['status'=>3],['where'=>['order_id'=>$this->request['order_id'],'driver_id'=>$this->request['driver_id']]]);

        if($this->db->trans_status()==true){
          $this->db->trans_commit(); 
        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['requests'=>$this->request]]);

        }else{
          $this->db->trans_rollback();
          $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
        }

    }catch(Exception $e){
        $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
    }
    
  }
}   

