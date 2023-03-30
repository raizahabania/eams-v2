<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

// if(!(isset($_GET['table']))){
//     include HTTP_404;
//     exit();
// }

if (isset($_GET['table']) && $_GET['table'] == 'users') { // USERS
    $sorters = array();
    $orderby = "date_log DESC";
    $groupby = "date_log";
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $to_encode = array();
    $output = "";
    $total_query = 0;

    // Users
    $table = "time_log";
    $sql_where = "employee_id = '$employee_id'";
    $dbfield = array('id', 'employee_id', 'card_id', 'time_in', 'break_out', 'break_in', 'time_out', 'building_timein','building_timeout', 'way', 'date_log');
    $dborig = array('id', 'employee_id', 'card_id', 'time_in', 'break_out', 'break_in', 'time_out', 'building_timein','building_timeout', 'way', 'date_log');
    $field_query = implode(',', $dbfield);
    $total_break = 'TIMEDIFF(break_in,break_out) as total_break,TIMESTAMPDIFF(minute,break_out,break_in) as total_bminute';
    $total_hour = 'TIMEDIFF(time_out,time_in) as total_hour,TIMESTAMPDIFF(minute,time_in,time_out) as total_minute';
    $time = 'DATE_FORMAT(date_log, "%m/%d/%Y") as date_log,DATE_FORMAT(time_in,  "%H:%i") as time_in , DATE_FORMAT(time_out, "%H:%i") as time_out,DATE_FORMAT(break_in, "%H:%i") as break_in,DATE_FORMAT(break_out, "%H:%i") as break_out';
    $field_query = implode(", ", $dbfield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . "," . $time . "," . $total_hour . "," . $total_break . " FROM " . $table . " " . $sql_conds . " GROUP BY $groupby ORDER BY $orderby";

    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['employee_id'] = $data['employee_id'];
                
                if($data['time_in'] == NULL){
                    $data['time_in'] = '';
                    $data['total_hour'] = '';
                }
                
                if($data['time_out'] == NULL){
                    $data['time_out'] = '';
                    $data['total_hour'] = '';
                }

                if ($data['break_in'] == null || $data['break_in'] == "00:00") {
                    $data['break_in'] = '';
                    $data['total_break'] = '00:00:00';
                }

                if ($data['break_out'] == null || $data['break_out'] == "00:00") {
                    $data['break_out'] = '';
                    $data['total_break'] = '00:00:00';
                }
                
                //total break
                $bms = explode(":", $data['total_break']);
                $data['total_break'] = number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2) . " hour/s";

                if ($data['total_hour'] == NULL) {
                    $data['total_hour'] = '00:00:00';
                }

                //total hour
                $hms = explode(":", $data['total_hour']);
                
                // if(($data['break_out'] == null || $data['break_in'] == null) && $data['time_out']){

                //     $data['total_hour'] = (number_format(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), 2)) - (number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2)) - 1 . " hour/s";
                // }else{
                    
                //     $data['total_hour'] = (number_format(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), 2)) - (number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2)) . " hour/s";
                // }
                
                
                
                if (($data['break_out'] == null || $data['break_in'] == null) && $data['time_out']) {
                    $total_hour = (number_format(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), 2)) - (number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2));
                
                    if ($total_hour > 4) {
                        $total_hour -= 1;
                    }
                } else {
                    $total_hour = (number_format(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), 2)) - (number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2));
                }

                if ($total_hour < 0) {
                    $data['total_hour'] = '00:00:00';
                } else if ($total_hour > 4) {
                    $data['total_hour'] = number_format($total_hour, 2) . " hour/s";
                } else {
                    $data['total_hour'] = number_format($total_hour, 2) . " hour/s";
                }



                // if ($data['total_break'] == '0.00 hour/s') {
                //     $data['total_hour'] = (number_format(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), 2)) - (number_format(($bms[0] + ($bms[1] / 60) + ($bms[2] / 3600)), 2)) . " hour/s";
                // }

                if($data['total_break'] > $data['total_hour']){
                    $data['total_hour'] = '0 hour/s';
                }
                
                $data['time_in'] = $data['time_in'] != null || $data['time_in'] != '' ? date('h:i:s A', strtotime($data['time_in'])) . ' [' . $data['building_timein'] . ']' : '';
                $data['time_out'] =  $data['time_out'] != null || $data['time_out'] != '' ? date('h:i:s A', strtotime($data['time_out'])) . ' [' . $data['building_timeout'] . ']' : '';
                $to_encode[] = $data;
            }
        }
    }
    // $data[] = 'time';
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}
