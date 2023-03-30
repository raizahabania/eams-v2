<?php
require 'config/config.php';
include 'config/connect.php';
$page_title ="Attendance Log";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>eams2</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
    <link rel="stylesheet" href="assets/css/customStyles.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />
    <link href="https://unpkg.com/tabulator-tables@4.1.4/dist/css/tabulator.min.css" rel="stylesheet">
</head>

<body style="font-family: Montserrat, sans-serif;">
<!-- Top navigation bar -->
<nav class="navbar navbar-dark navbar-expand-md sticky-top shadow py-3 bgc-navCCC">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="platformSG.php">
                <span class="bs-icon-lg bs-icon-rounded d-flex justify-content-center align-items-center me-2 bs-icon">
                    <img class="img-fluid" width="100%" src="assets/img/logo-light.png">
                </span>
            <span>EAMS</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3">
            <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-3">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="platformSG.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="timelog.php">Time Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Setting</a>
                </li>
                <!-- <li class="nav-item"><a class="nav-link" href="#">Third Item</a></li> -->
            </ul>
            <a class="nav-link active" href="login.php">Sign Out</a>
            <!-- <button class="btn btn-primary" type="button"></button> -->
        </div>
    </div>
</nav>
<!-- End top navigation bar -->
<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="page-title">
                            <i class="mdi mdi-apple-keyboard-command title_icon">

                            </i> <?php echo $page_title; ?></h4>
                        <div id="example-table" class=""></div>

                    </div>
                </div> <!-- end col-->
            </div>
            <!-- <div class="col-12">
                <div class="card-body">
                    <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i></h4>
                    <div id="example-table"></div>
                    <button id="download-csv">Download CSV</button>
                    <button id="download-json">Download JSON</button>
                    <button id="download-xlsx">Download XLSX</button>
                    <button id="print-table">Print</button>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Time setting modal -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="process.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Time Setting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <?php
                        $sql = "SELECT time_In,time_Out FROM sg_setting";
                        $query = mysqli_query($con, $sql);
                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                <div class="mb-3">
                                    <label for="timeIn" class="form-label">Time In</label>
                                    <input type="time" name="timeIn" value="<?php echo $data['time_In']; ?>" class="form-control" id="timeIn" placeholder="Time In" required>
                                </div>
                                <div class="mb-3">
                                    <label for="timeOut" class="form-label">Time Out</label>
                                    <input type="time" name="timeOut" value="<?php echo $data['time_Out']; ?>" class="form-control" id="timeOut" placeholder="Time Out" required>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="updateTime">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End time setting modal -->

</section>


<!-- Footer -->
<footer>
    <div class="container py-4 py-lg-5">
        <hr>
        <div class="d-flex justify-content-between align-items-center pt-3">
            <p class="text-muted mb-0">Copyright © 2022-2023 City College of Calamba</p>
        </div>
    </div>
</footer>
<!-- End footer -->

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.1.4/dist/js/tabulator.min.js"></script>
</body>
<script>
    // employees attedance
    (function(){
        var table = new Tabulator("#example-table", {

            ajaxSorting:true,
            ajaxFiltering:true,
            height:"500px",
            tooltips:true,
            printAsHtml:true,
            headerFilterPlaceholder:"",
            layout:"fitColumns",
            placeholder:"No Data Found",
            movableColumns:true,
            selectable:true,
            ajaxURL:"<?php echo BASE_URL;?>time_log.php",
            ajaxProgressiveLoad:"scroll",
            ajaxProgressiveLoadScrollMargin:1,
            printConfig:{
                columnGroups:false,
                rowGroups:false,
            },
            ajaxLoader: true,
            ajaxLoaderLoading: 'Fetching data from Database..',
            selectableRollingSelection:false,
            paginationSize: 20,

            columns:[
                // logs employee_id, card_id, time_in, time_out, break_in, break_out, date_log
                {title:"Date", field:"date_log", formatter:"datetime", formatterParams:{
                        inputFormat:"YYYY-MM-DD",
                        outputFormat:"MM-DD-YYYY",
                        invalidPlaceholder:"--",
                    }, align:"center", },
                {title:"Employee ID", field:"employee_id", align: "center"},
                // Format datetime to time only
                {title:"Time In", field:"time_in", formatter:"datetime", formatterParams:{
                        inputFormat:"dd-mmm-yyyy hh:mm:ss.s",
                        outputFormat:"h:mm:ss A",
                        invalidPlaceholder:"--",
                    }, align:"center"},
                {title:"Break Out", field:"break_out", formatter:"datetime", formatterParams:{
                        inputFormat:"dd-mmm-yyyy hh:mm:ss.s",
                        outputFormat:"h:mm:ss A",
                        invalidPlaceholder:"--",
                    }, align:"center"},
                {title:"Break In", field:"break_in", formatter:"datetime", formatterParams:{
                        inputFormat:"dd-mmm-yyyy hh:mm:ss.s",
                        outputFormat:"h:mm:ss A",
                        invalidPlaceholder:"--",
                    }, align:"center"},
                {title:"Time Out", field:"time_out", formatter:"datetime", formatterParams:{
                        inputFormat:"dd-mmm-yyyy hh:mm:ss.s",
                        outputFormat:"h:mm:ss A",
                        invalidPlaceholder:"--",
                    }, align:"center"},


            ], ajaxResponse: function (url, params, response) {
                //url - the URL of the request
                //params - the parameters passed with the request
                //response - the JSON object returned in the body of the response.
                console.log(response);
                return response; //return the tableData property of a response json object
            },

        });
    })();
</script>

</html>