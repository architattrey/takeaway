<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('BASE_URL')        OR define('BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/takeaway/'
);

defined('COMMON_FILE_URL')        OR define('COMMON_FILE_URL', BASE_URL.'public/');

defined('DEFAULT_DB_DATE_TIME_FORMAT')      OR define('DEFAULT_DB_DATE_TIME_FORMAT', date("Y-m-d H:i:s"));
//Limit & Status
defined('PAGE_LIMIT')        OR define('PAGE_LIMIT', 10);
defined('PAGE_LIMIT_APP')        OR define('PAGE_LIMIT_APP', 10);

defined('ACTIVE')        OR define('ACTIVE', 1);
defined('INACTIVE')        OR define('INACTIVE', 0);
defined('BLOCKED')        OR define('BLOCKED', 2);
defined('DELETED')        OR define('DELETED', 3);
defined('NOT_VERIFIED')        OR define('NOT_VERIFIED', 400);
defined('NO_ACCESS_TOKEN')        OR define('NO_ACCESS_TOKEN', 400);
defined('MALE')        OR define('MALE', 1);
defined('FEMALE')        OR define('FEMALE', 2);

defined('LOGIN_FAILED')        OR define('LOGIN_FAILED', 400);
defined('UNAUTHORIZED')        OR define('UNAUTHORIZED', 400);
defined('FAILED')        OR define('FAILED', 400);
defined('KEY_NOT_FOUND')        OR define('KEY_NOT_FOUND', 400);
defined('SUCCESS')        OR define('SUCCESS', 200);
defined('EXCEPTION')        OR define('EXCEPTION', 403);
defined('DB_ERROR')        OR define('DB_ERROR', 401);
defined('NOT_FOUND')        OR define('NOT_FOUND', 404);

//user types
defined('USER')        OR define('USER', 1);
defined('MERCHANT')        OR define('MERCHANT', 2);
defined('DRIVER')        OR define('DRIVER', 3);
defined('OTP_LENGTH')        OR define('OTP_LENGTH', 6);


defined('CAR')        OR define('CAR', 1);
defined('BIKE')        OR define('BIKE', 2);
defined('COMMON_UPLOAD_PATH')        OR define('COMMON_UPLOAD_PATH', FCPATH.'public/');

define('USER_ACCESS_TOKEN_KEY', 'access_token'); // user access token key


//modules
defined('MART')        OR define('MART', 1);
defined('RESTAURENT')        OR define('RESTAURENT', 2);

defined('ANDROID')        OR define('ANDROID', 1);
defined('IOS')        OR define('IOS', 2);

//notification
defined('NOTIFY_MART_ORDER')        OR define('NOTIFY_MART_ORDER', 1);
defined('NOTIFY_RES_ORDER')        OR define('NOTIFY_RES_ORDER', 2);
defined('IMAGE_URL')        OR define('IMAGE_URL', 'http://res.cloudinary.com/http-flynaut-com/image/upload/c_scale');


//orders
defined('PENDING')        OR define('PENDING', 1);
defined('PAID')        OR define('PAID', 2);
defined('DELIVERED')        OR define('DELIVERED', 3);
defined('CANCLED')        OR define('CANCLED', 4);


function sourceTypeList(){


	return array(0=>'News',1=>'Outdoor',2=>'Friends',3=>'radio');

}