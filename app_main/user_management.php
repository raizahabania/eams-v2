<?php
include '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH;
require ISLOGIN;

if (!($g_user_role == "ADMIN")) {
    return_role($g_user_role);
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <?php
    include_once DOMAIN_PATH . '/global/meta_data.php'; //meta
    include_once DOMAIN_PATH . '/global/include_top.php'; //links
    ?>
</head>

<body class="d-flex flex-column h-100">

    <?php
    include_once DOMAIN_PATH . '/global/header.php'; //header
    include_once DOMAIN_PATH . '/global/sidebar.php'; //sidebar
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>User Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_main/index.php">Home</a></li>
                    <li class="breadcrumb-item active">User Management</li>

                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold d-flex align-items-center justify-content-between" style="font-size: large;">
                    <div>
                        <i class="bi bi-person-circle"></i>&ensp;List of Users
                    </div>
                    <div class="mr-auto">
                        <button id="add_new" class="btn btn-outline-light btn-rounded btn-sm ml-1"><i class="bi bi-plus-circle"></i> Add User</button>
                    </div>
                </div>
                
                <div class="card-body mt-3 bg-white">
                    <div class="card">
                        <div id="user-table" class="table table-borderless"></div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade modal-xl" id="add_user_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="employee_id"><b>Employee ID</b> <span class="required-field"></span></label>
                                    <input type="text" name="employee_id" class="form-control" id="employee_id" placeholder="Employee ID">
                                    <span id="err_emp_id" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="card_id"><b>Card ID</b> <span class="required-field"></span></label>
                                    <input type="text" name="card_id" class="form-control" id="card_id" placeholder="Card ID">
                                    <span id="err_card_id" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="form-label" for="f_name"><b>First Name</b> <span class="required-field"></span></label>
                                    <input type="text" name="f_name" class="form-control" id="f_name" placeholder="First name">
                                    <span id="err_f_name" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="form-label" for="m_name"><b>Middle Name</b></label>
                                    <input type="text" name="m_name" class="form-control" id="m_name" placeholder="Middle name">
                                    <span id="err_m_name" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="form-label" for="l_name"><b>Last Name</b> <span class="required-field"></span></label>
                                    <input type="text" name="l_name" class="form-control" id="l_name" placeholder="Last name">
                                    <span id="err_l_name" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="form-label" for="suffix"><b>Suffix</b></label>
                                    <select name="suffix" id="suffix" class="form-control">
                                        <option value="" selected>Select Suffix</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="VI">VI</option>
                                    </select>
                                    <span id="err_suffix" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="username" class="form-label"><b>Username</b> <span class="required-field"></span></label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                    <span id="err_username" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label for="email" class="form-label"><b>Email Address</b> <span class="required-field"></span></label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
                                    <span id="err_email" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="position" class="form-label"><b>Position</b> <span class="required-field"></span></label>
                                    <select name="position" id="position" class="form-control">
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="Teaching Personnel">Teaching Personnel</option>
                                        <option value="Non-Teaching Personnel">Non-Teaching Personnel</option>
                                    </select>
                                    <span id="err_position" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-6">
                                    <label for="role" class="form-label"><b>User Role</b> <span class="required-field"></span></label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="" disabled selected>Select User Role</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Admin Staff</option>
                                        <option value="3">Security Guard</option>
                                        <option value="4">User</option>
                                    </select>
                                    <span id="err_role" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn_submit" name="actionSubmit" value="submitUser">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Update <span id="accountStatus"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateForm">
                        <div class="modal-body">
                            <h5 class="mb-3">
                                <span id="err_msg" class="badge bg-danger text-white rounded-1 p-2 mt-1 text-sm-start mx-2"></span>
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="employeeID" class="form-label"><b>Employee ID</b></label>
                                    <input type="text" name="employeeID" value="" class="form-control bg-light" id="employeeID">
                                    <input type="hidden" name="oldemployeeID" id="oldemployeeID">
                                    <span id="err_employeeID" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="cardID" class="form-label"><b>Card ID</b></label>
                                    <input type="text" name="cardID" value="" class="form-control bg-light" id="cardID">
                                    <input type="hidden" name="oldcardID" id="oldcardID">
                                    <span id="err_cardID" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="fName" class="form-label"><b>First Name</b></label>
                                    <input type="text" name="fName" value="" class="form-control bg-light" id="fName">
                                    <input type="hidden" name="oldfName" id="oldfName">
                                    <span id="err_fName" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="mName" class="form-label"><b>Middle Name</b></label>
                                    <input type="text" name="mName" value="" class="form-control bg-light" id="mName">
                                    <input type="hidden" name="oldmName" id="oldmName">
                                    <span id="err_mName" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="lName" class="form-label"><b>Last Name</b></label>
                                    <input type="text" name="lName" value="" class="form-control bg-light" id="lName">
                                    <input type="hidden" name="oldlName" id="oldlName">
                                    <span id="err_lName" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="suff" class="form-label"><b>Suffix</b></label>
                                    <select name="suff" id="suff" class="form-control bg-light">
                                        <option value=""></option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="VI">VI</option>
                                    </select>
                                    <input type="hidden" name="oldsuff" id="oldsuff">
                                    <span id="err_suff" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="userName" class="form-label"><b>Username</b></label>
                                    <input type="text" name="userName" class="form-control bg-light" id="userName">
                                    <input type="hidden" name="olduserName" id="olduserName">
                                    <span id="err_userName" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="emailAddress" class="form-label"><b>Email Address</b></label>
                                    <input type="text" name="emailAddress" class="form-control bg-light" id="emailAddress">
                                    <input type="hidden" name="oldemailAddress" id="oldemailAddress">
                                    <span id="err_emailAddress" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="pos" class="form-label"><b>Position</b></label>
                                    <select name="pos" id="pos" class="form-control bg-light">
                                        <option value="Teaching Personnel">Teaching Personnel</option>
                                        <option value="Non-Teaching Personnel">Non-Teaching Personnel</option>
                                    </select>
                                    <input type="hidden" name="oldpos" id="oldpos">
                                    <span id="err_pos" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-6">
                                    <label for="userRole" class="form-label"><b>User Role</b></label>
                                    <select name="userRole" id="userRole" class="form-control bg-light">
                                        <option value="1">Admin</option>
                                        <option value="2">Admin Staff</option>
                                        <option value="3">Security Guard</option>
                                        <option value="4">User</option>
                                    </select>
                                    <input type="hidden" name="olduserRole" id="olduserRole">
                                    <span id="err_userRole" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <input type="hidden" name="user_id" id="user_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" id="btn_deactivate" name="actionDeac" value="deacAccount">Deactivate Account</button>
                            <button type="submit" class="btn btn-primary" id="btn_reset" name="actionReset" value="resetPass">Reset Password</button>
                            <button type="submit" class="btn btn-success" id="btn_update" name="actionUpdate" value="updateUser">Update Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="locked_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Update <span id="locked_accountStatus"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <h5 class="mb-3">
                                <span id="err_msg" class="badge bg-danger text-white rounded-1 p-2 mt-1 text-sm-start mx-2"></span>
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="locked_employeeID" class="form-label"><b>Employee ID</b></label>
                                    <input type="text" name="locked_employeeID" value="" class="form-control" id="locked_employeeID" disabled>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="locked_cardID" class="form-label"><b>Card ID</b></label>
                                    <input type="text" name="locked_cardID" value="" class="form-control" id="locked_cardID" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="locked_fName" class="form-label"><b>First Name</b></label>
                                    <input type="text" name="locked_fName" value="" class="form-control" id="locked_fName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="locked_mName" class="form-label"><b>Middle Name</b></label>
                                    <input type="text" name="locked_mName" value="" class="form-control" id="locked_mName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="locked_lName" class="form-label"><b>Last Name</b></label>
                                    <input type="text" name="locked_lName" value="" class="form-control" id="locked_lName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="locked_suff" class="form-label"><b>Suffix</b></label>
                                    <input type="text" name="locked_suff" value="" class="form-control" id="locked_suff" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="locked_userName" class="form-label"><b>Username</b></label>
                                    <input type="text" name="locked_userName" class="form-control" id="locked_userName" disabled>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="locked_emailAddress" class="form-label"><b>Email Address</b></label>
                                    <input type="text" name="locked_emailAddress" class="form-control" id="locked_emailAddress" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="locked_pos" class="form-label"><b>Position</b></label>
                                    <input type="text" name="locked_pos" class="form-control" id="locked_pos" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="locked_userRole" class="form-label"><b>User Role</b></label>
                                    <select name="locked_userRole" id="locked_userRole" class="form-control" disabled>
                                        <option value="1">Admin</option>
                                        <option value="2">Admin Staff</option>
                                        <option value="3">Security Guard</option>
                                        <option value="4">User</option>
                                    </select>
                                </div>
                                <input type="hidden" name="locked_user_id" id="locked_user_id">
                                <input type="hidden" name="locked_emp_id" id="locked_emp_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn_deactivate_locked" name="actionDeac" value="deacAccount">Unlock Account</button>
                            <button type="submit" class="btn btn-primary" id="btn_reset_locked" name="actionReset" value="resetPass">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deactivate_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Update <span id="deactivate_accountStatus"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <h5 class="mb-3">
                                <span id="err_msg" class="badge bg-danger text-white rounded-1 p-2 mt-1 text-sm-start mx-2"></span>
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="deactivate_employeeID" class="form-label"><b>Employee ID</b></label>
                                    <input type="text" name="deactivate_employeeID" value="" class="form-control" id="deactivate_employeeID" disabled>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="deactivate_cardID" class="form-label"><b>Card ID</b></label>
                                    <input type="text" name="deactivate_cardID" value="" class="form-control" id="deactivate_cardID" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="deactivate_fName" class="form-label"><b>First Name</b></label>
                                    <input type="text" name="deactivate_fName" value="" class="form-control" id="deactivate_fName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="deactivate_mName" class="form-label"><b>Middle Name</b></label>
                                    <input type="text" name="deactivate_mName" value="" class="form-control" id="deactivate_mName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="deactivate_lName" class="form-label"><b>Last Name</b></label>
                                    <input type="text" name="deactivate_lName" value="" class="form-control" id="deactivate_lName" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label for="deactivate_suff" class="form-label"><b>Suffix</b></label>
                                    <input type="text" name="deactivate_suff" value="" class="form-control" id="deactivate_suff" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="deactivate_userName" class="form-label"><b>Username</b></label>
                                    <input type="text" name="deactivate_userName" class="form-control" id="deactivate_userName" disabled>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="deactivate_emailAddress" class="form-label"><b>Email Address</b></label>
                                    <input type="text" name="deactivate_emailAddress" class="form-control" id="deactivate_emailAddress" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="deactivate_pos" class="form-label"><b>Position</b></label>
                                    <input type="text" name="deactivate_pos" class="form-control" id="deactivate_pos" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="deactivate_userRole" class="form-label"><b>User Role</b></label>
                                    <select name="deactivate_userRole" id="deactivate_userRole" class="form-control" disabled>
                                        <option value="1">Admin</option>
                                        <option value="2">Admin Staff</option>
                                        <option value="3">Security Guard</option>
                                        <option value="4">User</option>
                                    </select>
                                </div>
                                <input type="hidden" name="deactivate_user_id" id="deactivate_user_id">
                                <input type="hidden" name="deactivate_emp_id" id="deactivate_emp_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn_activate">Activate Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main><!-- End #main -->

    <?php
    include_once FOOTER_PATH; //footer
    include_once DOMAIN_PATH . '/global/include_bottom.php'; //scripts
    ?>

</body>

<script>
    (function() {
        const roleClass = function(cell, formatterParams, onRendered) {
            var span = document.createElement("span");
            var row = cell.getRow();
            var data = row.getData();
            if (data.user_role == 1) {
                span.innerHTML = "Admin";
            } else if (data.user_role == 2) {
                span.innerHTML = "Admin Staff";
            } else if (data.user_role == 3) {
                span.innerHTML = "Security Guard";
            } else if (data.user_role == 4) {
                span.innerHTML = "User";
            }
            return span;
        };
        const statusClass = function(cell, formatterParams, onRendered) {
            const span = document.createElement("span");
            const row = cell.getRow();
            const data = row.getData();
            if (data.account_status == 'Active') {
                span.classList.add("status-green");
                span.style.fontSize = "small";
                span.innerHTML = "Active";
            } else if (data.account_status == 'Locked') {
                span.classList.add("status-red");
                span.style.fontSize = "small";
                span.innerHTML = "Locked";
            } else if (data.account_status == 'Deactivated') {
                span.classList.add("status-orange");
                span.style.fontSize = "small";
                span.innerHTML = "Deactivated";
            }
            return span;
        };
        const btnAction = function(cell, formatterParams, onRendered) { // for updating the status
            var cellEl = cell.getElement(); //get cell DOM element
            var actionBut = document.createElement("span");
            var row = cell.getRow();
            var data = row.getData();
            var edit_btn = document.createElement("button");
            var delete_btn = document.createElement("button");

            edit_btn.classList.add("btn", "btn-sm", "btn-outline-primary", "btn-rounded", "m-1");
            edit_btn.style.fontSize = "small";
            edit_btn.innerHTML = '<i class="bi bi-pencil-square"></i>&ensp;Update';
            edit_btn.addEventListener("click", function() {

                if (data.account_status == 'Active') {
                    // Open the edit modal
                    $("#update_modal").modal("show");

                    // Set the values of the form
                    document.getElementById("update_modal").querySelector("#user_id").value = data.user_id;
                    document.getElementById("update_modal").querySelector("#employeeID").value = data.employee_id;
                    document.getElementById("update_modal").querySelector("#oldemployeeID").value = data.employee_id;
                    document.getElementById("update_modal").querySelector("#cardID").value = data.card_id;
                    document.getElementById("update_modal").querySelector("#oldcardID").value = data.card_id;
                    document.getElementById("update_modal").querySelector("#fName").value = data.f_name;
                    document.getElementById("update_modal").querySelector("#oldfName").value = data.f_name;
                    document.getElementById("update_modal").querySelector("#mName").value = data.m_name;
                    document.getElementById("update_modal").querySelector("#oldmName").value = data.m_name;
                    document.getElementById("update_modal").querySelector("#lName").value = data.l_name;
                    document.getElementById("update_modal").querySelector("#oldlName").value = data.l_name;
                    document.getElementById("update_modal").querySelector("#suff").value = data.suffix;
                    document.getElementById("update_modal").querySelector("#oldsuff").value = data.suffix;
                    document.getElementById("update_modal").querySelector("#userName").value = data.username;
                    document.getElementById("update_modal").querySelector("#olduserName").value = data.username;
                    document.getElementById("update_modal").querySelector("#emailAddress").value = data.email_address;
                    document.getElementById("update_modal").querySelector("#oldemailAddress").value = data.email_address;
                    document.getElementById("update_modal").querySelector("#pos").value = data.position;
                    document.getElementById("update_modal").querySelector("#oldpos").value = data.position;
                    document.getElementById("update_modal").querySelector("#userRole").value = data.user_role;
                    document.getElementById("update_modal").querySelector("#olduserRole").value = data.user_role;

                    document.getElementById("update_modal").querySelector("#accountStatus").innerHTML = "- Active Account";

                    // clear any error messages in the form
                    document.getElementById("err_msg").innerHTML = "";
                    document.getElementById("err_msg").style.display = "none";
                    document.getElementById("err_employeeID").innerHTML = "";
                    document.getElementById("err_employeeID").style.display = "none";
                    document.getElementById("err_cardID").innerHTML = "";
                    document.getElementById("err_cardID").style.display = "none";
                    document.getElementById("err_fName").innerHTML = "";
                    document.getElementById("err_fName").style.display = "none";
                    document.getElementById("err_mName").innerHTML = "";
                    document.getElementById("err_mName").style.display = "none";
                    document.getElementById("err_lName").innerHTML = "";
                    document.getElementById("err_lName").style.display = "none";
                    document.getElementById("err_userName").innerHTML = "";
                    document.getElementById("err_userName").style.display = "none";
                    document.getElementById("err_emailAddress").innerHTML = "";
                    document.getElementById("err_emailAddress").style.display = "none";
                    document.getElementById("err_pos").innerHTML = "";
                    document.getElementById("err_pos").style.display = "none";
                    document.getElementById("err_userRole").innerHTML = "";
                    document.getElementById("err_userRole").style.display = "none";
                } else if (data.account_status == 'Locked') {
                    // Open the edit modal
                    $("#locked_modal").modal("show");

                    // Set the values of the form
                    document.getElementById("locked_modal").querySelector("#locked_user_id").value = data.user_id;
                    document.getElementById("locked_modal").querySelector("#locked_employeeID").value = data.employee_id;
                    document.getElementById("locked_modal").querySelector("#locked_emp_id").value = data.employee_id;
                    document.getElementById("locked_modal").querySelector("#locked_cardID").value = data.card_id;
                    document.getElementById("locked_modal").querySelector("#locked_fName").value = data.f_name;
                    document.getElementById("locked_modal").querySelector("#locked_mName").value = data.m_name;
                    document.getElementById("locked_modal").querySelector("#locked_lName").value = data.l_name;
                    document.getElementById("locked_modal").querySelector("#locked_suff").value = data.suffix;
                    document.getElementById("locked_modal").querySelector("#locked_userName").value = data.username;
                    document.getElementById("locked_modal").querySelector("#locked_emailAddress").value = data.email_address;
                    document.getElementById("locked_modal").querySelector("#locked_pos").value = data.position;
                    document.getElementById("locked_modal").querySelector("#locked_userRole").value = data.user_role;
                    document.getElementById("locked_modal").querySelector("#locked_accountStatus").innerHTML = "- Locked Account";
                } else if (data.account_status == 'Deactivated') {
                    // Open the edit modal
                    $("#deactivate_modal").modal("show");

                    // Set the values of the form
                    document.getElementById("deactivate_modal").querySelector("#deactivate_user_id").value = data.user_id;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_employeeID").value = data.employee_id
                    document.getElementById("deactivate_modal").querySelector("#deactivate_emp_id").value = data.employee_id;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_cardID").value = data.card_id;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_fName").value = data.f_name;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_mName").value = data.m_name;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_lName").value = data.l_name;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_suff").value = data.suffix;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_userName").value = data.username;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_emailAddress").value = data.email_address;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_pos").value = data.position;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_userRole").value = data.user_role;
                    document.getElementById("deactivate_modal").querySelector("#deactivate_accountStatus").innerHTML = "- Deactivated Account";
                }
            });

            delete_btn.classList.add("btn", "btn-sm", "btn-outline-danger", "btn-rounded", "m-1");
            delete_btn.style.fontSize = "small";
            delete_btn.innerHTML = '<i class="bi bi-trash"></i>&ensp;Delete';
            delete_btn.addEventListener("click", function() {
                swal.fire({
                    title: 'Are you sure you want to delete this account?',
                    showConfirmButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    showCancelButton: true,
                    cancelButtonColor: '#bd362f',
                    allowOutsideClick: false,
                    customClass: {
                        container: 'popup-modal-container',
                        title: 'title-ff',
                        popup: 'popup-modal',
                        icon: 'popup-modal-icon',
                        actions: 'popup-modal-actions',
                        confirmButton: 'actions-confirm',
                        cancelButton: 'actions-cancel',
                        htmlContainer: 'popup-modal-description'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        var user_id = data.user_id;
                        var employee_id = data.employee_id;
                        formData.append("actionDelete", 'submitDelete');
                        formData.append("user_id", user_id);
                        formData.append("employee_id", employee_id);
                        $.ajax({
                            url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                            }
                        });
                    }
                })
            });

            actionBut.appendChild(edit_btn);
            actionBut.appendChild(delete_btn);
            return cellEl.appendChild(actionBut);
        };

        const table = new Tabulator("#user-table", {
            ajaxSorting: false,
            ajaxFiltering: false,
            height: "500px",
            // tooltips: true,
            printAsHtml: true,
            headerFilterPlaceholder: "Search",
            layout: "fitDataStretch",
            placeholder: "No Data Found",
            movableColumns: true,
            // selectable: true,
            ajaxParams: {
                table: 'users'
            },
            ajaxURL: "<?php echo BASE_URL; ?>app_main/userprocess.php",
            ajaxProgressiveLoad: "scroll",
            ajaxProgressiveLoadScrollMargin: 1,
            printConfig: {
                columnGroups: false,
                rowGroups: false,
            },
            ajaxLoader: true,
            ajaxLoaderLoading: 'Fetching data from Database..',
            selectableRollingSelection: false,
            paginationSize: <?php echo QUERY_LIMIT; ?>,

            columns: [{
                    title: "Employee ID",
                    field: "employee_id",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150
                },
                {
                    title: "Card ID",
                    field: "card_id",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 100
                },
                {
                    title: "Name",
                    field: "name",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 170
                },
                {
                    title: "Username",
                    field: "username",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150
                },
                {
                    title: "Email Address",
                    field: "email_address",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 170
                },
                {
                    title: "Position",
                    field: "position",
                    minWidth: 120
                },
                {
                    title: "User Role",
                    field: "user_role",
                    formatter: roleClass,
                    minWidth: 120
                },
                {
                    title: "Status",
                    field: "account_status",
                    formatter: statusClass,
                    minWidth: 100
                },
                {
                    title: "Action",
                    field: "user_id",
                    formatter: btnAction,
                    minWidth: 200,
                    cellClick: function(e, cell) {
                        cell.getRow().toggleSelect();
                    }
                }
            ],
            ajaxResponse: function(url, params, response) {
                //url - the URL of the request
                //params - the parameters passed with the request
                //response - the JSON object returned in the body of the response.
                return response; //return the tableData property of a response json object
            },
        });
    })();

    const inputRegex = {
        name: /^[^0-9_!¡?÷¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/,
        // suffix: /(?i)(?:Jr\.?|Sr\.?|I{1,3}|IV|V|VI{1,3}|IX|X)$/,
        email: /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/,
        uppercase: /^(?=.*?[A-Z]).+$/,
        lowercase: /^(?=.*?[a-z]).+$/,
        number: /^(?=.*?[0-9]).+$/,
        special: /^(?=.*?[#?!@$%^&*-_]).+$/,
        username: /^[a-zA-Z0-9]{5}$/,
        employeeId: /[0-9]+$/,
        cardID: /[0-9]+$/,
        userRole: /[0-9]+$/,
        staffType: /^([a-zA-Z ]{2,30})-([a-zA-Z ]{2,30})$|^([a-zA-Z ]{2,30}) ([a-zA-Z ]{2,30})$/,
        flagEmp: /[0-9]+$/
    }

    function hideError() {
        const error = document.querySelectorAll('.badge');
        error.forEach((err) => {
            err.style.display = 'none';
        });
    }
    hideError();

    // for adding new user account
    function validateEmployeeId() {
        // Get the employee ID input field
        const employeeId = document.getElementById("employee_id");
        var condition_state;

        // Validate the employee ID
        if (employeeId.value.trim() === "") {
            // If the employee ID is empty, display an error message
            document.getElementById("err_emp_id").style.display = "block";
            document.getElementById("err_emp_id").innerHTML = "Employee ID cannot be empty.";
            employeeId.focus();
            condition_state = false;
        } else if (!inputRegex.employeeId.test(employeeId.value.trim())) {
            // If the employee ID does not match the regex, display an error message
            document.getElementById("err_emp_id").style.display = "block";
            document.getElementById("err_emp_id").innerHTML = "Invalid employee ID.";
            employeeId.focus();
            condition_state = false;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'employee_id',
                    'valid_value': employeeId.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the employee ID is already exist, display an error message
                        document.getElementById("err_emp_id").style.display = "block";
                        document.getElementById("err_emp_id").innerHTML = "Employee ID already exist.";
                        employeeId.focus();
                    } else {
                        condition_state = true;
                        // If the employee ID is not empty, clear any error message
                        document.getElementById("err_emp_id").innerHTML = "";
                        document.getElementById("err_emp_id").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function validateCardId() {
        // Get the card ID input field
        const cardId = document.getElementById("card_id");
        var condition_state;
        // Validate the card ID
        if (cardId.value.trim() === "") {
            // If the card ID is empty, display an error message
            document.getElementById("err_card_id").style.display = "block";
            document.getElementById("err_card_id").innerHTML = "Card ID cannot be empty.";
            cardId.focus();
            condition_state = false;
        } else if (!inputRegex.cardID.test(cardId.value.trim())) {
            // If the card ID does not match the regex, display an error message
            document.getElementById("err_card_id").style.display = "block";
            document.getElementById("err_card_id").innerHTML = "Invalid card ID.";
            cardId.focus();
            condition_state = false;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'card_id',
                    'valid_value': cardId.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the card ID is already exist, display an error message
                        document.getElementById("err_card_id").style.display = "block";
                        document.getElementById("err_card_id").innerHTML = "Card ID already exist.";
                        employeeId.focus();
                    } else {
                        condition_state = true;
                        // If the card ID is not empty, clear any error message
                        document.getElementById("err_card_id").innerHTML = "";
                        document.getElementById("err_card_id").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function validateFName() {
        // Get the first name input field
        const f_name = document.getElementById("f_name");
        var condition_state;

        // Validate the input
        if (f_name.value.trim() === "") {
            // If the first name is empty, display an error message
            document.getElementById("err_f_name").style.display = "block";
            document.getElementById("err_f_name").innerHTML = "First name cannot be empty.";
            f_name.focus();
            condition_state = false;
        } else if (!inputRegex.name.test(f_name.value.trim())) {
            // If the first name does not match the regex, display an error message
            document.getElementById("err_f_name").style.display = "block";
            document.getElementById("err_f_name").innerHTML = "Invalid first name.";
            f_name.focus();
            condition_state = false;
        } else {
            document.getElementById("err_f_name").innerHTML = "";
            document.getElementById("err_f_name").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateMName() {
        // Get the middle name input field
        const m_name = document.getElementById("m_name");
        var condition_state;

        // Validate the input
        if (m_name.value.trim() === "") {
            // If the middle name is empty, clear any error message
            document.getElementById("err_m_name").innerHTML = "";
            document.getElementById("err_m_name").style.display = "none";
            condition_state = true;
        } else if (!inputRegex.name.test(m_name.value.trim())) {
            // If the middle name does not match the regex, display an error message
            document.getElementById("err_m_name").style.display = "block";
            document.getElementById("err_m_name").innerHTML = "Invalid middle name.";
            m_name.focus();
            condition_state = false;
        } else {
            document.getElementById("err_m_name").innerHTML = "";
            document.getElementById("err_m_name").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateLName() {
        // Get the last name input field
        const l_name = document.getElementById("l_name");
        var condition_state;

        // Validate the input
        if (l_name.value.trim() === "") {
            // If the last name is empty, display an error message
            document.getElementById("err_l_name").style.display = "block";
            document.getElementById("err_l_name").innerHTML = "Last name cannot be empty.";
            l_name.focus();
            condition_state = false;
        } else if (!inputRegex.name.test(l_name.value.trim())) {
            // If the last name does not match the regex, display an error message
            document.getElementById("err_l_name").style.display = "block";
            document.getElementById("err_l_name").innerHTML = "Invalid last name.";
            l_name.focus();
            condition_state = false;
        } else {
            document.getElementById("err_l_name").innerHTML = "";
            document.getElementById("err_l_name").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateUsername() {
        // Get the username input field
        const username = document.getElementById("username");
        var condition_state;
        // Validate the username
        if (username.value.trim() === "") {
            // If the username is empty, display an error message
            document.getElementById("err_username").style.display = "block";
            document.getElementById("err_username").innerHTML = "Username cannot be empty.";
            username.focus();
            condition_state = false;
        } else if (username.value.trim().length < 5) {
            // If the username is less than 5 characters, display an error message
            document.getElementById("err_username").style.display = "block";
            document.getElementById("err_username").innerHTML = "Must be at least 5 characters long.";
            username.focus();
            condition_state = false;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'username',
                    'valid_value': username.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the username is already exist, display an error message
                        document.getElementById("err_username").style.display = "block";
                        document.getElementById("err_username").innerHTML = "Username already exist.";
                        username.focus();
                    } else {
                        condition_state = true;
                        // If the username is not empty, clear any error message
                        document.getElementById("err_username").innerHTML = "";
                        document.getElementById("err_username").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function validateEmail() {
        // Get the email input field
        const email = document.getElementById("email");
        var condition_state;
        // Validate the email
        if (email.value.trim() === "") {
            // If the email is empty, display an error message
            document.getElementById("err_email").style.display = "block";
            document.getElementById("err_email").innerHTML = "Email cannot be empty.";
            email.focus();
            condition_state = false;
        } else if (!inputRegex.email.test(email.value.trim())) {
            // If the email is not in a valid format, display an error message
            document.getElementById("err_email").style.display = "block";
            document.getElementById("err_email").innerHTML = "Email is not in a valid format.";
            email.focus();
            condition_state = false;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'email_address',
                    'valid_value': email.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the email address is already exist, display an error message
                        document.getElementById("err_email").style.display = "block";
                        document.getElementById("err_email").innerHTML = "Email address already exist.";
                        username.focus();
                    } else {
                        condition_state = true;
                        // If the email address is not empty, clear any error message
                        document.getElementById("err_email").innerHTML = "";
                        document.getElementById("err_email").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function validatePosition() {
        // Get the position input field
        const position = document.getElementById("position");
        var condition_state;
        // Validate the position
        if (position.value.trim() === "") {
            // If the position is empty, display an error message
            document.getElementById("err_position").style.display = "block";
            document.getElementById("err_position").innerHTML = "Position cannot be empty.";
            position.focus();
            condition_state = false;
        } else if (!inputRegex.staffType.test(position.value.trim())) {
            // If the position does not match the regex pattern, display an error message
            document.getElementById("err_position").style.display = "block";
            document.getElementById("err_position").innerHTML = "Invalid position.";
            position.focus();
            condition_state = false;
        } else {
            // If the position is not empty, clear any error messages
            document.getElementById("err_position").innerHTML = "";
            document.getElementById("err_position").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateRole() {
        // Get the flag input field
        const role = document.getElementById("role");
        var condition_state;
        // Validate the flag
        if (role.value.trim() === "") {
            // If the flag is empty, display an error message
            document.getElementById("err_role").style.display = "block";
            document.getElementById("err_role").innerHTML = "User role cannot be empty.";
            role.focus();
            condition_state = false;
        } else if (!inputRegex.flagEmp.test(role.value.trim())) {
            // If the flag does not match the regex pattern, display an error message
            document.getElementById("err_role").style.display = "block";
            document.getElementById("err_role").innerHTML = "Invalid user role.";
            role.focus();
            condition_state = false;
        } else {
            // If the flag is not empty, clear any error messages
            document.getElementById("err_role").innerHTML = "";
            document.getElementById("err_role").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    // for updating information
    function updateEmployeeId(val, old_val) {
        // Get the employee ID input field
        const employeeID = document.getElementById("employeeID");
        var condition_state;

        // Validate the input
        if (employeeID.value.trim() === "") {
            // If the employee ID is empty, display an error message
            document.getElementById("err_employeeID").style.display = "block";
            document.getElementById("err_employeeID").innerHTML = "Employee ID cannot be empty.";
            employeeID.focus();
            condition_state = false;
        } else if (!inputRegex.employeeId.test(employeeID.value.trim())) {
            // If the employee ID does not match the regex, display an error message
            document.getElementById("err_employeeID").style.display = "block";
            document.getElementById("err_employeeID").innerHTML = "Invalid employee ID.";
            employeeID.focus();
            condition_state = false;
        } else if (old_val.toLowerCase() == val.toLowerCase()) {
            // If the val (employee ID) is equal to old_value , clear any error message
            document.getElementById("err_employeeID").innerHTML = "";
            document.getElementById("err_employeeID").style.display = "none";
            condition_state = true;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'employee_id',
                    'valid_value': val
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the employee ID is already exist, display an error message
                        document.getElementById("err_employeeID").style.display = "block";
                        document.getElementById("err_employeeID").innerHTML = "Employee ID already exist.";
                        employeeID.focus();
                    } else {
                        condition_state = true;
                        // If the employee ID is not empty, clear any error message
                        document.getElementById("err_employeeID").innerHTML = "";
                        document.getElementById("err_employeeID").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function updateCardId(val, old_val) {
        // Get the card ID input field
        const cardID = document.getElementById("cardID");
        var condition_state;

        // Validate the input
        if (cardID.value.trim() === "") {
            // If the card ID is empty, display an error message
            document.getElementById("err_cardID").style.display = "block";
            document.getElementById("err_cardID").innerHTML = "Card ID cannot be empty.";
            cardID.focus();
            condition_state = false;
        } else if (!inputRegex.cardID.test(cardID.value.trim())) {
            // If the card ID does not match the regex, display an error message
            document.getElementById("err_cardID").style.display = "block";
            document.getElementById("err_cardID").innerHTML = "Invalid card ID.";
            cardID.focus();
            condition_state = false;
        } else if (old_val.toLowerCase() == val.toLowerCase()) {
            // If the val (card ID) is equal to old_val , clear any error message
            document.getElementById("err_cardID").innerHTML = "";
            document.getElementById("err_cardID").style.display = "none";
            condition_state = true;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'card_id',
                    'valid_value': val
                },
                dataType: 'json',
                success: function(response) {
                    if (response === 'exist') {
                        // If the card ID is already exist, display an error message
                        document.getElementById("err_cardID").style.display = "block";
                        document.getElementById("err_cardID").innerHTML = "Card ID already exist.";
                        cardID.focus();
                        condition_state = false;
                    } else {
                        // If the card ID is not already exist, clear any error message
                        document.getElementById("err_cardID").innerHTML = "";
                        document.getElementById("err_cardID").style.display = "none";
                        condition_state = true;
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function updateFName(val) {
        // Get the first name input field
        const fName = document.getElementById("fName");
        var condition_state;

        // Validate the input
        if (fName.value.trim() === "") {
            // If the first name is empty, display an error message
            document.getElementById("err_fName").style.display = "block";
            document.getElementById("err_fName").innerHTML = "First name cannot be empty.";
            fName.focus();
            condition_state = false;
        } else if (!inputRegex.name.test(fName.value.trim())) {
            // If the first name does not match the regex, display an error message
            document.getElementById("err_fName").style.display = "block";
            document.getElementById("err_fName").innerHTML = "Invalid first name.";
            fName.focus();
            condition_state = false;
        } else {
            document.getElementById("err_fName").innerHTML = "";
            document.getElementById("err_fName").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateMName(val) {
        // Get the middle name input field
        const mName = document.getElementById("mName");
        var condition_state;

        // Validate the input
        if (mName.value.trim() === "") {
            // If the middle name is empty, clear any error message
            document.getElementById("err_mName").innerHTML = "";
            document.getElementById("err_mName").style.display = "none";
            condition_state = true;
        } else if (!inputRegex.name.test(mName.value.trim())) {
            // If the middle name does not match the regex, display an error message
            document.getElementById("err_mName").style.display = "block";
            document.getElementById("err_mName").innerHTML = "Invalid middle name.";
            mName.focus();
            condition_state = false;
        } else {
            document.getElementById("err_mName").innerHTML = "";
            document.getElementById("err_mName").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateLName(val) {
        // Get the last name input field
        const lName = document.getElementById("lName");
        var condition_state;

        // Validate the input
        if (lName.value.trim() === "") {
            // If the last name is empty, display an error message
            document.getElementById("err_lName").style.display = "block";
            document.getElementById("err_lName").innerHTML = "Last name cannot be empty.";
            lName.focus();
            condition_state = false;
        } else if (!inputRegex.name.test(lName.value.trim())) {
            // If the last name does not match the regex, display an error message
            document.getElementById("err_lName").style.display = "block";
            document.getElementById("err_lName").innerHTML = "Invalid last name.";
            lName.focus();
            condition_state = false;
        } else {
            document.getElementById("err_lName").innerHTML = "";
            document.getElementById("err_lName").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateUsername(val, old_val) {
        // Get the card ID input field
        const userName = document.getElementById("userName");
        var condition_state;

        // Validate the input
        if (userName.value.trim() === "") {
            // If the username is empty, display an error message
            document.getElementById("err_userName").style.display = "block";
            document.getElementById("err_userName").innerHTML = "Username cannot be empty.";
            userName.focus();
            condition_state = false;
        } else if (userName.value.trim().length < 5) {
            // If the username is less than 5 characters, display an error message
            document.getElementById("err_userName").style.display = "block";
            document.getElementById("err_userName").innerHTML = "Must be at least 5 characters long.";
            password.focus();
            return false;
        } else if (old_val.toLowerCase() == val.toLowerCase()) {
            // If the val (username) is equal to old_val , clear any error message
            document.getElementById("err_userName").innerHTML = "";
            document.getElementById("err_userName").style.display = "none";
            condition_state = true;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'username',
                    'valid_value': val
                },
                dataType: 'json',
                success: function(response) {
                    if (response === 'exist') {
                        // If the username is already exist, display an error message
                        document.getElementById("err_userName").style.display = "block";
                        document.getElementById("err_userName").innerHTML = "Username already exist.";
                        userName.focus();
                        condition_state = false;
                    } else {
                        // If the username is not already exist, clear any error message
                        document.getElementById("err_userName").innerHTML = "";
                        document.getElementById("err_userName").style.display = "none";
                        condition_state = true;
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function updateEmail(val, old_val) {
        // Get the email address input field
        const emailAddress = document.getElementById("emailAddress");
        var condition_state;

        // Validate the input
        if (emailAddress.value.trim() === "") {
            // If the email address is empty, display an error message
            document.getElementById("err_emailAddress").style.display = "block";
            document.getElementById("err_emailAddress").innerHTML = "Email Address cannot be empty.";
            emailAddress.focus();
            condition_state = false;
        } else if (!inputRegex.email.test(emailAddress.value.trim())) {
            // If the email address is not in a valid format, display an error message
            document.getElementById("err_emailAddress").style.display = "block";
            document.getElementById("err_emailAddress").innerHTML = "Email Address is not in a valid format.";
            emailAddress.focus();
            return false;
        } else if (old_val.toLowerCase() == val.toLowerCase()) {
            // If the val (email address) is equal to old_val , clear any error message
            document.getElementById("err_emailAddress").innerHTML = "";
            document.getElementById("err_emailAddress").style.display = "none";
            condition_state = true;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'email_address',
                    'valid_value': val
                },
                dataType: 'json',
                success: function(response) {
                    if (response === 'exist') {
                        // If the email address is already exist, display an error message
                        document.getElementById("err_emailAddress").style.display = "block";
                        document.getElementById("err_emailAddress").innerHTML = "Email Address already exist.";
                        emailAddress.focus();
                        condition_state = false;
                    } else {
                        // If the email address is not already exist, clear any error message
                        document.getElementById("err_emailAddress").innerHTML = "";
                        document.getElementById("err_emailAddress").style.display = "none";
                        condition_state = true;
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    function updatePosition(val) {
        // Get the positiion input field
        const pos = document.getElementById("pos");
        var condition_state;

        // Validate the input
        if (pos.value.trim() === "") {
            // If the position is empty, display an error message
            document.getElementById("err_pos").style.display = "block";
            document.getElementById("err_pos").innerHTML = "Position cannot be empty.";
            pos.focus();
            condition_state = false;
        } else if (!inputRegex.staffType.test(pos.value.trim())) {
            // If the position does not match the regex, display an error message
            document.getElementById("err_pos").style.display = "block";
            document.getElementById("err_pos").innerHTML = "Invalid position.";
            pos.focus();
            condition_state = false;
        } else {
            document.getElementById("err_pos").innerHTML = "";
            document.getElementById("err_pos").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateRole(val) {
        // Get the user role input field
        const userRole = document.getElementById("userRole");
        var condition_state;

        // Validate the input
        if (userRole.value.trim() === "") {
            // If the user role is empty, display an error message
            document.getElementById("err_userRole").style.display = "block";
            document.getElementById("err_userRole").innerHTML = "User Role cannot be empty.";
            userRole.focus();
            condition_state = false;
        } else if (!inputRegex.userRole.test(userRole.value.trim())) {
            // If the user role does not match the regex, display an error message
            document.getElementById("err_userRole").style.display = "block";
            document.getElementById("err_userRole").innerHTML = "Invalid user role.";
            userRole.focus();
            condition_state = false;
        } else {
            document.getElementById("err_userRole").innerHTML = "";
            document.getElementById("err_userRole").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    (function() {
        // Add user modal
        $('#add_new').on('click', function() {
            $('#add_user_modal').modal('show');
            hideError();
        });
    })();

    $("#btn_submit").click(function(e) {
        e.preventDefault();
        const formData = new FormData();

        // Values
        var employee_id = $('#employee_id').val();
        var card_id = $('#card_id').val();
        var f_name = $('#f_name').val();
        var m_name = $('#m_name').val();
        var l_name = $('#l_name').val();
        var suffix = $('#suffix').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var position = $('#position').val();
        var role = $('#role').val();

        // Functions
        var val_employee_id = validateEmployeeId();
        var val_card_id = validateCardId();
        var val_f_name = validateFName();
        var val_m_name = validateMName();
        var val_l_name = validateLName();
        var val_username = validateUsername();
        var val_email = validateEmail();
        var val_position = validatePosition();
        var val_user_role = validateRole();


        if (val_employee_id == false || val_card_id == false || val_f_name == false || val_m_name == false || val_l_name == false || val_username == false || val_email == false || val_position == false || val_user_role == false) {

        } else {
            swal.fire({
                title: 'Do you want to add this user?',
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                cancelButtonColor: '#bd362f',
                allowOutsideClick: false,
                customClass: {
                    container: 'popup-modal-container',
                    title: 'title-ff',
                    popup: 'popup-modal',
                    icon: 'popup-modal-icon',
                    actions: 'popup-modal-actions',
                    confirmButton: 'actions-confirm',
                    cancelButton: 'actions-cancel',
                    htmlContainer: 'popup-modal-description'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    formData.append("actionSubmit", "submitUser");
                    formData.append("employee_id", employee_id);
                    formData.append("card_id", card_id);
                    formData.append("f_name", f_name);
                    formData.append("m_name", m_name);
                    formData.append("l_name", l_name);
                    formData.append("suffix", suffix);
                    formData.append("username", username);
                    // formData.append("password", password);
                    formData.append("email", email);
                    formData.append("position", position);
                    formData.append("user_role", role);
                    // formData.append("flag_emp", flag_emp);
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                        }
                    });
                }
            });
        }
    });

    $("#btn_update").click(function(e) {
        e.preventDefault();
        const formData = new FormData();

        // Values
        var user_id = $('#user_id').val();
        var employeeID = $('#employeeID').val();
        var oldemployeeID = $('#oldemployeeID').val();
        var cardID = $('#cardID').val();
        var oldcardID = $('#oldcardID').val();
        var fName = $('#fName').val();
        var oldfName = $('#oldfName').val();
        var mName = $('#mName').val();
        var oldmName = $('#oldmName').val();
        var lName = $('#lName').val();
        var oldlName = $('#oldlName').val();
        var suff = $('#suff').val();
        var oldsuff = $('#oldsuff').val();
        var userName = $('#userName').val();
        var olduserName = $('#olduserName').val();
        var emailAddress = $('#emailAddress').val();
        var oldemailAddress = $('#oldemailAddress').val();
        var pos = $('#pos').val();
        var oldpos = $('#oldpos').val();
        var userRole = $('#userRole').val();
        var olduserRole = $('#olduserRole').val();

        // Functions
        var emp_id = updateEmployeeId(employeeID.trim(), oldemployeeID.trim());;
        var card_id = updateCardId(cardID.trim(), oldcardID.trim());
        var f_name = updateFName(fName.trim());
        var m_name = updateMName(mName.trim());
        var l_name = updateLName(lName.trim());
        var username = updateUsername(userName.trim(), olduserName.trim())
        var email = updateEmail(emailAddress.trim(), oldemailAddress.trim());
        var position = updatePosition(pos.trim());
        var user_role = updateRole(userRole.trim());

        if (employeeID === oldemployeeID && cardID === oldcardID && fName === oldfName && mName === oldmName && lName === oldlName && suff === oldsuff && userName === olduserName && emailAddress === oldemailAddress && pos === oldpos && userRole === olduserRole) {
            document.getElementById("err_msg").style.display = "block";
            document.getElementById("err_msg").innerHTML = "You haven't changed any of the information.";
        } else if (emp_id == false || card_id == false || f_name == false || m_name == false || l_name == false || username == false || email == false || position == false || user_role == false) {
            document.getElementById("err_msg").innerHTML = "";
            document.getElementById("err_msg").style.display = "none";
        } else {
            document.getElementById("err_msg").innerHTML = "";
            document.getElementById("err_msg").style.display = "none";
            swal.fire({
                title: 'Do you want to save the changes?',
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                cancelButtonColor: '#bd362f',
                allowOutsideClick: false,
                customClass: {
                    container: 'popup-modal-container',
                    title: 'title-ff',
                    popup: 'popup-modal',
                    icon: 'popup-modal-icon',
                    actions: 'popup-modal-actions',
                    confirmButton: 'actions-confirm',
                    cancelButton: 'actions-cancel',
                    htmlContainer: 'popup-modal-description'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    formData.append("actionUpdate", "submitUpdate");
                    formData.append("user_id", user_id);
                    formData.append("employeeID", employeeID);
                    formData.append("cardID", cardID);
                    formData.append("fName", fName);
                    formData.append("mName", mName);
                    formData.append("lName", lName);
                    formData.append("suff", suff);
                    formData.append("userName", userName);
                    formData.append("emailAddress", emailAddress);
                    formData.append("pos", pos);
                    formData.append("userRole", userRole);
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                        }
                    });
                }
            });
        }
    });

    $("#btn_deactivate").click(function(e) {
        e.preventDefault();
        const formData = new FormData();
        var user_id = $('#user_id').val();
        var employeeID = $('#oldemployeeID').val();
        formData.append("actionDeactivate", "submitDeactivate");
        formData.append("user_id", user_id);
        formData.append("employee_id", employeeID);

        swal.fire({
            title: 'Are you sure you want to deactivate this account?',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                    }
                });
            }
        });
    });

    $("#btn_activate").click(function(e) {
        e.preventDefault();
        const formData = new FormData();
        var user_id = $('#deactivate_user_id').val();
        var employeeID = $('#deactivate_emp_id').val();
        formData.append("actionActivate", "submitActivate");
        formData.append("user_id", user_id);
        formData.append("employee_id", employeeID);

        swal.fire({
            title: 'Are you sure you want to activate this account?',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                    }
                });
            }
        });
    });

    $("#btn_deactivate_locked").click(function(e) {
        e.preventDefault();
        const formData = new FormData();
        var user_id = $('#locked_user_id').val();
        var employee_id = $('#locked_emp_id').val();
        formData.append("actionUnlock", "submitUnlock");
        formData.append("user_id", user_id);
        formData.append("employee_id", employee_id);
        swal.fire({
            title: 'Are you sure you want to unlock this account?',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                    }
                });
            }
        });
    });

    $("#btn_reset").click(function(e) {
        e.preventDefault();
        const formData = new FormData();
        var user_id = $('#user_id').val();
        var employee_id = $('#employeeID').val();
        formData.append("actionReset", "submitReset");
        formData.append("user_id", user_id);
        formData.append("employee_id", employee_id);
        swal.fire({
            title: 'Are you sure you want to reset the password?',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                    }
                });
            }
        });
    });

    $("#btn_reset_locked").click(function(e) {
        e.preventDefault();
        const formData = new FormData();
        var user_id = $('#locked_user_id').val();
        var employee_id = $('#locked_emp_id').val();
        formData.append("actionReset", "submitReset");
        formData.append("user_id", user_id);
        formData.append("employee_id", employee_id);
        swal.fire({
            title: 'Are you sure you want to reset the password?',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>app_main/userprocess.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        window.location.href = '<?php echo BASE_URL; ?>app_main/user_management.php';
                    }
                });
            }
        });
    });

    function password_modal(title, content_msg) {
        swal.fire({
            title: title,
            html: `<p style="font-size:16px;">Click on the button to copy the text from the text field.</p>
                    <div class="input-group outline-secondary">
                        <input type="text" id="copyPassword" value="` + content_msg + `" autofocus="false" class="form-control" readonly>
                        <div class="input-group-append">
                            <button class="btn copyPasswordBtn" data-clipboard-target="#copyPassword"><i class="bi bi-back" style="font-size:26px;"></i></button>
                        </div>
                    </div>`,
            showConfirmButton: false,
            cancelButtonText: 'Close',
            showCancelButton: true,
            cancelButtonColor: '#bd362f',
            allowOutsideClick: false,
            customClass: {
                container: 'popup-modal-container',
                title: 'title-ff',
                popup: 'popup-modal',
                icon: 'popup-modal-icon',
                actions: 'popup-modal-actions',
                confirmButton: 'actions-confirm',
                cancelButton: 'actions-cancel',
                htmlContainer: 'popup-modal-description'
            }
        })
    }

    var clipboardPassword = new ClipboardJS('.copyPasswordBtn');

    clipboardPassword.on('success', function(e) {
        success_notif('Copied Successfully');
    });

    <?php ## sweetalert msg session
    $msg_success = $session_class->getValue('msg_success');
    if (isset($msg_success) && $msg_success != "") {
        echo "success_notif('" . $msg_success . "');";
        $session_class->dropValue('msg_success');
    }
    $msg_error = $session_class->getValue('msg_error');
    if (isset($msg_error) && $msg_error != "") {
        echo "error_notif('" . $msg_error . "');";
        $session_class->dropValue('msg_error');
    }
    $msg_password = $session_class->getValue('msg_password');
    if (isset($msg_password) && $msg_password != "") {
        echo "password_modal('" . $msg_password['title'] . "','" . $msg_password['content_msg'] . "');";
        $session_class->dropValue('msg_password');
    }
    ?>
</script>

</html>