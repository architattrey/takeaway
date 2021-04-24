<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/** 
*----API-----
*/

//user
$route['(?i)api/signup'] = 'api/signup/index';
$route['(?i)api/login'] = 'api/login/index';
$route['(?i)api/forgot-password'] = 'api/forgot/index';
$route['(?i)api/verify-otp'] = 'api/forgot/verifyOtp';
$route['(?i)api/resend-otp'] = 'api/forgot/resendOtp';
$route['(?i)api/reset-password'] = 'api/forgot/resetPassword';
$route['(?i)api/user-logout'] = 'api/userLogout/index';
$route['(?i)api/user-update-profile'] = 'api/user/user/updateProfile';
$route['(?i)api/user-change-password'] = 'api/user/user/changePassword';


//driver
$route['(?i)api/driver-logout'] = 'api/driverLogout/index';
$route['(?i)api/driver-signup'] = 'api/driverSignup/signup';
$route['(?i)api/driver-login'] = 'api/driverLogin/index';
$route['(?i)api/driver/change-password'] = 'api/driver/changePassword';
$route['(?i)api/driver-forgot-password'] = 'api/forgot/driverForgotPassword';
$route['(?i)api/add-vechicle'] = 'api/driver/addVechicle';
$route['(?i)api/add-bank-account'] = 'api/driver/addBankAccount';
$route['(?i)api/add-driver-category'] = 'api/driver/addDriverCategory';
$route['(?i)api/driver-verify-otp'] = 'api/driverForgot/verifyOtp';
$route['(?i)api/driver-resend-otp'] = 'api/driverForgot/resendOtp';
$route['(?i)api/upload-document'] = 'api/driver/uploadDocument';
$route['(?i)api/driver-update-profile'] = 'api/driver/updateProfile';
$route['(?i)api/driver-vehicle-detail'] = 'api/vehicle/vehicleDetail';
$route['(?i)api/driver-uploaded-docs'] = 'api/vehicle/uploadedDocs';
$route['(?i)api/change-vehicle'] = 'api/vehicle/changeVehicle';
$route['(?i)api/driver-change-category'] = 'api/driver/updateDriverCategory';
$route['(?i)api/driver/update-lat-lng'] = 'api/driver/home/updateLatLng';


//driver cms
$route['(?i)api/about-us'] = 'api/cms/aboutUs';

//driver home
$route['(?i)api/term-conditions'] = 'api/cms/termsConditions';
$route['(?i)api/driver/recharge-self-credit'] = 'api/driver/credit/rechargeSelfWallet';
$route['(?i)api/driver/recharge-friend-credit'] = 'api/driver/credit/rechargeFriendWallet';
$route['(?i)api/driver/requests'] = 'api/driver/request/index';
$route['(?i)api/driver/accept-order'] = 'api/driver/request/acceptRequest';
$route['(?i)api/driver/reject-order'] = 'api/driver/request/rejectRequest';
$route['(?i)api/driver/order-detail'] = 'api/driver/order/detail';
$route['(?i)api/driver/mark-order-delivered'] = 'api/driver/order/markDelivered';
$route['(?i)api/driver/order-history'] = 'api/driver/order/history';


// mart routes
$route['(?i)api/mart-home'] = 'api/user/mart/home';
$route['(?i)api/recommend'] = 'api/user/mart/recommend';
$route['(?i)api/mart-detail'] = 'api/user/mart/detail';
$route['(?i)api/recharge-self-credit'] = 'api/user/credit/rechargeSelfWallet';
$route['(?i)api/recharge-friend-credit'] = 'api/user/credit/rechargeFriendWallet';

//restaurent route
$route['(?i)api/restaurent-home'] = 'api/user/restaurent/home';
$route['(?i)api/res-recommend'] = 'api/user/restaurent/recommend';

$route['(?i)api/res-detail'] = 'api/user/restaurent/detail';
$route['(?i)api/banners'] = 'api/user/banner/index';


//common

$route['(?i)api/categories'] = 'api/category/list';

//cart
$route['(?i)api/place-order'] = 'api/user/order/placeOrder';
$route['(?i)api/make-payment'] = 'api/user/order/makePayment';
$route['(?i)api/order-detail'] = 'api/user/order/detail';
$route['(?i)api/order-list'] = 'api/user/order/list';
$route['(?i)api/user/cancel-order'] = 'api/user/order/cancelOrder';

/**
*----------Admin-------
**/
$route['(?i)admin'] = 'admin/login';
$route['(?i)admin/logout'] = 'admin/login/logout';
$route['(?i)admin/forgot-password'] = 'admin/login/forgotPassword';
$route['(?i)admin/reset-password'] = 'admin/login/resetPassword';
$route['(?i)admin/change-password'] = 'admin/profile/changePassword';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
