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
    $schedules= array();

    // Users
    $table = "time_log";




    if (isset($_GET['status']) && $_GET['status'] == 'undefined') {
        $date = date('Y-m-d', strtotime(DATE_NOW));
    } else {
        $date = isset($_GET['status']) ? date('Y-m-d', strtotime($_GET['status'])) : '';
    }
    $day = date('w', strtotime($date));



    $faculty_sched =[];
    $collect_faculty =[];
    $default_query = "SELECT employee_id, day, start_time, end_time, active FROM schedule  WHERE day ='".$day."' ";
        // echo $default_query;
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $id = sha1($data['employee_id']);
                //find and declare if not exist
                if(!isset($faculty_sched[$id])) {
                    $faculty_sched[$id]=[];
                    $faculty_sched[$id]['e_id'] = $data['employee_id'];
                    $faculty_sched[$id]['start'] = $data['start_time'];
                    $faculty_sched[$id]['end'] = $data['end_time'];
                }

                if( strtotime($faculty_sched[$id]['start']) >= strtotime($data['start_time'])){
                    $faculty_sched[$id]['start'] = $data['start_time'];
                }

                if( strtotime($faculty_sched[$id]['end']) <= strtotime($data['end_time'])){
                    $faculty_sched[$id]['end'] = $data['end_time'];
                }    
                
                $collect_faculty[$id] = $data['employee_id'];
                // $to_encode[$id] = ['employee_id'=>$data['employee_id'],'time_in'=>NULL,'time_out'=>NULL,'date_log'=>$date,'' ]
            }
        }
    }

    $condition =" (time_in IS NOT NULL OR time_out IS NOT NULL)";
    $collect_faculty = array_values($collect_faculty);
    $faculty_id = implode("','",$collect_faculty);
    if(empty($faculty_id)){

    }else{
       $condition .= ' OR u.employee_id IN (\''.$faculty_id.'\')';
    }

    $condition = (empty($condition)) ? '' : 'WHERE '.$condition;

    $default_query = 'SELECT t.id,u.employee_id, CONCAT(u.f_name," ",u.l_name) as name, t.date_log, t.building_timein, t.building_timeout, IFNULL(TIMEDIFF(t.time_out,t.time_in),"00:00:00") as total_hour, IFNULL(TIMESTAMPDIFF(minute,t.time_in,t.time_out),0) as total_minute,IFNULL(TIMEDIFF(t.break_in,t.break_out),"00:00:00") as total_break, IFNULL(TIMESTAMPDIFF(minute,t.break_out,t.break_in),0) as total_bminute,DATE_FORMAT(t.time_in, "%H:%i:%s") as time_in , DATE_FORMAT(t.time_out, "%H:%i:%s") as time_out,DATE_FORMAT(t.break_in, "%H:%i") as break_in,DATE_FORMAT(t.break_out, "%H:%i") as break_out FROM users AS u';

    $default_query  .=' LEFT JOIN (SELECT id,employee_id,date_log,break_out,break_in,time_in,time_out,building_timein,building_timeout FROM time_log WHERE date_log = \''.escape($db_connect,$date).'\') as t ON u.employee_id = t.employee_id '.$condition.' ORDER BY t.id DESC';
    //echo $default_query;
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                //$data['employee_id'] = $data['employee_id'];
                $x_id = sha1($data['employee_id']);

                $sched_start = isset($faculty_sched[$x_id]) ? $faculty_sched[$x_id]['start'] : '';
                $sched_end = isset($faculty_sched[$x_id]) ? $faculty_sched[$x_id]['end'] : '';

                $status = 1;

                if ($data['break_in'] == null || $data['break_in'] == "00:00") {
                    $data['break_in'] = '';
                    $data['total_break'] = '00:00:00';
                }

                if ($data['break_out'] == null || $data['break_out'] == "00:00") {
                    $data['break_out'] = '';
                    $data['total_break'] = '00:00:00';
                }

                if ($data['time_in'] == null) {
                    $data['time_in'] = '';
                }

                if ($data['time_out'] == null) {
                    $data['time_out'] = '';
                }

                //total break
                $hms_1 = explode(":", $data['total_break']);
                $data['total_break'] = numberPrecision(($hms_1[0] + ($hms_1[1] / 60)), 2) . " hr/s";

                //total hour
                $hms_1 = explode(":", $data['total_hour']);
                $data['total_hour'] = numberPrecision(($hms_1[0] + ($hms_1[1] / 60)), 2) . " hr/s";

                //basic status
                if(empty($data['time_in'])){
                    $status = 'No Time In';
                }
                
                if(empty($data['time_out'])){
                    $status = 'No Time Out';
                }

                if(empty($data['time_in']) && empty($data['time_out']) ){
                    $status = 'Absent';
                }
                
                $data['total_work'] = '';

                if(empty($sched_start)){
                    $status = 'No Schedule';
                }

                if ((!empty($data['time_in'])) && (!empty($data['time_out'])) && !empty($sched_start) ) {

                    $one_half =   new DateTime($data['date_log'] . " 12:00:00");
                    $second_half =   new DateTime($data['date_log'] . " 13:00:00");

                    $t_in =   new DateTime($data['date_log'] . " " . $data['time_in']);
                    $t_out =   new DateTime($data['date_log'] . " " . $data['time_out']);

                    $sched_in =   new DateTime($data['date_log'] . " " . $sched_start);
                    $sched_out =   new DateTime($data['date_log'] . " " . $sched_end);

                    //if($sched_in != null && ($t_in < 0 && DATE_NOW.TIME_NOW  )
 
                    if($t_in <= $sched_in){ //override early
                        $t_in =   new DateTime($data['date_log'] . " " . $sched_start);
                    }

                    if($sched_out <= $t_out){ //override OT na
                        $t_out =   new DateTime($data['date_log'] . " " . $sched_end);
                    }


                    if($t_in <= $sched_in && $t_out >= $sched_out){
                        $status = 'Present';
                    }
                    
                    if($t_out < $sched_out){
                        $status = 'Early Out';
                    }

                    if($t_in > $sched_in){
                        $status = 'Late';
                    }
                    

                  
                    //first half
                    // $difference_first = "00:00:00";
                    if ($t_in <= $one_half && $t_out <= $one_half) { // 6:30<------>11:50   // 4:00 -- 4 :PM
                        $difference_first = $t_in->diff($t_out);
                        $difference_first = $difference_first->format('%h:%i:%s');
                    } else if ($t_in <= $one_half && $t_out >= $one_half) { //6:30<------>12:00 //11:50 -- 12.30
                        $difference_first = $t_in->diff($one_half); //minus from 12
                        $difference_first = $difference_first->format('%h:%i:%s');
                    } else { //else
                        $difference_first = "00:00:00";
                    }

                    $hms_1 = explode(":", $difference_first);

                    $difference_second = "00:00:00";
                    if ($t_in <= $second_half && $t_out >= $second_half) { // 8:00 -- 5:00  // 1:08 - 2:00
                        $difference_second = $second_half->diff($t_out);
                        $difference_second = $difference_second->format('%h:%i:%s');
                    } else if ($t_in >= $second_half && $t_out >= $second_half) { //1:08 - 2:00
                        $difference_second = $t_in->diff($t_out);
                        $difference_second = $difference_second->format('%h:%i:%s');
                    } else { //else 12:30 -- 12:50
                        $difference_second = "00:00:00";
                    }


                    $hms_2 = explode(":", $difference_second);
                    $one = numberPrecision($hms_2[0] + ($hms_2[1] / 60), 2);

                    $two = numberPrecision(($hms_1[0] + ($hms_1[1] / 60)), 2);
                    $data['total_work'] =  $one + $two;


                    $data['total_work'] = numberPrecision($data['total_work'], 2) . " hour/s";
                }

                $data['status'] = $status;

                $data['time_in'] = $data['time_in'] != null || $data['time_in'] != '' ? date('h:i:s A', strtotime($data['time_in'])) . ' [' . $data['building_timein'] . ']' : '';
                $data['time_out'] =  $data['time_out'] != null || $data['time_out'] != '' ? date('h:i:s A', strtotime($data['time_out'])) . ' [' . $data['building_timeout'] . ']' : '';

                

                // $data['status'] = $data['building_timein']."-".$data['building_timeout'];

                $to_encode[] = $data;
            }
        }
    }
    // $data[] = 'time';
    //$to_encode = array_values($to_encode);
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}

