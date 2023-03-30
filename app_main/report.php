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
<!-- <link rel="stylesheet" href="custom_styles.css"> -->
<style>
    .tabulator-print-header,tabulator-print-footer {
        text-align: center;
    }

    .tabulator-print-table td, .tabulator-print-table th {

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
            <h1>Employee Attendance Report</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_main/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Employee Attendance Report</li>

                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold" style="font-size: large;">
                    <i class="bi bi-person-circle"></i>&ensp;Attendance Report
                </div>
                <div class="card-body mt-3">
                    <div class="card">
                        <div class="m-2">

                        </div>
                        <div class="form-group" style="margin-left:auto;" id="DateDemo">
                            <input type="text" id="report" name="report" class="form-control form-control-sm" value="<?php echo DATE_NOW; ?>" placeholder="Select Date">
                        </div>
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



    </main><!-- End #main -->

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
    

    (function() {

        attendance_report();

        var set_server_time = <?php date_default_timezone_set('Asia/Manila');
                                echo "'" . date('Y-m-d H:i:s') . "';\r\n"; ?>
        var now_server = moment();
        var dateNow = now_server.format('MM/DD/YYYY');

        $('#report').datetimepicker({
            format: 'MM/DD/YYYY',
            maxDate: dateNow,

        })

        $('#report').on('dp.change', function(e) {
            var value = $("#report").val();
            attendance_report(value);

        });

        var total_record = 0;
        var global_id = 0;
        var global_action = "save";
        var collection_select = [];

        function record_details(values, data, calcParams) {
            if (values && values.length) {


                return values.length + ' of ' + total_record;
            }
        }

        function statusClass(cell, formatterParams, onRendered) {
                const span = document.createElement("span");
                const row = cell.getRow();
                const data = row.getData();

                if (data.day == "present") {
                    span.classList.add("status-green");
                    span.style.fontSize = "small";
                    span.innerHTML = "present";
                } else {
                    span.classList.add("status-red");
                    span.style.fontSize = "small";
                    span.innerHTML = "absent";
                }
                return span;
            };

        function attendance_report(value) {

            const table = new Tabulator("#example-table", {
                ajaxSorting: false,
                ajaxFiltering: false,
                height: "500px",
                // tooltips: true,
                printAsHtml: true,
                printHeader: "<h1>Employee Attendance Record<h1>",
                printRowRange: "selected",
                headerFilterPlaceholder: "Search",
                layout: "fitColumns",
                placeholder: "No Data Found",
                movableColumns: true,
                // selectable: true,
                ajaxParams: {
                    table: 'users',
                    day: value
                },
                ajaxURL: "<?php echo BASE_URL; ?>global_process/attendance_report.php",
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
                printConfig:{
                    formatCells:false, //show raw cell values without formatter
                },

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
                        formatter: 'textarea',
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
                        formatterPrint: "datetime",
                        formatterPrintParams: {
                            inputFormat: "YYYY-MM-DD",
                            outputFormat: "MM/DD/YYYY",
                            invalidPlaceholder: "",
                        },
                    },
                    {
                        title: "Status",
                        field: "day",
                        hozAlign: "center",
                        formatter: statusClass,
                        headerFilter: "input",
                        headerFilterFunc: "like",
                        headerFilterParams: {
                            allowEmpty: true
                        },
                        minWidth: 150,
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
                rowFormatterPrint:function(row){
                    //row - row component

                    var data = row.getData();


                },
            });

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

            function printFormatter(cell, formatterParams, onRendered) {
                return cell.getValue() ? "YES" : "NO";
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

        }







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