<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$csrf = new CSRF($session_class);
$token_1 = $csrf->validate('token_login_admin_form', $_POST['token_login_admin_form']);
if ($token_1) {
} else {
    $error = true;
    $msg_response = array();
    $msg_response['status'] = "error";
    $msg_response['msg'] = "Invalid Auth-Token";
    $session_class->setValue('error', $msg_response['msg']);
    header('Location: ' . BASE_URL . 'index.php');
    exit();
}

if (isset($_POST['user_login'])) {
    if (isset($_POST['username']) and isset($_POST['password']) and $_POST['user_login']=='login' ) {

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $agent = isset($_POST['agents']) ? json_decode($_POST['agents'], true) : array();
        //var_dump($agent);
        //exit();
        if (!empty($username) and !empty($password)) {

            $password = set_password($password);
            $query = "SELECT `user_id`,`employee_id`,`card_id`,`username`,`password`,`f_name`,`m_name`,`l_name`,`suffix`,`img`,`user_role`,`status`,`locked`,`position` FROM `users` WHERE `username`='$username' LIMIT 1";
            $result = mysqli_query($db_connect, $query);
            $num_row = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $session_class->incValue('browser_attempt_login', 1);
            $error_login = false;

            if ($num_row == 0) {
                $session_class->setValue('msg_error', 'Please Check your username');
            } else if ($num_row > 0) {
                $f_name = $row['f_name'] != null || $row['f_name'] != ''  ? $row['f_name'] : '';
                $m_name = $row['m_name'] != null || $row['m_name'] != '' ? $row['m_name'] : '';
                $l_name = $row['l_name'] != null || $row['l_name'] != '' ? $row['l_name'] : '';
                $suffix = $row['suffix'] != null || $row['suffix'] != '' ? $row['suffix'] : '';
                $fullname = $f_name  . " " . ($m_name != '' ? substr($m_name, 0, 1) . '. ' : '') . $l_name . " " . $suffix;
                $position = $row['position'] != null ? $row['position'] : '';

                if ($row['status'] == 1) {
                    $session_class->setValue('msg_error', 'Deactivated Account');
                } else {

                    $row['img']  = empty(trim($row['img'])) ? "" :  $row['img'];

                    $login_attempt = 0;
                    if ($row['password'] != $password) {
                        $session_class->setValue('last_user', sha1($username));
                        $session_class->incValue("login_attempt_" . sha1($username), 1);
                        $error_login = true;
                        $session_class->setValue('msg_error', 'Please check Username and Password!');

                        $login_attempt =  $session_class->getValue('login_attempt_' . sha1($username));
                    }
                    if ($row['locked'] == 1) {
                        $session_class->setValue('msg_error', 'Account ' . var_html($username) . ' has been locked. Please reset password or Contact System Admin.!');
                    } else if (!empty($login_attempt) and $login_attempt >= 5) {
                        $session_class->setValue('msg_error', 'Account ' . var_html($username) . ' has been locked. Please reset password or Contact System Admin.!');
                        $locked_query = "UPDATE users SET locked = '1' WHERE user_id = '" . $row['user_id'] . "'";
                        if (mysqli_query($db_connect, $locked_query)) {
                        }
                    } elseif ($row['user_role'] == 1 and !$error_login) { //admin
                        $session_class->setValue('user_id', $row['user_id']);
                        $session_class->setValue('employee_id', $row['employee_id']);
                        $session_class->setValue('role_id', 'ADMIN');
                        $session_class->setValue('photo', $row['img']);
                        $session_class->setValue('fullname', $fullname);
                        $session_class->setValue('f_name', $f_name);
                        $session_class->setValue('m_name', $m_name);
                        $session_class->setValue('l_name', $l_name);
                        $session_class->setValue('suffix', $suffix);
                        $session_class->setValue('position', $position);
                        $session_class->setValue('agent_browser', $agent);
                        $fingerprint = $session_class->getValue('fingerprint');
                        $session_class->setValue('browser_fingerprint', $fingerprint);
                        $session_class->setValue('msg_success', "Welcome to EAMS");
                        $session_class->dropValue('browser_attempt_login');
                        user_log("LOGIN", $agent);
                        header("location: " . BASE_URL . "app_main/index.php"); // location to admin page
                        exit();
                    } elseif ($row['user_role'] == 2 and !$error_login) { //admin staff
                        $session_class->setValue('user_id', $row['user_id']);
                        $session_class->setValue('employee_id', $row['employee_id']);
                        $session_class->setValue('role_id', 'ADMIN_STAFF');
                        $session_class->setValue('photo', $row['img']);
                        $session_class->setValue('fullname', $fullname);
                        $session_class->setValue('f_name', $f_name);
                        $session_class->setValue('m_name', $m_name);
                        $session_class->setValue('l_name', $l_name);
                        $session_class->setValue('suffix', $suffix);
                        $session_class->setValue('position', $position);
                        $session_class->setValue('agent_browser', $agent);
                        $fingerprint = $session_class->getValue('fingerprint');
                        $session_class->setValue('browser_fingerprint', $fingerprint);
                        $session_class->setValue('msg_success', "Welcome to EAMS");
                        $session_class->dropValue('browser_attempt_login');
                        user_log("LOGIN", $agent);
                        header("location: " . BASE_URL . "app_admin/index.php");
                        exit();
                    } elseif ($row['user_role'] == 3 and !$error_login) { //onsite
                        $session_class->setValue('user_id', $row['user_id']);
                        $session_class->setValue('employee_id', $row['employee_id']);
                        $session_class->setValue('role_id', 'ONSITE');
                        $session_class->setValue('photo', $row['img']);
                        $session_class->setValue('fullname', $fullname);
                        $session_class->setValue('f_name', $f_name);
                        $session_class->setValue('m_name', $m_name);
                        $session_class->setValue('l_name', $l_name);
                        $session_class->setValue('suffix', $suffix);
                        $session_class->setValue('position', $position);
                        $session_class->setValue('agent_browser', $agent);
                        $fingerprint = $session_class->getValue('fingerprint');
                        $session_class->setValue('browser_fingerprint', $fingerprint);
                        $session_class->setValue('msg_success', "Welcome to EAMS");
                        $session_class->dropValue('browser_attempt_login');
                        user_log("LOGIN", $agent);
                        $session_class->setValue('msg_login', 'Welcome to EAMS');
                        header("location: " . BASE_URL . "app_onsite/index.php");
                        exit();
                    } elseif ($row['user_role'] == 4 and !$error_login) { //enduser
                        $session_class->setValue('user_id', $row['user_id']);
                        $session_class->setValue('employee_id', $row['employee_id']);
                        $session_class->setValue('role_id', 'END_USER');
                        $session_class->setValue('photo', $row['img']);
                        $session_class->setValue('fullname', $fullname);
                        $session_class->setValue('f_name', $f_name);
                        $session_class->setValue('m_name', $m_name);
                        $session_class->setValue('l_name', $l_name);
                        $session_class->setValue('suffix', $suffix);
                        $session_class->setValue('position', $position);
                        $session_class->setValue('agent_browser', $agent);
                        $fingerprint = $session_class->getValue('fingerprint');
                        $session_class->setValue('browser_fingerprint', $fingerprint);
                        $session_class->setValue('msg_success', "Welcome to EAMS");
                        $session_class->dropValue('browser_attempt_login');
                        user_log("LOGIN", $agent);
                        header("location: " . BASE_URL . "app_user/index.php");
                        exit();
                    }
                }
            }
        } else {
            $session_class->setValue('msg_error', 'Invalid Input');
            header("location: " . BASE_URL . "index.php");
            exit();
        }
        header("location: " . BASE_URL . "index.php");
    exit();
    }

    else if (isset($_POST['username']) and $_POST['user_login']=='reset_login' ) {
     
	
        $agent = isset($_POST['agents']) ? json_decode($_POST['agents']):array();
        $emailto = isset($_POST['username']) ? trim($_POST['username']) : '';
        $error =false;
        $reset_password ="?reset=true";
        if($emailto ==""){
            $error = true;
            $msg_response['status']="msg_error";
            $msg_response['msg']="Provide Email";
        }
        // $session_class->setValue( $msg_response['status'], $msg_response['msg']);
        // header("location: " . BASE_URL . "index.php".$reset_password);
        // exit();
        // require DOMAIN_PATH.'/call_func/Exception.php';
        // require DOMAIN_PATH.'/call_func/PHPMailer.php';
        // require DOMAIN_PATH.'/call_func/SMTP.php';
        // require DOMAIN_PATH.'/config/smtp_data.php';
        require DOMAIN_PATH.'/call_func/Exception.php';
        require DOMAIN_PATH.'/call_func/PHPMailer.php';
        require DOMAIN_PATH.'/call_func/SMTP.php';
        require DOMAIN_PATH.'/config/smtp_data.php';
        
        
        if (!filter_var($emailto, FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $msg_response['status']="msg_error";
            $msg_response['msg']="Provide Valid Email";
        }
        
        if($error == false){
            $num_row =0;
            $query = "SELECT * FROM users WHERE email_address='".escape($db_connect,$emailto)."'";
            if($result = mysqli_query($db_connect,$query)){
                $num_row = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
            }
                
            $firstname ="";
            $user_id = "";
            $user_role = "";
            if($num_row == 0){
                $msg_response['status']="msg_error";
                $msg_response['msg']="Email not found!";
            }else if( $num_row > 0 ) { 
                //found student
                $firstname = $row['f_name'];
                $user_id = $row['user_id'];
                $user_type =1;
                
                
                if($row['user_role'] == 1){
                    $user_role = "ADMIN";
                }else if($row['user_role'] == 2){
                    $user_role = "REGISTRAR";
                }else{
                    $user_role = "VPAA";
                }
                
            }else{
                $msg_response['status']="msg_error";
                $msg_response['msg']="Email not found!";
            }
          
            
            if($firstname!="" AND $user_id!=""){
              
                $n = 10;
                $code = bin2hex(openssl_random_pseudo_bytes($n/2));
        
                $exp_date = date("Y-m-d H:i:s", strtotime('+4 hours', strtotime(DATE_NOW." ".TIME_NOW)));

                $reset = "INSERT INTO reset_code(reset_code,user_id,email_address,created,expire_date,status,user_type) VALUES ('".$code."','".$user_id."','".escape($db_connect,$emailto)."','".DATE_NOW." ".TIME_NOW."','".$exp_date."','0','".$user_type."')";
                
                if( mysqli_query($db_connect,$reset)){
                    $msg_response['status']="msg_success";
                    $msg_response['msg']="Email  found!";
                }
          
                    if(mysqli_query($db_connect,$reset)){
                        $reset_id = mysqli_insert_id($db_connect);
                        $website_url = BASE_URL;
                        $link_reset =BASE_URL."reset_password.php?code=".$code;
                        $emailTo = $emailto;
                        
                        $mail = new PHPMailer;
                        $mail->isSMTP(); 
                        $mail->isHTML = true;
                        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
                        $mail->Host = SMTP_HOST;
                        $mail->Port = SMTP_PORT;
                        //$mail->SMTPSecure = SMTP_SECURE;
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->SMTPAutoTLS = false;
                            $mail->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                            )
                        );
            
                            
                        $mail->Username = SMTP_USER;
                        $mail->Password = 'wriyqnploiicrobh';
                          //Recipients
                        // $mail->AddEmbeddedImage(BASE_URL.'assets/img/logo-light.png', 'logo');
                        $mail->setFrom(SMTP_FROMEMAIL,SMTP_FROMNAME);
                        $mail->addReplyTo(SMTP_REPLYTO,SMTP_REPLYNAME);
                        $mail->addAddress($emailTo);
                        $mail->Subject = 'Password Reset Request';      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        
                        $msg_raw="<!DOCTYPE html><html lang='en'><head><title>EAMS</title></head><body>";
                        include 'reset_password_body.php';
          
                        
                        // include DOMAIN_PATH.'/app/global/reset_body.php';
                        $msg_raw .= "</body></html>";
                        $mail->msgHTML($msg_raw);
                      
                        // $mail->AltBody = $msg_text;
    
                        if(!$mail->send()){
                            $msg_response['status']="error";
                            $msg_response['msg']="Email Server Error";
                            echo "Mailer Error: " . $mail->ErrorInfo;
                            exit();
                        }else{
                        
                          
                           

                            $fingerprint = $session_class->getValue('fingerprint');
                            $session_class->setValue('agent_browser',$agent);
                            $session_class->setValue('browser_fingerprint',$fingerprint);
                            $session_class->setValue('user_id',$user_id);
                            $session_class->setValue('role_id',array($user_role));
                                                
                            $log = json_encode(array('RESET_ID'=>$reset_id,'RESET_CODE'=>$code,'USER_ID'=>$user_id,'EMAIL'=>$emailto,'DATE_TIME'=>DATE_NOW.' '.TIME_NOW,'EXP_TIME'=>$exp_date));											
                            activity_log_new("REQUEST - RESET CODE [EMAIL - ".$emailto."] - Details::".$log);	
                                                    
                            $session_class->dropValue('user_id');
                            $session_class->dropValue('role_id');
                            $session_class->dropValue('browser_fingerprint');
                            $session_class->dropValue('agent_browser');
                         
                            $msg_response['status']="ok";
                            $msg_response['title']="Email Sent!";
                            $msg_response['type']="success";
                            $msg_response['msg']="An Email has been sent to your Recovery Email Account. Please follow the instructions to proceed with the reset process!";
                            $session_class->setValue('msg_success',$msg_response['msg']);
                            $reset_password="?reset";
         
                            // $session_class->end();
                    
            
                          
                        }
                        
                }
            
            }
            
            
    
        }
    }
    if(isset($msg_response['msg']) AND $msg_response['status'] == "msg_error" ){
        $session_class->setValue('msg_error',$msg_response['msg']);
    }else if(isset($msg_response['msg']) AND $msg_response['status'] == "msg_success" ){
        $session_class->setValue('msg_success',$msg_response['msg']);

    } else if(isset($msg_response['msg']) AND $msg_response['status'] == "ok" ){
        $session_class->setValue('msg_swal',$msg_response['title']);
        $session_class->setValue('msg_swal_text',$msg_response['msg']);

    }               
    header("location: " . BASE_URL . "index.php".$reset_password);


    exit();
}
