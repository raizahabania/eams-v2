<?php
include 'config/config.php';
include DOMAIN_PATH . "/config/connect.php";

if (isset($_POST['time_in'])) {
    $time_in = $_POST['time_in'];
    $validate = validate_user($time_in);
    if ($validate === true) {
        $user_info = fetchdata_user($time_in);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,time_in,time_out FROM time_log WHERE card_id='$time_in' AND date_log='" . DATE_NOW . "'";
        if ($check_query = mysqli_query($con, $check_sql)) {
            if (mysqli_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $timein_val = $check_data['time_in'];
                $timeout_val = $check_data['time_out'];
                if ($timein_val != NULL) {
                    $status = 'warning';
                    $title = strtok($name, " ") . ", you are already time in";
                    $msg = '';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } elseif ($timein_val == NULL && $timeout_val != NULL) {
                    $status = 'warning';
                    $title = 'Unable to time in';
                    $msg = strtok($name, " ") . ", you are already time out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } elseif ($timein_val == NULL && $timeout_val == NULL) {
                    $log_sql = "UPDATE time_log SET time_in='" . DATE_TIME . "' WHERE card_id='$time_in' AND date_log='" . DATE_NOW . "'";
                    if (mysqli_query($con, $log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Time In Update';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => $name,
                            'position'   => $position,
                            'remark'   => $remark
                        );
                        echo json_encode($data);
                        exit();
                    } else {
                        $status = 'error';
                        $title = "Failed to time in";
                        $msg = 'Please Try Again';
                        $data = array(
                            'status' => $status,
                            'title'   => $title,
                            'message'   => $msg
                        );
                        echo json_encode($data);
                        exit();
                    }
                }
            } else {
                $log_sql = "INSERT INTO time_log (employee_id,card_id,time_in,way,date_log) VALUES ('" . $employee_id . "','" . $time_in . "','" . DATE_TIME . "','onsite','" . DATE_NOW . "')";
                if (mysqli_query($con, $log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Time In';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => $name,
                        'position'   => $position,
                        'remark'   => $remark
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'error';
                    $title = "Failed to time in";
                    $msg = 'Please Try Again';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            }
        }
    } else {
        $status = 'error';
        $title = "Invalid ID";
        $msg = "Please Try Again";
        $data = array(
            'status' => $status,
            'title'   => $title,
            'message'   => $msg
        );
        echo json_encode($data);
        exit();
    }
}

if (isset($_POST['break_out'])) {
    $break_out = $_POST['break_out'];
    $validate = validate_user($break_out);
    if ($validate === true) {
        $user_info = fetchdata_user($break_out);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,time_in,break_out,break_in,time_out FROM time_log WHERE card_id='$break_out' AND date_log='" . DATE_NOW . "'";
        if ($check_query = mysqli_query($con, $check_sql)) {
            if (mysqli_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $breakout_val = $check_data['break_out'];
                $breakin_val = $check_data['break_in'];
                $timeout_val = $check_data['time_out'];
                if ($breakout_val == NULL && $breakin_val == NULL && $timeout_val == NULL) {
                    $log_sql = "UPDATE time_log SET break_out='" . DATE_TIME . "' WHERE card_id='$break_out' AND date_log='" . DATE_NOW . "'";
                    if (mysqli_query($con, $log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Break Out';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => $name,
                            'position'   => $position,
                            'remark'   => $remark
                        );
                        echo json_encode($data);
                        exit();
                    } else {
                        $status = 'error';
                        $title = "Failed to break out";
                        $msg = 'Please Try Again';
                        $data = array(
                            'status' => $status,
                            'title'   => $title,
                            'message'   => $msg
                        );
                        echo json_encode($data);
                        exit();
                    }
                } elseif ($timeout_val != NULL && $breakout_val == NULL) {
                    $status = 'warning';
                    $title = 'Unable to break out';
                    $msg = strtok($name, " ") . ", you are already time out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } elseif ($breakin_val != NULL && $breakout_val == NULL) {
                    $status = 'warning';
                    $title = 'Unable to break out';
                    $msg = strtok($name, " ") . ", you are already break in";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'warning';
                    $title = strtok($name, " ") . ", you are already break out";
                    $msg = '';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            } else {
                $log_sql = "INSERT INTO time_log (employee_id,card_id,break_out,way,date_log) VALUES ('" . $employee_id . "','" . $break_out . "','" . DATE_TIME . "','onsite','" . DATE_NOW . "')";
                if (mysqli_query($con, $log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Break Out';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => $name,
                        'position'   => $position,
                        'remark'   => $remark
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'error';
                    $title = "Failed to break out";
                    $msg = 'Please Try Again';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            }
        }
    } else {
        $status = 'error';
        $title = "Invalid ID";
        $msg = "Please Try Again";
        $data = array(
            'status' => $status,
            'title'   => $title,
            'message'   => $msg
        );
        echo json_encode($data);
        exit();
    }
}

if (isset($_POST['break_in'])) {
    $break_in = $_POST['break_in'];
    $validate = validate_user($break_in);
    if ($validate === true) {
        $user_info = fetchdata_user($break_in);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,time_in,break_in,time_out FROM time_log WHERE card_id='$break_in' AND date_log='" . DATE_NOW . "'";
        if ($check_query = mysqli_query($con, $check_sql)) {
            if (mysqli_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $breakin_val = $check_data['break_in'];
                $timeout_val = $check_data['time_out'];
                if ($breakin_val == NULL && $timeout_val == NULL) {
                    $log_sql = "UPDATE time_log SET break_in='" . DATE_TIME . "' WHERE card_id='$break_in' AND date_log='" . DATE_NOW . "'";
                    if (mysqli_query($con, $log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Break In';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => $name,
                            'position'   => $position,
                            'remark'   => $remark
                        );
                        echo json_encode($data);
                        exit();
                    } else {
                        $status = 'warning';
                        $title = "Failed to break in";
                        $msg = 'Please Try Again';
                        $data = array(
                            'status' => $status,
                            'title'   => $title,
                            'message'   => $msg
                        );
                        echo json_encode($data);
                        exit();
                    }
                } elseif ($breakin_val == NULL && $timeout_val != NULL) {
                    $status = 'warning';
                    $title = 'Unable to break in';
                    $msg = strtok($name, " ") . ", you are already time out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'error';
                    $title = strtok($name, " ") . ", you are already break in";
                    $msg = '';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            } else {
                $log_sql = "INSERT INTO time_log (employee_id,card_id,break_in,way,date_log) VALUES ('" . $employee_id . "','" . $break_in . "','" . DATE_TIME . "','onsite','" . DATE_NOW . "')";
                if (mysqli_query($con, $log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Break In';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => $name,
                        'position'   => $position,
                        'remark'   => $remark
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'warning';
                    $title = "Failed to break in";
                    $msg = 'Please Try Again';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            }
        }
    } else {
        $status = 'error';
        $title = "Invalid ID";
        $msg = "Please Try Again";
        $data = array(
            'status' => $status,
            'title'   => $title,
            'message'   => $msg
        );
        echo json_encode($data);
        exit();
    }
}

if (isset($_POST['time_out'])) {
    $time_out = $_POST['time_out'];
    $validate = validate_user($time_out);
    if ($validate === true) {
        $user_info = fetchdata_user($time_out);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,time_in,time_out FROM time_log WHERE card_id='$time_out' AND date_log='" . DATE_NOW . "'";
        if ($check_query = mysqli_query($con, $check_sql)) {
            if (mysqli_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $timeout_val = $check_data['time_out'];
                if ($timeout_val === NULL) {
                    $log_sql = "UPDATE time_log SET time_out='" . DATE_TIME . "' WHERE card_id='$time_out' AND date_log='" . DATE_NOW . "'";
                    if (mysqli_query($con, $log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Time Out';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => $name,
                            'position'   => $position,
                            'remark'   => $remark
                        );
                        echo json_encode($data);
                        exit();
                    } else {
                        $status = 'error';
                        $title = "Failed to time out";
                        $msg = 'Please Try Again';
                        $data = array(
                            'status' => $status,
                            'title'   => $title,
                            'message'   => $msg
                        );
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    $status = 'warning';
                    $title = strtok($name, " ") . ", you are already time out";
                    $msg = '';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            } else {
                $log_sql = "INSERT INTO time_log (employee_id,card_id,time_out,way,date_log) VALUES ('" . $employee_id . "','" . $time_out . "','" . DATE_TIME . "','onsite','" . DATE_NOW . "')";
                if (mysqli_query($con, $log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Time Out';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => $name,
                        'position'   => $position,
                        'remark'   => $remark
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'error';
                    $title = "Failed to break in";
                    $msg = 'Please Try Again';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
            }
        }
    } else {
        $status = 'error';
        $title = "Invalid ID";
        $msg = "Please try again";
        $data = array(
            'status' => $status,
            'title'   => $title,
            'message'   => $msg
        );
        echo json_encode($data);
        exit();
    }
}

if (isset($_POST['updateTime'])) {
    $timeIn = $_POST['timeIn'];
    $timeOut = $_POST['timeOut'];
    $sql = "UPDATE sg_setting SET time_In='$timeIn',time_Out='$timeOut' ";
    $query = mysqli_query($con, $sql);
    if ($query) {
        header('location: platformSG.php');
        exit();
    } else {
        header('location: platformSG.php');
        exit();
    }
}

// Validation of the user
function validate_user($card_id)
{
    global $con;
    $id = $card_id;
    $validate_sql = "SELECT employee_id,card_id FROM user WHERE card_id='" . $id . "'";
    if ($validate_query = mysqli_query($con, $validate_sql)) {
        mysqli_num_rows($validate_query) > 0 ? $return = true : $return = false;
        return $return;
    }
}

// Validation of the time in log
// function check_timelog($card_id)
// {
//     global $con;
//     $id = $card_id;
//     $check_sql = "SELECT card_id,time_in FROM time_log WHERE card_id='$id' AND date_log='" . DATE_NOW . "'";
//     if ($check_query = mysqli_query($con, $check_sql)) {
//         mysqli_num_rows($check_query) > 0 ? $return = true : $return = false;
//         return $return;
//     }
// }

// Fetch user data
function fetchdata_user($card_id)
{
    global $con;
    $id = $card_id;
    $validate_sql = "SELECT employee_id,f_name,l_name,card_id,position,img FROM user WHERE card_id='" . $id . "'";
    if ($validate_query = mysqli_query($con, $validate_sql)) {
        $validate_data = mysqli_fetch_assoc($validate_query);
        $employee_id = $validate_data['employee_id'];
        $img = $validate_data['img'];
        $name = $validate_data['f_name'] . ' ' . $validate_data['l_name'];
        $position = $validate_data['position'];
        $data = array(
            'employee_id' => $employee_id,
            'img' => $img,
            'name' => $name,
            'position' => $position
        );
        return $data;
    }
}
