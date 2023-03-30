<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (isset($_GET['table']) && $_GET['table'] == 'users') { // USERS
    $sorters = array();
    $orderby = "user_id DESC";
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $to_encode = array();
    $output = "";
    $total_query = 0;

    // Users
    $table = "users";

    $dbfield = array('employee_id','user_id','card_id','CONCAT(f_name," ",l_name) as name, position');
    $dborig = array('employee_id','user_id','card_id','name', 'position');
    $field_query = implode(',', $dbfield);

    
    $field_query = implode(", ", $dbfield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT " . $field_query . " FROM " . $table . " " . $sql_conds . " ORDER BY $orderby";

    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['employee_id'] = $data['employee_id'];
                $to_encode[] = $data;
            }
        }
    }
    // $data[] = 'time';
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}
