<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; // check kung nakalogin

$response = array(
    'success' => false,
    'message' => 'Unknown error',
    'username' => '',
    'email' => '',
);
$user_id = $session_class->getValue('user_id');

if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
        $response['success'] = false;
        $response['message'] = 'Incomplete Fields';
        echo json_encode($response);
        exit();
    }

    $current_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    $current_password = set_password($current_password);
    $new_password = set_password($new_password);
    $confirm_password = set_password($confirm_password);

    $sqls = mysqli_query($db_connect, "SELECT password FROM `users` WHERE `user_id` = '$user_id' AND `password` = '$current_password' ");
    $row = mysqli_num_rows($sqls);

    if ($row == 0) {
        $response['success'] = false;
        $response['message'] = 'Wrong Current Password';
        echo json_encode($response);
        exit();
    }
    if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&*_?]{8,12}$/', $new_password)) {

        $response['success'] = false;
        $response['message'] = 'The password does not meet the requirements!';
        echo json_encode($response);
        exit();
    } else if ($new_password != $confirm_password) {
        $response['success'] = false;
        $response['message'] = 'Password Not Match';
        echo json_encode($response);
        exit();
    } else if ($new_password == $current_password) {
        $response['success'] = false;
        $response['message'] = "Please choose a password that you haven't used before";
        echo json_encode($response);
        exit();
    } else {
        $sql = mysqli_query($db_connect, "UPDATE `users` SET  `password` = '$new_password' WHERE `user_id` = '$user_id' AND `password` = '$current_password' ");
        $response['message'] = 'Password Updated Successfully';
        $response['success'] = true;
        echo json_encode($response);
        exit();
    }
}

if (!isset($_POST['emailaddress']) && !isset($_POST['username']) && !isset($_POST['emp_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['emailaddress']) && !isset($_POST['username']) && !isset($_POST['emp_id'])) {
    $response['success'] = false;
    $response['message'] = 'Please fill up all fields';
    echo json_encode($response);
    exit();
}


$emp_id = isset($_POST['emp_id']) ? trim($_POST['emp_id']) : "";
$emp_id = escape($db_connect, $emp_id);
$email = isset($_POST['emailaddress']) ? trim($_POST['emailaddress']) : "";
$user = isset($_POST['username']) ? trim($_POST['username']) : "";

// $duplicate_user = mysqli_query($db_connect, "SELECT username FROM users WHERE employee_id = '$emp_id'");
// $drow = mysqli_fetch_assoc($duplicate_user);
// $duser = mysqli_num_rows($duplicate_user);

// $duplicate_email = mysqli_query($db_connect, "SELECT email_address FROM users WHERE employee_id = '$emp_id'");
// $demail = mysqli_num_rows($duplicate_email);

if($emp_id == ""){
    $response['success'] = false;
    $response['message'] = 'undefiend employee id';
    echo json_encode($response);
    exit();
}

if($user == ""){
    $response['success'] = false;
    $response['message'] = 'Username field cannot be empty';
    echo json_encode($response);
    exit();
}

if($email == ""){
    $response['success'] = false;
    $response['message'] = 'Email Address field cannot be empty';
    echo json_encode($response);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['success'] = false;
    $response['message'] = 'Invalid email address';
    echo json_encode($response);
    exit();
}

$sqls = mysqli_query($db_connect, "SELECT username,email_address FROM `users` WHERE `employee_id` = '$emp_id' AND `username` = '$user' AND `email_address` = '$email' ");
$row = mysqli_num_rows($sqls);

if ($row > 0) {
    $response['success'] = false;
    $response['message'] = 'No changes made';
    echo json_encode($response);
    exit();
}

// if($duser > 0 || $drow['username'] != $user){
//     $response['success'] = false;
//     $response['message'] = 'username is already taken';
//     echo json_encode($response);
//     exit();
// }

// if($demail > 0){
//     $response['success'] = false;
//     $response['message'] = 'email is already taken';
//     echo json_encode($response);
//     exit();
// }


$sql = mysqli_query($db_connect, "UPDATE `users` SET  `email_address` = '$email', `username` = '$user' WHERE `employee_id` = '$emp_id' ");

$response['success'] = true;
$response['message'] = 'UPDATED SUCCESSFULLY';
$response['username'] = $user;
$response['email'] = $email;
echo json_encode($response);
exit();
