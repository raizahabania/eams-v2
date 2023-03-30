<?php
include 'connect.php';

if (isset($_POST['submitTimeIn'])) {
    $id = $_POST['id'];
    date_default_timezone_set('Asia/Manila');
    $time = date('Y-m-d H:i:s');
    $way = 'onsite';
    $sqlSelect = "SELECT * FROM sample WHERE sample_id='$id' AND timeIn IS NOT NULL";
    $querySelect = mysqli_query($con, $sqlSelect);
    if (mysqli_num_rows($querySelect) > 0) {
        header('location:sample.php?AlreadyTimeIn');
        exit();
    } else {
        $sql = "INSERT INTO sample (sample_id,timeIn,way) VALUE ('$id','$time','$way')";
        $query = mysqli_query($con, $sql);
        if ($query) {
            header('location:sample.php?submit');
            exit();
        } else {
            header('location:sample.php?not-submit');
            exit();
        }
    }
}

if (isset($_POST['submitBreakOut'])) {
    $id = $_POST['id'];
    $time = date('Y-m-d H:i:s');
    $way = 'onsite';
    date_default_timezone_set('Asia/Manila');
    $sqlSelect = "SELECT sample_id FROM sample WHERE sample_id='$id' AND timeIn IS NOT NULL";
    $querySelect = mysqli_query($con, $sqlSelect);
    if (mysqli_num_rows($querySelect) > 0) {
        $sql = "UPDATE sample SET breakOut='$time' WHERE sample_id='$id' AND way='$way'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            header('location:sample.php?submit');
            exit();
        } else {
            header('location:sample.php?not-submit');
            exit();
        }
    } else {
        header("location:sample.php?YouDon'tHaveTimeInTime");
        exit();
    }
}

if (isset($_POST['submitBreakIn'])) {
    $id = $_POST['id'];
    $time = date('Y-m-d H:i:s');
    $way = 'onsite';
    date_default_timezone_set('Asia/Manila');
    $sqlSelect = "SELECT sample_id FROM sample WHERE sample_id='$id' AND timeIn IS NOT NULL AND breakOut IS NOT NULL";
    $querySelect = mysqli_query($con, $sqlSelect);
    if (mysqli_num_rows($querySelect) > 0) {
        $sql = "UPDATE sample SET breakIn='$time' WHERE sample_id='$id' AND way='$way'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            header('location:sample.php?submit');
            exit();
        } else {
            header('location:sample.php?not-submit');
            exit();
        }
    } else {
        header('location:sample.php?PleaseBreakOutFirst');
        exit();
    }
}

if (isset($_POST['submitTimeOut'])) {
    $id = $_POST['id'];
    $time = date('Y-m-d H:i:s');
    $way = 'onsite';
    date_default_timezone_set('Asia/Manila');
    $sqlSelect = "SELECT sample_id FROM sample WHERE sample_id='$id' AND timeIn IS NOT NULL";
    $querySelect = mysqli_query($con, $sqlSelect);
    if (mysqli_num_rows($querySelect) > 0) {
        $sql = "UPDATE sample SET timeOut='$time' WHERE sample_id='$id' AND way='$way'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            header('location:sample.php?submit');
            exit();
        } else {
            header('location:sample.php?not-submit');
            exit();
        }
    } else {
        header('location:sample.php?PleaseTimeInFirst');
        exit();
    }
}
