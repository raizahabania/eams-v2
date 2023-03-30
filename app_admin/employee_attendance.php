<?php
include '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH;
require ISLOGIN;

if (!($g_user_role == "ADMIN_STAFF")) {
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
<!-- <link rel="stylesheet" href="custom_styles.css"> -->
<style>
    .tabulator-print-header,
    tabulator-print-footer {
        text-align: center;
    }

    .tabulator-print-table td,
    th {

        border: solid 1px #000 !important;
        ;
    }
</style>

<body class="d-flex flex-column h-100">

    <?php
    include_once DOMAIN_PATH . '/global/header.php'; //header
    include_once DOMAIN_PATH . '/global/sidebar.php'; //sidebar
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Employee Attendance Record</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_admin/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Employee Attendance Record</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white fw-semibold" style="font-size: large;">
                    <div>
                        <i class="bi bi-person-circle"></i>&ensp;Attendance Record
                    </div>
                    <div>
                        <button id="add_new" class="btn btn-outline-light btn-rounded btn-sm ml-1"><i class="bi bi-plus-circle"></i>&ensp;Add Attendance</button>
                        <button id="add_bulk" class="btn btn-outline-light btn-rounded btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#upload_bulk"><i class="bi bi-arrow-bar-up"></i>&ensp;Add Bulk Attendance</button>
                    </div>
                </div>
                <div class="card-body mt-3">
                    <div class="card">
                        <div id="example-table" class="table table-borderless"></div>
                        <div>
                            <button class="btn btn-primary" id="download-csv">Download CSV</button>
                            <button class="btn btn-primary" id="download-json">Download JSON</button>
                            <button class="btn btn-primary" id="download-xlsx">Download XLSX</button>
                            <button class="btn btn-primary" id="print-table">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editattendance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> </h5>
                    <button type="button" class="btn bg-light" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form_submit">
                        <?php include DOMAIN_PATH . '/global_process/edit_user.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_btn" data-bs-dismiss="modal">Close</button>
                    <button name="save" value="<?php echo $action_form; ?>" class="btn btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>


    <!-- Bulk Modal -->
    <div class="modal fade" id="upload_bulk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Bulk Insert Attendance</h5>
                    <button type="button" class="btn-close" id="close_csv_upload" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a id="template" href="<?php echo BASE_URL; ?>global_process/download.php?path=<?php echo EMP_ATTENDANCE_RECORD_LIST; ?>">
                        <button class="btn btn-outline-primary btn-rounded alignToTitle btn-sm mb-2"><i class="bi bi-download"></i>&ensp;Download Template</button>
                    </a>
                    <form autocomplete="off" id="bulk_upload_frm" enctype="multipart/form-data">
                        <input type="file" id="bulk_insert" name="bulk_insert" class="dropify" styles="height:500px" data-default-file="" accept="text/*" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_bulk">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!---- alert modal rows-->
    <div class="modal fade" id="row_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="alert alert-danger m-0 pb-0 pt-2 py-1" style="border-left: solid 5px red; border-radius:0 5px 5px 0;" id="staticBackdropLabel" role="alert">
                        <h6><strong><i class="bi bi-exclamation-octagon" style="font-size:18px;"></i>&ensp;Invalid CSV file. Please input new CSV file</strong></h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bulk_modal_body" style="overflow:auto;">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload_bulk">Upload Another</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once FOOTER_PATH; //footer
    include_once DOMAIN_PATH . '/global/include_bottom.php'; //scripts
    ?>
</body>

<script>
    // time 
    $(document).ready(function() {

        // Set time and date
        var set_server_time = <?php date_default_timezone_set('Asia/Manila');
                                echo "'" . date('Y-m-d H:i:s') . "';\r\n"; ?>
        var serverOffset = moment(set_server_time).diff(new Date());
        clearInterval(clock_id);
        var now_server = moment();
        var dateNow = now_server.format('ddd | MMMM DD, YYYY');
        $('#nowDate').html(dateNow);
        var clock_id = setInterval(function() {
            if (document.getElementById('nowTime')) {
                var now_server = moment();
                now_server.add(serverOffset, 'milliseconds');
                var timeNow = now_server.format('h:mm:ss A');
                $('#nowTime').html(timeNow);
            } else {
                clearInterval(clock_id);
            }
        }, 1000);
        // End set time and date
    });

    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#date_log').attr('max', maxDate);
    });

    (function() {
        var bulk_insert = $('#bulk_insert').dropify({});
        bulk_insert = bulk_insert.data('bulk_insert');
        $("#bulk_insert").change(function() {
            var file = this.files[0];
            var fileType = file.type;
            var match = ['text/csv'];
            if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
                Toast.fire({
                    background: '#bd362f',
                    icon: 'error',
                    title: 'Not a Csv file!',
                    text: 'Only Csv file allowed',
                    timer: 1500
                })
                $('.dropify-clear').click();
                return false;
            }
        });


        $("#bulk_upload_frm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>global_process/attendance_bulk.php",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#submit_bulk").attr("disabled", true);
                    $('#submit_bulk').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    $(".close_csv_upload").attr("disabled", true);
                },
                complete: function() {
                    $('#submit_bulk').html('Submit');
                    $('#submit_bulk').removeAttr('disabled');
                    $(".close_csv_upload").removeAttr('disabled');
                },
                success: function(response) {
                    if (response.error == true) {
                        var html_code = "<table class='table table-striped'>";
                        html_code += "<thead>";
                        html_code += "<tr class='border-bottom'><th class='border-0'>#</th>";
                        html_code += "<th class='border-0'>Employee ID</th>";
                        html_code += "<th class='border-0'>Date</th>";
                        html_code += "<th class='border-0'>Time In</th>";
                        html_code += "<th class='border-0'>Break Out</th>";
                        html_code += " <th class='border-0'>Break In</th>";
                        html_code += "<th class='border-0'>Time Out</th>";
                        html_code += "<th class='border-0'>Remarks</th></tr></thead>";
                        html_code += "<tbody>" + response.row.join('') + "</tbody></table>";
                        bulk_modal_body
                        $('#upload_bulk').modal('hide');
                        $('#row_modal').modal('show');
                        $('#bulk_modal_body').html(html_code);
                        $('.dropify-clear').click();
                    }
                    if (response.message == "success") {
                        $('.dropify-clear').click();
                        Toast.fire({
                            title: '<span style="color:white">Record has been Added!</span>',
                            background: '#51a351',
                            icon: 'success',
                            timer: 3000
                        });
                        $('#upload_bulk').modal('hide');
                    }

                    if (response.message == "empty") {
                        $('.dropify-clear').click();
                        swal.fire({
                            title: 'This Csv is Empty!',
                            icon: 'error',
                            timer: 3000
                        });
                    }
                },
            });
        });

        var total_record = 0;
        var global_id = 0;
        var date_log_hide = "";
        var global_action = "save";
        var collection_select = [];

        //selctize
        var employee_select = $("#employee_id").selectize({
            valueField: "user_id",
            labelField: "name",
            searchField: "name",
            create: false,
            maxItems: 1,
            render: {
                option: function(item, escape) {
                    return (
                        "<div>" +
                        "<span class='title'>" + escape(item.name) + "</span>" +
                        '<p class="text-muted  m-0">' + escape(item.position) + "</p>" +
                        "</div>"
                    );
                },
                item: function(item, escape) {
                    return "<div>" + (item.name ? '<span class="name">' + escape(item.name) + "</span>" : "") + "</div>";
                },
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "<?php echo BASE_URL . 'global_process/data.php?data='; ?>" + encodeURIComponent(query),
                    type: "GET",
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.data);
                    },
                });
            },
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            background: '#51a351',
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $("#form_submit").on('submit', function(e) {
            e.preventDefault();
            var formdata = new FormData(this);

            $(".form-message").css("display", "");
            $("#in").css({
                "border-color": '',
                "color": ''
            });
            $("#out").css({
                "border-color": '',
                "color": ''
            });

            if ($("#in").val() >= $("#out").val()) {
                $(".form-message").html("Time in must be less than time out");
                $(".form-message").css("display", "block");
                $("#in").css({
                    "border-color": 'red',
                    "color": 'red'
                });
                $("#out").css({
                    "border-color": 'red',
                    "color": 'red'
                });
                return;
            }

            if ($("#bout").val() != "" || $("#bin").val() != "") {

                if ($("#bout").val() <= $("#in").val()) {
                    $(".form-message").html("Break out must be greater than time in");
                    $(".form-message").css("display", "block");
                    $("#in").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    $("#bout").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    return;
                }
                if ($("#bout").val() >= $("#out").val()) {
                    $(".form-message").html("Break out must be less than time out");
                    $(".form-message").css("display", "block");
                    $("#out").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    $("#bout").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    return;
                }
                if ($("#bin").val() <= $("#bout").val()) {
                    $(".form-message").html("Break in must be greater than break out");
                    $(".form-message").css("display", "block");
                    $("#bout").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    $("#bin").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    return;
                }

                if ($("#bin").val() <= $("#in").val()) {
                    $(".form-message").html("Break in must be greater than time in");
                    $(".form-message").css("display", "block");
                    $("#bin").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    $("#in").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    return;
                }

                if ($("#bin").val() > $("#out").val()) {
                    $(".form-message").html("Break in must be less than time out");
                    $(".form-message").css("display", "block");
                    $("#bin").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    $("#out").css({
                        "border-color": 'red',
                        "color": 'red'
                    });
                    return;
                }
            }

            formdata.append('get_id', global_id);
            formdata.append('date_log_hide', date_log_hide);
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL; ?>global_process/update_submit.php",
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,

                success: function(response) {
                    if (response.success) {
                        $('#editattendance').modal('hide');
                        table.setData();
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

        function record_details(values, data, calcParams) {
            if (values && values.length) {


                return values.length + ' of ' + total_record;
            }
        }

        const table = new Tabulator("#example-table", {
            ajaxSorting: false,
            ajaxFiltering: false,
            height: "500px",
            // tooltips: true,
            printAsHtml: true,
            printStyled: false,
            printHeader: "<h1>Employee Attendance Record<h1>",
            printRowRange: "selected",
            headerFilterPlaceholder: "Search",
            layout: "fitColumns",
            placeholder: "No Data Found",
            movableColumns: true,
            // selectable: true,
            ajaxParams: {
                table: 'users'
            },
            ajaxURL: "<?php echo BASE_URL; ?>global_process/attendance_record.php",
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
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,

                },
                {
                    title: "Name",
                    field: "name",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,

                },
                {
                    title: "Date",
                    field: "date_log",
                    minWidth: 150,
                    hozAlign: "right",
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "YYYY-MM-DD",
                        outputFormat: "MM/DD/YYYY",
                        invalidPlaceholder: "",
                    },
                    headerFilter: "input",
                    headerFilterPlaceholder: "Search",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    align: "center",
                },
                {
                    title: "Time In",
                    field: "time_in",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,
                    // formatter: "datetime",
                    // formatterParams: {
                    //     inputFormat: "HH:mm:ss",
                    //     outputFormat: "hh:mm:ss A",
                    //     invalidPlaceholder: "",
                    // },

                },
                {
                    title: "Break Out",
                    field: "break_out",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "HH:mm:ss",
                        outputFormat: "hh:mm:ss A",
                        invalidPlaceholder: "",
                    },

                },
                {
                    title: "Break In",
                    field: "break_in",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "HH:mm:ss",
                        outputFormat: "hh:mm:ss A",
                        invalidPlaceholder: "",
                    },

                },
                {
                    title: "Time Out",
                    field: "time_out",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,
                    // formatter: "datetime",
                    // formatterParams: {
                    //     inputFormat: "HH:mm:ss",
                    //     outputFormat: "hh:mm:ss A",
                    //     invalidPlaceholder: "",
                    // },

                },
                {
                    title: "Total Time",
                    field: "total_hour",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,

                },
                {
                    title: "Total Hours",
                    field: "total_hours",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,
                },
                {
                    title: "Total Break",
                    field: "total_break",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,

                },
                {
                    formatter: editAttendance,
                    hozAlign: "right",
                    headerSort: false,
                    headerFilter: false,
                    download: false,
                    print: false,
                    hozAlign: "center",
                    minWidth: 100,
                    cellClick: function(e, cell) {
                        cell.getRow().toggleSelect();
                    }
                },

            ],
            ajaxResponse: function(url, params, response) {
                //url - the URL of the request
                //params - the parameters passed with the request
                //response - the JSON object returned in the body of the response.
                return response; //return the tableData property of a response json object
            },
            ajaxResponse: function(url, params, response) {
                if (response.total_record) {
                    total_record = response.total_record;
                }
                return response;
            },
            renderComplete: function() {
                var table = this;
                this.selectRow(collection_select);
            },
            rowSelected: function(row) {
                if (collection_select.indexOf(row.getData().id) === -1) {
                    collection_select.push(row.getData().id);
                }
            },
            rowDeselected: function(row) {
                if (collection_select.indexOf(row.getData().id) !== -1) {
                    collection_select.splice(collection_select.indexOf(row.getData().id), 1);
                }
            },
            ajaxRequesting: function(url, params) {
                if (typeof this.modules.ajax.showLoader() != "undefined") {
                    this.modules.ajax.showLoader();
                }
            },
        })

        var add_new = document.getElementById('add_new');
        addListener(add_new, "click", function() {
            var selectize = employee_select[0].selectize;
            selectize.clear();

            $(".form-message").css("display", "");
            $("#bout").css({
                "border-color": '',
                "color": ''
            });
            $("#bin").css({
                "border-color": '',
                "color": ''
            });
            $("#in").css({
                "border-color": '',
                "color": ''
            });
            $("#out").css({
                "border-color": '',
                "color": ''
            });
            $("#employee_id").selectize()[0].selectize.enable();
            $("select[name=employee_id]").prop('disabled', false);
            $("input[name=date_log]").prop('disabled', false);

            var employee_id = document.querySelector('input[name=employee_id]');
            var firstname = document.querySelector('input[name=firstname]');
            var lastname = document.querySelector('input[name=lastname]');
            var date_log = document.querySelector('input[name=date_log]');
            var time_in = document.querySelector('input[name=time_in]');
            var time_out = document.querySelector('input[name=time_out]');
            var break_in = document.querySelector('input[name=break_in]');
            var break_out = document.querySelector('input[name=break_out]');

            if (employee_id) {
                employee_id.value = "";
            }
            if (date_log) {
                date_log.value = "";
            }
            if (time_in) {
                time_in.value = "";
            }
            if (time_out) {
                time_out.value = "";
            }
            if (break_in) {
                break_in.value = "";
            }
            if (break_out) {
                break_out.value = "";
            }
            date_log_hide = "";
            global_id = 0;

            var save = document.querySelector('button[name=save]');

            if (save) {
                save.value = "save";
                save.innerHTML = "Add Attendance";
                global_action = "save";
            }
            console.log("add_new");
            $("#editattendance").modal('show');
        });

        function editAttendance(cell, formatterParams) {
            var cellEl = cell.getElement(); //get cell DOM element
            var linkBut = document.createElement("span");
            var id = cell.getData().id;
            linkBut.innerHTML = "<button type='button' class='btn btn-primary attendance_edit btn-rounded btn-sm ml-1' data-bs-toggle='modal' data-bs-target='#editattendance'><i class='bi bi-pencil'> </i> EDIT</button>";
            addListener(linkBut, "click", function() {
                global_id = cell.getData().id;
                find_id = cell.getData().employee_id;
                var selectize = employee_select[0].selectize;
                $.ajax({
                    url: '<?php echo BASE_URL; ?>global_process/data.php',
                    type: 'GET',
                    //accepts:"application/json",
                    data: {
                        id: find_id
                    },
                    error: function() {
                        console.log('error connection');
                    },
                    success: function(res) {
                        if (res.result == "ok") {
                            var json = res.data;
                            json.forEach(function(existingOption) {
                                selectize.addOption(existingOption);
                                selectize.addItem(existingOption[selectize.settings.valueField]);
                            });
                            /*self.setValue(<echo isset($g_selected['percent_id']) ? $g_selected['percent_id'] : '';?>); */
                        }
                    }
                });

                $(".form-message").css("display", "");
                $("#bout").css({
                    "border-color": '',
                    "color": ''
                });
                $("#bin").css({
                    "border-color": '',
                    "color": ''
                });
                $("#in").css({
                    "border-color": '',
                    "color": ''
                });
                $("#out").css({
                    "border-color": '',
                    "color": ''
                });
                $("#employee_id").selectize()[0].selectize.disable();
                $("input[name=firstname]").prop('disabled', true);
                $("input[name=lastname]").prop('disabled', true);
                $("input[name=date_log]").prop('disabled', true);

                var employee_id = document.querySelector('input[name=employee_id]');
                var firstname = document.querySelector('input[name=firstname]');
                var lastname = document.querySelector('input[name=lastname]');
                var date_log = document.querySelector('input[name=date_log]');
                var time_in = document.querySelector('input[name=time_in]');
                var time_out = document.querySelector('input[name=time_out]');
                var break_in = document.querySelector('input[name=break_in]');
                var break_out = document.querySelector('input[name=break_out]');

                if (employee_id) {
                    employee_id.value = cell.getData().employee_id;
                }
                if (firstname) {
                    firstname.value = cell.getData().firstname;
                }
                if (lastname) {
                    lastname.value = cell.getData().lastname;
                }
                if (date_log) {
                    date_log.value = cell.getData().date_log;
                }
                if (time_in) {
                    time_in.value = cell.getData().time_in;
                }
                if (time_out) {
                    time_out.value = cell.getData().time_out;
                }
                if (break_in) {
                    break_in.value = cell.getData().break_in;
                }
                if (break_out) {
                    break_out.value = cell.getData().break_out;
                }
                date_log_hide = cell.getData().date_log;

                var save = document.querySelector('button[name=save]');
                if (save) {
                    save.value = "update";
                    save.innerHTML = "Update";
                    global_action = "update";
                }

            });

            return cellEl.appendChild(linkBut);
        }

        function copyToClipboard(value) {
            const str = value;
            const el = document.createElement('textarea')
            el.value = str
            el.setAttribute('readonly', '')
            el.style.position = 'absolute'
            el.style.left = '-9999px'
            document.body.appendChild(el)
            el.select()
            document.execCommand('copy')
            document.body.removeChild(el)
        }

        addListener(document.getElementById('download-csv'), "click", function() {
            table.download("csv", "users_" + getFormattedTime() + ".csv");
        });
        addListener(document.getElementById('download-json'), "click", function() {
            table.download("json", "users_" + getFormattedTime() + ".json");
        });
        addListener(document.getElementById('download-xlsx'), "click", function() {
            table.download("xlsx", "users_" + getFormattedTime() + ".xlsx");
        });
        addListener(document.getElementById('print-table'), "click", function() {
            table.print(false, true);
        });



        function add_overlay() {
            var body = document.querySelector('body');
            var overlay = document.querySelector('.overlay');
            if (overlay) {} else {
                var div = document.createElement('div');
                div.className = "overlay";
                body.appendChild(div);
            }
        }
        add_overlay();
        $(document).on({
            ajaxStart: function() {
                addClass(document.querySelector('body'), 'loading');
                isPaused = true;
            },
            ajaxStop: function() {
                removeClass(document.querySelector('body'), "loading");
                isPaused = false;
            }
        });

    })();

    <?php ## sweetalert msg session
    $msg_success = $session_class->getValue('msg_success');
    if (isset($msg_success) and $msg_success != "") {
        echo "success_notif('" . $msg_success . "');";
        $session_class->dropValue('msg_success');
    }
    $msg_error = $session_class->getValue('msg_error');
    if (isset($msg_error) and $msg_error != "") {
        echo "error_notif('" . $msg_error . "');";
        $session_class->dropValue('msg_error');
    }
    ?>
</script>

</html>