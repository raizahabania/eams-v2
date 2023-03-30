<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (isset($_GET['table']) && $_GET['table'] == 'users') { // USERS
    $sorters = array();
    $orderby = "user_id";
    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $to_encode = array();
    $output = "";
    $total_query = 0;

    // Users
    $table = "users";
    $dbfield = array('user_id', 'employee_id', 'card_id', 'f_name', 'm_name', 'l_name', 'suffix', 'user_role', 'username', 'email_address', 'position', 'status', 'locked');
    $dborig = array('user_id', 'employee_id', 'card_id', 'f_name', 'm_name', 'l_name', 'suffix', 'user_role', 'username', 'email_address', 'position', 'status', 'locked');
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
                $data['name'] = $data['f_name'] . " " . $data['m_name'] . " " . $data['l_name'] . " " . $data['suffix'];
                if ($data['status'] == 1) {
                    $data['account_status'] = 'Deactivated';
                } elseif ($data['locked'] == 1) {
                    $data['account_status'] = 'Locked';
                } elseif ($data['status'] == 0 && $data['locked'] == 0) {
                    $data['account_status'] = 'Active';
                }
                $to_encode[] = $data;
            }
        }
    }
    $output = json_encode(["data" => $to_encode]);
    echo $output;
    exit();
}

if (isset($_POST['actionSubmit']) && $_POST['actionSubmit'] == 'submitUser') {
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $card_id = isset($_POST['card_id']) ? trim($_POST['card_id']) : '';
    $f_name = isset($_POST['f_name']) ? trim($_POST['f_name']) : '';
    $m_name = isset($_POST['m_name']) ? trim($_POST['m_name']) : '';
    $l_name = isset($_POST['l_name']) ? trim($_POST['l_name']) : '';
    $suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    // $inputpassword = isset($_POST['password']) ? trim($_POST['password']) : '';
    $inputpassword = password_generate();
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $user_role = isset($_POST['user_role']) ? trim($_POST['user_role']) : '';
    $position = isset($_POST['position']) ? trim($_POST['position']) : '';
    // $flag_emp = isset($_POST['flag_emp']) ? trim($_POST['flag_emp']) : '';
    $password = set_password($inputpassword);
    $msg_password = array("title" => "Added Successfully","content_msg" =>$inputpassword);

    $table = 'users';
    $dbfield = array('employee_id', 'card_id', 'f_name', 'm_name', 'l_name', 'suffix', 'user_role', 'username', 'password', 'email_address', 'position');
    $insertfield = array();

    $insertfield[] = "'" . $employee_id . "'";
    $insertfield[] = "'" . $card_id . "'";
    $insertfield[] = "'" . $f_name . "'";
    $insertfield[] = "'" . $m_name . "'";
    $insertfield[] = "'" . $l_name . "'";
    $insertfield[] = "'" . $suffix . "'";
    $insertfield[] = "'" . $user_role . "'";
    $insertfield[] = "'" . $username . "'";
    $insertfield[] = "'" . $password . "'";
    $insertfield[] = "'" . $email . "'";
    $insertfield[] = "'" . $position . "'";
    // $insertfield[] = "'" . $flag_emp . "'";

    $field_query = implode(", ", $dbfield);
    $field_insert = implode(",", $insertfield);

    $insert_sql = "INSERT INTO " . $table . " (" . $field_query . ") VALUES (" . $field_insert . ")";
    if ($insert_query = call_mysql_query($insert_sql)) {
        $session_class->setValue('msg_password', $msg_password);
    } else {
        $session_class->setValue('msg_error', 'Adding Failed');
    }
    exit();
}

if (isset($_POST['actionUpdate']) && $_POST['actionUpdate'] == 'submitUpdate') {
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employeeID = isset($_POST['employeeID']) ? trim($_POST['employeeID']) : '';
    $cardID = isset($_POST['cardID']) ? trim($_POST['cardID']) : '';
    $fName = isset($_POST['fName']) ? trim($_POST['fName']) : '';
    $mName = isset($_POST['mName']) ? trim($_POST['mName']) : '';
    $lName = isset($_POST['lName']) ? trim($_POST['lName']) : '';
    $suff = isset($_POST['suff']) ? trim($_POST['suff']) : '';
    $userName = isset($_POST['userName']) ? trim($_POST['userName']) : '';
    $emailAddress = isset($_POST['emailAddress']) ? trim($_POST['emailAddress']) : '';
    $pos = isset($_POST['pos']) ? trim($_POST['pos']) : '';
    $userRole = isset($_POST['userRole']) ? trim($_POST['userRole']) : '';

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();

    $table = "users";
    $updatefield[] = "employee_id = '" . $employeeID . "'";
    $updatefield[] = "card_id = '" . $cardID . "'";
    $updatefield[] = "f_name = '" . $fName . "'";
    $updatefield[] = "m_name = '" . $mName . "'";
    $updatefield[] = "l_name = '" . $lName . "'";
    $updatefield[] = "suffix = '" . $suff . "'";
    $updatefield[] = "user_role = '" . $userRole . "'";
    $updatefield[] = "username = '" . $userName . "'";
    $updatefield[] = "email_address = '" . $emailAddress . "'";
    $updatefield[] = "position = '" . $pos . "'";
    $sql_where_array[] = "user_id = '" . $user_id . "'";

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
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $table = "users";
    $dbfield = array('user_id', 'employee_id');
    $field_query = implode(", ", $dbfield);
    $sql_where_array[] = "user_id = '" . $user_id . "'";
    $sql_where_array[] = "employee_id = '" . $employee_id . "'";
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

if (isset($_POST['actionDeactivate']) && $_POST['actionDeactivate'] == 'submitDeactivate') {
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $action_status = 1; // deactivate account

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();

    $table = "users";
    $updatefield[] = "status = '" . $action_status . "'";
    $sql_where_array[] = "user_id = '" . $user_id . "'";
    $sql_where_array[] = "employee_id = '" . $employee_id . "'";

    $field_query = implode(',', $updatefield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "UPDATE " . $table . " SET " . $field_query . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        $session_class->setValue('msg_success', 'Deactivated Successfully');
    } else {
        $session_class->setValue('msg_error', 'Deactivating Account Failed');
    }
    exit();
}

if (isset($_POST['actionActivate']) && $_POST['actionActivate'] == 'submitActivate') {
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $action_status = 0; // activate account

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();

    $table = "users";
    $updatefield[] = "status = '" . $action_status . "'";
    $sql_where_array[] = "user_id = '" . $user_id . "'";
    $sql_where_array[] = "employee_id = '" . $employee_id . "'";

    $field_query = implode(',', $updatefield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "UPDATE " . $table . " SET " . $field_query . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        $session_class->setValue('msg_success', 'Activated Successfully');
    } else {
        $session_class->setValue('msg_error', 'Activating Account Failed');
    }
    exit();
}

if (isset($_POST['actionUnlock']) && $_POST['actionUnlock'] == 'submitUnlock') {
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $action_locked = 0; // unlock account

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();

    $table = "users";
    $updatefield[] = "locked = '" . $action_locked . "'";
    $sql_where_array[] = "user_id = '" . $user_id . "'";
    $sql_where_array[] = "employee_id = '" . $employee_id . "'";

    $field_query = implode(',', $updatefield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "UPDATE " . $table . " SET " . $field_query . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        $session_class->setValue('msg_success', 'Unlocked Successfully');
    } else {
        $session_class->setValue('msg_error', 'Unlocking Account Failed');
    }
    exit();
}

if (isset($_POST['actionReset']) && $_POST['actionReset'] == 'submitReset') {
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $action_locked = 0; // unlock account
    $password_generate = password_generate();
    $password = set_password($password_generate);

    $sql_where = "";
    $sql_conds = "";
    $sql_where_array = array();
    $updatefield = array();
    $msg_password = array("title" => "Successfully Reset Password","content_msg" =>$password_generate);

    $table = "users";
    $updatefield[] = "locked = '" . $action_locked . "'";
    $updatefield[] = "password = '" . $password . "'";
    $sql_where_array[] = "user_id = '" . $user_id . "'";
    $sql_where_array[] = "employee_id = '" . $employee_id . "'";

    $field_query = implode(',', $updatefield);
    if (count($sql_where_array) > 0) {
        $sql_where = implode(" AND ", $sql_where_array);
    }
    $sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

    $default_query = "UPDATE " . $table . " SET " . $field_query . " " . $sql_conds . " ";
    if ($query = call_mysql_query($default_query)) {
        $session_class->setValue('msg_password', $msg_password);
    } else {
        $session_class->setValue('msg_error', 'Unlocking Account Failed');
    }
    exit();
}

// VALIDATIONS
if (isset($_POST['valid_input']) && $_POST['valid_input'] === 'employee_id') {
    $table = "users";
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

if (isset($_POST['valid_input']) && $_POST['valid_input'] === 'card_id') {
    $table = "users";
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

if (isset($_POST['valid_input']) && $_POST['valid_input'] === 'username') {
    $table = "users";
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

if (isset($_POST['valid_input']) && $_POST['valid_input'] === 'email_address') {
    $table = "users";
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
