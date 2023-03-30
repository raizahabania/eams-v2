<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$query_limit = QUERY_LIMIT;

$table_name = "time_log";
$field_query = '*';
$pages = 0;
$start = 0;
$size = 0;

$sorters = array();
$orderby = "date_log DESC";
$sql_where = "";
$sql_conds = "";
$sql_where_array = array();
$to_encode = array();
$output = "";
$total_query = 0;

$dbfield = array('id', 'employee_id', 'card_id', 'time_in', 'time_out', 'break_in', 'break_out', 'building_timein', 'building_timeout', 'way', 'date_log'); // need iset based sa table columns

//$dborig = array('user_id','name','firstname','lastname','id','time_in','time_out','break_in','break_out','building','way');
$dborig = array('id', 'employee_id', 'card_id', 'time_in', 'time_out', 'break_in', 'break_out', 'building_timein', 'building_timeout', 'way', 'date_log');

if (isset($_GET['filters'])) {
    /**
     * Filters the data based on the filter value and field name
     * @return array $sql_where_array - array of the filtered data
     */
    $filters = array();
    $sort_filters = array();
    $filters = $_GET['filters'];
    // This loop will filter the data based on the filter value and field name
    foreach ($filters as $filter) {
        if (isset($filter['field'])) {
            if ($filter['field'] == 'user_role') {
                if (is_array($filter['value'])) {
                    $filter['value'] = $filter['value'][0];
                }
                if ($filter['value'] == 0) {
                    continue;
                }
            }
            $id = $filter['field'];
            $sort_filters[$id] = $filter['value'];
        }
    }

    foreach ($dborig as $id) {
        if (isset($sort_filters[$id])) {
            $value = escape($db_connect, $sort_filters[$id]);
            if ($id == "name") {
                $sql_where_array[] = 'employee_id LIKE \'%' . $value . '%\'';
                continue;
            }
            $sql_where_array[] = $id . ' LIKE \'%' . $value . '%\'';
        }
    }

    // This will create the where clause for the query based on the filtered data array
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
}

if (isset($_GET['sorters'])) {
    $sorters = $_GET['sorters'];
    $tag = array('asc', 'desc');
    if (in_array($sorters[0]['field'], $dborig) and in_array($sorters[0]['dir'], $tag)) {
        $orderby = $sorters[0]['field'] . ' ' . $sorters[0]['dir'];
    }
}


if (isset($_GET['size']) and is_digit($_GET['size'])) {
    $query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
}

//total query counter
$field_query = 'COUNT(DISTINCT id) as count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;
$default_query = "SELECT " . $field_query . " FROM " . $table_name . " " . $sql_conds;
if ($query = call_mysql_query($default_query)) {
    if ($num = call_mysql_num_rows($query)) {
        while ($data = call_mysql_fetch_array($query)) {
            $total_query = $data['count'];
        }
    }
}
// page button
$pages = ($total_query === 0) ? 1 : ceil($total_query / $query_limit);
if (isset($_GET['page']) and is_digit($_GET['page'])) {
    $page_no = $_GET['page'] - 1;
    $start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;

$field_query = implode(',', $dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where; // ichange based sa need
$default_query = "SELECT " . $field_query . " FROM " . $table_name . " " . $sql_conds . " ORDER BY " . $orderby;
$limit = " LIMIT " . $start_no . "," . $query_limit;
$sql_limit = $default_query . ' ' . $limit;
if ($query = call_mysql_query($sql_limit)) {
    if ($num = call_mysql_num_rows($query)) {
        while ($data = call_mysql_fetch_array($query)) {
            $data = array_html($data);
            $data['id'] = $data['id'];
            $data['break_in'] = date('h:i',strtotime($data['break_in'])) != '00:00' || $data['break_in'] != null ? $data['break_in'] : '';
            $data['break_out'] = date('h:i',strtotime($data['break_out'])) != '00:00' || $data['break_out'] != null ? $data['break_out'] : '';
            $data['time_in'] = $data['time_in'] != null || $data['time_in'] != '' ? date('h:i:s A',strtotime($data['time_in'])) . ' [' . $data['building_timein'] . ']' : '';
            $data['time_out'] =  $data['time_out'] != null || $data['time_out'] != '' ? date('h:i:s A',strtotime($data['time_out'])) . ' [' . $data['building_timeout'] . ']' : '';
            $to_encode[] = $data;
        }
    }
    $output = json_encode(["last_page" => $pages, "data" => $to_encode, "total_record" => $total_query]);
} else {
    $output =  json_encode(["last_page" => 0, "data" => "", "total_record" => 0]);
}

echo $output; //output
