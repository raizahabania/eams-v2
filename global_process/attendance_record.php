<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;


function numberPrecision($number, $decimals = 0)
{
    $negation = ($number < 0) ? (-1) : 1;
    $coefficient = 10 ** $decimals;
    return $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
}

if (isset($_GET['table']) && $_GET['table'] == 'users') { // USERS
    $sorters = array();
    $orderby = "id DESC";
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $to_encode = array();
    $output = "";
    $total_query = 0;
    // Users
    $table = "time_log";

    $dbfield = array('al.employee_id', 'CONCAT(u.f_name," ",u.l_name) as name', 'id', 'date_log','building_timein','building_timeout');
    $dborig = array('employee_id', 'name', 'id', 'date_log');

    $field_query = implode(", ", $dbfield);
    $total_break = 'IFNULL(TIMEDIFF(break_in,break_out),"00:00:00") as total_break, IFNULL(TIMESTAMPDIFF(minute,break_out,break_in),0) as total_bminute';
    $total_hour = 'IFNULL(TIMEDIFF(time_out,time_in),"00:00:00") as total_hour, IFNULL(TIMESTAMPDIFF(minute,time_in,time_out),0) as total_minute';

    
    $extract_time = 'DATE_FORMAT(time_in,  "%H:%i:%s") as time_in , DATE_FORMAT(time_out, "%H:%i:%s") as time_out,DATE_FORMAT(break_in, "%H:%i") as break_in,DATE_FORMAT(break_out, "%H:%i") as break_out';
    $name = 'as al LEFT JOIN (SELECT f_name,l_name,employee_id FROM users) as u ON al.employee_id = u.employee_id';

    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . "," . $total_hour . "," . $total_break . "," . $extract_time . " FROM " . $table . " " . $name . " " . $sql_conds . " ORDER BY $orderby";

//echo $default_query;
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['employee_id'] = $data['employee_id'];
                // if time_in and time_out is null

                if ($data['break_in'] == null || $data['break_in'] == "00:00") {
                    $data['break_in'] = '';
                    $data['total_break'] = '00:00:00';
                }

                if ($data['break_out'] == null || $data['break_out'] == "00:00") {
                    $data['break_out'] = '';
                    $data['total_break'] = '00:00:00';
                }

                if($data['time_in'] == null){
                    $data['time_in'] = '';
                }

                if($data['time_out'] == null){
                    $data['time_out'] = '';
                }
                
                //total break
                $hms_1 = explode(":", $data['total_break']);
                $data['total_break'] =numberPrecision(($hms_1[0] + ($hms_1[1] / 60) ), 2) ." hr/s";

                //total hour
                $hms_1 = explode(":", $data['total_hour']);
                $data['total_hour'] = numberPrecision(($hms_1[0] + ($hms_1[1] / 60) ), 2) ." hr/s";


             
                $data['total_work'] = '';
                if( (!empty($data['time_in'])) && (!empty($data['time_out'])) ){   

                    $one_half =   new DateTime($data['date_log']." 12:00:00");
                    $second_half =   new DateTime($data['date_log']." 13:00:00");
    
                    $t_in =   new DateTime($data['date_log']." ".$data['time_in']);
                    $t_out =   new DateTime($data['date_log']." ".$data['time_out']);
    
                    //first half
                   // $difference_first = "00:00:00";
                    if( $t_in <= $one_half && $t_out <= $one_half ) { // 6:30<------>11:50   // 4:00 -- 4 :PM
                        $difference_first = $t_in->diff($t_out);
                        $difference_first = $difference_first->format('%h:%i:%s');
                    }else if($t_in <= $one_half && $t_out >= $one_half){ //6:30<------>12:00 //11:50 -- 12.30
                        $difference_first = $t_in->diff($one_half); //minus from 12
                        $difference_first = $difference_first->format('%h:%i:%s');

                    }else{ //else
                        $difference_first = "00:00:00";
                    }

                    $hms_1 = explode(":", $difference_first);

                    $difference_second = "00:00:00";
                    if( $t_in <= $second_half && $t_out >= $second_half ) { // 8:00 -- 5:00  // 1:08 - 2:00
                        $difference_second= $second_half->diff($t_out);
                        $difference_second = $difference_second->format('%h:%i:%s');

                    }else if( $t_in >= $second_half && $t_out >= $second_half ) { //1:08 - 2:00
                        $difference_second= $t_in->diff($t_out);
                        $difference_second = $difference_second->format('%h:%i:%s');

                    }else{ //else 12:30 -- 12:50
                       $difference_second = "00:00:00";
                    }


                    $hms_2 = explode(":", $difference_second);
                    $one = numberPrecision($hms_2[0] + ($hms_2[1] / 60),2);

                    $two = numberPrecision(($hms_1[0] + ($hms_1[1] / 60)), 2); 
                    $data['total_work'] =  $one + $two;

           
                    $data['total_work'] = numberPrecision($data['total_work'],2)." hour/s";
    
                }
                   

                $data['time_in'] = $data['time_in'] != null || $data['time_in'] != '' ? date('h:i:s A', strtotime($data['time_in'])) . ' [' . $data['building_timein'] . ']' : '';
                $data['time_out'] =  $data['time_out'] != null || $data['time_out'] != '' ? date('h:i:s A', strtotime($data['time_out'])) . ' [' . $data['building_timeout'] . ']' : '';
                $to_encode[] = $data;
            }
        }
    }
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}