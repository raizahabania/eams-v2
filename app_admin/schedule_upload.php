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

$start_date = date('Y-m-01');
 $end_date = date('Y-m-t');

	$filename=$_FILES["bulk_insert"]["tmp_name"];
 
 
		 if($_FILES["bulk_insert"]["size"] > 0)
		 {
 
		  	$file = fopen($filename, "r");
			  $i=0;
	         while (($emapData = fgetcsv($file, 200, ",")) !== FALSE)
	         {
		

				if($i==0){
					$i++;
					continue;
			
				}
		

			

			

				if(empty($emapData[3])||empty($emapData[4])||empty($emapData[5])||empty($emapData[6])){
					continue;

				}
				$emapData[4] = date("Y-m-d", strtotime($emapData[4]));
				
				if($emapData[4] > $end_date || $emapData[4] < $start_date){
					$response['not_valid']="not_church";
					continue;
				}
				if($emapData[6] != $_SESSION['church']){
					$response['not_valid']="not_church";
					continue;
				}
			
	          //It wiil insert a row to our subject table from our csv file`
	           $sql = "INSERT  into finance (first_name,last_name,middle_initial,source,date_finance,amount,church) 
	            	values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	          $result = mysqli_query( $dbconn, $sql );
				if(! $result )
				{
				continue;
				}
                
				
	         }
	         fclose($file);
	      
			mysqli_close($dbconn); 
 
        
           
 
		 }
         $response['message']="complete";
         echo json_encode($response);
	 
?>		