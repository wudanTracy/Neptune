<?php
//header("content_type:text/html; charset = utf_8");
/**
 * Created by PhpStorm.
 * User: yyli
 * Date: 2015/7/13
 * Time: 16:24
 */
$dbms = 'mysql';     //选择数据库
$host = 'localhost'; //IP地址
$dbName = 'neptune';    //数据库名称
$user = 'root';      //用户名
$pass = '';          //密码
$dsn = "$dbms:host=$host;dbname=$dbName";


try {
    $dbh = new PDO($dsn, $user, $pass); //PDO
    //echo "success!<br/>";
} catch (PDOException $e) {
    //echo "failed";
    die ("Error!: " . $e->getMessage() . "<br/>");
}
$dbh->query('set names utf8;');
?>