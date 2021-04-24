
<?php

/**
 * @package         modules
 * @subpackage      Business
 * @category        Controller
 * @description     User Controller / API implementation
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail extends MX_Controller {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->helper('url');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
    }
    /**
     * @name sendregisterMail
     * @descripiton Thie method is used to send otp mail
     */
    public function sendregisterMail(){

        $mailData['name']  = $_POST['name'];
        $mailData['BASE_URL']  = $_POST['BASE_URL'];
        $this->Common_model->sendmailnew($_POST['email'], 'Account Registration', '', true, $mailData, 'registration');
    }
    /**
     * @name sendOtpMail
     * @descripiton Thie method is used to send otp mail
     */
    public function sendOtpMail(){

        $mailData['name']  = $_POST['name'];
        $mailData['BASE_URL']  = $_POST['BASE_URL'];
        $mailData['otp']  = $_POST['otp'];
        $this->Common_model->sendmailnew($_POST['email'], 'One Time Password', '', true, $mailData, 'otp');
    }

    /**
     * @name sendOtpMail
     * @descripiton Thie method is used to send otp mail
     */
    public function sendPasswordMail(){

        $mailData['name']  = $_POST['name'];
        
        $mailData['password']  = $_POST['password'];
        $this->Common_model->sendmailnew($_POST['email'], 'Forgot Password', '', true, $mailData, 'password');
    }

}
