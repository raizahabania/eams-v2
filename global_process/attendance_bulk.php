<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; // check kung nakalogin

$response = array(
    'message' => 'Form submission Failed',
    'row' => 'Form submission Failed',
    'error' => false,
    'icon' => false
);

$remarks = null;
$response['row'] = array();
$id_last = array();
$alert = "";
$date_now = DATE_NOW;
$header = array('Employee ID', 'Date', 'Time In', 'Break Out', 'Break In', 'Time Out');
$filename = $_FILES["bulk_insert"]["tmp_name"];
$not_exist = "";
$i = 0;

if ($_FILES["bulk_insert"]["size"] > 0) {
    $file = fopen($filename, "r");
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($i == 0) {
            if (empty($emapData[0]) || empty($emapData[1]) || empty($emapData[2]) || empty($emapData[3]) || empty($emapData[4]) || empty($emapData[5])) {
                $remarks .= 'Incomplete Header';
                $alert = "danger";
                $response['error'] = true;
                $response['row'][] = '<tr><td colspan="8" class="text-center">' . $remarks . '</td</tr>';
                echo json_encode($response);
                exit;
            }

            if (($emapData[0] == $header[0]) && ($emapData[1] == $header[1]) && ($emapData[2] == $header[2]) && ($emapData[3] == $header[3]) && ($emapData[4] == $header[4]) && ($emapData[5] == $header[5])) {
                $i++;
                continue;
            } else {
                $remarks .= 'Incorrect Header';
                $alert = "danger";
                $response['error'] = true;
                $response['row'][] = "<tr><td> 1 </td><td>" . $emapData[0] . "</td><td>" . $emapData[1] . "</td><td>" . $emapData[2] . "</td><td>" . $emapData[3] . "</td><td>" . $emapData[4] . "</td><td>" . $emapData[5] . "</td><td><div style='padding: 0;text-align: center;' class='alert alert-" . $alert . "' role='alert'>" . $remarks . "</div></td></tr>";
                echo json_encode($response);
                exit();
            }
        }

        $remarks = "";
        $row_number = $i + 1;
        if (empty($emapData[0]) && empty($emapData[1]) && empty($emapData[2]) && empty($emapData[3]) && empty($emapData[4]) && empty($emapData[5])) {
            continue;
        }

        //check first if rows are complete   
        if (empty($emapData[0]) || empty($emapData[1]) || empty($emapData[2]) || empty($emapData[5])) {
            if (empty($emapData[0])) {
                $remarks = 'Employee ID';
            }
            if (empty($emapData[1])) {
                if ($remarks == "") {
                    $remarks = 'Date';
                } else {
                    $remarks .= ', Date';
                }
            }
            if (empty($emapData[2])) {
                if ($remarks == "") {
                    $remarks = 'Time In';
                } else {
                    $remarks .= ', Time In';
                }
            }
            if (empty($emapData[5])) {
                if ($remarks == "") {
                    $remarks = 'Time Out';
                } else {
                    $remarks .= ', Time Out';
                }
            }
            $remarks .= ' cannot be empty.';
            $response['error'] = true;
            $alert = "danger";
        } else {
            $emp_id = $emapData[0];
            $date = $emapData[1];
            $time_in = $emapData[2];
            $break_out = $emapData[3];
            $break_in = $emapData[4];
            $time_out = $emapData[5];

            $new_time_in = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $time_in")));
            $new_time_out = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $time_out")));

            //It wiil check if employee exist
            if (employee_exist($db_connect, $emapData[0]) == false) {
                $remarks .= 'Employee ID not exist';
                $response['error'] = true;
                $alert = "danger";
            }

            //check first if Date and time  are Valid   
            if (!(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $emapData[1]))) {
                if ($remarks == "") {
                    $remarks .= 'Invalid Date Format (format: "Y-m-d")';
                } else {
                    $remarks .= ', Invalid Date Format (format: "Y-m-d")';
                }
                $response['error'] = true;
                $alert = "danger";
            } else {
                if (!(date("Y-m-d", strtotime($emapData[1])) <= $date_now)) {
                    if ($remarks == "") {
                        $remarks .= 'Invalid Date';
                    } else {
                        $remarks .= ', Invalid Date';
                    }
                    $response['error'] = true;
                    $alert = "danger";
                } else if (attendanceExists($db_connect, $emapData[0], $emapData[1]) == true) {
                    if ($remarks == "") {
                        $remarks .= 'Attendance already exist';
                    } else {
                        $remarks .= ', Attendance already exist ';
                    }
                    $response['error'] = true;
                    $alert = "danger";
                    $not_exist = true;
                    // $emapData[1] = null;
                } else if (attendanceExists($db_connect, $emapData[0], $emapData[1]) == false) {
                    $not_exist = false;
                }
            }
            // $date_enter = $emapData[1];
            if ($not_exist == false) {

                if ($new_time_in >= $new_time_out) {
                    if ($remarks == "") {
                        $remarks .= 'Invalid Time In or Out';
                    } else {
                        $remarks .= ', Invalid Time In or Out';
                    }
                    $response['error'] = true;
                    $alert = "danger";
                }

                if ($break_in != "" && $break_out != "") {

                    $new_break_in = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_in")));
                    $new_break_out = escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_out")));

                    if ($new_break_in <= $new_break_out) {
                        if ($remarks == "") {
                            $remarks .= 'Invalid Break Time';
                        } else {
                            $remarks .= ', Invalid Break Time';
                        }
                        $response['error'] = true;
                        $alert = "danger";
                    } elseif ($new_break_out <= $new_time_in || $new_break_out >= $new_time_out) {
                        if ($remarks == "") {
                            $remarks .= 'Invalid Break out';
                        } else {
                            $remarks .= ', Invalid Break out';
                        }
                        $response['error'] = true;
                        $alert = "danger";
                    } elseif ($new_break_in <= $new_time_in || $new_break_in >= $new_time_out) {
                        if ($remarks == "") {
                            $remarks .= 'Invalid Break in';
                        } else {
                            $remarks .= ', Invalid Break in';
                        }
                        $response['error'] = true;
                        $alert = "danger";
                    }
                } else {
                    $new_break_in = escape($db_connect, "NULL");
                    $new_break_out = escape($db_connect, "NULL");
                }
            }
            //  if  There is no error
            if ($remarks == "") {
                $remarks .= 'Correct';
                $alert = "success";
            }
        }



        if ($break_in != "" && $break_out != "") {
            $new_break_in = "'" . escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_in"))) . "'";
            $new_break_out = "'" . escape($db_connect, date('Y-m-d H:i:s', strtotime("$date $break_out"))) . "'";
        } else {
            $new_break_in = escape($db_connect, "NULL");
            $new_break_out = escape($db_connect, "NULL");
        }
        try {
            $sql = "INSERT INTO time_log (employee_id,date_log,time_in,time_out,break_out,break_in,manual) VALUES ('$emp_id','$date','$new_time_in','$new_time_out',$new_break_out,$new_break_in,1)";
            mysqli_query($db_connect, $sql);
            $last_id = $db_connect->insert_id;
            $id_last[] = $last_id;
        } catch (Exception $e) {
            if ($e->getCode() == 1062) {
                $response['error'] = true;
                $remarks = 'Attendance already exist';
                $alert = "danger";
            } else {
                $response['error'] = true;
                $remarks .= 'Error Encounter';
                $alert = "danger";
            }
        }

        $response['row'][] = '<tr><td>' . $row_number . '</td><td>' . $emapData[0] . '</td><td>' . $emapData[1] . '</td><td>' . $emapData[2] . '</td><td>' . $emapData[3] . '</td><td>' . $emapData[4] . '</td><td>' . $emapData[5] . '</td><td><div style="padding: 0;text-align: center;"class="alert alert-' . $alert . '" role="alert">' . $remarks . '</div></td></tr>';
        $i++;
    }


    if ($response['error'] == true) {
        if (!(empty($id_last))) {
            $id_last = implode(",", $id_last);
            $query = 'DELETE FROM time_log  WHERE id IN (' . $id_last . ')';
            if (mysqli_query($db_connect, $query)) {
            }
        }
    } else {
        $response['message'] = 'success';
    }

    fclose($file);
    mysqli_close($db_connect);
} else {
    $response['message'] = 'empty';
}
echo json_encode($response);


/////////////// Function checking for Email Id/////////////////////////	
function employee_exist($db_connect, $employee)
{
    $sql =    "SELECT * FROM users where employee_id = ? ";
    $stmt = mysqli_stmt_init($db_connect);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = false;
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $employee);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

/////////////// Function checking for date/////////////////////////	
function attendanceExists($db_connect, $emp_id, $attendance_date)
{
    $output = "";
    $attendance_date = date('Y-m-d', strtotime($attendance_date));
    $sql = "SELECT employee_id,date_log FROM time_log WHERE employee_id='" . $emp_id . "' AND date_log='" . $attendance_date . "'";
    if ($query = mysqli_query($db_connect, $sql)) {
        if ($num = mysqli_num_rows($query)) {
            $output = true;
        } else {
            $output = false;
        }
    }
    return $output;
}
