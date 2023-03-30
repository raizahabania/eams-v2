<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validato

$page_title = "ADMIN LOGIN";
$page_id = "";
$error_encounter = false;


$g_user_role = $session_class->getValue('role_id');
if (isset($g_user_role) OR !empty($g_user_role)) {
	if (($g_user_role == "ADMIN_STAFF")) {
		header("Location: ".BASE_URL."app_admin/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	}
	if (($g_user_role == "END_USER")) {
		header("Location: ".BASE_URL."app_user/index.php"); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
		exit();
	}
	
}
$g_user_role = $session_class->getValue('role_id');
if ($g_user_role == NULL) {
	$g_user_role = [""];
}


// include "redirect.php";

$csrf = new CSRF($session_class);

$last_user = $session_class->getValue('last_user');
$login_attempt = 0;
if (!empty($last_user)) {
	$login_attempt = $session_class->getValue('login_attempt_' . $last_user);
}

// $browser_attempt = $session_class->getValue('browser_attempt_login');
// if (empty($browser_attempt)) {
// 	$browser_attempt = 0;
// }


// if ($browser_attempt >= 30) {
// 	$mod_msg['title'] = "Login Disabled";
// 	$mod_msg['subtitle'] = 'Login Attempt exceed.<br>Please wait for a moment to be allowed again.';
// 	include MOD_404;
// 	exit();
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
		#password {
			-webkit-text-security: disc;
			text-security: disc;
			-moz-text-security: disc;
		}

		.password_show {
			-webkit-text-security: none !important;
			text-security: none !important;
			-moz-text-security: none !important;
		}

		.logo-img {
			max-height: 100px;
			;
		}

		/* .logo-img {
			width: 150px;
		}
		@media only screen and (max-width: 321px) {
			.logo-img {
				width: 100px;
			}
		}
		@media only screen and (max-width: 769px) {
			.logo-img {
				width: 100px;
			}
		}
		@media only screen and (max-width: 1025px) {
			.logo-img {
				width: 120px;
			}
		} */
	</style>
</head>

<body data-layout="detached" class="bg-light">
	<!-- HEADER -->
	<div class="container-fluid active">
		<div class="wrapper in">
			<div class="content-page">
				<div class="content">
					<!-- BEGIN PlACE PAGE CONTENT HERE -->
					<div class="row justify-content-center mt-5 mx-auto">
						<div class="col-lg-4 col-md-8 card shadow-lg o-hidden border-0 my-5">
							<div class="pt-3 px-lg-4 px-md-3 px-3">
								<div class="row text-center">
									<div class="block-heading mb-0 text-center">
										<img src="<?php echo BASE_URL; ?>assets/img/logo-light.png" class="logo-img">
									</div>
									<div>
										<h5 class="text-dark mb-4 text-center">Employee Attendance Monitoring System</h5>
									</div>
								</div>
								<div>
									<form class="user" name='login_form' id="login_form" action="<?php echo BASE_URL; ?>login.php" method="POST">
										<h6 class="text-dark" id="log_title">SIGN-IN</h6>
										<div class="row">
											<div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2">
												<input type="text" class="form-control" name="username" id="username" value="" placeholder="Username" required>
											</div>
											<div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2" id="password_div">
												<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
												<div style="text-align:right;">
													<span class="text-dark" style="font-size:10pt;">Login Attempts: <?php echo $login_attempt; ?></span>
												</div>
											</div>
											<div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2" id="forgotlogin">
												<a href="#" id="forgot_action"> <i class="bi-question-octagon-fill"></i><span> Forgot Password</span> </a>
											</div>
											<div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2" id="backlogin" style="display:none;">
												<a href="#" id="back_login"> <i class="bi-caret-left-fill"></i><span> Back to Login</span> </a>
											</div>
											<div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2">
												<button type="submit" id="btn_submit" name="user_login" value="login" class="btn btn-primary d-block btn-user w-100">LOGIN</button>
											</div>
											<?php echo $csrf->input('token_login_admin_form', 'token_login_admin_form', 3600, 1); ?>
										</div>
									</form>
								</div>
							</div>
							<div class="bg-white w-100">
								<div class=" mt-auto bg-white">
									<div class="container my-auto py-2">
										<hr>
										<div class="copyright text-center my-auto mb-2">
											<span>&copy; 2021-<?php echo date('Y'); ?> City College of Calamba</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PLACE PAGE CONTENT HERE -->
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
	</div>
	<!-- all the js files -->
</body>
<?php
include DOMAIN_PATH . "/global/include_bottom.php";
include ALERT_SESSION;
?>

<script>
	<?php
	$msg_response = $session_class->getValue('login_status');
	if (isset($msg_response) && $msg_response != "") {
		$title = $session_class->getValue('login_status');
		$icon = $session_class->getValue('login_icon');
		echo 'msg_alert("' . $title . '","' . $icon . '");';
		$session_class->dropValue('login_status');
		$session_class->dropValue('login_icon');
	} ?>
		(function() {
			var global_action = "";
			const back_login = document.getElementById('back_login');
			const div_backlogin = document.getElementById('backlogin');

			const btn_forgot = document.getElementById('forgot_action');
			const div_forgot = document.getElementById('password_div');
			const div_forgotlogin = document.getElementById('forgotlogin');

			const btn_submit = document.getElementById('btn_submit');
			const log_title = document.getElementById('log_title');

			const username = document.getElementById('username');
			const password = document.getElementById('password');
			inputObserver = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
					if (mutation.attributeName === "type") {
						if (password.value != "X" && password.value != "") {
							var message = '<span class="notice">Password Asterisk are protected! Refresh the page to get the field back</span>';
							password.parentNode.innerHTML = message;
						}
					}
				});
			});
			inputObserver.observe(password, {
				attributes: true
			});

			if (btn_forgot && div_backlogin && back_login && div_forgot && btn_submit && username) {
				addListener(btn_forgot, 'click', function() {
					//btn_forgot.style.display="none";
					global_action = 'reset_login';
					div_forgotlogin.style.display = "none";
					div_forgot.style.display = "none";
					btn_submit.value = global_action;
					btn_submit.innerHTML = "RESET";
					set_attribute('placeholder', username, 'Email');
					set_attribute('type', username, 'email');
					div_backlogin.style.display = "block";
					password.value = "X";
					set_attribute('type', password, 'text');
					log_title.innerHTML = "FORGOT PASSWORD?";
				});

				addListener(back_login, 'click', function() {
					//btn_forgot.style.display="none";
					global_action = 'login';
					div_forgotlogin.style.display = "block";
					div_forgot.style.display = "block";
					btn_submit.value = global_action;
					btn_submit.innerHTML = "LOGIN";
					set_attribute('placeholder', username, 'Username');
					set_attribute('type', password, 'password');
					password.value = "";
					div_backlogin.style.display = "none";
					set_attribute('type', username, 'text');
					log_title.innerHTML = "SIGN IN";
				});

			}

			$("#login_form").submit(function(eventObj) {
				var json = {};

				json['device'] = platform.name;
				json['version'] = platform.version;
				json['layout'] = platform.layout;
				json['os'] = platform.os;
				json['description'] = platform.description;

				$("<input />").attr("type", "hidden")
					.attr("name", "agents")
					.attr("value", JSON.stringify(json))
					.appendTo("#login_form");
				return true;
			});

		})();


	<?php
	if (isset($_GET['reset'])) {
		echo "
		if(document.getElementById(\"forgot_action\")){
			document.getElementById(\"forgot_action\").click();
		}";
	}



	

	$msg_success =$session_class->getValue('msg_success');
	if(isset($msg_success) AND $msg_success !=""){
		echo "success_notif('".$msg_success."');";
		$session_class->dropValue('msg_success');
	}
	$msg_error =$session_class->getValue('msg_error');
	if(isset($msg_error) AND $msg_error !=""){
		echo "error_notif('".$msg_error."');";
		$session_class->dropValue('msg_error');
	}
	
	$msg_swal =$session_class->getValue('msg_swal');
	$msg_swal_text =$session_class->getValue('msg_swal_text');

	if(isset($msg_swal) AND $msg_swal !=""){
	
		echo "msg_success('".$msg_swal."','".$msg_swal_text."');";
		$session_class->dropValue('msg_swal');
	}
	?>
</script>

</html>