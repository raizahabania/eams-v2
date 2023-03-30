<?php
require 'config/config.php';
include DOMAIN_PATH.'/config/connect.php';

$query_limit = 20;

$table_name= "time_log";
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


$start_no = ($start >= $total_query) ? $total_query : $start;

$default_query ="SELECT `date_log`, `employee_id`, `card_id`, `time_in`, `time_out`, `break_in`, `break_out` FROM `time_log`";

// run query
$query = $default_query . $sql_where . $sql_conds . " ORDER BY " . $orderby . " LIMIT " . $start_no . "," . $query_limit;

$result = mysqli_query($con, $query);
if (!$result) {
    printf("Error: %s \r ", mysqli_error($con));
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $to_encode[] = $row;
}

$output = json_encode(['total' => $total_query, 'data' => $to_encode, 'last_page' => $pages]);

echo $output;