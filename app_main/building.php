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
            <h1>Building Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_main/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Building Management</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold d-flex align-items-center justify-content-between" style="font-size: large;">
                    <div>
                        <i class="bi bi-person-circle"></i>&ensp;List of Building Name
                    </div>
                    <div class="mx-1">
                        <button id="add_new" class="btn btn-outline-light btn-rounded btn-sm ml-1"><i class="bi bi-plus-circle"></i> Add Building</button>
                    </div>
                </div>
                <div class="card-body mt-3 bg-white">
                    <div class="card">
                        <div id="building-table" class="table table-borderless"></div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="add_build_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Add Building</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label" for="operator"><b>Operator</b> <span class="required-field"></span></label>
                                    <select name="operator" id="operator" class="form-control">
                                        <option value="" selected disabled>Select Operator</option>
                                        <?php
                                        $sg_array = array();
                                        $sg_sql = "SELECT operator FROM sg_setting";
                                        if ($sg_query = mysqli_query($db_connect, $sg_sql)) {
                                            if ($sg_num = mysqli_num_rows($sg_query)) {
                                                while ($sg_data = mysqli_fetch_assoc($sg_query)) {
                                                    $sg_array[] = "'" . $sg_data['operator'] . "'";
                                                }
                                            }
                                        }
                                        if (!(empty($sg_array))) {
                                            $sg_operator = implode(", ", $sg_array);
                                        } else {
                                            $sg_operator = "' '";
                                        }
                                        $user_sql = "SELECT employee_id,f_name,m_name,l_name,suffix FROM users WHERE NOT employee_id IN ($sg_operator) AND user_role = '3' ORDER BY f_name ASC";
                                        if ($user_query = mysqli_query($db_connect, $user_sql)) {
                                            if ($user_num = mysqli_num_rows($user_query)) {
                                                while ($user_data = mysqli_fetch_assoc($user_query)) {
                                                    $name = $user_data['f_name'] . ' ' . ($user_data['m_name'] != null || $user_data['m_name'] != '' ? $user_data['m_name'] . ' ' : '') . '' . $user_data['l_name'] . ' ' . $user_data['suffix'];
                                                    echo '<option value="' . $user_data['employee_id'] . '">' . $name . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span id="err_operator" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="timein"><b>Time In</b> <span class="required-field"></span></label>
                                    <input type="text" name="timein" class="timein form-control" id="timein" readonly>
                                    <span id="err_timein" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="timeout"><b>Time Out</b> <span class="required-field"></span></label>
                                    <input type="text" name="timeout" class="timeout form-control" id="timeout" readonly>
                                    <span id="err_timeout" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="building_name" class="form-label"><b>Building Name</b> <span class="required-field"></span></label>
                                    <input type="text" name="building_name" class="form-control" id="building_name" placeholder="Building Name">
                                    <span id="err_building_name" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn_submit" name="actionSubmit" value="submitBuilding">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered">
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
                            <input type="hidden" name="building_id" id="building_id">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label" for="operatorId"><b>Operator</b> <span class="required-field"></span></label>
                                    <select name="operatorId" id="operatorId" class="update_operator form-control"></select>
                                    <span id="err_operatorId" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                    <input type="hidden" name="oldoperatorId" id="oldoperatorId">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="time_in"><b>Time In</b> <span class="required-field"></span></label>
                                    <input type="text" name="time_in" class="time_in form-control" id="time_in" readonly>
                                    <span id="err_time_in" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                    <input type="hidden" name="oldtime_in" id="oldtime_in">
                                </div>
                                <div class="col-lg-6 col-md-6 mb-2">
                                    <label class="form-label" for="time_out"><b>Time Out</b> <span class="required-field"></span></label>
                                    <input type="text" name="time_out" class="time_out form-control" id="time_out" readonly>
                                    <span id="err_time_out" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                    <input type="hidden" name="oldtime_out" id="oldtime_out">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="buildingName" class="form-label"><b>Building Name</b> <span class="required-field"></span></label>
                                    <input type="text" name="buildingName" class="form-control" id="buildingName" placeholder="Building Name">
                                    <span id="err_buildingName" class="badge bg-danger text-white rounded-1 p-1 mt-1 text-sm-start"></span>
                                    <input type="hidden" name="oldbuildingName" id="oldbuildingName">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btn_update" name="actionUpdate" value="updateUser">Update Information</button>
                            </div>
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
        const btnAction = function(cell, formatterParams, onRendered) { // for updating the information
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
                $.ajax({
                    data: {
                        "updateBuildingId": data.employee_id
                    },
                    url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                    type: 'post',
                    success: function(response) {
                        $(".update_operator").html(response);
                    },
                    async: false
                });

                $("#update_modal").modal("show");
                // Set the values of the form
                document.getElementById("update_modal").querySelector("#building_id").value = data.id;
                document.getElementById("update_modal").querySelector("#operatorId").value = data.employee_id;
                document.getElementById("update_modal").querySelector("#oldoperatorId").value = data.employee_id;
                document.getElementById("update_modal").querySelector("#time_in").value = data.time_In;
                document.getElementById("update_modal").querySelector("#oldtime_in").value = data.time_In;
                document.getElementById("update_modal").querySelector("#time_out").value = data.time_Out;
                document.getElementById("update_modal").querySelector("#oldtime_out").value = data.time_Out;
                document.getElementById("update_modal").querySelector("#buildingName").value = data.building;
                document.getElementById("update_modal").querySelector("#oldbuildingName").value = data.building;
                document.getElementById("update_modal").querySelector("#accountStatus").innerHTML = "- Active Account";
                // updatelink('building', data.employee_id_param);
                document.getElementById("err_msg").innerHTML = "";
                document.getElementById("err_msg").style.display = "none";
                document.getElementById("err_operatorId").innerHTML = "";
                document.getElementById("err_operatorId").style.display = "none";
                document.getElementById("err_time_in").innerHTML = "";
                document.getElementById("err_time_in").style.display = "none";
                document.getElementById("err_time_out").innerHTML = "";
                document.getElementById("err_time_out").style.display = "none";
                document.getElementById("err_buildingName").innerHTML = "";
                document.getElementById("err_buildingName").style.display = "none";
            });

            delete_btn.classList.add("btn", "btn-sm", "btn-outline-danger", "btn-rounded", "m-1");
            delete_btn.style.fontSize = "small";
            delete_btn.innerHTML = '<i class="bi bi-trash"></i>&ensp;Delete';
            delete_btn.addEventListener("click", function() {
                swal.fire({
                    title: 'Are you sure you want to delete this?',
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
                        var building_id = data.id;
                        var operator = data.operator;
                        formData.append("actionDelete", 'submitDelete');
                        formData.append("building_id", building_id);
                        formData.append("operator", operator);
                        $.ajax({
                            url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                window.location.href = '<?php echo BASE_URL; ?>app_main/building.php';
                            }
                        });
                    }
                })
            });

            actionBut.appendChild(edit_btn);
            actionBut.appendChild(delete_btn);
            return cellEl.appendChild(actionBut);
        };

        const table = new Tabulator("#building-table", {
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
                table: 'building'
            },
            ajaxURL: "<?php echo BASE_URL; ?>app_main/buildingprocess.php",
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
                    title: "Operator",
                    field: "name",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 200
                },
                {
                    title: "Time In",
                    field: "time_In",
                    minWidth: 200
                },
                {
                    title: "Time Out",
                    field: "time_Out",
                    minWidth: 200
                },
                {
                    title: "Building Name",
                    field: "building",
                    minWidth: 200
                },
                {
                    title: "Action",
                    field: "user_id",
                    formatter: btnAction,
                    minWidth: 250,
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

    function hideError() {
        const error = document.querySelectorAll('.badge');
        error.forEach((err) => {
            err.style.display = 'none';
        });
    }
    hideError();

    // for adding new building
    function validateOperator() {
        // Get the Operator input field
        const operator = document.getElementById("operator");
        var condition_state;

        // Validate the Operator
        if (operator.value.trim() === "") {
            // If the Operator is empty, display an error message
            document.getElementById("err_operator").style.display = "block";
            document.getElementById("err_operator").innerHTML = "Please Select Operator.";
            operator.focus();
            condition_state = false;
        } else {
            document.getElementById("err_operator").innerHTML = "";
            document.getElementById("err_operator").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateTimeIn() {
        // Get the Time In input field
        const timein = document.getElementById("timein");
        var condition_state;
        // Validate the Time In
        if (timein.value.trim() === "") {
            // If the Time In is empty, display an error message
            document.getElementById("err_timein").style.display = "block";
            document.getElementById("err_timein").innerHTML = "Time in cannot be empty.";
            timein.focus();
            condition_state = false;
        } else {
            document.getElementById("err_timein").innerHTML = "";
            document.getElementById("err_timein").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateTimeOut() {
        // Get the time out input field
        const timeout = document.getElementById("timeout");
        var condition_state;

        // Validate the input
        if (timeout.value.trim() === "") {
            // If the time out is empty, display an error message
            document.getElementById("err_timeout").style.display = "block";
            document.getElementById("err_timeout").innerHTML = "Time out cannot be empty.";
            timeout.focus();
            condition_state = false;
        } else {
            document.getElementById("err_timeout").innerHTML = "";
            document.getElementById("err_timeout").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function validateBuildingName() {
        // Get the building name input field
        const building_name = document.getElementById("building_name");
        var condition_state;

        // Validate the input
        if (building_name.value.trim() === "") {
            // If the building name is empty, clear any error message
            document.getElementById("err_building_name").style.display = "block";
            document.getElementById("err_building_name").innerHTML = "Building name cannot be empty.";
            building_name.focus();
            condition_state = false;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'building',
                    'valid_value': building_name.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the building_name is already exist, display an error message
                        document.getElementById("err_building_name").style.display = "block";
                        document.getElementById("err_building_name").innerHTML = "Building name already exist.";
                        building_name.focus();
                    } else {
                        condition_state = true;
                        // If the building_name is not empty, clear any error message
                        document.getElementById("err_building_name").innerHTML = "";
                        document.getElementById("err_building_name").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    // for updating information
    function updateOperator() {
        // Get the Operator input field
        const operatorId = document.getElementById("operatorId");
        var condition_state;

        // Validate the Operator
        if (operatorId.value.trim() === "") {
            // If the Operator is empty, display an error message
            document.getElementById("err_operatorId").style.display = "block";
            document.getElementById("err_operatorId").innerHTML = "Please Select Operator.";
            operatorId.focus();
            condition_state = false;
        } else {
            document.getElementById("err_operatorId").innerHTML = "";
            document.getElementById("err_operatorId").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateTimeIn() {
        // Get the Time In input field
        const time_in = document.getElementById("time_in");
        var condition_state;
        // Validate the Time In
        if (time_in.value.trim() === "") {
            // If the Time In is empty, display an error message
            document.getElementById("err_time_in").style.display = "block";
            document.getElementById("err_time_in").innerHTML = "Time in cannot be empty.";
            time_in.focus();
            condition_state = false;
        } else {
            document.getElementById("err_time_in").innerHTML = "";
            document.getElementById("err_time_in").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateTimeOut() {
        // Get the time out input field
        const time_out = document.getElementById("time_out");
        var condition_state;

        // Validate the input
        if (time_out.value.trim() === "") {
            // If the time out is empty, display an error message
            document.getElementById("err_time_out").style.display = "block";
            document.getElementById("err_time_out").innerHTML = "Time out cannot be empty.";
            time_out.focus();
            condition_state = false;
        } else {
            document.getElementById("err_time_out").innerHTML = "";
            document.getElementById("err_time_out").style.display = "none";
            condition_state = true;
        }
        return condition_state;
    }

    function updateBuildingName() {
        // Get the building name input field
        const buildingName = document.getElementById("buildingName");
        const oldbuildingName = document.getElementById("oldbuildingName");
        var condition_state;

        // Validate the input
        if (buildingName.value.trim() === "") {
            // If the building name is empty, clear any error message
            document.getElementById("err_buildingName").style.display = "block";
            document.getElementById("err_buildingName").innerHTML = "Building name cannot be empty.";
            buildingName.focus();
            condition_state = false;
        } else if (buildingName.value.trim() == oldbuildingName.value.trim()) {
            // If the building name is empty, clear any error message
            document.getElementById("err_buildingName").innerHTML = "";
            document.getElementById("err_buildingName").style.display = "none";
            buildingName.focus();
            condition_state = true;
        } else {
            $.ajax({
                url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                type: 'post',
                data: {
                    'valid_input': 'building',
                    'valid_value': buildingName.value.trim()
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'exist') {
                        condition_state = false;
                        // If the building_name is already exist, display an error message
                        document.getElementById("err_buildingName").style.display = "block";
                        document.getElementById("err_buildingName").innerHTML = "Building name already exist.";
                        buildingName.focus();
                    } else {
                        condition_state = true;
                        // If the building_name is not empty, clear any error message
                        document.getElementById("err_buildingName").innerHTML = "";
                        document.getElementById("err_buildingName").style.display = "none";
                    }
                },
                async: false
            });
        }
        return condition_state;
    }

    (function() {
        // Add user modal
        $('#add_new').on('click', function() {
            $('#add_build_modal').modal('show');
            hideError();
        });

        $('input.timein').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '5:00am',
            maxTime: '12:00pm',
            defaultTime: '8',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            zindex: 9999999
        });

        $('input.timeout').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '1:00pm',
            maxTime: '10:00pm',
            defaultTime: '17',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            zindex: 9999999
        });

        $('input.time_in').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '5:00am',
            maxTime: '12:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            zindex: 9999999
        });

        $('input.time_out').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '1:00pm',
            maxTime: '10:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            zindex: 9999999
        });
    })();

    $("#btn_submit").click(function(e) {
        e.preventDefault();
        const formData = new FormData();

        // Values
        var operator = $('#operator').val();
        var timein = $('#timein').val();
        var timeout = $('#timeout').val();
        var building_name = $('#building_name').val();

        // Functions
        var val_operator = validateOperator();
        var val_timein = validateTimeIn();
        var val_timeout = validateTimeOut();
        var val_building_name = validateBuildingName();

        if (val_operator == false || val_timein == false || val_timeout == false || val_building_name == false) {

        } else {
            swal.fire({
                title: 'Do you want to add this?',
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
                    formData.append("actionSubmit", "submitBuilding");
                    formData.append("operator", operator);
                    formData.append("timein", timein);
                    formData.append("timeout", timeout);
                    formData.append("building_name", building_name);
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            window.location.href = '<?php echo BASE_URL; ?>app_main/building.php';
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
        var building_id = $('#building_id').val();
        var operatorId = $('#operatorId').val();
        var oldoperatorId = $('#oldoperatorId').val();
        var time_in = $('#time_in').val();
        var oldtime_in = $('#oldtime_in').val();
        var time_out = $('#time_out').val();
        var oldtime_out = $('#oldtime_out').val();
        var buildingName = $('#buildingName').val();
        var oldbuildingName = $('#oldbuildingName').val();

        // Functions
        var operatorId_valid = updateOperator();
        var time_in_valid = updateTimeIn();
        var time_out_valid = updateTimeOut();
        var buildingName_valid = updateBuildingName();

        if (operatorId === oldoperatorId && time_in === oldtime_in && time_out === oldtime_out && buildingName === oldbuildingName) {
            document.getElementById("err_msg").style.display = "block";
            document.getElementById("err_msg").innerHTML = "You haven't changed any of the information.";
        } else if (operatorId_valid == false || time_in_valid == false || time_out_valid == false || buildingName_valid == false) {
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
                    formData.append("building_id", building_id);
                    formData.append("operatorId", operatorId);
                    formData.append("time_in", time_in);
                    formData.append("time_out", time_out);
                    formData.append("buildingName", buildingName);
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>app_main/buildingprocess.php',
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            window.location.href = '<?php echo BASE_URL; ?>app_main/building.php';
                        }
                    });
                }
            });
        }
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
    ?>
</script>

</html>