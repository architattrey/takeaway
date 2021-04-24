  <?php
  class Push{

    /**
    *@name sendFCMNotification
    *@description This method is used to send FCM notification to the android devices.
    *@param $devices
    *@param $message
    */
    public static function sendFCMNotification($devices,$message){
      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array (
          'registration_ids' => $devices,
          'data' => $message,
      );
      $data =json_encode($fields);
      $headers = array (
              'Authorization: key=' . "AAAAh-fYT5c:APA91bEnreh3hjS4kszb_6IEyNDGAh5MzUTHDroqHMw3Ti22iQxOT3AB_CXKlbgtE-F8FuT9fMFbiit27Zz_A28HewNlemNs8ggcMi5WfrbqspO6bDerNNW8FEkY19hopaBLh3TRFQtu",
              'Content-Type: application/json'
      );

      $ch = curl_init ();
      //Setting the curl url
      curl_setopt($ch, CURLOPT_URL, $url);
      //setting the method as post
      curl_setopt($ch, CURLOPT_POST, true);
      //adding headers
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //disabling ssl support
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //adding the fields in json format
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      //finally executing the curl request
      $result = curl_exec($ch);

      if ($result === FALSE) {
          die('Curl failed: ' . curl_error($ch));
      }
      //Now close the connection
      curl_close($ch);
      //and return the result


      return $result;


    }
    /**
    *@name sendAPNSNotification
    *@description This method is used to send Apple Push notification to the ios devices.
    *@param $deviceToken
    *@param $payload
    */
    public static function sendAPNSNotification($deviceToken,$payload){
         ini_set('display_errors', '1');
         $date = @strtotime(date('Y-m-d'));
         $data['aps'] = $payload;
         
         $apnsPort = '2195';

         $apnsHost = 'gateway.sandbox.push.apple.com';
         //$apnsHost = 'gateway.push.apple.com';

         $apnsCert = getcwd().'/ckpem/apns-dev-cert.pem';

         $passphrase = '';

         $ctx = stream_context_create();
         stream_context_set_option($ctx, 'ssl', 'local_cert', $apnsCert);
         stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
         //$fp = stream_socket_client( $apnsHost, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
         $fp = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
          if (!$fp)
             return false;

         $sec_payload = json_encode($data);
         $msg = chr(0) .chr(0) .chr(32) . pack('H*', $deviceToken) . pack('n', strlen($sec_payload)) . $sec_payload;
         // Send it to the server
         $result = @fwrite($fp, $msg, strlen($msg));

         if($result){
                 //echo "true";
                 //return true;
         }else {
                 //return false;
         }
         fclose($fp);
    }
    /**
    *@name preparingDevicesForPush
    *@description This method is used to prepare all device tokes for the particular device type & send to push message.
    *@param $receiverId
    *@param $notificationData
    */
    public static function preparingDevicesForPush($receiverId,$notificationData,$isMultiple=false){
              $CI = &get_instance();

              $andriodDevice = [];
              $iosDevice = [];
              $exists = [];

              if($isMultiple){

                  $devices   = $CI->Common_model->fetch_data("users_login_session","device_type,device_token",["where_in"=>["user_id"=>$receiverId],"order_by"=>["login_session_id","DESC"]]);

              }else{

                  $devices   = $CI->Common_model->fetch_data("users_login_session","device_type,device_token",["where"=>["user_id"=>$receiverId],"order_by"=>["login_session_id","DESC"]]);
              }
              for ($l = 0; $l < count($devices); $l++) {
              if ($devices[$l]["device_type"]==ANDROID && !empty(trim($devices[$l]["device_token"])) && !in_array($devices[$l]["device_token"], $exists)) {

                  $andriodDevice[] = $devices[$l]["device_token"];
                  $exists[] = $devices[$l]["device_token"];

              }elseif ($devices[$l]["device_type"]==IOS && !empty(trim($devices[$l]["device_token"]))&& !in_array($devices[$l]["device_token"], $exists)) {

                  $iosDevice [] = $devices[$l]["device_token"];
                  $exists[] = $devices[$l]["device_token"];
              }
          }
          $res = [];
          $res['data']['alert'] = $notificationData["message"];
          $res['data']['sound'] = "default";
          $res['data']['message'] = $notificationData;
          if (!empty($andriodDevice)) {
              self::sendFCMNotification($andriodDevice, $res);
          }

          if (!empty($iosDevice)) {
              krsort($iosDevice);
              foreach ($iosDevice as $dev) {
                  self::sendAPNSNotification($dev, $res['data']);
              }
          }
    }


    /**
    *@name preparingBatchDevicesForPush
    *@description This method is used to prepare all device tokes for the particular device type & send to push message.
    *@param $receiverId
    *@param $notificationData
    */
    public static function preparingBatchDevicesForPush($devices,$notificationData){
              $CI = &get_instance();

              $andriodDevice = [];
              $iosDevice = [];
              $exists = [];

            if(!empty($devices)){

                for ($l = 0; $l < count($devices); $l++) {
                    if ($devices[$l]["device_type"]==ANDROID && !empty(trim($devices[$l]["device_token"])) && !in_array($devices[$l]["device_token"], $exists)) {

                        $andriodDevice[] = $devices[$l]["device_token"];
                        $exists[] = $devices[$l]["device_token"];

                    }elseif ($devices[$l]["device_type"]==IOS && !empty(trim($devices[$l]["device_token"]))&& !in_array($devices[$l]["device_token"], $exists)) {

                        $iosDevice [] = $devices[$l]["device_token"];
                        $exists[] = $devices[$l]["device_token"];
                    }
                }
            }
          $res = [];
          $res['data']['alert'] = $notificationData["message"];
          $res['data']['sound'] = "default";
          $res['data']['message'] = $notificationData;

          if (!empty($andriodDevice)) {
              self::sendFCMNotification($andriodDevice, $res);
          }
          if (!empty($iosDevice)) {
              krsort($iosDevice);
              foreach ($iosDevice as $dev) {
                  self::sendAPNSNotification($dev, $res['data']);
              }
          }
    }

  }

   ?>
