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

$jsondata =[{"section":"1","room_number":"adasd","subject_name":"asdas","subject_code":"asdas","day":"1","start_time":"01:10","end_time":"02:00","row_id":1},{"section":"2","room_number":"asdada","subject_name":"asd","subject_code":"asd","day":"0","start_time":"11:04","end_time":"11:03","row_id":2},{"section":"3","room_number":"dasd","subject_name":"asdasd","subject_code":"asdasd","day":"0","start_time":"01:03","end_time":"11:04","row_id":3}]


$jsonarray = json_decode( $jsondata, true );
$total = count($jsonarray);
// echo $jsonarray[1]['day'];

$jsonarray->ksort();

foreach ($jsonarray as $key => $val) {
    echo "$key = $val\n";
}







// $i=0;
// $nxtday=2;
// while($i<$total){
//   if($jsonarray[$i]['start_time'] >= $jsonarray[$i]['end_time']){
//     $response['message']="low";
//     $response['row_count']="#".$i+1;
//     echo json_encode($response);
//     exit;
//   }
//   $i++;}
// $nxtday=2;
//   for ($x = 0; $x<$total; $x++) {
    
//     if($x==0){
  
//       continue;

//     }
//     else if($jsonarray[$x]['day']!=$jsonarray[$nxtday]['day']){
//       $nxtday++;

//       continue;
//     }
//     else if($jsonarray[$nxtday]['start_time']<=$jsonarray[$x]['end_time']&&$jsonarray[$x]['day']==$jsonarray[$nxtday]['day']){
//       $response['message']="exist";
//       $response['row_count']="#".$nxtday+1;
//       $response['day']=$jsonarray[$nxtday]['start_time'].$x." ".$jsonarray[$x]['end_time'].$nxtday;
//       echo json_encode($response);
//       exit;
//       }
//       $nxtday++;
//   } 
//     //   else if($end[count($start)-1]<$stime){
//     //   $enter= false; break;
//     //  } else if( $end[$x]<$time&&$start[$x+1]>$endtime ){
//     //   $enter=  false;break;}
    
//     // else{
//     //   $enter= true;
//     // }} 
//     $i=0;
//     while($i<$total){
// $sql="INSERT INTO schedule(employee_id,day,start_time,end_time,section,room,subject_name,subject_code) VALUES ('".$employee_id."','".$jsonarray[$i]['day']."','".$jsonarray[$i]['start_time']."','".$jsonarray[$i]['end_time']."','".$jsonarray[$i]['section']."','".$jsonarray[$i]['room_number']."','".$jsonarray[$i]['subject_name']."','".$jsonarray[$i]['subject_code']."');";
// if(mysqli_query($db_connect,$sql)){
//   $response['message']="complete";

// }
// $i++;}

// echo json_encode($response);



?>