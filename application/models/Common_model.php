<?php

class Common_model extends CI_Model {


    public $finalrole = array();

    public function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    /**
     * Fetch data from any table based on different conditions
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	array
     * @return	bool
     */
    public function fetch_data($table, $fields = '*', $conditions = array(), $returnRow = false) {

        //Preparing query
        $this->db->select($fields,false);
        $this->db->from($table);

        //If there are conditions
        if (count($conditions) > 0) {
            $this->condition_handler($conditions);
        }
        $query = $this->db->get();
        /* if($table == 'user'){
          print_r($query);die;
          } */
        //Return
        return $returnRow ? $query->row_array() : $query->result_array();
    }


     public function fetch_password_data($table, $fields = '*', $conditions = array(), $returnRow = false) {

        //Preparing query
        $this->db->select($fields,false);
        $this->db->from($table);

        //If there are conditions
        if (count($conditions) > 0) {
            $this->condition_handler($conditions);
        }
        $query = $this->db->get();
        /* if($table == 'user'){
          print_r($query);die;
          } */
        //Return
        return $returnRow ? $query->row_array() : $query->result_array();
    }

    /**
     * Insert data in DB
     *
     * @access	public
     * @param	string
     * @param	array
     * @param	string
     * @return	string
     */
    public function insert_single($table, $data = array()) {
       // pr($data);
        //Check if any data to insert
        if (count($data) < 1) {
            return false;
        }

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Insert batch data
     *
     * @access	public
     * @param	string
     * @param	array
     * @param	array
     * @param	bool
     * @return	bool
     */
    public function insert_batch($table, $defaultArray, $dynamicArray = array(), $updatedTime = false) {
        //Check if default array has values
        if (count($dynamicArray) < 1) {
            return false;
        }

        //If updatedTime is true
        if ($updatedTime) {
            $defaultArray['UpdatedTime'] = time();
        }

        //Iterate it
        foreach ($dynamicArray as $val) {
            $updates[] = array_merge($defaultArray, $val);
        }
        return $this->db->insert_batch($table, $updates);
    }

    /**
     * Delete data from DB
     *
     * @access	public
     * @param	string
     * @param	array
     * @param	string
     * @return	string
     */
    public function delete_data($table, $conditions = array()) {
        //If there are conditions
        if (count($conditions) > 0) {
            $this->condition_handler($conditions);
        }
        return $this->db->delete($table);
    }

    /**
     * Handle different conditions of query
     *
     * @access	public
     * @param	array
     * @return	bool
     */
    private function condition_handler($conditions) {
        //Where
        if (array_key_exists('where', $conditions)) {

            //Iterate all where's
            foreach ($conditions['where'] as $key => $val) {
                $this->db->where($key, $val);
            }
        }

        //Where OR
        if (array_key_exists('or_where', $conditions)) {

            //Iterate all where or's
            foreach ($conditions['or_where'] as $key => $val) {
                $this->db->or_where($key, $val);
            }
        }

        //Where In
        if (array_key_exists('where_in', $conditions)) {

            //Iterate all where in's
            foreach ($conditions['where_in'] as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }

        //Where Not In
        if (array_key_exists('where_not_in', $conditions)) {

            //Iterate all where in's
            foreach ($conditions['where_not_in'] as $key => $val) {
                $this->db->where_not_in($key, $val);
            }
        }

        //Having
        if (array_key_exists('having', $conditions)) {
            $this->db->having($conditions['having']);
        }

        //Group By
        if (array_key_exists('group_by', $conditions)) {
            $this->db->group_by($conditions['group_by']);
        }

        //Order By
        if (array_key_exists('order_by', $conditions)) {

            //Iterate all order by's
            foreach ($conditions['order_by'] as $key => $val) {
                $this->db->order_by($key, $val);
            }
        }

        //Order By
        if (array_key_exists('like', $conditions)) {

            //Iterate all likes
            foreach ($conditions['like'] as $key => $val) {
                $this->db->like($key, $val);
            }
        }

        //Limit
        if (array_key_exists('limit', $conditions)) {

            //If offset is there too?
            if (count($conditions['limit']) == 1) {
                $this->db->limit($conditions['limit'][0]);
            } else {
                $this->db->limit($conditions['limit'][0], $conditions['limit'][1]);
            }
        }
    }

    /**
     * Update Batch
     *
     * @access	public
     * @param	string
     * @param	array
     * @return	boolean
     */
    public function update_batch_data($table, $defaultArray, $dynamicArray = array(), $key) {
        //Check if any data
        if (count($dynamicArray) < 1) {
            return false;
        }

        //Prepare data for insertion
        foreach ($dynamicArray as $val) {
            $data[] = array_merge($defaultArray, $val);
        }
        return $this->db->update_batch($table, $data, $key);
    }

    /**
     * Update details in DB
     *
     * @access	public
     * @param	string
     * @param	array
     * @param	array
     * @return	string
     */
    public function update_single($table, $updates, $conditions = array()) {
        //If there are conditions
        if (count($conditions) > 0) {
            $this->condition_handler($conditions);
        }
        return $this->db->update($table, $updates);
    }

    public function updateTableData($data, $tableName, $where) {
        $this->db->set($data);
        foreach ($where as $key => $value) {
            $this->db->where($key, $value);
        }
        if (!$this->db->update($tableName)) {
            throw new Exception("Update error");
        } else {
            return true;
        }
    }

    /**
     * Count all records
     *
     * @access	public
     * @param	string
     * @return	array
     */
    public function fetch_count($table, $conditions = array()) {
        $this->db->from($table);
        //If there are conditions
        if (count($conditions) > 0) {
            $this->condition_handler($conditions);
        }
        return $this->db->count_all_results();
    }

    /**
     * For sending mail
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	string
     * @param	boolean
     * @return	array
     */
    public function sendmailnew($email, $subject, $message = false, $single = true, $param = false, $templet = false) {
        if ($single == true) {
            $this->load->library('email');
        }

        $this->config->load('email');
        $this->email->from($this->config->item('from'), $this->config->item('from_name'));
        $this->email->reply_to($this->config->item('reply_to'), $this->config->item('reply_to_name'));
        $this->email->to($email);
        $this->email->subject($subject);
        if ($param && $templet) {
            $body = $this->load->view('mail/' . $templet, $param, TRUE);
            $this->email->message($body);
        } else {
            $this->email->message($message);
        }
        return $this->email->send() ? true : false;
    }

    /**
     * For sending mail
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	string
     * @param	boolean
     * @return	array
     */
    public function sendmail($email, $subject, $message = false, $single = true, $param = false, $templet = false) {

        if ($single == true) {
            $this->load->library('email');
        }
        $this->config->load('email');
        $this->email->set_newline("\r\n");
        $this->email->from($this->config->item('from_name'), $this->config->item('From'));
        $this->email->reply_to($this->config->item('Reply-To'), $this->config->item('reply_to_name'));

        $email1 = $this->email->to($email);
        $this->email->subject($subject);
        if ($templet) {

            $this->email->message($templet);
        } else {

            $this->email->message($message);
        }
        return $this->email->send() ? true : false;
    }

    function mcrypt_data($input) {
        /* Return mcrypted data */
        $key1 = "ShareSpark";
        $key2 = "Org";
        $key = $key1 . $key2;
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $input, MCRYPT_MODE_CBC, md5(md5($key))));
        //var_dump($encrypted);
        return $encrypted;
    }

    function demcrypt_data($input) {
        /* Return De-mcrypted data */
        $key1 = "ShareSpark";
        $key2 = "Org";
        $key = $key1 . $key2;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $decrypted;
    }

    function bcrypt_data($input) {
        $salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
        $hash = crypt($input, '$2a$12$' . $salt);
        return $hash;
    }

    public function simplify_array($array, $key) {
        $returnArray = array();
        foreach ($array as $val) {
            $returnArray[] = $val[$key];
        }
        return $returnArray;
    }

    //Validate date
    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function checkParameters($arrdata) {
        foreach ($arrdata as $key => $ar) {
            if ($ar[$key] == '') {

                return false;
            }
        }
    }

    public function sendMailToUser($email, $message, $subject = 'No Subject', $from = FROM, $replyTo = NO_REPLY) {
        $extraKey = '-f' . $replyTo;

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $from . ' <' . $replyTo . '>' . "\r\n";

        if (is_array($message)) {
            $message = json_encode($message);
        }

        return mail($email, $subject, $message, $headers, $extraKey);

        /* $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'mail.applaurels.com',
          'smtp_port' => 25,
          'smtp_user' => 'noreply@applaurels.com',
          'smtp_pass' => 'noreply@321',
          'mailtype'  => 'html',
          'charset'   => 'iso-8859-1'
          );
          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");

          // Sender email address
          $this->email->from(NO_REPLY, FROM);
          // Receiver email address
          $this->email->to($email);
          // Subject of email
          $this->email->subject($subject);
          // Message in email
          $this->email->message($message);

          $result = $this->email->send(); */
    }

    /**
     * @name  fetch_using_join
     * @description fetch data from join
     * @param string $select
     * @param string $from
     * @param string $joinCondition
     * @param string $joinType
     * @param string $where
     * @return arrray
     */
    public function fetch_using_join($select, $from, $join, $where, $asArray = NULL, $offset = NULL, $orderBy = NULL, $limit = NULL) {

        $this->db->select($select, FALSE);
        $this->db->from($from);
        for ($i = 0; $i < count($join); $i++) {
            $this->db->join($join[$i]["table"], $join[$i]["condition"], $join[$i]["type"]);
        }
        $this->db->where($where);
        if (isset($orderBy['order']) && $orderBy !== NULL) {
            $this->db->order_by($orderBy["order"], $orderBy["sort"]);
        }

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return ($asArray !== NULL) ? $query->row() : $query->result_array();
    }

    /**
     * @name rawquery
     * @access public
     * @description  Performs raw query. Optionally gives in array or object format
     * @return array/object
     */
    public function rawquery($data, $resultArray = NULL) {
        $query = $this->db->query($data);
        return ($resultArray !== NULL) ? $query->result_array() : $query->row();
    }

    /**
     * @name uploadfile
     * @param type $filename
     * @param type $filearr
     * @param type $restype
     * @param type $foldername
     * @return boolean
     */
    public function uploadfile($filename = '', $filearr, $restype = 'name', $foldername = '', $allowedType = NULL) {

        if (!is_dir(COMMON_UPLOAD_PATH . '/' . $foldername)) {
            mkdir(COMMON_UPLOAD_PATH . '/' . $foldername);
            chmod(COMMON_UPLOAD_PATH . '/' . $foldername, 0755);
        }

        if ($filearr[$filename]['name'] != '') {
            $config['upload_path'] = COMMON_UPLOAD_PATH . $foldername;
            if (!empty($allowedType)) {
                $config['allowed_types'] = $allowedType;
            } else {
                $config['allowed_types'] = '*';
            }
            $new_name = date('Y/m/d') . '_' . time() . '_' . $filearr[$filename]['name'];
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload($filename)) {
                $res = $this->upload->data();
                if ($restype == 'name') {
                    unset($foldername);
                    return $res['file_name'];
                } elseif ($restype == 'url') {
                    return COMMON_FILE_URL . $foldername . '/' . $res['file_name'];
                }
            } else {
                return false;
            }
        }
    }

    /**
     * @name createvideothumb
     * @param type $vidurl
     * @param type $restype
     * @param type $foldername
     * @return string
     */
    public function createvideothumb($vidurl, $restype = 'name', $foldername) {

        $newthumbnail = time() . '_video_thumbnail.jpg';
        $thumbnail = getcwd() . $foldername . '/' . $newthumbnail;

        // shell command [highly simplified, please don't run it plain on your script!]
        shell_exec("ffmpeg -i $vidurl -deinterlace -an -ss 11 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
        
        if ($restype == 'name') {
            return $newthumbnail;
        } else if ($restype == 'url') {
            return base_url() . $foldername . '/' . $newthumbnail;
        }
    }

    /**
     * @name createImagethumb
     * @param type $filename
     * @param type $restype
     * @param type $foldername
     * @return string
     */
    public function createImagethumb($filename, $restype = 'name', $foldername) {

        $newthumbnail = date('Y/m/d') . time() . '_image_thumbnail.jpg';
        $thumbnail = COMMON_UPLOAD_PATH . $foldername . '/' . $newthumbnail;

        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => COMMON_UPLOAD_PATH . $foldername . '/' . $filename,
            'new_image' => $thumbnail,
            'maintain_ratio' => False,
            'create_thumb' => False,
            'width' => 100,
            'height' => 100
        );
        $this->load->library('image_lib');
        $this->image_lib->initialize($config_manip);
        //$this->load->library('image_lib', $config_manip);

        if ($this->image_lib->resize()) {
            return $newthumbnail;
        }
        $this->image_lib->clear();
    }

    /**
     * @name  insertAll
     * @description function for insert_batch
     * @param string $table
     * @param array $data
     * @return boolean
     */
    public function insertAll($table, $data) {

        return $this->db->insert_batch($table, $data);
    }

    /**
     *
     * @param type $to
     * @param type $body
     */
    public function sendsmsbytwillio($To, $message) {
        $To = $To;
        $from = "+12016764982";
        $id = "AC1bf83dd5e59115e430838752ff9682b7";
        $token = "83f14f7095c6fb56a16d51f058f09125";
        $y = exec("curl 'https://api.twilio.com/2010-04-01/Accounts/$id/Messages.json' -X POST \--data-urlencode 'To=+$To' \--data-urlencode 'From=+$from' \--data-urlencode 'Body=$message' \-u $id:$token");
        //echo json_encode($y);
    }

    public function uploadImagefile($filename = '', $filearr, $restype = 'name', $foldername = '', $uploadPath = NULL, $allowedType = NULL) {

        if (!is_dir($uploadPath . '/' . $foldername)) {
            mkdir($uploadPath . '/' . $foldername);
            chmod($uploadPath . '/' . $foldername, 0755);
        }

        if ($filearr[$filename]['name'] != '') {
            $config['upload_path'] = $uploadPath . $foldername;
            if (!empty($allowedType)) {
                $config['allowed_types'] = $allowedType;
            } else {
                $config['allowed_types'] = '*';
            }
            //$new_name = date('Y/m/d').'_'.time().'_'.$filearr[$filename]['name'];
            $new_name = date('Y/m/d') . '_' . time() . '_' . $this->removeSpace($filearr[$filename]['name']);
            $config['file_name'] = $new_name;
            $filearr[$filename]['tmp_name'] = $new_name;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($filename)) {
                $res = $this->upload->data();

                if ($restype == 'name') {
                    unset($foldername);
                    return $res['file_name'];
                } elseif ($restype == 'url') {
                    return COMMON_FILE_URL . $foldername . '/' . $res['file_name'];
                }
            } else {
                return false;
            }
        }
    }

    public function removeSpace($str) {

        return str_replace(' ', '', $str);
    }

// check Age for user
    /*
     * Checks for valid date and age
     *
     * @access public
     *
     * @param int $day Day
     * @param int $month Month
     * @param int $year Year
     * @param int $requiredAge Minimum Required Age, defaults to 18
     *
     * @return array An array with "error" status and relavent message
     */
    public function checkAge($day, $month, $year, $requiredAge = 18) {
        $returnArray = [];
        if (checkdate($month, $day, $year)) {
            $age = ( ( ( (time() - strtotime("{$year}-{$month}-{$day}"))/* timestamp */ / 365 )/* 365 */ / 24 )/* 24 */ / 60 )/* 60 */ / 60;

            if ($age < $requiredAge) {
                $returnArray = [
                    "error" => true,
                    "message" => "underage"
                ];
            } else {
                $returnArray = [
                    "error" => false,
                    "data" => $age,
                    "message" => "success"
                ];
            }
        } else {
            $returnArray = [
                "error" => true,
                "message" => "invalid date"
            ];
        }

        return $returnArray;
    }

    /*
     * Inserts Data into database but throws exception
     *
     * @param array $data Data to be inserted into database
     * @param string $tableName Table Name
     * @param bool $returnLastInsertId Return Last Insert Id when set to true
     *
     * @returns bool|int|string Returns TRUE|Last Insert Id on successful insertion, FALSE otherwise.
     */

    public function insertTableData($data, $tableName, $returnLastInsertId = false) {
        if ($this->db->set($data)->insert($tableName)) {

            if ($this->db->affected_rows()) {
                if ($returnLastInsertId == true) {
                    return $this->db->insert_id();
                } else {
                    return true;
                }
            } else {
                throw new Exception("Insert Error");
            }
        } else {
            throw new Exception("Insert Error");
        }
    }

    /* notification table insert data */

    public function notificationTable($notificationData) {
        try {
            $id = $this->insertTableData($notificationData, "user_notification", true);
            return $id;
        } catch (Exception $error) {
            throw new Exception($error . " - Notification Table");
        }
    }

    /**
     * Generates unique token
     * @return array
     */
    public function generateRandomTokenPair() {
        $uniqueToken = uniqid("", true);
        $uniqueToken = hash("sha1", $uniqueToken);

        $tokenPair = [
            $uniqueToken,
            base64_encode($uniqueToken)
        ];

        return $tokenPair;
    }

    function paginaton_link_custom($total_rows, $pageurl, $limit = 2, $per_page = 1) {
        $ci = & get_instance();
        $current_page_total = $limit * $per_page;
        $current_page_start = ($current_page_total - $limit) + 1;
        if ($current_page_total > $total_rows) {
            $current_page_start = ($current_page_total - $limit) + 1;
            $current_page_total = $total_rows;
        }
        $config['total_rows'] = $total_rows;
        $config['base_url'] = base_url() . $pageurl;
        $config['per_page'] = $limit;
        $config['full_tag_open'] = "<div class='col-sm-5 text-left'><small class='text-muted inline m-t-sm m-b-sm'>Showing $current_page_start to $current_page_total of $total_rows entries  </small></div><div class='col-sm-7 text-right text-center-xs'> <ul class='pagination pagination-lg'>";
        $config['full_tag_close'] = "</ul> </div>";
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 20;
        $config['uri_segment'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['cur_tag_open'] = '<li class="pages active"><a href="javascript:void(0);"  style="background-color:#007775;" class="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '>';
        $config['next_tag_open'] = '<li class="pages">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page_last_tag">';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="disabled"><a href="javascript:void(0)"><i class="fa fa-step-backward" aria-hidden="true">';
        $config['first_tag_close'] = '</i></a></li>';
        $config['num_link'] = '<a href="javascript:void(0);" class=""></a>';
        $config['num_tag_open'] = '<li class="pag_num_tag">';
        $config['num_tag_close'] = '</a></li>';

        $ci->pagination->initialize($config);
        $pagination = $ci->pagination->create_links();
        return $pagination;
    }

    public function encrypt($source) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
            $output = openssl_encrypt($source, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        
            
        
        return $output; 
       //return $this->encryption->encrypt($source);
    }

    public function decrypt($source) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return openssl_decrypt(base64_decode($source), $encrypt_method, $key, 0, $iv);
        //return $this->encryption->decrypt($source);
    }

    /**
     *
     * @param type $digits
     * @return type
     */
    public function generateOtp($digits) {

        return str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    }

    public function s3_uplode($key = null, $files) {
        if (isset($files[$key]) && !empty($files[$key])) {

            $bucketName = $this->config->item('s3_bucket_name');
            $s3_access_key = $this->config->item('s3_access_key');
            $s3_secret_key = $this->config->item('s3_secret_key');

            S3::setAuth($s3_access_key, $s3_secret_key);

            $fileName = time() . $this->removeSpace($files[$key]['name']);
            $fileUrl = AMAZON_URL . AMAZON_FOLDER_NAME . "/" . $this->removeSpace($fileName);

            if (S3::putObject(S3::inputFile($files[$key]['tmp_name'], false), $bucketName . '/' . AMAZON_FOLDER_NAME, $fileName, S3::ACL_PUBLIC_READ)) {

                return $fileUrl;
            } else {

                return FALSE;
            }
        }
    }
    
    function s3_uplode_thumb($filename, $temp_name) {
        $s3 = new S3();
        $name = explode('.', $filename);
        $ext = array_pop($name);
        
        $name = 'blog' . uniqid() . strtotime("now") . '.' . $ext;
        $bucketName = $this->config->item('s3_bucket_name');
        $s3_access_key = $this->config->item('s3_access_key');
        $s3_secret_key = $this->config->item('s3_secret_key');

        S3::setAuth($s3_access_key, $s3_secret_key);
        $imgdata = $temp_name;
        
        $uri = AMAZON_FOLDER_NAME.'/'. $name;
        $mediaurl = AMAZON_URL . AMAZON_FOLDER_NAME . "/" . $this->removeSpace($name);
        
        if (S3::putObject(S3::inputFile($temp_name, false), $bucketName . '/' . AMAZON_FOLDER_NAME, $name, S3::ACL_PUBLIC_READ)) {

            return $mediaurl;
        } else {

            return FALSE;
        }
    }

    /**
     * @name getUniqueAlphaNumericCode
     * @param type $length
     * @return type
     */
    public function getUniqueAlphaNumericCode($length = "") {
        return md5(time());
    }

    public function removeCharacter($str) {

        return ucwords(str_replace('_', ' ', $str));
    }
    
    public function setTime($time,$format,$timeZone){
        
        $UTC = new DateTimeZone("UTC");
        $newTZ = new DateTimeZone($timeZone);
        $date = new DateTime( $time , $UTC );
        $date->setTimezone( $newTZ );
        
        return $time =  $date->format($format);

    }
    
     public function setUtcTimeinLocal($time,$format,$timeZone){
       $dt = new DateTime($timeZone);
       $tz = new DateTimeZone('Asia/Kolkata'); // or whatever zone you're after
       $dt->setTimezone($tz);
       $dt->format('Y-m-d H:i:s');
        return $time =  $dt->format($format);

    }


    public function setDate($date,$format="d/m/Y H:i:a"){

        return date($format,strtotime($date));
    }

    public function generateTxnId($id){
     return $id.time().uniqid(mt_rand(),true);  
    }
    
}
