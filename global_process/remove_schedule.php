<?php
//insert.php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;// check kung nakalogin
$page_title ="schedule";
$response = array(
  'message'=> 'Form submission Failed'

);

  $schedule_id=$_POST["schedule_id"];

  
  $sql="DELETE FROM schedule WHERE id='$schedule_id'";
  if(mysqli_query($db_connect,$sql)){



    $response['message']='success';
  }
echo json_encode($response);

?>