<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; // check kung nakalogin

$response = array(
    'success' => false,
    'message' => 'Unknown error'
);

$date = "";

$get_id = isset($_POST['get_id']) ? trim($_POST['get_id']) : '';

if (!is_digit($get_id)) {
    $response['message'] = 'Data invalid';
    echo json_encode($response);
    exit();
}

$action = 'save';
if ($get_id > 0) {
    $action = 'update';
}

$get_id = escape($db_connect, $get_id);
$time_in = isset($_POST['time_in']) ? trim($_POST['time_in']) : "";
$time_out = isset($_POST['time_out']) ? trim($_POST['time_out']) : "";
$break_in = isset($_POST['break_in']) ? trim($_POST['break_in']) : "";
$break_out = isset($_POST['break_out']) ? trim($_POST['break_out']) : "";

$date_log = isset($_POST['date_log']) ? trim($_POST['date_log']) : "";
$employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : "";

if ($get_id == "") {
    $response['message'] = 'Employee Name field cannot be empty';
    echo json_encode($response);
    exit();
}

// if($time_in == "" || $time_out == ""){
//     $response['message'] = 'Time in and Time out cannot be empty';
//         echo json_encode($response);
//         exit();
// }


if ($action == 'update' && $get_id > 0) {

    $sqldate = "SELECT date_log FROM time_log WHERE id='" . $get_id . "'";
    $resultdate = mysqli_query($db_connect, $sqldate);
    if ($resultdate) {
        if (mysqli_num_rows($resultdate) > 0) {
            $rowdate = mysqli_fetch_array($resultdate);
            $date = $rowdate['date_log'];
        }
    }

    if (empty($date)) {
        $response['message'] = 'Date not found';
        echo json_encode($response);
        exit();
    }
}

if ($time_in != "" && $time_out != "") {

    if (!preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $time_in)) {
        $response['message'] = 'Invalid time in';
        echo json_encode($response);
        exit();
    }
    if (!preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $time_out)) {
        $response['message'] = 'Invalid time out';
        echo json_encode($response);
        exit();
    }

    if ($break_in != "" || $break_out != "") {
        if (!preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $break_in)) {
            $response['message'] = 'Invalid break in';
            echo json_encode($response);
            exit();
        }
        if (!preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $break_out)) {
            $response['message'] = 'Invalid break out';
            echo json_encode($response);
            exit();
        }
    }


    $new_time_in = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $time_in")));
    $new_time_out = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $time_out")));

    if ($break_in != "" || $break_out != "") {
        $new_break_in = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_in")));
        $new_break_out = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_out")));
    } else {

        $new_break_in = escape($db_connect, "$date $break_in");
        $new_break_out = escape($db_connect, "$date $break_out");
    }

    if ($action == 'save') {

        if ($date_log == "") {
            $response['message'] = 'Date field cannot be empty';
            echo json_encode($response);
            exit();
        }

        $date_log = escape($db_connect, $date_log);
        $employee_id = escape($db_connect, $employee_id);

        $sqldate = "SELECT employee_id,card_id FROM " . EMPLOYEE_TABLE . " WHERE user_id ='" . $employee_id . "'";
        $resultdate = mysqli_query($db_connect, $sqldate);
        if ($resultdate) {
            if (mysqli_num_rows($resultdate) > 0) {
                $rowdate = mysqli_fetch_assoc($resultdate);
                $employee_id = $rowdate['employee_id'];
            }
        }

        $sql = "INSERT  INTO time_log (employee_id,date_log,time_in,time_out,break_in,break_out,building_timein,building_timeout,manual) VALUES ('" . $employee_id . "', '" . $date_log . "','" . $new_time_in . "','" . $new_time_out . "','" . $new_break_in . "','" . $new_break_out . "','Manual','Manual','1')";
    } else if ($action == 'update') {

        $sql = "UPDATE time_log SET  time_in = '" . $new_time_in . "', time_out = '" . $new_time_out . "', break_out = '" . $new_break_out . "', break_in = '" . $new_break_in . "'  WHERE id='" . $get_id . "'";
    }

    $response['success'] = false;

    try {
        mysqli_query($db_connect, $sql);
        $response['success'] = true;
        $response['message'] = 'Successfully saved';
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate user
            $response['message'] = "Insert Duplicate Entry Failed";
        } else {
            //throw $e;// in case it's any other error
            $response['message'] = "Unknown error";
            $response['data'] = $sql;
        }
    }

    echo json_encode($response);
    exit();
} else {

    $response['message'] = 'Time in and Time out cannot be empty';
    echo json_encode($response);
    exit();
    // $response['message'] = 'Invalid data';
    // echo json_encode($response);
    // exit();
}
