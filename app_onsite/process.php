<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (isset($_POST['time_in'])) {
    $time_in = trim($_POST['time_in']);
    $building = trim($_POST['building']);
    $validate = validate_user($time_in);
    if ($validate === true) {
        $user_info = fetchdata_user($time_in);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT id,card_id,employee_id,time_in,time_out,break_in,break_out,building_timeout,building_timein FROM time_log WHERE employee_id = '".escape($db_connect,$employee_id)."' AND date_log='" . DATE_NOW . "'";
        if ($check_query = call_mysql_query($check_sql)) {
            if (call_mysql_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $check_data = array_html($check_data);
                $timein_val = $check_data['time_in'];
                $timeout_val = $check_data['time_out'];
                $breakin_val = $check_data['break_in'];
                $breakout_val = $check_data['break_out'];
                if ($timein_val != NULL) {
                    
                    if($check_data['building_timein'] == 'Online'){
                        //Update 
                         $log_sql = "UPDATE time_log SET time_in ='" . DATE_TIME . "', building_timein = '" .escape($db_connect,$building). "' WHERE id= '".$check_data['id']."'";
                        if ($check_query = call_mysql_query($log_sql)) {
                            $status = 'success';
                            $remark = 'Time in successfully updated';
                            $data = array(
                                'status' => $status,
                                'image'  => $img,
                                'name'   => trim($name),
                                'position'   => $position,
                                'remark'   => $remark
                            );
                            echo json_encode(array_html($data));
                            exit();
                        }else{
                            $status = 'warning';
                            $title = "Error Occured";
                            $msg = '';
                            $data = array(
                                'status' => $status,
                                'title'   => $title,
                                'message'   => $msg
                            );
                            echo json_encode($data);
                            exit();
                        }
                        
                        
                    }else{
                        
                    }
                    
                    $status = 'warning';
                    $title = trim($name) . ", you are already time in";
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
                    $msg = trim($name) . ", you are already time out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } elseif ($timein_val == NULL && $breakin_val != NULL) {
                    $status = 'warning';
                    $title = 'Unable to time in';
                    $msg = trim($name) . ", you are already break in";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } elseif ($timein_val == NULL && $breakout_val != NULL) {
                    $status = 'warning';
                    $title = 'Unable to time in';
                    $msg = trim($name) . ", you are already break out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } 
            } else {
                $log_sql = "INSERT INTO time_log (employee_id,card_id,time_in,building_timein,way,date_log) VALUES ('" . $employee_id . "','" . $time_in . "','" . DATE_TIME . "','" . $building . "','onsite','" . DATE_NOW . "')";
                if (call_mysql_query($log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Time In';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => trim($name),
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
    $break_out = trim($_POST['break_out']);
    $building = trim($_POST['building']);
    $validate = validate_user($break_out);
    if ($validate === true) {
        $user_info = fetchdata_user($break_out);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,employee_id,time_in,break_out,break_in,time_out FROM time_log WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
        if ($check_query = call_mysql_query($check_sql)) {
            if (call_mysql_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $check_data = array_html($check_data);
                $breakout_val = $check_data['break_out'];
                $breakin_val = $check_data['break_in'];
                $timeout_val = $check_data['time_out'];
                if ($breakout_val == NULL && $breakin_val == NULL && $timeout_val == NULL) {
                    $log_sql = "UPDATE time_log SET break_out='" . DATE_TIME . "' WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
                    if (call_mysql_query($log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Break Out';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => trim($name),
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
                    $msg = trim($name) . ", you are already time out";
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
                    $msg = trim($name) . ", you are already break in";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'warning';
                    $title = trim($name) . ", you are already break out";
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
                if (call_mysql_query($log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Break Out';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => trim($name),
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
    $break_in = trim($_POST['break_in']);
    $building = trim($_POST['building']);
    $validate = validate_user($break_in);
    if ($validate === true) {
        $user_info = fetchdata_user($break_in);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,employee_id,time_in,break_in,time_out FROM time_log WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
        if ($check_query = call_mysql_query($check_sql)) {
            if (call_mysql_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $check_data = array_html($check_data);
                $breakin_val = $check_data['break_in'];
                $timeout_val = $check_data['time_out'];
                if ($breakin_val == NULL && $timeout_val == NULL) {
                    $log_sql = "UPDATE time_log SET break_in='" . DATE_TIME . "' WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
                    if (call_mysql_query($log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Break In';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => trim($name),
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
                } elseif ($breakin_val == NULL && $timeout_val != NULL) {
                    $status = 'warning';
                    $title = 'Unable to break in';
                    $msg = trim($name) . ", you are already time out";
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $status = 'warning';
                    $title = trim($name) . ", you are already break in";
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
                if (call_mysql_query($log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Break In';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => trim($name),
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
    $time_out = trim($_POST['time_out']);
    $building = trim($_POST['building']);
    $validate = validate_user($time_out);
    if ($validate === true) {
        $user_info = fetchdata_user($time_out);
        $employee_id = $user_info['employee_id'];
        $img = $user_info['img'];
        $name = $user_info['name'];
        $position = $user_info['position'];
        $check_sql = "SELECT card_id,employee_id,time_in,time_out,building_timein FROM time_log WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
        if ($check_query = call_mysql_query($check_sql)) {
            if (call_mysql_num_rows($check_query) > 0) {
                $check_data = mysqli_fetch_assoc($check_query);
                $check_data = array_html($check_data);
                $timeout_val = $check_data['time_out'];
                if($check_data['building_timein'] == 'Online'){
                    $status = 'warning';
                    $title = trim($name) . ", you are not allowed to Time Out in Onsite due to you are Time In recorded as Online";
                    $msg = '';
                    $data = array(
                        'status' => $status,
                        'title'   => $title,
                        'message'   => $msg
                    );
                    echo json_encode($data);
                    exit();
                }
                if ($timeout_val === NULL) {
                    $log_sql = "UPDATE time_log SET time_out='" . DATE_TIME . "', building_timeout='" . $building . "' WHERE employee_id='$employee_id' AND date_log='" . DATE_NOW . "'";
                    if (call_mysql_query($log_sql)) {
                        $status = 'success';
                        $remark = 'Successfully Time Out';
                        $data = array(
                            'status' => $status,
                            'image'  => $img,
                            'name'   => trim($name),
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
                    $title = trim($name) . ", you are already time out";
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
                $log_sql = "INSERT INTO time_log (employee_id,card_id,time_out,building_timeout,way,date_log) VALUES ('" . $employee_id . "','" . $time_out . "','" . DATE_TIME . "','" . $building . "','onsite','" . DATE_NOW . "')";
                if (call_mysql_query($log_sql)) {
                    $status = 'success';
                    $remark = 'Successfully Time Out';
                    $data = array(
                        'status' => $status,
                        'image'  => $img,
                        'name'   => trim($name),
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

if (isset($_POST['updateSetting']) && $_POST['updateSetting'] == "submitUpdate") {
    $activepage = isset($_POST['activepage']) ? trim($_POST['activepage']) : '';
    $operator = isset($_POST['operator']) ? trim($_POST['operator']) : '';
    $building = isset($_POST['building']) ? trim($_POST['building']) : '';
    $timeIn = isset($_POST['timeIn']) ? trim($_POST['timeIn']) : '';
    $timeOut = isset($_POST['timeOut']) ? trim($_POST['timeOut']) : '';
    $sql = "UPDATE sg_setting SET building='$building',time_In='$timeIn',time_Out='$timeOut' WHERE operator='" . $operator . "'";
    if ($query = call_mysql_query($sql)) {
        $session_class->setValue('msg_success', 'Updated Successfully');
        header('location: ' . BASE_URL . 'app_onsite/' . $activepage . '.php');
        exit();
    } else {
        $session_class->setValue('msg_error', 'Updating Failed');
        header('location: ' . BASE_URL . 'app_onsite/' . $activepage . '.php');
        exit();
    }
}

// validation of the user
function validate_user($card_id)
{
    $id = $card_id;
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();

    $table = "users";
    $dbfield = array('employee_id', 'card_id');
    $field_query = implode(", ", $dbfield);

    $sql_where_array[] = "card_id = '" . $id . "'";
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . " FROM " . $table . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            $num > 0 ? $return = true : $return = false;
            return $return;
        }
    }
}

// fetch user info
function fetchdata_user($card_id)
{
    $id = $card_id;
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();

    $table = "users";
    $dbfield = array('employee_id', 'f_name', 'l_name', 'suffix', 'card_id', 'position', 'img');
    $field_query = implode(", ", $dbfield);

    $sql_where_array[] = "card_id = '" . $id . "'";
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . " FROM " . $table . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['img'] = 'online_profile.png';
                $data['name'] = $data['f_name'] . " " . $data['l_name'] . " " . $data['suffix'];
                return $data;
            }
        }
    }
}
