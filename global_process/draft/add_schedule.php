<?php
//insert.php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; // check kung nakalogin
$page_title = "schedule";
$response = array(
  'message' => 'Form submission Failed'

);

$employee_id = $_POST["employee_id"];
$jsondata = $_POST['schedule'];
$id_last = array();
$jsonarray = json_decode($jsondata, true);
$total = count($jsonarray);
// echo $jsonarray[1]['day'];

$i = 0;
$nxtday = 1;
while ($i < $total) {
  if ($jsonarray[$i]['start_time'] >= $jsonarray[$i]['end_time']) {
    $response['message'] = "low";
    $response['row_count'] = "#" . $i + 1;
    echo json_encode($response);
    exit;
  }
  $i++;
}
// $response['message']= $jsonarray[0]['day'];
// echo json_encode($response);

// for ($x = 0; $x<$total; $x++) {

//   if($x==0){
//     continue;
//   }

//   else if($jsonarray[$x]['start_time']<=$jsonarray[$x-1]['end_time']&&$jsonarray[$x]['day']==$jsonarray[$x-1]['day']){
//     $response['message']="exist";
//     $response['row_count']="#".$x+1;
//     echo json_encode($response);
//     exit;
//     }
//       } 
//   else if($end[count($start)-1]<$stime){
//   $enter= false; break;
//  } else if( $end[$x]<$time&&$start[$x+1]>$endtime ){
//   $enter=  false;break;}

// else{
//   $enter= true;
// }} 
$i = 0;
while ($i < $total) {

  if (scheduleExists($db_connect, $jsonarray[$i]['day'], $jsonarray[$i]['start_time'], $jsonarray[$i]['end_time'], $employee_id) == true) {
    $response['message'] = "exist";
    $response['row_count'] = "#" . $i + 1;


    echo json_encode($response);
    $id_last = implode(',', $id_last);
    $query = "DELETE FROM schedule  WHERE id IN ('.$id_last.')";
    mysqli_query($db_connect, $query);
    exit;
  }

  $sql = "INSERT INTO schedule(employee_id,day,start_time,end_time,section,room,subject_name,subject_code) VALUES ('" . $employee_id . "','" . $jsonarray[$i]['day'] . "','" . $jsonarray[$i]['start_time'] . "','" . $jsonarray[$i]['end_time'] . "','" . $jsonarray[$i]['section'] . "','" . $jsonarray[$i]['room_number'] . "','" . $jsonarray[$i]['subject_name'] . "','" . $jsonarray[$i]['subject_code'] . "');";
  if (mysqli_query($db_connect, $sql)) {
    $last_id = $db_connect->insert_id;

    $id_last[] = $last_id;

    $response['status'] = scheduleExists($db_connect, $jsonarray[$i]['day'], $jsonarray[$i]['start_time'], $jsonarray[$i]['end_time'], $employee_id);
    $response['message'] = 'complete';
  }
  $i++;
}








echo json_encode($response);

function scheduleExists($db_connect, $day, $start_time, $end_time, $employee_id)
{
  $start_time = date("H:i:s", strtotime($start_time));
  $end_time = date("H:i:s", strtotime($end_time));
  $query = "SELECT * FROM schedule where day= '$day' and employee_id='$employee_id' ORDER BY start_time  ASC";
  $query_run = mysqli_query($db_connect, $query);
  $start = array();
  $end = array();
  $start = array();
  $end = array();
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
