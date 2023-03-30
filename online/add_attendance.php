<?php 
require '../config/config.php';
require GLOBAL_FUNC;
require CONNECT_PATH;
require CL_SESSION_PATH;

$csrf = new CSRF($session_class);

$response = array(
    'message'=> null,
	'success'=> false
);

$token_1 = $csrf->validate('token_code', $_POST['token_code']);
$response['token_code'] = $csrf->string('token_code', 'token_code', 3600, 10);
if ($token_1) {
    
}else {
    $response = array();
    $response['error'] = "error";
    $response['message'] = "Invalid Auth-Token";
    echo json_encode($response);
	exit();
}


if(!isset($_POST['id_number'])&&!isset($_POST['action'])){
	header('Location:'.BASE_URL.'online');
	exit();
}

if(empty($_POST['id_number'])||empty($_POST['action'])){
	$response['message']="Incomplete Input";	
	echo json_encode($response);
	exit;
}

$attendance_time=date("Y-m-d H:i:s", strtotime(DATE_TIME));
$attendance_date=date("Y-m-d", strtotime(DATE_TIME));
$submit_button= isset($_POST['action']) ? $_POST['action'] : '';
$id_num = isset($_POST['id_number']) ? $_POST['id_number'] : '';
$password = isset($_POST['submit_password']) ? $_POST['submit_password'] : '';


$name = '';
$role = '';

////Hide Name///////////
//select user details and check if exists
$user_query ="SELECT CONCAT(f_name,' ',l_name) as name ,img,position FROM users where employee_id = '".escape($db_connect,$id_num)."' LIMIT 1" ;
if($user_query_run = mysqli_query($db_connect, $user_query)){
    if($data = mysqli_fetch_assoc($user_query_run)){
        $name=$data['name'];
        $role=$data['position'];
    }
}
	
if(!empty($name)){
	$response['name']=name_block($name);	
}else{
    $response['message'] = "Employee Number not found";
	echo json_encode($response);
	exit();
}

////end Hide Name///////////

//// Inputing  Employee ID and time///////////

//// Time In   ///////////
if($submit_button=="time-in"){

        
        if(!empty($password)){
            $submit_password=set_password($password);
        	if (password_exist($db_connect,$id_num,$submit_password) != true){
                $response['message']="Wrong Password";	
                echo json_encode($response);
                exit;
            }
        }
    
	    $time_select='time_in';
        $time_in = '';
        $time_out = '';
        $b_time_in ='';
        
    	$attendance_query ="SELECT time_in, time_out,building_timein,building_timeout,way FROM time_log  WHERE employee_id = '".escape($db_connect,$id_num)."' AND date_log='".escape($db_connect,$attendance_date)."' LIMIT 1"  ;
		if($attendance_query_run = mysqli_query($db_connect, $attendance_query)){
		    if($data = mysqli_fetch_assoc($attendance_query_run)){
		        	$time_in = $data['time_in'];
		        	$time_out = $data['time_out'];
		        	$b_time_in = $data['building_timein'];
		    }
		}
		
		if(empty($time_in)){
            
		}else{
    		$response['message'] = "This user already have time in";
    		echo json_encode($response);
    		exit();
		}
		
		 if(!empty($password)){
            $sql =	"INSERT into time_log (employee_id,date_log,time_in,building_timein, way) values('".escape($db_connect,$id_num)."','".escape($db_connect,$attendance_date)."','".escape($db_connect,$attendance_time)."','Online','online')";
    		if (mysqli_query($db_connect, $sql)) {
    			$response['message'] = "Attendance Record Successfully!";
    			$response['success'] = true;
    			echo json_encode($response);
    			exit;
    		}else{
    		  $response['error'] = "error";
    		   $response['message'] = "Error Encountered!";
    		    echo json_encode($response);
    		    exit();
    		}
        }
		
		$response['success']=true;
		echo json_encode($response);
        exit();
}
////  End of time In   ///////////
	  
	  
//// Time Out   ///////////
if($submit_button=="time-out"){
        
        $time_in = '';
        $time_out = '';
        $time_select = 'time_out';
        $b_time_in ='';
        
        if(!empty($password)){
            $submit_password=set_password($password);
        	if (password_exist($db_connect,$id_num,$submit_password) != true){
                $response['message']="Wrong Password";	
                echo json_encode($response);
                exit;
            }
        }
        
    	$attendance_query ="SELECT time_in, time_out,building_timein,building_timeout,way FROM time_log  WHERE employee_id = '".escape($db_connect,$id_num)."' AND date_log='".escape($db_connect,$attendance_date)."' LIMIT 1"  ;
		if($attendance_query_run = mysqli_query($db_connect, $attendance_query)){
		    if($data = mysqli_fetch_assoc($attendance_query_run)){
		        	$time_in = $data['time_in'];
		        	$time_out = $data['time_out'];
		        	$b_time_in = $data['building_timein'];
		    }
		}
		
		if(empty($time_in)){
		    $response['message']="No time in";	
            echo json_encode($response);
            exit;
		}else{
    		if($b_time_in != 'Online'){
    		    $response['message']="Sorry Time out is not allowed due to Time in recorded as Onsite";	
                echo json_encode($response);
                exit;
    		}
		}
		
		if(!empty($time_out)){
		    $response['message']="This user already has time out";	
		    $response['time']= $time_select;
            echo json_encode($response);
            exit;
		}
		
        if(!empty($password)){
            $sql="UPDATE  time_log SET time_out='".escape($db_connect,$attendance_time)."',building_timeout='Online' WHERE date_log ='".escape($db_connect,$attendance_date)."' AND employee_id='".escape($db_connect,$id_num)."'";
    		if(mysqli_query($db_connect,$sql)){ 
    			$response['message']="Attendance Record Successfully!";	
    			$response['success']=true;
    			echo json_encode($response);
    			exit;
    		 }else{
    		  $response['error'] = "error";
    		   $response['message'] = "Error Encountered!";
    		    echo json_encode($response);
    		    exit();
    		}
        }
        
	    $response['success']=true;
	    $response['time']=$time_select;
	    echo json_encode($response);
        exit();
		
}

  $response['error'] = 'error';
  $response['message'] = "Invalid Request";
  echo json_encode($response);
  exit();

	  ////  End of Time Out   ///////////
	  
// if(isset($_POST['submit_password'])){

// 	if($submit_button=="time-in"){
// 	$sql=	"INSERT into time_log (employee_id,date_log,time_in,building_timein,way) values('$id_num','$attendance_date','$attendance_time','Online','online')";
//     if(mysqli_query($db_connect,$sql)){ 
// 		$response['message']="Attendance Record Successfully!";	
// 		$response['success']=true;
//         echo json_encode($response);
// 		exit;
// 	}}


// }

//// End Inputing  Employee ID///////////





  //functions
//   datetime validate
  function verify_Attendance_time($attendance_time)
{
    return (DateTime::createFromFormat('Y-m-d H:i:s', $attendance_time) !== false);
}
//for if user doest have a time in
function user_exist($db_connect,$id_num){
	$sql=	"SELECT * FROM users where employee_id = ?";
	$stmt = mysqli_stmt_init($db_connect);
	if (!mysqli_stmt_prepare($stmt,$sql)){
	
		exit();
	}			
	mysqli_stmt_bind_param($stmt,"s",$id_num);
	mysqli_stmt_execute($stmt);
	$resultData = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}else{
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}
function password_exist($db_connect,$id_num,$submit_password){
	$sql=	"SELECT * FROM users where employee_id = ? AND password= ? ";
	$stmt = mysqli_stmt_init($db_connect);
	if (!mysqli_stmt_prepare($stmt,$sql)){
	    return false;
	}			
	mysqli_stmt_bind_param($stmt,"ss",$id_num,$submit_password);
	mysqli_stmt_execute($stmt);
	$resultData = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}else{
		return false;
	}
	mysqli_stmt_close($stmt);
}

//check if user time exist $time_select is use for the column name whether if time_in or time_out will return false if time does not exist in the database.
function time_exist($db_connect,$time_select,$id_num,$attendance_date){

		$attendance_query ="SELECT ".$time_select." FROM time_log where ".$time_select." is not null and  employee_id = '$id_num' and date_log='$attendance_date'"  ;
		
		$attendance_query_run = mysqli_query($db_connect, $attendance_query);
        $time_in = '';

		foreach($attendance_query_run as $row){
		    
			$time_in = new DateTime($row[$time_select]);
			
		}
		if(!empty($time_in)){
			return $time_in;
		}else {
			return false;
		}


}
//end of time exist function

//name hidden function.
function name_block($name){
	$i = 0;
	$array_name=explode(" ",$name);
				while($i < count($array_name))
				{

				$count = strlen($array_name[$i]);
				if($count<=4){
				$not_hide=1;
				$scount=$count-1;
				$array_name[$i] = substr_replace($array_name[$i], str_repeat('&#9679;', $scount), $not_hide, $scount);
				
				}else{

					$not_hide=2;
					$scount=$count-3;
					$array_name[$i] = substr_replace($array_name[$i], str_repeat('&#9679;', $scount), $not_hide, $scount);

				}
				$i++;
				}
return implode(" ",$array_name);
}

// end of name hidden function.

?>