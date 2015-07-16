<?php
/**
 * Created by PhpStorm.
 * User: wudan
 * Date: 2015/7/14
 * Time: 9:56
 */
session_start();
include_once "func-check-login.php";
if ($login) {
    include "conn.php";
    $id = $_POST['dish_id'];//
    $del = "update menu set flag = 1 where id = '$id' ";//ok
    $dbh->query($del);

    if ($dbh === false) {
        $status["status"] = false;
    } else {
        $status["status"] = true;
    }
    $dbh = null;
}
