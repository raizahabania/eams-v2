<?php
//date_default_timezone_set('UTC');
define("DOMAIN_PATH", dirname(__DIR__));
define("UPLOAD_PATH", DOMAIN_PATH . '/upload/files');
define("DEFAULT_TIMEZONE", 'Asia/Manila');
define("LANG", 'en');
define("META_AUTHOR", '');
define("META_DESC", '');

$url =  base_url();
$active_page = active_page();
define("BASE_URL", $url);
define("ACTIVE_PAGE", $active_page);
ini_set('date.timezone', DEFAULT_TIMEZONE);
date_default_timezone_set(DEFAULT_TIMEZONE);

// limit fetch data
define('QUERY_LIMIT', 20);

define('YEAR', date('Y'));
define('MONTH', date('m'));
define('DAY', date('d'));
define('DATE_NOW', date('Y-m-d'));
define('TIME_NOW', date('H:i:s'));
define("DATE_TIME", DATE_NOW . " " . TIME_NOW);
define('PAGE_TITLE', 'EAMS');
define('FILE_VERSION', '1.0.1');


//function path
define('CL_SESSION_PATH', DOMAIN_PATH . '/call_func/cl_session.php');
define('CONNECT_PATH', DOMAIN_PATH . '/call_func/connect.php');
define('VALIDATOR_PATH', DOMAIN_PATH . '/call_func/validator.php');
define('GLOBAL_FUNC', DOMAIN_PATH . '/call_func/global_func.php');
define('ALERT_SESSION', DOMAIN_PATH . '/call_func/alert_session.php');
define('FOOTER_PATH', DOMAIN_PATH . '/global/footer.php');
##define('MENU' , DOMAIN_PATH.'/admin/menu.php');
define('ISLOGIN', DOMAIN_PATH . '/call_func/islogin.php');
define('PASSWORD_HELPER', DOMAIN_PATH . '/call_func/password_helper.php');

define('EMPLOYEE_TABLE','users'); //employee table
//global var

// file format
define('EMP_SCHED_LIST', 'emp_sched_list.csv');
define('EMP_ATTENDANCE_RECORD_LIST', 'emp_attendance_record_list.csv');

define('DEFAULT_SESSION', 'web_session');
define('SESSION_CONFIG', array('name' => DEFAULT_SESSION, 'path' => '/', 'domain' => '', 'secure' => false, 'bits' => 4, 'length' => 32, 'hash' => 'sha256', 'decoy' => true, 'min' => 60, 'max' => 600, 'debug' => false));
define('SALT', '1234TREWPOIUYT_'); //change me

function page_url()
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $actual_link;
}

function active_page()
{
    $actual_link = basename($_SERVER['PHP_SELF'], ".php");
    return $actual_link;
}


function base_url()
{
    // first get http protocol if http or https
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    $base_url .= "localhost/eams/"; #change to localhost or domain
    return $base_url;
}

