<?php
//require 'Cloudinary.php';
//require 'Uploader.php';
//require 'Api.php';

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        
    }
    /**
     * @name loadAdmin
     * @param type $page
     * @param type $data
     */
    protected function loadAdmin($page, $data) {
        $this->load->view("admin/template/login_header", $data);
        $this->load->view("admin/{$page}", $data);
        $this->load->view("admin/template/login_footer", $data);
    }
    /**
     * @name loadAdminProfile
     * @description This method is used to load all internal pages of admin.
     * @param type $page
     * @param type $data
     */
    protected function loadAdminProfile($page, $data) {
        $this->load->view("admin/template/header", $data);
        $this->load->view("admin/template/side_menu", $data);
        $this->load->view("admin/{$page}", $data);
        $this->load->view("admin/template/footer", $data);
    }
    /**
     * @name loadWeb
     * @param type $page
     * @param type $data
     */
    protected function loadWeb($page, $data) {
        $this->load->model('Cms_Model');
        $data['footerText'] = $this->Cms_Model->getPageData('footer_text');
        $data['footerAddress'] = $this->Cms_Model->getPageData('footer_address');
        $this->load->view("web/templates/header", $data);
        $this->load->view("web/{$page}", $data);
        $this->load->view("web/templates/footer", $data);
    }
    /**
     * @name isLoggedIn
     * @param N/A
     */
    function isLoggedIn() {
        $isLoggedIn = $this->session->userdata('admininfo');

        if (!isset($isLoggedIn['isLoggedIn']) || $isLoggedIn['isLoggedIn'] != TRUE) {
            redirect(base_url() . 'admin');
        }
    }
    /**
     * @name isLoggedIn
     * @param N/A
     */
    function alreadyLoggedIn() {
        $isLoggedIn = $this->session->userdata('admininfo');

        if (isset($isLoggedIn['isLoggedIn']) || $isLoggedIn['isLoggedIn'] != FALSE) {
            redirect(base_url() . 'admin/profile');
        }
    }
    /**
     * name : resize image funcction
     * description : function for cropping image with its aspect ratio
     * @param string $path
     * @param string $filename
     * @param string $size
     * @param string $MaxWidth
     * @param string $MaxHeight
     * @return boolean
     */
    function resizeImage($path, $filename, $size, $MaxWidth, $MaxHeight) {

        $SrcImage = $path . $filename;
        $DestImage = $path . $size . "/" . $filename;
        $Quality = 80;

        list($iWidth, $iHeight, $type) = getimagesize($SrcImage);
        $ImageScale = min($MaxWidth / $iWidth, $MaxHeight / $iHeight);
        $NewWidth = ceil($ImageScale * $iWidth);
        $NewHeight = ceil($ImageScale * $iHeight);
        $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);

        if (!is_dir($path . $size)) {

            @chmod($path . $size, 0777);
            @mkdir($path . $size, 0777, true);
            @chmod($path . $size, 0777);
        }

        switch (strtolower(image_type_to_mime_type($type))) {
            case 'image/jpg':
                $NewImage = imagecreatefromjpeg($SrcImage);
                break;
            case 'image/jpeg':
                $NewImage = imagecreatefromjpeg($SrcImage);
                break;
            case 'image/png':
                $NewImage = imagecreatefrompng($SrcImage);
                break;
            case 'image/gif':
                $NewImage = imagecreatefromgif($SrcImage);
                break;
            default:
                return false;
        }

        // Resize Image
        if (imagecopyresampled($NewCanves, $NewImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $iWidth, $iHeight)) {
            // copy file
            $imgtype = strtolower(image_type_to_mime_type($type));
            if ($imgtype == 'image/png') {
                imagepng($NewCanves, $DestImage);
            } else if ($imgtype == 'image/gif') {
                imagegif($NewCanves, $DestImage);
            } else {
                imagejpeg($NewCanves, $DestImage);
            }
            imagedestroy($NewCanves);
            return true;
        }
    }
    /**
     * @name getAdminProfileId
     * @description This method is used to get logedin id of user.
     */
    function getLoggedInId() {
        $isLoggedIn = $this->session->userdata('admininfo');

        if (isset($isLoggedIn['isLoggedIn']) || $isLoggedIn['isLoggedIn'] != FALSE) {
            return $isLoggedIn['id'];
        }
    }
    /**
     * @name createSlug
     * @param string string
     * @return string
     */
    public static function createSlug($string) {

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $string);
        return strtolower($slug);
    }
}