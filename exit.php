<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
session_start();
if(isset($_SESSION['name']))
{
    unset($_SESSION['name']);
    $db->showMessage('已退出微留言','index.php');
}
?>