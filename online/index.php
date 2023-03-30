<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;

$csrf = new CSRF($session_class);
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
	<?php
	include_once DOMAIN_PATH . '/global/meta_data.php'; //meta
	include_once DOMAIN_PATH . '/global/include_top.php'; //links
	?>
	<style>
		#time-out-btn,
		#time-in-btn {
			background: #083AA9;
			border: #083AA9;
		}

		img {
			vertical-align: middle;
			border-style: none;
		}

		.swal2-image {
			width: 200px;
			height: 200px;
			object-fit: cover;
			border-radius: 50%;
		}

		.swal_error .swal2-content {
			font-size: 24px;
			color: red;
		}

		.swal_success .swal2-content {
			font-size: 24px;
			color: green;
		}

		.form-message {
			font-size: 20px;
			color: red;
		}
	</style>
</head>

<body data-layout="detached" class="d-flex flex-column h-100">
	<!-- HEADER -->
	<div class="loader_container">
		<div class="loader"></div>
	</div>
	<div class="container-fluid active ">
		<div class="wrapper in">
			<!-- BEGIN CONTENT -->
			<!-- PAGE CONTAINER-->
			<div class="content-page">
				<div class="content">
					<!-- BEGIN PlACE PAGE CONTENT HERE -->
					<div class="row justify-content-md-center mt-5">
						<div class="col-xs-12  col-sm-12 col-lg-6">
							<div class="card mb-3" style="background:#083AA9;color:white;">
								<div class="card-body" style="padding:10px;">
									<h4 class="page-title mb-0"> <img src="<?php echo BASE_URL; ?>assets/img/logo-light.png" alt="" height="50"><span style="font-size:20pt;font-family:inkfree;">Employee Attendance Monitoring System</span></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xs-12 col-sm-12 col-lg-6">
							<div class="card">
								<div class="card-body mt-2">
									<form action="" id="att-log-frm">
										<div class="text-center text-black mb-5">
											<div id="nowTime" class="text-dark font-monospace" style="font-size: 32pt; font-weight: 800;"></div>
											<div id="nowDate" class="text-secondary" style="font-size: 24pt; font-weight: 500;"></div>
										</div>
										<input type="hidden" id="attendance_time" name="attendance_time">
										<input type="hidden" id="attendance_date" name="attendance_date">
										<div class=" form-group col-xs-12 col-sm-12 col-lg-12">
											<h5>Enter your Employee Number </h5>
											<input type="text" id="id_number" name="id_num" class="form-control col-sm-12" required>
										</div>
										<?php echo $csrf->input('token_code', 'token_code', 3600, 10); ?>
										<div class="btn-group d-flex mt-4" role="group">
											<button type="submit" class="btn btn-primary rounded bg-navy" id="time-in-btn" value="time-in">TIME IN</button>
											<button type="submit" class="btn btn-primary rounded bg-navy" id="time-out-btn" style="margin-left: 10px;" value="time-out">TIME OUT</button>
										</div>
									</form>
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
	<!-- bundle -->
	<?php
    include_once FOOTER_PATH; //footer
    include_once DOMAIN_PATH . '/global/include_bottom.php'; //scripts
	?>
</body>

<script>

	$(document).on('submit', '#submit_password_frm', function(e) {
		e.preventDefault();
		var action = submit_button;
		var submit_password = $('.emp_password').val();
		var id_number = $('#id_number').val();
		var att_time = $('#attendance_time').val();
		var att_date = $('#attendance_date').val();
		var token_code = $('#token_code').val();
		$.ajax({
			type: "POST",
			url: "add_attendance.php",
			data: {
				action: submit_button,
				submit_password: submit_password,
				att_time: att_time,
				att_date: att_date,
				id_number: id_number,
				token_code: token_code,
			},
			dataType: "json",
			success: function(response) {
			    $('#token_code').val(response.token_code);
			    if(response.error){
                     error_notif(response.message);
                     return;
                }
				if (response.success) {
					
					success_notif(response.message);
				
				}
				else if (response.success == false) {
					error_notif(response.message);
				
				}
			
			

			}
		});
	});

	$(document).on('click', '.btn-secondary', function() {
		swal.clickConfirm();

	});

	var submit_button;

	$("#time-in-btn").click(function() {
		submit_button = $("#time-in-btn").val();
	});
	$("#time-out-btn").click(function() {
		submit_button = $("#time-out-btn").val();
	});

	$("#att-log-frm").on('submit', function(e) {
		e.preventDefault();
		var action = submit_button;
		var id_number = $('#id_number').val();
        var token_code = $('#token_code').val();

		$.ajax({
			type: "POST",
			url: "add_attendance.php",
			data: {
				action: submit_button,
	            token_code : token_code,
				id_number: id_number
			},
			dataType: "json",
			success: function(response) {
			    $('#token_code').val(response.token_code);
                if(response.error){
                     error_notif(response.message);
                      return;
                }
				if (response.success) {
					Swal.fire({
						title: response.name,
						imageUrl: "<?php echo BASE_URL; ?>assets/img/online_profile.png",
						html: `
							<form id="submit_password_frm">
								<div class="mb-3">
									<label for="exampleInputPassword1" class="form-label">Enter Password</label>
									<input type="password"  class="form-control emp_password" id="exampleInputPassword1"required>
								</div>
								<div class="form-message"></div>
								<button type="submit" name="submit_password" class="btn btn-primary submit_password">Submit</button>
								<button type="button" class="btn btn-secondary">Cancel</button>
							</form>
							`,
						showConfirmButton: false,
					})

				}else if (response.success == false) {
					var img ="<?php echo BASE_URL; ?>assets/img/online_profile.png";
					var icon = ""
					if (response.name==undefined){
						var img ="";
					var icon = "error"
					}
					$('.form-message').css("display", "block");
					$('.form-message').html('<p>'+response.message+'</p>');
							Swal.fire({
						position: 'center',
						imageUrl: img,
						icon: icon,
						title: response.name,
						text: ""+response.message+"!",
						customClass: 'swal_error',
						showConfirmButton: false,
						timer: 3000,
						
					})
				}

			
			},
			error: function() {
				alert("error");

			}
		});
	});

	// time 
	$(document).ready(function() {
		$(".submit_password").prop("disabled", true);
		// Set time and date
		var set_server_time = <?php date_default_timezone_set('Asia/Manila');
								echo "'" . DATE_TIME . "';\r\n"; ?>
		        var serverOffset = moment(set_server_time).diff(new Date());
			
		clearInterval(clock_id);
		var now_server = moment();
		
		var dateNow1 = now_server.format('YYYY-MM-DD');
		var clock_id = setInterval(function() {
			if (document.getElementById('nowTime')) {
				var now_server = moment();
				now_server.add( serverOffset,'milliseconds'); //add sa datetime
				var timeNow = now_server.format('h:mm:ss A');
				var dateNow = now_server.format('ddd | MMMM DD, YYYY');
				$('#nowDate').html(dateNow);
				$('#nowTime').html(timeNow);
				$('#attendance_time').val(dateNow1 + " " + timeNow);
				$('#attendance_date').val(dateNow1);

			} else {
				clearInterval(clock_id);
			}

		}, 1000);
		// End set time and date
	});
</script>

</html>