
<?php

require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;
$employee_id=$_POST["employee_id"];
$table="schedule";
$query = "SELECT subject_name,subject_code,day,start_time,DATE_FORMAT(start_time,'%I:%i %p') as 'formated_time',DATE_FORMAT(end_time,'%I:%i %p') as 'end_time' FROM ".$table."";

if(isset($_POST["employee_id"]))
{
$query .= " WHERE ";
 $query .= "employee_id = '".$employee_id."' GROUP BY start_time ORDER BY start_time ASC ";
}


$number_filter_row = mysqli_num_rows(mysqli_query($db_connect, $query));

$result = mysqli_query($db_connect,$query);

$data = array();


$day = array(); 
$query_day = "SELECT * FROM schedule";
$day_result = mysqli_query($db_connect, $query_day);
while($row = mysqli_fetch_array($day_result))
{
  $day[]=$row['day'];
}

while($row = mysqli_fetch_array($result))
{
	$i=0;
	$sub_array = array();
	$subject=$row["subject_name"];
	$sub_array[] = "<span style='color:#FF0000;font-weight: bold;'>".$row['formated_time'].'-'. $row['end_time']."</span>";
	while($i<=6){
		if(in_array($i,$day)==true){
			$query_subject = mysqli_query($db_connect, "SELECT id,subject_name,subject_code,room,section FROM ".$table." WHERE start_time='".$row['start_time']."'  AND employee_id = '".$employee_id."' AND day='".$i."' ");
			$get_subject = mysqli_fetch_assoc($query_subject); 
			if(!empty($get_subject)){
				// Buttons 
				$buttons='';
			if(!($g_user_role == "END_USER")){
				$buttons='<div class="m-2"><button type="button" data-id="'.$get_subject['id'].'" id="remove_schedule" class="btn btn-outline-danger btn-rounded btn-sm"><i class="bi bi-trash" ></i></button</div>';
			}
			   	//ENd  Buttons 
			$get_subject['subject_name'];
				$sub_array[] ="<span style='color:#006600;font-weight: bold;'>".$get_subject['subject_name']." (".$get_subject['subject_code'].")</span><br><span style='color:#000066;font-weight: bold;' >".$get_subject['room'].",".$get_subject['section']."</span>".$buttons;
			}
			else{
				$sub_array[] = " ";
			}
	
		}else{
			$sub_array[] = "";
		}
	

		$i++;
}
$data[] = $sub_array;
}





$output = array(

 "data"    => $data,
);



echo json_encode($output);

?>