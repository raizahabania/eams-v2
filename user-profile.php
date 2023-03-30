<?php
include 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (!($g_user_role == "ADMIN_STAFF" || $g_user_role == "ADMIN" || $g_user_role == "END_USER")) {
    header("Location: " . BASE_URL); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
    exit();
}
$sql = mysqli_query($db_connect, "SELECT * FROM users WHERE employee_id = '$employee_id' ");


while ($row = mysqli_fetch_array($sql)) {
    $emp_id = $row['employee_id'];
    $fname = $row['f_name'];
    $mname = $row['m_name'];
    $lname = $row['l_name'];
    $suffix = $row['suffix'];
    $names = $fname . " " . $mname . " " . $lname . " " . $suffix;
    $card_id = $row['card_id'];
    $img = $row['img'];
    $position = $row['position'];
    $user = $row['username'];
    $pass = set_password($row['password']);
    $emails = $row['email_address'];
}
?>
<!DOCTYPE html>
<html lang="<?php echo LANG; ?>" class="h-100">

<head>
    <?php
    include DOMAIN_PATH . "/global/meta_data.php";
    include DOMAIN_PATH . "/global/include_top.php";
    ?>
</head>

<body class="d-flex flex-column h-100">
    <?php
    include DOMAIN_PATH . "/global/header.php";

    include DOMAIN_PATH . "/global/sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>USER PROFILE</h1>
            <!--<nav>-->
            <!--    <ol class="breadcrumb">-->
            <!--        <li class="breadcrumb-item"><a href="index.php">Home</a></li>-->
            <!--        <li class="breadcrumb-item active">USER PROFILE</li>-->
            <!--    </ol>-->
            <!--</nav>-->
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">
                <div class="col-xl-4">
                    <div class="card">

                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center"> <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $img;  ?>" style="border-radius:60px;width:100px;" alt="Profile" class="rounded-circle"><br>
                            <h4><?php echo $names; ?></h4>
                            <h6><?php echo $position; ?></h6>
                            <form id="upload_photo">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <input class="form-control" type="file" name="photo" id="photo" required>

                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary" id="photo_submit" type="submit">Upload</button>
                                        <?php
                                        $photo = $session_class->getValue('photo');
                                        if ($photo == 'profile-img.png') { ?>
                                            <button class="btn btn-danger" id="non_photo" type="button">Remove</button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger" name="photo_remove" id="photo_remove" type="button">Remove</button>
                                        <?php } ?>

                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item"> <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button></li>
                                <li class="nav-item"> <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button></li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-edit" id="profile-edit">
                                    <br>
                                    <form>
                                        <div class="row mb-3">
                                            <label for="employee_id" class="col-md-4 col-lg-3 col-form-label">Employee ID</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="employee_id" type="text" class="form-control" id="employee_id" value="<?php echo $employee_id; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="rfid" class="col-md-4 col-lg-3 col-form-label">RFID Number</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="rfid" type="text" class="form-control" id="rfid" value="<?php echo $card_id; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fullname" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullname" type="text" class="form-control" id="fullname" value="<?php echo $names; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="user" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="user" type="text" class="form-control" id="user" value="<?php echo $user; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="user" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="user" type="text" class="form-control" id="email" value="<?php echo $emails; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="position" class="col-md-4 col-lg-3 col-form-label">Position</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="position" type="text" class="form-control" id="position" value="<?php echo $position; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary float-end" style="text-align:right" data-bs-toggle="modal" data-bs-target="#user-profile">Edit Profile</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">

                                    <form class="needs-validation  mb-5 border-top" novalidate id="change_pass">

                                        <div class="col">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>

                                            <div class="col-12" style="margin-bottom:30px;">
                                                <input type="password" id="old_password" name="old_password" class="form-control" required>
                                                <div class="form-message"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col">

                                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                                        Your password must be 8-20 characters long, must contain special characters "!@#$%&*_?", numbers, lower and upper letters only.
                                                    </small>
                                                    <br>
                                                    <label for="new_password" style="margin-top: 10px;">Password</label>
                                                    <input type="password" class="form-control" id="validationPassword" name="new_password" placeholder="New Password" value="" required>
                                                    <div class="progress" style="height: 5px;">
                                                        <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">

                                                        </div>
                                                    </div>


                                                    <div id="feedbackin" class="valid-feedback">
                                                        Strong Password!
                                                    </div>
                                                    <div id="feedbackirn" class="invalid-feedback">
                                                        Atleas 8 characters,
                                                        Number, special character
                                                        Caplital Letter and Small letters
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="invalid-feedback" id="confirm_feedback">Password Not Match</div>
                                            <div class="col-12" style="margin-top:10px">
                                                <label for="confirm_password" class="form-label" style="margin-bottom: 0;">Confirm Password!</label>
                                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" id="confirm_password" required>

                                            </div>
                                            <div class="form-check" style="margin-top: 15px;">
                                                <input class="form-check-input show_password" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Show Passwod
                                                </label>
                                            </div>
                                            <div class="col-12">

                                                <button class="btn btn-primary w-100 update" name="login_submit" type="submit">Update</button>
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="user-profile" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header ngbAutofocus bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Update <span id="accountStatus"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form type="post" id="userupdate">
                            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                            <div class="modal-body">
                                <div class="form-message alert alert-danger" role="alert" style="display:none;"></div>
                                <h5 class="mb-3">
                                    <span id="err_msg" class="badge bg-danger text-white rounded-1 p-2 mt-1 text-sm-start mx-2"></span>
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="userName" class="form-label"><b>Username</b></label>
                                        <input type="text" name="username" value="<?php echo $user; ?>" class="form-control bg-light" id="username" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="emailAddress" class="form-label"><b>Email Address</b></label>
                                        <input type="email" name="emailaddress" value="<?php echo $emails; ?>" class="form-control bg-light" id="emailaddress" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a type="button" class="btn btn-success" id="update_user" name="update_user" value="update_user">Update Information</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <?php
    include DOMAIN_PATH . "/global/footer.php";
    include DOMAIN_PATH . "/global/include_bottom.php";
    ?>
</body>

<script>
    (function() {

        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                // making sure password enters the right characters
                form.validationPassword.addEventListener('keypress', function(event) {
                    console.log("keypress");
                    console.log("event.which: " + event.which);
                    var checkx = true;
                    var chr = String.fromCharCode(event.which);
                    console.log("char: " + chr);


                    var matchedCase = new Array();
                    matchedCase.push("[!@#$%&*_?]"); // Special Character
                    matchedCase.push("[A-Z]"); // Uppercase Alpabates
                    matchedCase.push("[0-9]"); // Numbers
                    matchedCase.push("[a-z]");

                    for (var i = 0; i < matchedCase.length; i++) {
                        if (new RegExp(matchedCase[i]).test(chr)) {
                            console.log("checkx: is true");
                            checkx = false;
                        }
                    }

                    if (form.validationPassword.value.length >= 12)
                        checkx = true;

                    if (checkx) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                });

                //Validate Password to have more than 8 Characters and A capital Letter, small letter, number and special character
                // Create an array and push all possible values that you want in password
                var matchedCase = new Array();
                matchedCase.push("[!@#$%&*_?]"); // Special Character
                matchedCase.push("[A-Z]"); // Uppercase Alpabates
                matchedCase.push("[0-9]"); // Numbers
                matchedCase.push("[a-z]"); // Lowercase Alphabates


                form.validationPassword.addEventListener('keyup', function() {

                    var messageCase = new Array();
                    messageCase.push(" Special Character"); // Special Character
                    messageCase.push(" Upper Case"); // Uppercase Alpabates
                    messageCase.push(" Numbers"); // Numbers
                    messageCase.push(" Lower Case"); // Lowercase Alphabates

                    var ctr = 0;
                    var rti = "";
                    for (var i = 0; i < matchedCase.length; i++) {
                        if (new RegExp(matchedCase[i]).test(form.validationPassword.value)) {
                            if (i == 0) messageCase.splice(messageCase.indexOf(" Special Character"), 1);
                            if (i == 1) messageCase.splice(messageCase.indexOf(" Upper Case"), 1);
                            if (i == 2) messageCase.splice(messageCase.indexOf(" Numbers"), 1);
                            if (i == 3) messageCase.splice(messageCase.indexOf(" Lower Case"), 1);
                            ctr++;
                            //console.log(ctr);
                            //console.log(rti);
                        }
                    }


                    //console.log(rti);
                    // Display it
                    var progressbar = 0;
                    var strength = "";
                    var bClass = "";
                    switch (ctr) {
                        case 0:
                        case 1:
                            strength = "Way too Weak";
                            progressbar = 15;
                            bClass = "bg-danger";
                            break;
                        case 2:
                            strength = "Very Weak";
                            progressbar = 25;
                            bClass = "bg-danger";
                            break;
                        case 3:
                            strength = "Weak";
                            progressbar = 34;
                            bClass = "bg-warning";
                            break;
                        case 4:
                            strength = "Medium";
                            progressbar = 65;
                            bClass = "bg-warning";
                            break;
                    }

                    if (strength == "Medium" && form.validationPassword.value.length >= 8) {
                        strength = "Strong";
                        bClass = "bg-success";
                        form.validationPassword.setCustomValidity("");
                    } else {
                        form.validationPassword.setCustomValidity(strength);
                    }

                    var sometext = "";

                    if (form.validationPassword.value.length < 8) {
                        var lengthI = 8 - form.validationPassword.value.length;
                        sometext += ` ${lengthI} more Characters, `;
                    }

                    sometext += messageCase;
                    console.log(sometext);

                    console.log(sometext);

                    if (sometext) {
                        sometext = " You Need" + sometext;
                    }


                    $("#feedbackin, #feedbackirn").text(strength + sometext);
                    $("#progressbar").removeClass("bg-danger bg-warning bg-success").addClass(bClass);
                    var plength = form.validationPassword.value.length;
                    if (plength > 0) progressbar += ((plength - 0) * 1.75);
                    //console.log("plength: " + plength);
                    var percentage = progressbar + "%";
                    form.validationPassword.parentNode.classList.add('was-validated');
                    //console.log("pacentage: " + percentage);
                    $("#progressbar").width(percentage);

                    if (form.new_password.checkValidity() == true) {

                        $('#confirm_password').prop("disabled", false)
                        $('.btn-primary').prop("disabled", false)

                    } else {
                        $('#confirm_password').prop("disabled", true)
                        $('.btn-primary').prop("disabled", true)
                    }


                });



            });
        }, false);

        $('#user-profile').on('click',function(){
            $("#userupdate").clear();
        });

        $('#update_user').on('click', function() {

            var formData = new FormData(userupdate);
            if ($("#username").val() == "") {
                $(".form-message").html("Username field cannot be empty");
                $(".form-message").css("display", "block");
                return;
            }
            if ($("#emailaddress").val() == "") {
                $(".form-message").html("Email Address field cannot be empty");
                $(".form-message").css("display", "block");
                return;
            }
            if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test($("#emailaddress").val())) {
                $(".form-message").html("Please enter a valid email address");
                $(".form-message").css("display", "block");
                return;
            }
            $.ajax({
                url: '<?php BASE_URL; ?>update_user.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#user-profile').modal('hide');
                        $('#user').val(response.username);
                        $('#email').val(response.email);
                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message,
                        })
                    }
                }
            });
        });

        $('#change_pass').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?php BASE_URL; ?>update_user.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({

                            icon: 'success',
                            title: response.message,
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });



                    } else if (response.success == false) {
                        error_notif(response.message)

                    }
                }
            });
        });

        $(document).on('submit', '#upload_photo', function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?php BASE_URL; ?>update_photo.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message,
                        })
                    }
                }
            });

        });

        $('#photo_remove').on("click", function() {
            Swal.fire({
                title: 'Do you want to remove Profile?',
                showDenyButton: true,
                confirmButtonText: 'YES',
                cancelButtonText: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    var action = 'photo_remove';
                    $.ajax({
                        url: '<?php BASE_URL; ?>update_photo.php',
                        type: 'POST',
                        data: {
                            action: action
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: response.message,
                                })
                            }
                        }
                    })
                }
            });
        });

        $('#non_photo').on("click", function() {
            Toast.fire({
                icon: 'error',
                title: "No photo to remove",
            })
        });
    })();


    $(".show_password").change(function() {
        if (this.checked) {
            $("#validationPassword").prop("type", "text");
            $("#confirm_password").prop("type", "text");
            $("#old_password").prop("type", "text");

        } else {
            $("#validationPassword").prop("type", "password");
            $("#confirm_password").prop("type", "password");
            $("#old_password").prop("type", "password");
        }
    });
</script>

<script>
    <?php ## sweetalert msg session
    // $msg_success = $session_class->getValue('msg_success');
    // if (isset($msg_success) && $msg_success != "") {
    //     echo "success_notif('" . $msg_success . "');";
    //     $session_class->dropValue('msg_success');
    // }
    // $msg_error = $session_class->getValue('msg_error');
    // if (isset($msg_error) && $msg_error != "") {
    //     echo "error_notif('" . $msg_error . "');";
    //     $session_class->dropValue('msg_error');
    // }
    // $msg_reset = $session_class->getValue('msg_reset');
    // if (isset($msg_reset) && $msg_reset != "") {
    //     echo "reset_modal('" . $msg_reset['title'] . "','" . $msg_reset['content_msg'] . "');";
    //     $session_class->dropValue('msg_reset');
    // }
    ?>
</script>

</html>