<?php
require 'config/config.php';
require CONNECT_PATH;
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require VALIDATOR_PATH; // library for form validato

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require DOMAIN_PATH.'/call_func/Exception.php';
require DOMAIN_PATH.'/call_func/PHPMailer.php';
require DOMAIN_PATH.'/call_func/SMTP.php';
require DOMAIN_PATH.'/config/smtp_data.php';

$page_title ="PASSWORD RESET";
$error_encounter = false;
$message="";
$title ="";
$code =isset($_GET['code']) ? $_GET['code']:'';
$query = "SELECT reset_id,user_id,email_address,expire_date,user_type FROM reset_code WHERE reset_code='".escape($db_connect,$code)."' AND expire_date > '".DATE_NOW." ".TIME_NOW."' AND status ='0' LIMIT 1";
$data =array();
$num = 0;
if($result = mysqli_query($db_connect,$query)){
	$num = mysqli_num_rows($result);
	if($num > 0){
		$data = mysqli_fetch_assoc($result);
		$data_reset = $data;
		$num_query =0;
		$table_name ="";
		$table_id ="";
		$locked = "";
		$reset_user_role ="";
		if($data['user_type'] == 1){ // user_table
			$user = "SELECT user_id,username,f_name,email_address FROM users WHERE user_id='".$data['user_id']."' LIMIT 1";
			$table_name ="users";
			$table_id ="user_id";
			$locked = " ,locked = '0' ";
			$reset_user_role = "ADMIN";
			if($result = mysqli_query($db_connect,$user)){
				$num_query  = mysqli_num_rows($result);
			}
			$reset_user_role = "ADMIN";
		}else if($data['user_type'] == 2){ // teacher_table
			$user = "SELECT user_id,username,f_name,email_address FROM users WHERE user_id='".$data['user_id']."' LIMIT 1";
			$table_name ="teacher";
			$locked = ",locked = '0' ";
			$table_id ="teacher_id";
			$reset_user_role = "ADMIN_STAFF";
			if($result = mysqli_query($db_connect,$user)){
				$num_query  = mysqli_num_rows($result);
			}
		}else if($data['user_type'] == 3){ // student table
			$user = "SELECT user_id,username,f_name,email_address FROM users WHERE user_id='".$data['user_id']."' LIMIT 1";
			$table_name ="users";
			$table_id ="user_id";
			$locked = ",locked = '0' ";
			$reset_user_role = "ONSITE";
			if($result = mysqli_query($db_connect,$user)){
				$num_query  = mysqli_num_rows($result);
			}
		}	
	}else if($data['user_type'] == 4){ // student table
		$user = "SELECT user_id,username,f_name,email_address FROM users WHERE user_id='".$data['user_id']."' LIMIT 1";
		$table_name ="users";
		$table_id ="user_id";
			$locked = ",locked = '0' ";
			$reset_user_role = "END_USER";
			if($result = mysqli_query($db_connect,$user)){
				$num_query  = mysqli_num_rows($result);
			}
		}
		
		if($num_query > 0){
			$row = mysqli_fetch_assoc($result);
			
			if (!filter_var($row['email_address'], FILTER_VALIDATE_EMAIL)) {
				$title ="PASSWORD RESET ERROR";
				$message = "Invalid Error Provided!";
				
			}else{
			
				$update = "UPDATE reset_code SET status = '1' WHERE reset_id = '".$data['reset_id']."'";
				if($result = mysqli_query($db_connect,$update)){
					
					$text_password = bin2hex(openssl_random_pseudo_bytes(12/2));
					$new_password = sha1($text_password);
					$update = "UPDATE ".$table_name." SET password = '".$new_password."' WHERE ".$table_id." = '".$data['user_id']."'";
					if($result = mysqli_query($db_connect,$update)){
						
						$website_url = BASE_URL;
						$emailTo = $row['email_address'];
						
						$mail = new PHPMailer;
						$mail->isSMTP(); 
						$mail->isHTML = true;
						$mail->SMTPDebug = SMTP_DEBUG; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
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
						$mail->Password = SMTP_PASS;
						  //Recipients
						$mail->setFrom(SMTP_FROMEMAIL,SMTP_FROMNAME);
						$mail->addReplyTo(SMTP_REPLYTO,SMTP_REPLYNAME);
						$mail->addAddress($emailTo);
						$mail->Subject = 'Password Reset';
						
						$msg_raw="";
						$username = $row['username'];
						$firstname = $row['f_name'];
						
						$msg_raw="<!DOCTYPE html><html lang='en'><head><title>e-Guro</title></head><body>";
						
 $msg_raw .='<div style="max-width:600px;margin:0 auto;font-size:16px;line-height:24px"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> <td style="background-color:white;padding-top:30px;padding-bottom:30px"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> 
	<tr> <td align="center" style="padding-top:0;padding-bottom:20px"><a rel="nofollow" href="'.BASE_URL.'index.php" target="_blank" ><img src="'.DOMAIN_PATH.'assets/img/logo-light.png" alt="CCC LOGO" width="104" height="100" style="vertical-align:middle" data-image-whitelisted="" class="CToWUd" data-bit="iit"></a></td> </tr> 
	<tr> <td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:20px;padding-bottom:20px"><h3 style="margin-top:0;margin-bottom:0;font-family:Montserrat,Helvetica,Arial,sans-serif!important;font-weight:700;font-size:20px;line-height:30px;color:#222">We changed your password</h3> </td> </tr> 
	<tr><td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:20px"> Hi '.$firstname.',</td></tr> 
	<tr><td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:20px"> Here is your<br> Username:<strong>'.$username.'</strong><br>  New Password: <strong>'.$text_password.'</strong> </td> </tr> 
	<tr><td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:20px"> <table style="text-align:center" width="100%" border="0" cellspacing="0" cellpadding="0"> 
	<tbody><tr> <td> <div style="text-align:center;margin:0 auto">  <a rel="nofollow" style="background-color:#37a000;border:2px solid #37a000;border-radius:2px;color:#ffffff;white-space:nowrap;font-weight:bold;display:block;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:36px;text-align:center;text-decoration:none" href="'.BASE_URL.'index.php" target="_blank" >Go to Login page</a> </div> </td> </tr>
	</tbody>
</table>
</td> </tr> 
<tr><td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:20px"> This is a system-generated e-mail. Please do not reply. </td> </tr> 
<tr> <td style="font-family:Helvetica,Arial,sans-serif!important;color:black;font-size:16px;line-height:24px;padding-left:20px;padding-right:20px;padding-top:30px"> 
<div style="padding-top:10px">Thanks for your time,<br>The MIS Team</div> </td> </tr> </tbody> 
</table> 
</td></tr> </tbody> </table> </td> </tr> </tbody> 
</table>
</td> </tr> </tbody> 
</table> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody> <tr> 
<td align="center" width="100%" style="color:#656565;font-size:12px;line-height:24px;padding-bottom:30px;padding-top:30px"><div style="font-family:Helvetica,Arial,sans-serif!important">©2022-2023 e-Guro - City College of Calamba.</div></td></tr></tbody> </table> </div>';
					
						$msg_raw .= "</body></html>";
						$mail->msgHTML($msg_raw);
						// $mail->AltBody = $msg_text;

						if(!$mail->send()){
							$title ="PASSWORD RESET ERROR";
							$message = "Internal Error - Unable to send Email!";
							//echo "Mailer Error: " . $mail->ErrorInfo;
						}else{
							//echo "Message sent!";
							
							$fingerprint = $session_class->getValue('fingerprint');
							$session_class->setValue('agent_browser','NONE');
							$session_class->setValue('browser_fingerprint',$fingerprint);
							$session_class->setValue('user_id',$data_reset['user_id']);
							$session_class->setValue('role_id',array($reset_user_role));
							
							$log = json_encode(array('RESET_ID'=>$data_reset['reset_id'],'USER_ID'=>$data_reset['user_id'],'EMAIL'=>$emailTo,'DATE_TIME'=>DATE_NOW.' '.TIME_NOW));	
							if($data_reset['user_type'] == 1){
								activity_log_new("SUCCESS - RESET PASSWORD [EMAIL - ".$emailTo."] - Details::".$log);	
							}else if($data_reset['user_type'] == 2 OR $data_reset['user_type'] == 3){
								activity_log_user("SUCCESS - RESET PASSWORD [EMAIL - ".$emailTo."] - Details::".$log);	
							}
							
							$session_class->dropValue('user_id');
							$session_class->dropValue('role_id');
							$session_class->dropValue('browser_fingerprint');
							$session_class->dropValue('agent_browser');
						 
							$title ="PASSWORD RESET SUCCESSFULL";
							$message = "Your new password has been sent to your email ".$row['email_address'];
						}
						
					}else{
						$title ="PASSWORD RESET ERROR";
						$message = "Unable to reset Password - Internal Error!";
					}
				}else{
					$title ="PASSWORD RESET ERROR";
					$message = "Unable to reset Password - Internal Error!";
				}
				
			}
		}else{
			$title ="PASSWORD RESET ERROR";
			$message = "User not exists!";
		}
		
		
		
	}else{
		$title ="PASSWORD RESET ERROR";
		$message = "Link have been expired or not found!";
	}
// }else{
// 	$title ="PASSWORD RESET ERROR";
// 	$message = "Link not found!";
// }



?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
  	include DOMAIN_PATH . "/global/meta_data.php";
	  include DOMAIN_PATH . "/global/include_top.php";
?>
<style>
#password{
	-webkit-text-security:disc; 
	text-security:disc;
	-moz-text-security: disc;
}
.password_show{
	-webkit-text-security:none!important; 
	text-security:none!important;
	-moz-text-security: none!important;
}       

</style>
</head>

<body data-layout="detached">
    <!-- HEADER -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->

            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
										<form class="" name='login_form' id="login_form" action="<?php echo BASE_URL;?>app/login.php" method="POST">
										<h3 id="log_title"><?php echo $title; ?></h3>
												<div class="row">
												<div class="col-lg-12"> <?php echo $message;?></div>
												
											 </div>
										</form>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    <!-- bundle -->

</body>
<?php include DOMAIN_PATH . "/global/include_bottom.php"; ?>
<script>
</script>
</html>
