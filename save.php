<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
#开启session
session_start();
#接收表单数据
$chatcontent = isset($_POST['chatContent']) ? $_POST['chatContent'] : '';
$chatdatatime = date('Y-m-d h:i:s');
// $chatdatatime = NULL;
$chatispost = 0;
$chatrecontent = '暂无回复';
#判断数据的合法性
if(!empty($_SESSION) && $_SESSION != ''){
    if($chatcontent != ''){
        $sql = "select userName from user where nickName='".$_SESSION['name']."'";
        $result =  $db->getOneData($sql);
        $sql = "insert into chat(userName,nickName,chatContent,chatReContent,chatIsPost,chatDateTime) values('".$result['username']."','".$_SESSION['name']."','".$chatcontent."','".$chatrecontent."','".$chatispost."','".$chatdatatime."')";
        $result = $db->execSql($sql);
        if($result == true){
            $db->showMessage('感谢您的留言，我们将尽快审核，审核通过后，您能在留言板看到您的留言','index.php');
        }
        else{
            $db->showMessage('抱歉！留言失败','index.php');
        }
    }
    else{
        $db->showMessage('您还没有留言！','index.php');
    }
}
$db->closeConn();
?>
