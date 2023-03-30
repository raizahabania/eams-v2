<?php
define ('LOGIN_AUTH',true);
/**
 * Create, or retrieve, the session variable.
 */


$s_user_id = $session_class->getValue('user_id');
if (!isset($s_user_id)) { // hindi naka login
	header("Location: ".BASE_URL."index.php");
	exit();
}

$employee_id = $session_class->getValue('employee_id');


$url = page_url();
if (empty($session_class->getValue('page_path'))) {
    $session_class->setValue('page_path',$url);
}

$g_user_role = $session_class->getValue('role_id');
if (!isset($g_user_role) OR empty($g_user_role)) {
	$session_class->end();
	include HTTP_401;
	exit();
}

$global_profile_pic = $session_class->getValue('photo');
if (!isset($global_profile_pic) OR empty($global_profile_pic)) {
	$table_pic = "";
	$tb_id="";
	if($g_user_role[0] == "ADMIN"){ 
		$table_pic = "users";
		$tb_id="user_id";
	}
	$get_path = get_profile_pic($s_user_id,$tb_id,$table_pic);
	//echo $get_path."SS";
	if(empty(trim($get_path))){
		$get_path = BASE_URL."images/placeholder.png";
	}
	$session_class->setValue('photo',$get_path);
    $global_profile_pic = $get_path;
}

$global_fy = array();
$global_my_class = array();
$g_user_name = $session_class->getValue('name');

function return_role($user_role){
	if ($user_role == "ADMIN") {
		header("Location: " . BASE_URL . "app_main/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	} elseif ($user_role == "ADMIN_STAFF") {
		header("Location: " . BASE_URL . "app_admin/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	} elseif ($user_role == "ONSITE") {
		header("Location: " . BASE_URL . "app_onsite/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	} elseif ($user_role == "END_USER") {
		header("Location: " . BASE_URL . "app_user/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	}
}

?>