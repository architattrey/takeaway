
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/AutheticationLib.php';

class Order extends AutheticationLib {

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


    public function placeOrder_post(){
        // validate user login access token.
        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);
        $this->request = file_get_contents('php://input');
        
        if($this->request){
          $this->request   =json_decode($this->request,true);
        }
        

        //validating order detail
        $this->validator(['user_id','total_amount','module_id','module_type','cart'],$this->request,true);
        //validating cart detail
        //$this->validator(['item_id','item_price','item_qty'],$this->request['cart']);
        if(isset($this->request['cart']) && empty($this->request['cart'])){
            $this->response(['status_code' => 400, 'status_message' => "Cart can not be empty.",]);
        }
        $this->db->trans_begin();

        //saving order values
        $orderId = $this->insertOrderValues($this->request);
        if($orderId){

          $this->insertCartValues($this->request,$orderId);

        }

        if($this->db->trans_status()==TRUE){
            $this->db->trans_commit();
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['order_id'=>$orderId]]);
        }else{
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
        }

    }

    private function insertOrderValues($postedData){
      try{

             $userLatLng =  $this->Common_model->fetch_data("users","lat,lng",['where'=>['user_id'=>$postedData['user_id']]],true);   

            $saveData['user_id']  = $postedData['user_id'];
            $saveData['module_id']  = $postedData['module_id'];
            $saveData['module_type']  = $postedData['module_type'];
            $saveData['total_amount']  = isset($postedData['total_amount'])?$postedData['total_amount']:0;
            $saveData['estimated_amt']  = isset($postedData['estimated_amount'])?$postedData['estimated_amount']:0;
            $saveData['gst']  = isset($postedData['gst'])?$postedData['gst']:0;
            $saveData['delivery_amount']  = isset($postedData['delivery_amount'])?$postedData['delivery_amount']:0;
            $saveData['module_address']  = isset($postedData['module_address'])?$postedData['module_address']:"";
            $saveData['user_address']  = isset($postedData['user_address'])?$postedData['user_address']:"";
            $saveData['is_current_address']  = isset($postedData['is_current_address'])?$postedData['is_current_address']:0;
            $saveData['status']  = 1;
            $saveData['lat']  = isset($userLatLng['lat'])?$userLatLng['lat']:"";
            $saveData['lng']  = isset($userLatLng['lng'])?$userLatLng['lng']:"";
            $saveData['created_at']  = DEFAULT_DB_DATE_TIME_FORMAT;
            $saveData['updated_at']  = DEFAULT_DB_DATE_TIME_FORMAT;

            return $this->Common_model->insert_single('orders',$saveData);
      }catch(Exception $e){
        $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
      }
    }

    private function insertCartValues($postedData,$orderId){
      try{

          if(isset($postedData['cart']) && !empty($postedData['cart'])){
              
              foreach($postedData['cart'] as $key=>$value){

                    $saveData['order_id'] =  $orderId;
                    $saveData['item_id'] =  $value['item_id'];
                    $saveData['item_amount'] =  $value['item_price'];
                    $saveData['item_qty'] =  $value['item_qty'];
                    $saveData['status'] =  ACTIVE;
                    $saveData['created_at']  = DEFAULT_DB_DATE_TIME_FORMAT;
                    $saveData['updated_at']  = DEFAULT_DB_DATE_TIME_FORMAT;    
                    $data[] = $saveData;
                
              }

                return $this->Common_model->insert_batch('order_items',[],$data);
          }

            
      }catch(Exception $e){
        $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
      }
    }


    public function makePayment_post(){
        // validate user login access token.
        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);
        $this->request  = $this->post();
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('credit','Credit','trim|required|callback_check_available_credit');
        $this->form_validation->set_rules('order_id','Order id','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['user_id','credit','order_id']);
        }

        //check available drivers
        $this->load->model('Order_Model','Order',true);

        $driversTokens=$this->Order->getAllNearByDrivers($this->request);
        
        if(is_array($driversTokens) && empty($driversTokens)){

            $this->response(['status_code' => 1200, 'status_message' => "No drivers available for your location."]);
        }
        $this->db->trans_begin();    
        $response = $this->paymentCredit($this->request);

        if($this->db->trans_status()==TRUE){
           $this->db->trans_commit();  

           //broadcast notification request & managing order history for drivers.

           $this->sendNotificationToDrivers($this->request,$driversTokens);
           $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['credits'=>$response]]);

        }else{
            $this->db->trans_rollback();
            $this->response(['status_code' => DB_ERROR, 'status_message' => $this->lang->line('FAILED'),'data'=>new stdClass()]);
        }

    }

    private function paymentCredit($request){

        try{

            $usercredit  =$this->Common_model->fetch_data('users','wallet_credit_point as credits',['where'=>['user_id'=>$request['user_id']]],true);
            $remainingCredit = $usercredit['credits']-$request['credit'];
            $txnId  = $this->Common_model->generateTxnId($request['order_id']);

            //update order lat & lng
            if(isset($request['latitude']) && isset($request['longitude'])){

                $updateData['lat'] = $request['latitude'];
                $updateData['lng'] = $request['longitude'];
            }
            $updateData['status'] = 2;
            $updateData['txn_id'] = $txnId;
            $this->Common_model->update_single("orders",$updateData,['where'=>['order_id'=>$request['order_id']]]);
            //ends here

            $this->Common_model->update_single("users",['wallet_credit_point'=>$remainingCredit],['where'=>['user_id'=>$request['user_id']]]);            
            
            return ['credits'=>$remainingCredit,'transection_id'=>$txnId];

        }catch(Exception $e){
            $this->response(['status_code' => EXCEPTION, 'status_message' => $e->getTraceAsString()]);
        }

    }


    private function sendNotificationToDrivers($request,$driversTokens){
        $logs=[];
        
        $this->load->model('Order_Model','Order',true);

        $data =  $this->Order->getOrderForNotification($request);

        $message =ucfirst($this->loginUser->name)." sent an order to mart ".ucfirst($data['mart_name']);

        $driverids=[];
        if(!empty($driversTokens)){

            foreach ($driversTokens as $key => $value) {
                # code...
                array_push($driverids,$value['driver_id']);

                if(in_array($value['driver_id'],$driverids)){

                        $logs[] = ["sender_id" => $this->loginUser->user_id, "notification_type" => NOTIFY_MART_ORDER, "text" => $message, "receiver_id" => $value['driver_id'], "module_id" => $request['order_id'], "created_at" => DEFAULT_DB_DATE_TIME_FORMAT, "updated_at" => DEFAULT_DB_DATE_TIME_FORMAT, "is_read" => INACTIVE];

                        $history[] =  ['order_id'=>$request['order_id'],'driver_id'=>$value['driver_id']];

                }
                
            }
            if(count($logs)>0){
                $this->Common_model->insert_batch('notifications',[],$logs);    
            }
            //creating driver order history here.
            if(count($history)>0){
                $this->Common_model->insert_batch('driver_order_history',[],$history);    
            }

            $notificationData["notification_type"] = NOTIFY_MART_ORDER;
            $notificationData["sender_id"] = $this->loginUser->user_id;
            $notificationData["module_id"] = $request['order_id'];
            $notificationData["message"] = $message;
        
        
            //Push::preparingBatchDevicesForPush($driversTokens, $notificationData);
        
        }
        
    }


    public function check_available_credit(){
        $this->request  = $this->post();
        
       $isValid = CommonAction::checkAvailableCredit($this->request['user_id'],$this->request['credit']);
       if($isValid){
            return true;
       }else{

          $this->form_validation->set_message('check_available_credit', "You do not have enough credits.");
            return false;  

       }
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

        $this->validator(['order_id'],$this->request,true);
        $this->load->model("Order_Model","Order",true);

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
                


                //driver
                if($value['driver_id']!=false){
                    
                        $driver['driver_id']  = isset($value['driver_id'])?$value['driver_id']:"";
                        $driver['driver_image']  = isset($value['driver_image'])?$value['driver_image']:"";
                        $driver['driver_name']  = isset($value['driver_name'])?$value['driver_name']:"";
                        $driver['driver_mobile']  = isset($value['driver_mobile'])?$value['driver_mobile']:"";
                        $driver['driver_rating']  = isset($value['driver_rating'])?$value['driver_rating']:"";
                        $driver['vechile_id']  = isset($value['vechile_id'])?$value['vechile_id']:"";
                        $driver['vechile_name']  = isset($value['vechile_name'])?$value['vechile_name']:"";
                        $driver['vechile_color']  = isset($value['vechile_color'])?$value['vechile_color']:"";
                        $driver['vechile_number']  = isset($value['vechile_number'])?$value['vechile_number']:"";
                        $driver['vechile_type']  = isset($value['vechile_type'])?$value['vechile_type']:"";
                        $driver['vechile_model']  = isset($value['vechile_model'])?$value['vechile_model']:"";
                        $driver['vechile_category']  = isset($value['vechile_category'])?$value['vechile_category']:"";

                }
                

                unset($order['item_id'],$order['item_qty'],$order['item_amount'],$order['item_name']);

                unset($order['driver_id'],$order['driver_name'],$order['driver_image'],$order['driver_mobile'],$order['driver_rating'],$order['vechile_id']);
                unset($order['vechile_name'],$order['vechile_color'],$order['vechile_number'],$order['vechile_type'],$order['vechile_model'],$order['vechile_category'],$order['product_name']);
            }
        }
        $order['cart'] = $orderItems;
        $order['driver'] = $driver;

        $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['orders'=>$order]]);
    }


    //get order list of users
    public function list_get(){

        $this->request  = $this->get();

        // validate user login access token.
        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);

        $this->validator(['user_id'],$this->request,true);
        $this->load->model("Order_Model","Order",true);

        if(isset($this->request['order_type']) && $this->request['order_type']!=""){
            $this->request['order_type'] = $this->request['order_type'];
        }else{
            $this->request['order_type'] = DELIVERED;
        }

        $headers[0]['order_type'] = DELIVERED;
        $headers[0]['title'] = "Deals History";

        $headers[1]['order_type'] = PENDING;
        $headers[1]['title'] = "Upcoming Deals";

        $headers[2]['order_type'] = CANCLED;
        $headers[2]['title'] = "Cancelled Deals";

        $orders =$this->Order->getOrderList($this->request,PAGE_LIMIT_APP,$this->request['offset']);
        
        if(is_array($orders) && !empty($orders)){

            $this->offset = count($orders) + $this->request["offset"];
            $this->request['offset'] = $this->offset;
            $this->is_more_data  =!empty($this->Order->getOrderList($this->request,PAGE_LIMIT_APP,$this->request['offset']))?1:0;

            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['order_type'=>$this->request['order_type'],'offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'headers'=>$headers,'orders'=>$orders]]);
        }else{
            $this->response(['status_code' => SUCCESS, 'status_message' => $this->lang->line('SUCCESS'),'data'=>['order_type'=>$this->request['order_type'],'offset'=>$this->offset,'is_more_data'=>$this->is_more_data,'headers'=>$headers,'orders'=>[]]]);
        }

    }


      // method to mark order as delivered by driver.
  public function cancelOrder_post(){
    try{
        $this->request = $this->post();
        $accessToken  = $this->getAccessToken();

        $userId = $this->checkLogin($accessToken);

        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('order_id','Order_id','trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->setErrorJson(['user_id','order_id']);
        }
        
        $this->db->trans_begin();

        $this->Common_model->update_single("orders",['status'=>4],['where'=>['order_id'=>$this->request['order_id'],'user_id'=>$this->request['user_id']]]);

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

