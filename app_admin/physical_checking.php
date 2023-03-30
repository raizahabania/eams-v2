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

$today = date('D');
$week = date('W', strtotime($today));
$day = $today == 'Mon' ? '1' : ($today == 'Tue' ? '2' : ($today == 'Tue' ? '2' : ($today == 'Wed' ? '3' : ($today == 'Thu' ? '4' : ($today == 'Fri' ? '5' : ($today == 'Sat' ? '6' : '7'))))));

$initial_date = DATE_NOW;
$day_of_the_week = date('w', strtotime($initial_date));
$mon_date = date('Y-m-d', strtotime(('1' - $day_of_the_week) . ' day', strtotime($initial_date)));
$tue_date = date('Y-m-d', strtotime(('2' - $day_of_the_week) . ' day', strtotime($initial_date)));
$wed_date = date('Y-m-d', strtotime(('3' - $day_of_the_week) . ' day', strtotime($initial_date)));
$thu_date = date('Y-m-d', strtotime(('4' - $day_of_the_week) . ' day', strtotime($initial_date)));
$fri_date = date('Y-m-d', strtotime(('5' - $day_of_the_week) . ' day', strtotime($initial_date)));
$sat_date = date('Y-m-d', strtotime(('6' - $day_of_the_week) . ' day', strtotime($initial_date)));
$date_today = $today == 'Mon' ? $mon_date : ($today == 'Tue' ? $tue_date : ($today == 'Wed' ? $wed_date : ($today == 'Thu' ? $thu_date : ($today == 'Fri' ? $fri_date : ($today == 'Sat' ? $sat_date : $sat_date)))));
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
            <h1>Physical Checking</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_admin/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Physical Checking</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white fw-semibold" style="font-size: large;">
                    <i class="bi-calendar2-week"></i>&ensp;Schedule Date
                </div>
                <div class="form-group" style="margin-left:auto;" id="DateDemo">
                    <input type="text" id="weeklyDatePicker" class="form-control form-control-sm" value="<?php echo $date_today; ?>" placeholder="Select Week" />
                </div>
                <div class="card-body mt-3">
                    <div class="card text-center p-2">
                        <div class="card-header mb-0 mt-0 border-bottom-0">
                            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="myTab" role="tablist" style="text-align: center;font-size: 16pt;">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="mon-tab" data-dateTab="<?php echo $mon_date; ?>" data-tableName="monTable" data-bs-toggle="tab" data-bs-target="#mon" type="button" role="tab" aria-controls="mon" aria-selected="true" style="font-size:large; width:100%;">Monday</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="tue-tab" data-dateTab="<?php echo $tue_date; ?>" data-tableName="tueTable" data-bs-toggle="tab" data-bs-target="#tue" type="button" role="tab" aria-controls="tue" aria-selected="false" style="font-size:large;">Tuesday</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="wed-tab" data-dateTab="<?php echo $wed_date; ?>" data-tableName="wedTable" data-bs-toggle="tab" data-bs-target="#wed" type="button" role="tab" aria-controls="wed" aria-selected="false" style="font-size:large;">Wednesday</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="thu-tab" data-dateTab="<?php echo $thu_date; ?>" data-tableName="thuTable" data-bs-toggle="tab" data-bs-target="#thu" type="button" role="tab" aria-controls="thu" aria-selected="false" style="font-size:large;">Thursday</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="fri-tab" data-dateTab="<?php echo $fri_date; ?>" data-tableName="friTable" data-bs-toggle="tab" data-bs-target="#fri" type="button" role="tab" aria-controls="fri" aria-selected="false" style="font-size:large;">Friday</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link" id="sat-tab" data-dateTab="<?php echo $sat_date; ?>" data-tableName="satTable" data-bs-toggle="tab" data-bs-target="#sat" type="button" role="tab" aria-controls="sat" aria-selected="false" style="font-size:large;">Saturday</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade p-3" id="mon" role="tabpanel" aria-labelledby="mon-tab">
                                <?php if ($today == 'Mon') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-3" id="tue" role="tabpanel" aria-labelledby="tue-tab">
                                <?php if ($today == 'Tue') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-3" id="wed" role="tabpanel" aria-labelledby="wed-tab">
                                <?php if ($today == 'Wed') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-3" id="thu" role="tabpanel" aria-labelledby="thu-tab">
                                <input type="hidden" id="thu_val" value="">
                                <?php if ($today == 'Thu') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-3" id="fri" role="tabpanel" aria-labelledby="fri-tab">
                                <?php if ($today == 'Fri') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-3" id="sat" role="tabpanel" aria-labelledby="sat-tab">
                                <?php if ($today == 'Sat') { ?>
                                    <div id="schedule-table" class="table table-borderless"></div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="remarks_modal" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ngbAutofocus bg-success text-white">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Physical Checking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo BASE_URL; ?>app_admin/pcheck.php" method="POST">
                        <span id="mess"></span>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="text" name="date" value="" class="form-control bg-light" id="schedule" placeholder="Date" readonly>
                                </div>
                                <div class="col-3 mb-2">
                                    <label for="st" class="form-label">Start Time</label>
                                    <input type="text" name="st" value="" class="form-control bg-light" id="st" placeholder="Start Time" readonly>
                                </div>
                                <div class="col-3 mb-2">
                                    <label for="et" class="form-label">End Time</label>
                                    <input type="text" name="et" value="" class="form-control bg-light" id="et" placeholder="End Time" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="room" class="form-label">Room</label>
                                    <input type="text" name="room" value="" class="form-control bg-light" id="room" placeholder="Room" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="" class="form-control bg-light" id="name" placeholder="Name" readonly>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="employeeId" class="form-label">Employee ID</label>
                                    <input type="text" name="employeeId" value="" class="form-control bg-light" id="employee_id" placeholder="Employee ID" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="1">Present</option>
                                        <option value="2">Absent</option>
                                    </select>
                                </div>
                                <input type="hidden" name="section" value="" id="section">
                                <input type="hidden" name="subject_code" value="" id="subject_code">
                                <input type="hidden" name="series_num" value="" id="series_num">
                                <input type="hidden" name="remarks" value="" id="remarks">
                                <input type="hidden" name="id" value="" id="id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn_check" name="actionStatus" value="">Submit</button>
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
        var weeklyDatePicker = document.getElementById("weeklyDatePicker");
        var mon_tab = document.getElementById("mon-tab");
        var tue_tab = document.getElementById("tue-tab");
        var wed_tab = document.getElementById("wed-tab");
        var thu_tab = document.getElementById("thu-tab");
        var fri_tab = document.getElementById("fri-tab");
        var sat_tab = document.getElementById("sat-tab");
        var mon = document.getElementById("mon");
        var tue = document.getElementById("tue");
        var wed = document.getElementById("wed");
        var thu = document.getElementById("thu");
        var fri = document.getElementById("fri");
        var sat = document.getElementById("sat");
        var disabled_state = false;

        // DATEs
        var date_today = <?php echo "'" . $date_today . "';\r\n"; ?>;
        var set_server_time = <?php echo "'" . DATE_TIME . "';\r\n"; ?>
        var serverOffset = moment(set_server_time).diff(new Date());
        var now_server = moment();
        now_server.add(serverOffset,'milliseconds'); 
        var weekNow = now_server.format('WW, YYYY');
        var yearNow = now_server.format('YYYY');
        var dateNow = now_server.format('MM/DD/YYYY');
        var date = now_server.format('YYYY-MM-DD');
        var dayNow = now_server.format('dddd');
        var today = dayNow == 'Monday' ? '1' : (dayNow == 'Tuesday' ? '2' : (dayNow == 'Wednesday' ? '3' : (dayNow == 'Thursday' ? '4' : (dayNow == 'Friday' ? '5' : (dayNow == 'Saturday' ? '6' : '6')))));

        dayChange(false);
        tableSchedule();

        moment.locale('en', {
            week: {
                dow: 1
            } // Monday is the first day of the week
        });

        $(weeklyDatePicker).datetimepicker({ // set week
            format: 'MM/DD/YYYY',
            // daysOfWeekDisabled: [0],
            maxDate: dateNow
        });

        $('#weeklyDatePicker').on('dp.change', function(e) { // onchange of the week
            var value = $("#weeklyDatePicker").val();
            var daySelect = moment(value, "MM/DD/YYYY").format("dddd");
            var dateSelect = moment(value, "MM/DD/YYYY").format("YYYY-MM-DD");
            var weekDate = "Week: " + moment(value, "MM/DD/YYYY").format("WW, YYYY");
            var weekSelect = moment(value, "MM/DD/YYYY").format("WW, YYYY");
            var yearSelect = moment(value, "MM/DD/YYYY").format("YYYY");
            $("#weeklyDatePicker").val(weekDate);
            var active_tab = document.getElementById($('#myTab .active').attr('id'));
            var active_show = document.getElementById($('#myTabContent .tab-pane.active').attr('id'));

            if (yearSelect < yearNow) {
                var getWeekDayDate = getWeekDayDates(value);
                var activeArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];
                dayChange(true);

                for (let i = 0; i < activeArray.length; i++) {
                    var tabVal = moment(getWeekDayDate[i].date).format("YYYY-MM-DD");
                    removeClass(activeArray[i], 'disabled');
                    activeArray[i].setAttribute('data-dateTab', tabVal);
                }

                if (active_tab !== null && active_show !== null) { // removing the active tab and content
                    removeClass(active_tab, 'active');
                    removeClass(active_show, 'active');
                }

                if (daySelect == 'Monday') {
                    addClass(mon_tab, 'active');
                    addClass(mon, 'active');
                    addClass(mon, 'show');
                    $(mon).html('<div id="monTable-table" class="table table-borderless"></div>');
                    tableCheck('monTable', dateSelect);
                } else if (daySelect == 'Tuesday') {
                    addClass(tue_tab, 'active');
                    addClass(tue, 'active');
                    addClass(tue, 'show');
                    $(tue).html('<div id="tueTable-table" class="table table-borderless"></div>');
                    tableCheck('tueTable', dateSelect);
                } else if (daySelect == 'Wednesday') {
                    addClass(wed_tab, 'active');
                    addClass(wed, 'active');
                    addClass(wed, 'show');
                    $(wed).html('<div id="wedTable-table" class="table table-borderless"></div>');
                    tableCheck('wedTable', dateSelect);
                } else if (daySelect == 'Thursday') {
                    addClass(thu_tab, 'active');
                    addClass(thu, 'active');
                    addClass(thu, 'show');
                    $(thu).html('<div id="thuTable-table" class="table table-borderless"></div>');
                    tableCheck('thuTable', dateSelect);
                } else if (daySelect == 'Friday') {
                    addClass(fri_tab, 'active');
                    addClass(fri, 'active');
                    addClass(fri, 'show');
                    $(fri).html('<div id="friTable-table" class="table table-borderless"></div>');
                    tableCheck('friTable', dateSelect);
                } else if (daySelect == 'Saturday') {
                    addClass(sat_tab, 'active');
                    addClass(sat, 'active');
                    addClass(sat, 'show');
                    $(sat).html('<div id="satTable-table" class="table table-borderless"></div>');
                    tableCheck('satTable', dateSelect);
                }
            } else {
                if (weekNow == weekSelect) {
                    // var getWeekDayDate = getWeekDayDates(value);
                    // var activeArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];
                    // for (let i = 0; i < activeArray.length; i++) {
                    //     var tabVal = moment(getWeekDayDate[i].date).format("YYYY-MM-DD");
                    //     activeArray[i].setAttribute('data-dateTab', tabVal);
                    // }
                    var getWeekDayDate = getWeekDayDates(value);
                    var activeArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];

                    for (let i = 0; i < activeArray.length; i++) {
                        var tabVal = moment(getWeekDayDate[i].date).format("YYYY-MM-DD");
                        removeClass(activeArray[i], 'disabled');
                        activeArray[i].setAttribute('data-dateTab', tabVal);
                    }

                    if (active_tab !== null && active_show !== null) {
                        removeClass(active_tab, 'active');
                        removeClass(active_show, 'active');
                    }
                    if (disabled_state == true) {
                        var disabledArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];
                        for (let i = 0; i < disabledArray.length; i++) {
                            removeClass(disabledArray[i], 'disabled');
                        }
                    }
                    if (dayNow == 'Monday') {
                        $(mon).html('<div id="schedule-table" class="table table-borderless"></div>');
                    } else if (dayNow == 'Tuesday') {
                        $(tue).html('<div id="schedule-table" class="table table-borderless"></div>');
                    } else if (dayNow == 'Wednesday') {
                        $(wed).html('<div id="schedule-table" class="table table-borderless"></div>');
                    } else if (dayNow == 'Thursday') {
                        $(thu).html('<div id="schedule-table" class="table table-borderless"></div>');
                    } else if (dayNow == 'Friday') {
                        $(fri).html('<div id="schedule-table" class="table table-borderless"></div>');
                    } else if (dayNow == 'Saturday') {
                        $(sat).html('<div id="schedule-table" class="table table-borderless"></div>');
                    }
                    tableSchedule();
                    dayChange(false);
                    setActive();
                } else if (weekNow > weekSelect) {
                    var getWeekDayDate = getWeekDayDates(value);
                    var activeArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];
                    dayChange(true);

                    for (let i = 0; i < activeArray.length; i++) {
                        var tabVal = moment(getWeekDayDate[i].date).format("YYYY-MM-DD");
                        removeClass(activeArray[i], 'disabled');
                        activeArray[i].setAttribute('data-dateTab', tabVal);
                    }

                    if (active_tab !== null && active_show !== null) { // removing the active tab and content
                        removeClass(active_tab, 'active');
                        removeClass(active_show, 'active');
                    }

                    if (daySelect == 'Monday') {
                        addClass(mon_tab, 'active');
                        addClass(mon, 'active');
                        addClass(mon, 'show');
                        $(mon).html('<div id="monTable-table" class="table table-borderless"></div>');
                        tableCheck('monTable', dateSelect);
                    } else if (daySelect == 'Tuesday') {
                        addClass(tue_tab, 'active');
                        addClass(tue, 'active');
                        addClass(tue, 'show');
                        $(tue).html('<div id="tueTable-table" class="table table-borderless"></div>');
                        tableCheck('tueTable', dateSelect);
                    } else if (daySelect == 'Wednesday') {
                        addClass(wed_tab, 'active');
                        addClass(wed, 'active');
                        addClass(wed, 'show');
                        $(wed).html('<div id="wedTable-table" class="table table-borderless"></div>');
                        tableCheck('wedTable', dateSelect);
                    } else if (daySelect == 'Thursday') {
                        addClass(thu_tab, 'active');
                        addClass(thu, 'active');
                        addClass(thu, 'show');
                        $(thu).html('<div id="thuTable-table" class="table table-borderless"></div>');
                        tableCheck('thuTable', dateSelect);
                    } else if (daySelect == 'Friday') {
                        addClass(fri_tab, 'active');
                        addClass(fri, 'active');
                        addClass(fri, 'show');
                        $(fri).html('<div id="friTable-table" class="table table-borderless"></div>');
                        tableCheck('friTable', dateSelect);
                    } else if (daySelect == 'Saturday') {
                        addClass(sat_tab, 'active');
                        addClass(sat, 'active');
                        addClass(sat, 'show');
                        $(sat).html('<div id="satTable-table" class="table table-borderless"></div>');
                        tableCheck('satTable', dateSelect);
                    }
                } else if (weekNow < weekSelect) {
                    disabled_state = true;
                    if (active_tab !== null && active_show !== null) {
                        removeClass(active_tab, 'active');
                        removeClass(active_show, 'active');
                    }
                    var disabledArray = [mon_tab, tue_tab, wed_tab, thu_tab, fri_tab, sat_tab];
                    for (let i = 0; i < disabledArray.length; i++) {
                        addClass(disabledArray[i], 'disabled');
                    }
                }
            }
        });

        function dayChange(dayChange) { // onchange of the day 
            if (dayChange == false) {
                $('#myTab button').on('click', function(e) {
                    e.preventDefault();
                    var idTab = $(this).attr("data-bs-target");
                    var tableName = $(this).attr("data-tableName");
                    var dateTab = $(this).attr("data-dateTab");

                    if (date_today == dateTab) {
                        var html_val = $(idTab).html('<div id="schedule-table" class="table table-borderless"></div>');
                        $(this).tab(html_val);
                        tableSchedule();
                    } else if (date_today > dateTab) {
                        var html_val = $(idTab).html('<div id="' + tableName + '-table" class="table table-borderless"></div>');
                        $(this).tab(html_val);
                        tableCheck(tableName, dateTab);
                    }
                });
                setActive();
            } else if (dayChange == true) {
                $('#myTab button').on('click', function(e) {
                    e.preventDefault();
                    var idTab = $(this).attr("data-bs-target");
                    var tableName = $(this).attr("data-tableName");
                    var dateTab = $(this).attr("data-dateTab");
                    var html_val = $(idTab).html('<div id="' + tableName + '-table" class="table table-borderless"></div>');
                    $(this).tab(html_val);
                    tableCheck(tableName, dateTab);
                });
            }
        }

        function getWeekDayDates(dateVal) { // fetch all dates of the week
            var today = new Date(dateVal);
            var day = today.getDay();
            var date = today.getDate();
            var month = today.getMonth();
            var year = today.getFullYear();
            var days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var dates = [];
            for (var i = 0; i < days.length; i++) {
                var first = date - day + (i + 1);
                var dayDate = new Date(year, month, first);
                dates.push({
                    day: days[i],
                    date: dayDate.getFullYear() + '-' + (dayDate.getMonth() + 1) + '-' + dayDate.getDate()
                });
            }
            return dates;
        }

        function setActive() {
            if (dayNow === 'Monday') {
                addClass(mon_tab, 'active');
                addClass(mon, 'active');
                addClass(mon, 'show');
            } else if (dayNow === 'Tuesday') {
                addClass(tue_tab, 'active');
                addClass(tue, 'active');
                addClass(tue, 'show');
            } else if (dayNow === 'Wednesday') {
                addClass(wed_tab, 'active');
                addClass(wed, 'active');
                addClass(wed, 'show');
            } else if (dayNow === 'Thursday') {
                addClass(thu_tab, 'active');
                addClass(thu, 'active');
                addClass(thu, 'show');
            } else if (dayNow === 'Friday') {
                addClass(fri_tab, 'active');
                addClass(fri, 'active');
                addClass(fri, 'show');
            } else if (dayNow === 'Saturday' || dayNow === 'Sunday') {
                addClass(sat_tab, 'active');
                addClass(sat, 'active');
                addClass(sat, 'show');
            }

            if (!(today >= '1')) {
                addClass(mon_tab, 'disabled');
            }
            if (!(today >= '2')) {
                addClass(tue_tab, 'disabled');
            }
            if (!(today >= '3')) {
                addClass(wed_tab, 'disabled');
            }
            if (!(today >= '4')) {
                addClass(thu_tab, 'disabled');
            }
            if (!(today >= '5')) {
                addClass(fri_tab, 'disabled');
            }
            if (!(today >= '6')) {
                addClass(sat_tab, 'disabled');
            }
        }

        function removeClass(classVal, value) { // for removing class
            classVal.classList.remove(value);
        }

        function addClass(classVal, value) { // for adding class
            classVal.classList.add(value);
        }

        function tableSchedule() { // schedule fetch table
            if (dayNow != 'Sunday') { // schedule fetch table 

                function handleDateChange() { // for filtering
                    // Get the value of the date picker
                    const date = weeklyDatePicker.value;
                    table.clearFilter();
                    // If all of the values are empty, don't filter the table
                    if (!date) {
                        return table.render();
                    }
                    table.setFilter(date);
                }

                weeklyDatePicker.addEventListener('change', handleDateChange);

                const buttonEdit = function(cell, formatterParams, onRendered) { // for updating the status
                    const row = cell.getRow();
                    const data = row.getData();
                    const btn = document.createElement("button");

                    var date = moment(date_today).format('MM-DD-YYYY');
                    var remarks = data.remarks == 'Scheduled' ? 0 : 1;
                    var status = data.check_status;

                    btn.classList.add("btn", "btn-sm", "btn-primary");
                    btn.style.fontSize = "small";
                    if (status == 0) {
                        btn.innerHTML = "Check";
                    } else {
                        btn.innerHTML = "Update";
                    }
                    btn.addEventListener("click", function() {
                        // Open the edit modal
                        $("#remarks_modal").modal("show");
                        if (status == 0) {
                            btn_check = "checkStatus";
                        } else {
                            btn_check = "updateStatus";
                        }
                        // Set the values of the form
                        document.getElementById("remarks_modal").querySelector("#id").value = data.id;
                        document.getElementById("remarks_modal").querySelector("#name").value = data.name;
                        document.getElementById("remarks_modal").querySelector("#employee_id").value = data.employee_id;
                        document.getElementById("remarks_modal").querySelector("#room").value = data.room;
                        document.getElementById("remarks_modal").querySelector("#schedule").value = date;
                        document.getElementById("remarks_modal").querySelector("#st").value = data.start_time;
                        document.getElementById("remarks_modal").querySelector("#et").value = data.end_time;
                        document.getElementById("remarks_modal").querySelector("#remarks").value = remarks;
                        document.getElementById("remarks_modal").querySelector("#status").value = status;
                        document.getElementById("remarks_modal").querySelector("#series_num").value = data.series_num;
                        document.getElementById("remarks_modal").querySelector("#btn_check").value = btn_check;
                        document.getElementById("remarks_modal").querySelector("#section").value = data.section;
                        document.getElementById("remarks_modal").querySelector("#subject_code").value = data.subject_code;
                    });
                    return btn;
                };

                const statusClass = function(cell, formatterParams, onRendered) {
                    const span = document.createElement("span");
                    const row = cell.getRow();
                    const data = row.getData();

                    if (data.check_status == 0) {
                        span.classList.add("status-yellow");
                        span.style.fontSize = "small";
                        span.innerHTML = "Checking";
                    } else if (data.check_status == 1) {
                        span.classList.add("status-green");
                        span.style.fontSize = "small";
                        span.innerHTML = "Present";
                    } else if (data.check_status == 2) {
                        span.classList.add("status-red");
                        span.style.fontSize = "small";
                        span.innerHTML = "Absent";
                    } else if (data.check_status == 3) {
                        span.classList.add("status-darkred");
                        span.style.fontSize = "small";
                        span.innerHTML = "Not Checked";
                    }
                    return span;
                };

                const table = new Tabulator("#schedule-table", { // schedule fetch table
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
                    ajaxURL: "<?php echo BASE_URL; ?>app_admin/pcheck.php",
                    ajaxParams: {
                        day: date,
                        table: 'schedule'
                    },
                    ajaxProgressiveLoadScrollMargin: 1,
                    printConfig: {
                        columnGroups: false,
                        rowGroups: false,
                    },
                    ajaxLoader: true,
                    ajaxLoaderLoading: 'Fetching data from Database..',
                    columns: [{
                            title: "Room",
                            field: "room",
                            headerFilter: "input",
                            headerFilterFunc: "like",
                            headerFilterParams: {
                                allowEmpty: true
                            },
                            minWidth: 150
                        },
                        {
                            title: "Section",
                            field: "section",
                            headerFilter: "input",
                            headerFilterFunc: "like",
                            headerFilterParams: {
                                allowEmpty: true
                            },
                            minWidth: 110
                        },
                        {
                            title: "Subject Code",
                            field: "subject_code",
                            headerFilter: "input",
                            headerFilterFunc: "like",
                            headerFilterParams: {
                                allowEmpty: true
                            },
                            minWidth: 150
                        },
                        {
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
                            title: "Name",
                            field: "name",
                            headerFilter: "input",
                            headerFilterFunc: "like",
                            headerFilterParams: {
                                allowEmpty: true
                            },
                            minWidth: 150
                        },
                        {
                            title: "Time Frame",
                            field: "time_frame",
                            minWidth: 170

                        },
                        {
                            title: "Remarks",
                            field: "remarks",
                            minWidth: 120
                        },
                        {
                            title: "Status",
                            field: "check_status",
                            formatter: statusClass,
                            hozAlign: "center",
                            minWidth: 150
                        },
                        {
                            title: "Action",
                            formatter: buttonEdit,
                            align: "center",
                            headerSort: false,
                            cellClick: function(e, cell) {
                                cell.getRow().toggleSelect();
                            },
                            minWidth: 150
                        }
                    ],
                    ajaxResponse: function(url, params, response) {
                        //url - the URL of the request
                        //params - the parameters passed with the request
                        //response - the JSON object returned in the body of the response.
                        return response.data; //return the tableData property of a response json object
                    },
                });

            } else if (dayNow == 'Sunday') {
                var active = $("#myTab .active");
                var idTab = active.attr("data-bs-target");
                var tableName = active.attr("data-tableName");
                var dateTab = active.attr("data-dateTab");
                var html_val = $(idTab).html('<div id="' + tableName + '-table" class="table table-borderless"></div>');
                tableCheck(tableName, dateTab)
            }
        }

        function tableCheck(tableName, dateVal) { // physical checking fetch table
            const remarksClass = function(cell, formatterParams, onRendered) {
                const span = document.createElement("span");
                const row = cell.getRow();
                const data = row.getData();
                if (data.remarks == 0) {
                    span.innerHTML = "Scheduled";
                } else if (data.remarks == 1) {
                    span.innerHTML = "Make-up Class";
                }
                return span;
            };

            const statusClass = function(cell, formatterParams, onRendered) {
                const span = document.createElement("span");
                const row = cell.getRow();
                const data = row.getData();
                // 0-checking, 1-present, 2-absent, 3-not checked
                if (data.check_status == 0) {
                    span.classList.add("status-yellow");
                    span.style.fontSize = "small";
                    span.innerHTML = "Checking";
                } else if (data.check_status == 1) {
                    span.classList.add("status-green");
                    span.style.fontSize = "small";
                    span.innerHTML = "Present";
                } else if (data.check_status == 2) {
                    span.classList.add("status-red");
                    span.style.fontSize = "small";
                    span.innerHTML = "Absent";
                } else if (data.check_status == 3) {
                    span.classList.add("status-orange");
                    span.style.fontSize = "small";
                    span.innerHTML = "Not Checked";
                }
                return span;
            };

            const table = new Tabulator("#" + tableName + "-table", {
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
                    day: dateVal,
                    table: 'physical_checking'
                },
                ajaxURL: "<?php echo BASE_URL; ?>app_admin/pcheck.php",
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
                        title: "Room",
                        field: "room",
                        headerFilter: "input",
                        headerFilterFunc: "like",
                        headerFilterParams: {
                            allowEmpty: true
                        },
                        minWidth: 150
                    },
                    {
                        title: "Section",
                        field: "section",
                        headerFilter: "input",
                        headerFilterFunc: "like",
                        headerFilterParams: {
                            allowEmpty: true
                        },
                        minWidth: 110
                    },
                    {
                        title: "Subject Code",
                        field: "subject_code",
                        headerFilter: "input",
                        headerFilterFunc: "like",
                        headerFilterParams: {
                            allowEmpty: true
                        },
                        minWidth: 150
                    },
                    {
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
                        title: "Remarks",
                        field: "remarks",
                        minWidth: 120
                    },
                    {
                        title: "Status",
                        field: "check_status",
                        formatter: statusClass,
                        hozAlign: "center",
                        minWidth: 150
                    },
                    {
                        title: "Date Checked",
                        field: "date_check",
                        minWidth: 150
                    }
                ],
                ajaxResponse: function(url, params, response) {
                    //url - the URL of the request
                    //params - the parameters passed with the request
                    //response - the JSON object returned in the body of the response.
                    return response; //return the tableData property of a response json object
                },
            });
        }

        // set week input into week date format
        const weekDate = "Week: " + moment(dateNow, "MM/DD/YYYY").format("WW, YYYY");
        $("#weeklyDatePicker").val(weekDate);
    })();

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