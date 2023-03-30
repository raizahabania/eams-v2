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

);

$remarks = null;
$response['row'] = array();
$id_last = array();
$alert = "";
$days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
$header = array('Employee ID', 'Day', 'Start Time', 'End Time', 'Section', 'Room', 'Subject Name', 'Subject Code');
$filename = $_FILES["bulk_insert"]["tmp_name"];
$i = 0;

if ($_FILES["bulk_insert"]["size"] > 0) {
	$file = fopen($filename, "r");
	while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
		if ($i == 0) {
			if (empty($emapData[0]) || empty($emapData[1]) || empty($emapData[2]) || empty($emapData[3]) || empty($emapData[4]) || empty($emapData[5]) || empty($emapData[6]) || empty($emapData[7])) {
				$remarks .= 'Incomplete Header';
				$alert = "danger";
				$response['error'] = true;
				$response['row'][] = '<tr><td class="text-center" colspan="10">' . $remarks . '</td</tr>';
				echo json_encode($response);
				exit;
			}

			if (($emapData[0] == $header[0]) && ($emapData[1] == $header[1]) && ($emapData[2] == $header[2]) && ($emapData[3] == $header[3]) && ($emapData[4] == $header[4]) && ($emapData[5] == $header[5]) && ($emapData[6]) && ($emapData[7] == $header[7])) {
				$i++;
				continue;
			} else {
				$remarks .= 'Incorrect Header';
				$alert = "danger";
				$response['error'] = true;
				$response['row'][] = '<tr><td> 1 </td><td>' . $emapData[0] . '</td><td>' . $emapData[1] . '</td><td>' . $emapData[2] . '</td><td>' . $emapData[3] . '</td><td>' . $emapData[4] . '</td><td>' . $emapData[5] . '</td><td>' . $emapData[6] . '</td><td>' . $emapData[7] . '</td><td><div style="padding: 0;text-align: center;"class="alert alert-' . $alert . '" role="alert">' . $remarks . '</div></td></tr>';
				echo json_encode($response);
				exit();
			}
		}
		$day_enter = $emapData[1];
		$emapData[1] = strtolower($emapData[1]);
		$remarks = "";


		$row_number = $i + 1;
		//It wiil check if employee exist
		if (empty($emapData[0]) && empty($emapData[1]) && empty($emapData[2]) && empty($emapData[3]) && empty($emapData[4]) && empty($emapData[5]) && empty($emapData[6]) && empty($emapData[7])) {

			continue;
		}

		if (employee_exist($db_connect, $emapData[0]) == false) {

			$remarks .= 'Employee not exist ';
			$response['error'] = true;
			$alert = "danger";
		}

		//check first if rows are complete   
		if (empty($emapData[0]) || empty($emapData[1]) || empty($emapData[2]) || empty($emapData[3]) || empty($emapData[4]) || empty($emapData[5]) || empty($emapData[6]) || empty($emapData[7])) {
			$remarks = 'Incomplete Row';
			$response['error'] = true;
			$alert = "danger";
		} else {
			//check first if Date and time  are Valid   
			if (!in_array($emapData[1], $days) || !preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/', $emapData[2]) || !preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/', $emapData[3])) {
				if ($remarks == "") {
					$remarks .= 'Invalid Day or Time';
				} else {
					$remarks .= 'and Invalid Day or Time';
				}
				$response['error'] = true;
				$alert = "danger";
				$emapData[1] = null;
				//check  if  Shedule is Exist  
			} else if (scheduleExists($db_connect, $emapData[1], $emapData[2], $emapData[3], $emapData[0]) == true) {
				if ($remarks == "") {
					$remarks .= 'Time not Valid';
				} else {
					$remarks .= 'and Time not Valid ';
				}
				$response['error'] = true;
				$alert = "danger";
				$emapData[1] = null;
			}
			//  if  There is no error
			if ($remarks == "") {

				$remarks .= 'Correct';
				$alert = "success";
				$emapData[1] = date('w', strtotime($emapData[1]));
			}
		}
		$response['row'][] = '<tr><td>' . $row_number . '</td><td>' . $emapData[0] . '</td><td>' . $day_enter . '</td><td>' . $emapData[2] . '</td><td>' . $emapData[3] . '</td><td>' . $emapData[4] . '</td><td>' . $emapData[5] . '</td><td>' . $emapData[6] . '</td><td>' . $emapData[7] . '</td><td><div style="padding: 0;text-align: center;"class="alert alert-' . $alert . '" role="alert">' . $remarks . '</div></td></tr>';
		$sql = "INSERT INTO schedule(employee_id,day,start_time,end_time,section,room,subject_name,subject_code)
	            	values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]')";


		if (mysqli_query($db_connect, $sql)) {
			$last_id = $db_connect->insert_id;
			$id_last[] = $last_id;
		} else {
			continue;
		}

		$i++;
	}

	if ($response['error'] == true) {
		$id_last = implode(",", $id_last);
		$query = 'DELETE FROM schedule  WHERE id IN (' . $id_last . ')';
		mysqli_query($db_connect, $query);
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

	$sql =	"SELECT * FROM users where employee_id = ? ";
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
function scheduleExists($db_connect, $day, $start_time, $end_time, $employee_id)
{
	$day = date('w', strtotime($day));
	$start_time = date("H:i:s", strtotime($start_time));
	$end_time = date("H:i:s", strtotime($end_time));
	$query = "SELECT * FROM schedule where day= '$day' and employee_id='$employee_id' ORDER BY start_time  ASC";
	$query_run = mysqli_query($db_connect, $query);
	$start = array();
	$end = array();
	$start = array();
	$end = array();

	if ($start_time > $end_time) {
		return true;
		exit();
	}
	if (mysqli_num_rows($query_run) > 0) {

		foreach ($query_run as $row) {
			$start[] = $row["start_time"];
			$end[] = $row["end_time"];
		}
	} else {
		return false;
		exit();
	}


	for ($x = 0; $x < count($start); $x++) {


		if ($start[0] >= $end_time) {
			$enter = false;
			break;
		} else if ($start_time >= end($end)) {
			$enter = false;
			break;
		} else if (($end[$x] <= $start_time) && ($start[$x + 1] >= $end_time)) {
			$enter = false;
			break;
		} else {
			$enter = true;
		}
	}
	return $enter;
}
	 	/////////////// End function checking for date/////////////////////////	
