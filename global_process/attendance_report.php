<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

// $session_class->session_close();
// if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
// 	include HTTP_404;
// 	exit();
// }
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
    $table = "schedule";

    $dbfield = array('al.employee_id', 'day', 'CONCAT(u.f_name," ",u.l_name) as name', 'id', 'sched.date_log', 'time_in', 'time_out');
    $dborig = array('employee_id', 'day','name', 'id', 'date_log', 'time_in', 'time_out');


    if (isset($_GET['day']) && $_GET['day'] == 'undefined') {
        $date = date('Y-m-d', strtotime(DATE_NOW));
    } else {
        $date = isset($_GET['day']) ? date('Y-m-d', strtotime($_GET['day'])) : '';
    }

    $day = date('w', strtotime($date));
    $sql_where = "day = '$day'";

    $field_query = implode(", ", $dbfield);
    $sched = "as al LEFT JOIN (SELECT employee_id, date_log, time_in, time_out FROM time_log WHERE date_log = '" . $date . "') as sched ON al.employee_id = sched.employee_id";
    $name = 'LEFT JOIN (SELECT f_name,l_name,employee_id FROM users) as u ON al.employee_id = u.employee_id';

    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . " FROM " . $table . " " . $sched . " " . $name . " " . $sql_conds . " ORDER BY $orderby";

    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['employee_id'] = $data['employee_id'];
                // if time_in and time_out is null

                $data['day'] = 'absent';
                if ($data['date_log'] != null) { // check if present
                    $data['day'] = 'present';
                }
                // $data['name'] = $empname['name'];

                $data['date_log'] = $date;
                $to_encode[] = $data;
            }
        }
    }
    // $data[] = 'time';
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}
