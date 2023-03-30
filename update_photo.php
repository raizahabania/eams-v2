<?php

require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; // check kung nakalogin

$response = array(
    'success' => false,
    'message' => 'Unknown error',
    'photos' => '',
);



$employee_id = $session_class->getValue('employee_id');

 $img = mysqli_query($db_connect, "SELECT img FROM users WHERE employee_id = '$employee_id'");
 $row_img = mysqli_fetch_assoc($img);

if (isset($_POST['action']) && $_POST['action'] == 'photo_remove') {

    $remove =  mysqli_query($db_connect, "UPDATE  users  SET img = 'profile-img.png' WHERE employee_id = '$employee_id'");
    if($row_img['img'] != 'profile-img.png'){
        unlink(DOMAIN_PATH.'/assets/img/'.$row_img['img']);
    }

    $response['success'] = true;
    $response['message'] = 'Removed Successfully';
    echo json_encode($response);
    $default_img = trim('profile-img.png');
    $session_class->setValue('photo', $default_img);

    exit();
}


if (!empty($_FILES['photo']['name'])) {

    $tmp_name = $_FILES['photo']['tmp_name'];
    $img_name = $_FILES['photo']['name'];
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);
    $new_img_name =  $employee_id ."-".uniqid()."." . $img_ex_lc;
    $img_upload_path = 'assets/img/' . $new_img_name;

    $allowed = array('gif', 'png', 'jpg','jpeg');

    if (!in_array($img_ex_lc, $allowed)) {
        $response['success'] = false;
        $response['message'] = 'Please select a valid image file (JPG and PNG are allowed).';
        echo json_encode($response);
        exit();
    }

    $sql =  mysqli_query($db_connect, "UPDATE  users  SET img='$new_img_name' WHERE employee_id = '$employee_id'");
    move_uploaded_file($tmp_name, $img_upload_path);
    
    if($row_img['img'] != 'profile-img.png'){
        unlink(DOMAIN_PATH.'/assets/img/'.$row_img['img']);
    }

    $response['success'] = true;
    $response['message'] = 'UPDATED SUCCESSFULLY';
    $response['photos'] = $new_img_name;
    echo json_encode($response);

    // $session_class->dropValue('photo');
    $session_class->setValue('photo', $new_img_name);

    exit();
}