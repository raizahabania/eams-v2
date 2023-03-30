<?php
 require '../config/config.php';
 require GLOBAL_FUNC;
 require CL_SESSION_PATH;
 require CONNECT_PATH;
 require ISLOGIN;// check kung nakalogin

 header('Content-Type: application/json; charset=utf-8');

 $response = array(
    'result' => 'error',
    'data' => [],
);

//USER PERMISSION

$get_text = isset($_GET['data']) ? trim($_GET['data']) : '';
$get_id = isset($_GET['id']) ? trim($_GET['id']) : '';


if(!empty($get_text)){
    $sqldate = "SELECT user_id, employee_id, f_name, m_name, l_name, suffix, position FROM ".EMPLOYEE_TABLE." WHERE (l_name LIKE '".escape($db_connect,$get_text)."%' OR f_name LIKE '".escape($db_connect,$get_text)."%')";
}else{
    $sqldate = "SELECT user_id, employee_id, f_name, m_name, l_name, suffix, position FROM ".EMPLOYEE_TABLE." WHERE AND employee_id= '".escape($db_connect,$get_id)."' LIMIT 10";
}
$resultdate = mysqli_query($db_connect,$sqldate);
if($resultdate)
{
    if(mysqli_num_rows($resultdate) > 0)
    {   
        $response['result'] = 'ok';
        while($rowdata = mysqli_fetch_assoc($resultdate)){
            $letter = empty($rowdata['m_name']) ? '' : substr($rowdata['m_name'],0,1);
            $letter = ( $letter != "") ? $letter.". " : " ";
            $rowdata['name'] = $rowdata['f_name'].' '.$letter.$rowdata['l_name'].' '.$rowdata['suffix'];
            $response['data'][] = array_html($rowdata);
        }
    }
    mysqli_free_result($resultdate);
}else{
    $response['result'] = 'error';
    $response['data'] = [];
}

echo json_encode($response);
exit();



?>