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

<body class="d-flex flex-column h-100">

    <?php
    include_once DOMAIN_PATH . '/global/header.php'; //header
    include_once DOMAIN_PATH . '/global/sidebar.php'; //sidebar
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>My Attendance</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_admin/index.php">Home</a></li>
                    <li class="breadcrumb-item active">My Attendance</li>

                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold" style="font-size: large;">
                    <i class="bi bi-person-circle"></i>&ensp;My Attendance Record
                </div>
                <div class="card-body mt-3">
                    <div class="card">
                        <div class="m-2">

                        </div>
                        <div id="example-table" class="table table-borderless"></div>
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

        const table = new Tabulator("#example-table", {
            ajaxSorting: false,
            ajaxFiltering: false,
            height: "500px",
            // tooltips: true,
            printAsHtml: true,
            headerFilterPlaceholder: "Search",
            layout: "fitColumns",
            placeholder: "No Data Found",
            movableColumns: true,
            // selectable: true,
            ajaxParams: {
                table: 'users'
            },
            ajaxURL: "<?php echo BASE_URL; ?>global_process/table_record.php",
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
                    title: "Date",
                    field: "date_log",
                    hozAlign: "center",
                    headerFilter: "input",
                    headerFilterFunc: "like",
                    headerFilterParams: {
                        allowEmpty: true
                    },
                    minWidth: 150,

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
            ],
            ajaxResponse: function(url, params, response) {
                //url - the URL of the request
                //params - the parameters passed with the request
                //response - the JSON object returned in the body of the response.
                return response; //return the tableData property of a response json object
            },
        })

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