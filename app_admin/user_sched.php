<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$session_class->session_close();
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
	include HTTP_404;
	exit();
}


$query_limit = QUERY_LIMIT;

$table_name= "schedule";
$field_query ='*';	
$pages =0;
$start = 0;
$size = 0;

$sorters =array();
$orderby ="id DESC";
$sql_where="";
$sql_conds="";
$sql_where_array=array();
$to_encode=array();
$output="";
$total_query = 0;

$dbfield = array('date_sched','id_num','CONCAT(TIME_FORMAT(start_time, "%h:%i %p"),"-",TIME_FORMAT(end_time, "%h:%i %p")) as sched_time','start_time','end_time','section','room','id','subject'); // need iset based sa table columns

$dborig = array('date_sched','id_num','sched_time','start_time','end_time','section','room','id','subject');

if(isset($_GET['size']) AND is_digit($_GET['size'])){
	$query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
}

//total query counter 
$field_query ='COUNT(DISTINCT id) as count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;
$default_query ="SELECT ".$field_query." FROM ".$table_name." ".$sql_conds;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$total_query = $data['count'];
		}
	}
}
// page button
$pages= ($total_query===0) ? 1 : ceil($total_query/$query_limit);
if(isset($_GET['page']) AND is_digit($_GET['page'])){
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;

$field_query = implode(',',$dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where; // ichange based sa need
$default_query ="SELECT ".$field_query." FROM ".$table_name." ".$sql_conds." ORDER BY ".$orderby;
$limit=" LIMIT ". $start_no.",".$query_limit; 
$sql_limit=$default_query.' '.$limit;
if($query = call_mysql_query($sql_limit)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$data = array_html($data);
			$data['id'] = $data['id'];
			$to_encode[] = $data;
		}
	}
	$output = json_encode(["last_page"=>$pages, "data"=>$to_encode,"total_record"=>$total_query]);
}else{
	$output =  json_encode(["last_page"=>0, "data"=>"","total_record"=>0]);
}

echo $output; //output

?>