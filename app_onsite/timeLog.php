<?php
include '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (!($g_user_role == "ONSITE")) {
    return_role($g_user_role);
}

$activepage = ACTIVE_PAGE;
$timeIn = "00:00:00";
$timeOut = "00:00:00";
$building = "";
$employee_id = $session_class->getValue('employee_id');
$sql = "SELECT operator,time_In,time_Out,building FROM sg_setting WHERE operator='$employee_id'";
if ($query = call_mysql_query($sql)) {
    if ($num = call_mysql_num_rows($query)) {
        $data = call_mysql_fetch_array($query);
        $data = array_html($data);
        $timeIn = $data['time_In'];
        $timeOut = $data['time_Out'];
        $building = $data['building'];
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <?php
    include DOMAIN_PATH . "/global/meta_data.php";
    include DOMAIN_PATH . "/global/include_top.php";
    ?>
</head>

<body class="d-flex flex-column h-100" style="font-family: Montserrat, sans-serif;">
    <!-- HEADER -->
    <?php include_once DOMAIN_PATH . "/global/top_bar.php"; ?>

    <main class="flex-shrink-0">
        <section>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h5 class="page-title text-white"><i class="bi bi-calendar4-range"></i>&ensp;Time Log Report</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-md-inline-flex justify-content-between align-items-center mb-3 mt-3 border-bottom pb-3 d-lg-flex">
                                    <div class="w-100 p-md-2">
                                        <label for="filter-field" class="form-label">
                                            Filter BY:
                                        </label>
                                        <select id="filter-field" class="form-select">
                                            <option value="date_log">
                                                Date
                                            </option>
                                            <option value="employee_id">
                                                Employee ID
                                            </option>
                                            <option value="time_in">
                                                Time In
                                            </option>
                                            <option value="break_out">
                                                Break Out
                                            </option>
                                            <option value="break_in">
                                                Break In
                                            </option>
                                            <option value="time_out">
                                                Time Out
                                            </option>
                                            <option value="way">
                                                Status
                                            </option>
                                        </select>
                                    </div>
                                    <div class="w-100 p-lg-2">
                                        <label for="filter-value" class="form-label">
                                            Filter Value:
                                        </label>
                                        <input type="text" id="filter-value" class="form-control">
                                    </div>
                                    <div class="w-100 p-lg-2 mt-auto">
                                        <button class="btn btn-primary" id="filter-clear">Clear Filter</button>
                                    </div>
                                </div>
                                <div id="example-table" class="table table-borderless"></div>
                                <div>
                                    <button id="print-table">Print</button>
                                    <button id="download-csv">Download CSV</button>
                                    <button id="download-xlsx">Download XLSX</button>
                                    <!-- <button id="download-pdf">Download PDF</button> -->
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include DOMAIN_PATH . "/app_onsite/settings.php";
    include FOOTER_PATH;
    ?>
</body>

</html>
<?php
// script, function
include DOMAIN_PATH . "/global/include_bottom.php";
?>
<script>
    // employees attedance
    (function() {
        // Define variables for input elements
        const fieldEl = document.getElementById("filter-field");
        const typeEl = document.getElementById("filter-type");
        const valueEl = document.getElementById("filter-value");

        function handleFilterChange() {
            // Get the value of the filter input elements
            const field = fieldEl.value;
            const type = "like";
            const value = valueEl.value;

            // Clear any existing filters on the table
            table.clearFilter();

            // If all of the values are empty, don't filter the table
            if (!field || !type || !value) {
                return;
            }

            // Set the filter for the chosen column
            table.setFilter(field, type, value);
        }

        //Clear filters on "Clear Filters" button click
        document.getElementById("filter-clear").addEventListener("click", function() {
            fieldEl.value = "";
            valueEl.value = "";
            table.clearFilter();
        });

        // Add event listeners to the filter input elements
        fieldEl.addEventListener("change", handleFilterChange);
        valueEl.addEventListener("change", handleFilterChange);
        var table = new Tabulator("#example-table", {
            // pagination: true,
            // paginationMode: "remote",
            // paginationSizeSelector: [20, 50, 100],
            // paginationCounter: "rows",

            ajaxSorting: true,
            ajaxFiltering: true,
            height: "500px",
            // tooltips: true,
            printAsHtml: true,
            headerFilterPlaceholder: "",
            layout: "fitColumns",
            placeholder: "No Data Found",
            movableColumns: true,
            selectable: true,
            ajaxURL: "<?php echo BASE_URL; ?>app_onsite/timeLog_db.php",
            ajaxProgressiveLoad: "scroll",
            ajaxProgressiveLoadScrollMargin: 1,
            printConfig: {
                columnGroups: false,
                rowGroups: false,
            },
            ajaxLoader: true,
            ajaxLoaderLoading: 'Fetching data from Database..',
            selectableRollingSelection: false,
            paginationSize: 10,
            

            columns: [
                // logs employee_id, card_id, time_in, time_out, break_in, break_out, date_log
                {
                    title: "Date",
                    field: "date_log",
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "YYYY-MM-DD",
                        outputFormat: "MM-DD-YYYY",
                        invalidPlaceholder: "--",
                    },
                    align: "center",
                },
                {
                    title: "Employee ID",
                    field: "employee_id",
                    align: "center"
                },
                // Format datetime to time only
                {
                    title: "Time In",
                    field: "time_in",
                    // formatter: "datetime",
                    // formatterParams: {
                    //     inputFormat: "YYYY-MM-DD hh:mm:ss",
                    //     outputFormat: "h:mm:ss A",
                    //     invalidPlaceholder: "--",
                    // },
                    align: "center"
                },
                {
                    title: "Break Out",
                    field: "break_out",
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "YYYY-MM-DD hh:mm:ss",
                        outputFormat: "h:mm:ss A",
                        invalidPlaceholder: "",
                    },
                    align: "center"
                },
                {
                    title: "Break In",
                    field: "break_in",
                    formatter: "datetime",
                    formatterParams: {
                        inputFormat: "YYYY-MM-DD hh:mm:ss",
                        outputFormat: "h:mm:ss A",
                        invalidPlaceholder: "",
                    },
                    align: "center"
                },
                {
                    title: "Time Out",
                    field: "time_out",
                    align: "center"
                },


            ],
            ajaxResponse: function(url, params, response) {
                //url - the URL of the request
                //params - the parameters passed with the request
                //response - the JSON object returned in the body of the response.
                return response; //return the tableData property of a response json object
            },

        });

        //trigger download of timelog.csv file
        document.getElementById("download-csv").addEventListener("click", function() {
            table.download("csv", "timelog.csv");
        });

        //trigger download of timelog.xlsx file
        document.getElementById("download-xlsx").addEventListener("click", function() {
            table.download("xlsx", "timelog.xlsx", {
                sheetName: "My Data"
            });
        });

        //trigger download of timelog.xlsx file
        document.getElementById("print-table").addEventListener("click", function() {
            table.print(false, true);
        });

        //trigger download of timelog.pdf file
        // document.getElementById("download-pdf").addEventListener("click", function() {
        //     table.download("pdf", "data.pdf", {
        //         orientation: "portrait", //set page orientation to portrait
        //         title: "Dynamics Quotation Report", //add title to report
        //         jsPDF: {
        //             unit: "in", //set units to inches
        //         },
        //         autoTable: { //advanced table styling
        //             styles: {
        //                 fillColor: [100, 255, 255]
        //             },
        //             columnStyles: {
        //                 id: {
        //                     fillColor: 255
        //                 }
        //             },
        //             margin: {
        //                 top: 60
        //             },
        //         },
        //         documentProcessing: function(doc) {
        //             //carry out an action on the doc object
        //         }
        //     });
        // });
    })();

    $("#settings").click(function() {
        const building = <?php echo "'" . $building . "';"; ?>;
        const time_in = <?php echo "'" . $timeIn . "';"; ?>;
        const time_out = <?php echo "'" . $timeOut . "';"; ?>;

        $("#settingModal").modal("show");
        // Set the values of the form
        document.getElementById("settingModal").querySelector("#building").value = building;
        document.getElementById("settingModal").querySelector("#timeIn").value = time_in;
        document.getElementById("settingModal").querySelector("#timeOut").value = time_out;
    });

    <?php ## sweetalert msg session
    $msg_success = $session_class->getValue('msg_success');
    if (isset($msg_success) && $msg_success != "") {
        echo "msg_success('" . $msg_success . "');";
        $session_class->dropValue('msg_success');
    }
    $msg_error = $session_class->getValue('msg_error');
    if (isset($msg_error) && $msg_error != "") {
        echo "msg_error('" . $msg_error . "');";
        $session_class->dropValue('msg_error');
    }
    ?>
</script>