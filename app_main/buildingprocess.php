<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;


if (isset($_GET['table']) && $_GET['table'] == 'building') {
    $sorters = array();
    $orderby = "id";
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $to_encode = array();
    $output = "";
    $total_query = 0;

    $table = "sg_setting";
    $table_join = "users";
    $dborig = array('id', 'operator', 'time_In', 'time_Out', 'building');
    $dbfield = array('id', 'operator', 'time_In', 'time_Out', 'building');
    $field_query = implode(",", $dbfield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "SELECT * FROM " . $table . " as sgInfo LEFT JOIN (SELECT employee_id,f_name,m_name,l_name,suffix FROM " . $table_join . ") as usersInfo on sgInfo.operator = usersInfo.employee_id " . $sql_conds . " ORDER BY $orderby";

    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            while ($data = call_mysql_fetch_array($query)) {
                $data = array_html($data);
                $data['name'] = $data['f_name'] . " " . ($data['m_name'] != '' ? $data['m_name'] . ' ' : '') . "" . $data['l_name'] . " " . $data['suffix'];
                $data['time_In'] = date('h:i a', strtotime($data['time_In']));
                $data['time_Out'] = date('h:i a', strtotime($data['time_Out']));
                $to_encode[] = $data;
            }
        }
    }
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}

if (isset($_POST['actionSubmit']) && $_POST['actionSubmit'] == 'submitBuilding') {
    $operator = isset($_POST['operator']) ? trim($_POST['operator']) : '';
    $timein = isset($_POST['timein']) ? date('H:i', strtotime(trim($_POST['timein']))) : '';
    $timeout = isset($_POST['timeout']) ? date('H:i', strtotime(trim($_POST['timeout']))) : '';
    $building_name = isset($_POST['building_name']) ? trim($_POST['building_name']) : '';
    $table = 'sg_setting';
    $dbfield = array('operator', 'time_In', 'time_Out', 'building');
    $insertfield = array();

    $insertfield[] = "'" . $operator . "'";
    $insertfield[] = "'" . $timein . "'";
    $insertfield[] = "'" . $timeout . "'";
    $insertfield[] = "'" . $building_name . "'";

    $field_query = implode(", ", $dbfield);
    $field_insert = implode(",", $insertfield);

    $insert_sql = "INSERT INTO " . $table . " (" . $field_query . ") VALUES (" . $field_insert . ")";
    if ($insert_query = call_mysql_query($insert_sql)) {
        $session_class->setValue('msg_success', 'Added Successfully');
    } else {
        $session_class->setValue('msg_error', 'Adding Failed');
    }
    exit();
}

if (isset($_POST['actionUpdate']) && $_POST['actionUpdate'] == 'submitUpdate') {
    $building_id = isset($_POST['building_id']) ? trim($_POST['building_id']) : '';
    $operatorId = isset($_POST['operatorId']) ? trim($_POST['operatorId']) : '';
    $time_in = isset($_POST['time_in']) ? date('H:i', strtotime(trim($_POST['time_in']))) : '';
    $time_out = isset($_POST['time_out']) ? date('H:i', strtotime(trim($_POST['time_out']))) : '';
    $buildingName = isset($_POST['buildingName']) ? trim($_POST['buildingName']) : '';

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();

    $table = "sg_setting";
    $updatefield[] = "operator = '" . $operatorId . "'";
    $updatefield[] = "time_In = '" . $time_in . "'";
    $updatefield[] = "time_Out = '" . $time_out . "'";
    $updatefield[] = "building = '" . $buildingName . "'";
    $sql_where_array[] = "id = '" . $building_id . "'";

    $field_query = implode(',', $updatefield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "UPDATE " . $table . " SET " . $field_query . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        $session_class->setValue('msg_success', 'Updated Successfully');
    } else {
        $session_class->setValue('msg_error', 'Updating Failed');
    }
    exit();
}

if (isset($_POST['actionDelete']) && $_POST['actionDelete'] == 'submitDelete') {
    $building_id = isset($_POST['building_id']) ? trim($_POST['building_id']) : '';
    $operator = isset($_POST['operator']) ? trim($_POST['operator']) : '';

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $table = "sg_setting";
    $dbfield = array('id', 'operator');
    $field_query = implode(", ", $dbfield);
    $sql_where_array[] = "id = '" . $building_id . "'";
    $sql_where_array[] = "operator = '" . $operator . "'";
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;
    $default_query = "SELECT " . $field_query . " FROM " . $table . " " . $sql_conds . " LIMIT 1";
    if ($query = call_mysql_query($default_query)) {
        if ($num = call_mysql_num_rows($query)) {
            $delete_sql = "DELETE FROM " . $table . " " . $sql_conds . " ";
            if ($delete_query = call_mysql_query($delete_sql)) {
                $alter_sql = "ALTER TABLE " . $table . " AUTO_INCREMENT = 1";
                $alter_query = call_mysql_query($alter_sql);
                $session_class->setValue('msg_success', 'Deleted Successfully');
            } else {
                $session_class->setValue('msg_error', 'Deleting Failed');
            }
        }
    }
    exit();
}

if (isset($_POST['updateBuildingId']) && $_POST['updateBuildingId'] != '') {
    $updateBuildingId = $_POST['updateBuildingId'];
    $sg_array = array();
    $sg_sql = "SELECT operator FROM sg_setting WHERE operator != '" . $updateBuildingId . "'";
    if ($sg_query = mysqli_query($db_connect, $sg_sql)) {
        if ($sg_num = mysqli_num_rows($sg_query)) {
            while ($sg_data = mysqli_fetch_assoc($sg_query)) {
                $sg_array[] = "'" . $sg_data['operator'] . "'";
            }
        }
    }
    if (!(empty($sg_array))) {
        $sg_operator = implode(", ", $sg_array);
    } else {
        $sg_operator = "' '";
    }
    $user_sql = "SELECT employee_id,f_name,m_name,l_name,suffix FROM users WHERE NOT employee_id IN ($sg_operator) AND user_role = '3' ORDER BY f_name ASC";
    if ($user_query = mysqli_query($db_connect, $user_sql)) {
        if ($user_num = mysqli_num_rows($user_query)) {
            while ($user_data = mysqli_fetch_assoc($user_query)) {
                $name = $user_data['f_name'] . ' ' . ($user_data['m_name'] != null || $user_data['m_name'] != '' ? $user_data['m_name'] . ' ' : '') . '' . $user_data['l_name'] . ' ' . $user_data['suffix'];
                echo '<option value="' . $user_data['employee_id'] . '">' . $name . '</option>';
            }
        }
    }
}

// VALIDATIONS
if (isset($_POST['valid_input']) && $_POST['valid_input'] != '') {
    $table = "sg_setting";
    $input = trim($_POST['valid_input']);
    $value = isset($_POST['valid_value']) ? trim($_POST['valid_value']) : '';
    $default_query = "SELECT " . $input . " FROM " . $table . " WHERE " . $input . " = '" . $value . "'";
    $output = '';
    if ($query = call_mysql_query($default_query)) {
        if (($num = call_mysql_num_rows($query)) > 0) {
            $output = 'exist';
        }
    }
    echo json_encode($output);
    exit();
}
// END VALIDATIONS
