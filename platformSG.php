<?php
include 'config/config.php';
include DOMAIN_PATH . "/config/connect.php";

$timeIn = "00:00:00";
$timeOut = "00:00:00";
$sql = "SELECT time_In,time_Out FROM sg_setting WHERE id=1";
if ($query = mysqli_query($con, $sql)) {;
    $data = mysqli_fetch_assoc($query);
    $timeIn = $data['time_In'];
    $timeOut = $data['time_Out'];
}

$system_flag = false;
if (TIME_NOW >= $timeOut) {
    $system_flag = true;
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
        <div class="text-black-50 position-relative py-4 py-xl-5" style="height:500px;">
            <!-- Time and Date -->
            <div class="text-center text-black mb-5">
                <div id="nowTime" class="text-dark font-monospace" style="font-size: 50pt; font-weight: 800;"></div>
                <div id="nowDate" class="text-dark" style="font-size: 35pt; font-weight: 500;"></div>
            </div>
            <!-- End Time and Date -->

            <!-- Details Log Time Status -->
            <div id="myCarousel" class="carousel slides">
                <div class="carousel-inner container mx-auto">
                    <div class="carousel-item" id="logTimein">
                        <div class="row mb-5">
                            <div class="p-2 col-10 col-md-11 col-xl-12 rounded-2 text-center mx-auto text-white bgc-blue500">
                                <h1 class="text-uppercase" style="font-size:50pt; font-weight:600;">Time In</h1>
                                <p class="w-lg-50 mb-0" style="font-size:large;">Please tap your card.</p>
                                <form action="sg-process.php" method="post" id="timeinForm">
                                    <input type="text" name="time_in" id="time_in" class="btn btn-sm border-0 timeIn mb-0 cursor-default" autocomplete="off" autocorrect="off">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row mb-5">
                            <div class="p-2 col-10 col-md-11 col-xl-12 rounded-2 text-center mx-auto text-white bgc-yellow500">
                                <h1 class="text-uppercase" style="font-size:50pt; font-weight:600;">Break Out</h1>
                                <p class="w-lg-50 mb-0" style="font-size:large;">Please tap your card.</p>
                                <form action="sg-process.php" method="post" id="breakoutForm">
                                    <input type="text" name="break_out" id="break_out" class="btn btn-sm border-0 breakOut mb-0 cursor-default" autocomplete="off" autocorrect="off">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row mb-5">
                            <div class="p-2 col-10 col-md-11 col-xl-12 rounded-2 text-center mx-auto text-white bgc-emerald600">
                                <h1 class="text-uppercase" style="font-size:50pt; font-weight:600;">Break In</h1>
                                <p class="w-lg-50 mb-0" style="font-size:large;">Please tap your card.</p>
                                <form action="sg-process.php" method="post" id="breakinForm">
                                    <input type="text" name="break_in" id="break_in" class="btn btn-sm border-0 breakIn mb-0 cursor-default" autocomplete="off" autocorrect="off">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" id="logTimeout">
                        <div class="row mb-5">
                            <div class="p-2 col-10 col-md-11 col-xl-12 rounded-2 text-center mx-auto text-white bgc-rose700">
                                <h1 class="text-uppercase" style="font-size:50pt; font-weight:600;">Time Out</h1>
                                <p class="w-lg-50 mb-0" style="font-size:large;">Please tap your card.</p>
                                <form action="sg-process.php" method="post" id="timeoutForm">
                                    <input type="text" name="time_out" id="time_out" class="btn btn-sm border-0 timeOut mb-0 cursor-default" autocomplete="off" autocorrect="off">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Details Log Time Status -->
        </div>

        <!-- Log Time Status Button -->
        <div class="container position-relative" style="top:-30px;">
            <div class="row gy-5 gy-lg-0 row-cols-1 row-cols-md-2 row-cols-lg-4">
                <div class="col-xxl-3">
                    <div class="card shadow">
                        <button type="button" id="TimeIn" data-bs-target="#myCarousel" data-bs-slide-to="0" class="p-2 rounded-2 bg-white border border-0 active" aria-current="true" aria-label="Slide 1">
                            <div class="card-body pt-5 p-4">
                                <div class="bs-icon-lg bs-icon-rounded bgc-blue500 d-flex flex-shrink-0 justify-content-center align-items-center position-absolute mb-3 bs-icon lg" style="top: -30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="#fff" viewBox="0 0 16 16" class="bi bi-clock">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"></path>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="fw-bolder tc-blue500 card-title">Time In</h3>
                            </div>
                        </button>
                        <div class="card-footer font-monospace p-4 py-3">
                            <h6 class="card-subtitle text-dark mb-2">Press the "<i class="fa-solid fa-arrow-up"></i>" key to activate</h6>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <button type="button" id="BreakOut" data-bs-target="#myCarousel" data-bs-slide-to="1" class="p-2 rounded-2 bg-white border border-0 active" aria-current="true" aria-label="Slide 2">
                            <div class="card-body pt-5 p-4">
                                <div class="bs-icon-lg bs-icon-rounded bgc-yellow500 d-flex flex-shrink-0 justify-content-center align-items-center position-absolute mb-3 bs-icon lg" style="top: -30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-clock-history text-white">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"></path>
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"></path>
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"></path>
                                    </svg>
                                </div>
                                <h3 class="fw-bolder tc-yellow500 card-title">Break Out</h3>
                            </div>
                        </button>
                        <div class="card-footer font-monospace p-4 py-3">
                            <h6 class="card-subtitle text-dark mb-2">Press the "<i class="fa-solid fa-arrow-left"></i>" key to activate</h6>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <button type="button" id="BreakIn" data-bs-target="#myCarousel" data-bs-slide-to="2" class="p-2 rounded-2 bg-white border border-0 active" aria-current="true" aria-label="Slide 3">
                            <div class="card-body pt-5 p-4">
                                <div class="bs-icon-lg bs-icon-rounded bgc-emerald600 d-flex flex-shrink-0 justify-content-center align-items-center position-absolute mb-3 bs-icon lg" style="top: -30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-clock-history text-white">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"></path>
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"></path>
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"></path>
                                    </svg>
                                </div>
                                <h3 class="fw-bolder tc-emerald600 card-title">Break In</h3>
                            </div>
                        </button>
                        <div class="card-footer font-monospace p-4 py-3">
                            <h6 class="card-subtitle text-dark mb-2">Press the "<i class="fa-solid fa-arrow-right"></i>" key to activate</h6>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow">
                        <button type="button" id="TimeOut" data-bs-target="#myCarousel" data-bs-slide-to="3" class="p-2 rounded-2 bg-white border border-0 active" aria-current="true" aria-label="Slide 4">
                            <div class="card-body pt-5 p-4">
                                <div class="bs-icon-lg bs-icon-rounded bgc-rose700 d-flex flex-shrink-0 justify-content-center align-items-center position-absolute mb-3 bs-icon lg" style="top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="#fff" viewBox="0 0 16 16" class="bi bi-clock">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"></path>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"></path>
                                    </svg></div>
                                <h3 class="fw-bolder tc-rose700 card-title">Time Out</h3>
                            </div>
                        </button>
                        <div class="card-footer font-monospace p-4 py-3">
                            <h6 class="card-subtitle text-dark mb-2">Press the "<i class="fa-solid fa-arrow-down"></i>" key to activate</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Log Time Status Button -->

        <!-- Time setting modal -->
        <div class="modal fade" id="settingModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="sg-process.php" method="post">
                        <div class="modal-header ngbAutofocus">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Setting</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <span id="mess"></span>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <label for="timeIn" class="form-label">Place</label>
                                    <select name="" id="" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="oneGate1">Main building - Gate 1</option>
                                        <option value="oneGate2">Main building - Gate 2</option>
                                        <option value="twoGate1">New building - Gate 1</option>
                                        <option value="twoGate1">New building - Gate 2</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <hr> -->
                            <div class="mb-3 row">
                                <div class="col-6 mb-3">
                                    <label for="timeIn" class="form-label">Time In</label>
                                    <input type="time" name="timeIn" value="<?php echo $timeIn; ?>" class="form-control" id="timeIn" placeholder="Time In" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="timeOut" class="form-label">Time Out</label>
                                    <input type="time" name="timeOut" value="<?php echo $timeOut; ?>" class="form-control" id="timeOut" placeholder="Time Out" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updateTime">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End time setting modal -->
    </main>
    <?php include FOOTER_PATH; ?>
</body>

</html>
<?php
// script, function
include DOMAIN_PATH . "/global/include_bottom.php";
?>

<script>
    var time_in = document.getElementById("time_in");
    var time_out = document.getElementById("time_out");
    var break_in = document.getElementById("break_in");
    var break_out = document.getElementById("break_out");
    var system_flag = <?php echo ($system_flag) ? "true;\r\n" : "false;\r\n"; ?>
    var manual_flag = false; // manual trigger

    $(document).ready(function() {
        // KeyPress of Log Status
        $(document).keydown(function(e) {
            if (e.keyCode == 38) {
                manual_flag = true;
                document.getElementById("TimeIn").click();
                time_in.focus();
            } else if (e.keyCode == 37) {
                manual_flag = true;
                document.getElementById("BreakOut").click();
                break_out.focus();
            } else if (e.keyCode == 39) {
                manual_flag = true;
                document.getElementById("BreakIn").click();
                break_in.focus();
            } else if (e.keyCode == 40) {
                manual_flag = true;
                document.getElementById("TimeOut").click();
                time_out.focus();
            }
        });

        $("#TimeIn").on('click', function() {
            manual_flag = true;
            time_in.focus();
        });

        $("#BreakOut").on('click', function() {
            manual_flag = true;
            break_out.focus();
        });

        $("#BreakIn").on('click', function() {
            manual_flag = true;
            break_in.focus();
        });

        $("#TimeOut").on('click', function() {
            manual_flag = true;
            time_out.focus();
        });
        // End KeyPress of log status

        // Set time and date
        var set_server_time = <?php echo "'" . DATE_TIME . "';\r\n"; ?>
        var serverOffset = moment(set_server_time).diff(new Date());
        clearInterval(clock_id);
        var now_server = moment();
        var dateNow = now_server.format('ddd | MMMM DD, YYYY');
        $('#nowDate').html(dateNow);
        var clock_id = setInterval(function() {
            if (document.getElementById('nowTime')) {
                var now_server = moment();
                now_server.add(serverOffset, 'milliseconds');
                var timeNow = now_server.format('hh:mm:ss A');
                $('#nowTime').html(timeNow);
            } else {
                clearInterval(clock_id);
            }
        }, 1000);
        // End set time and date

        // Activate carousel
        function Activate() {
            var now_server = moment();
            now_server.add(serverOffset, 'milliseconds');
            var timeNow = now_server.format('HH:mm:ss');
            var timeOut = <?php echo "'" . $timeOut . "';"; ?>;

            if (manual_flag) {

            } else if (timeNow.substring(0, 2) >= timeOut.substring(0, 2) || system_flag) {
                var logTimeout = document.getElementById("logTimeout");
                if (logTimeout && time_out) {
                    logTimeout.classList.add("active");
                    $('#logTimein').removeClass("active");
                    time_out.focus();
                }
            } else {
                var logTimein = document.getElementById("logTimein");
                if (logTimein && time_in) {
                    logTimein.classList.add("active");
                    time_in.focus();
                }
            }
        }
        $('#settingModal').on('show.bs.modal', function() {
            time_in.blur();
            break_out.blur();
            break_in.blur();
            time_out.blur();
        });
        setInterval(Activate, 1000);
        // End activate carousel
    });

    function log_process(form) {
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'success') {
                    msg_html('<img src="main/images/' + data.image + '" width="200" style="border-radius:50%;">', data.name, data.position, data.remark);
                    form[0].reset();
                    setTimeout(form[0].blur(), 3000)
                } else if (data.status == 'error') {
                    form[0].reset();
                    msg_error(data.title, data.message);
                    setTimeout(form[0].blur(), 3000)
                } else if (data.status == 'warning') {
                    form[0].reset();
                    form[0].blur()
                    msg_warning(data.title, data.message);

                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    var timeinForm = $('#timeinForm');
    var timeoutForm = $('#timeoutForm');
    var breakinForm = $('#breakinForm');
    var breakoutForm = $('#breakoutForm');

    timeinForm.submit(function(e) {
        e.preventDefault();
        log_process(timeinForm);
    });
    timeoutForm.submit(function(e) {
        e.preventDefault();
        log_process(timeoutForm);
    });
    breakinForm.submit(function(e) {
        e.preventDefault();
        log_process(breakinForm);
    });
    breakoutForm.submit(function(e) {
        e.preventDefault();
        log_process(breakoutForm);
    });
</script>