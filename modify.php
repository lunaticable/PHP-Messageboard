<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
$id = isset($_GET['chatid']) ? $_GET['chatid']: '' ;
$rechatcontent = isset($_POST['rechatContent']) ? $_POST['rechatContent']: '' ;
// echo $id,$rechatcontent;
$chatispost = 0;
#判断数据的合法性
// if(!empty($_SESSION) && $_SESSION != ''){
    if($id != '' && $rechatcontent != ''){
        $sql = "update chat set chatContent='".$rechatcontent."',chatIsPost= '".$chatispost."' where chatId=".$id;
        $r = $db->execSql($sql);
        if($r == true){
            $db->showMessage('修改成功','index.php');
        }
        else{
            $db->showMessage('抱歉！修改失败','index.php');
        }
    }
    else{
        $db->showMessage('数据不完整，或其他错误导致失败','index.php');
    }
// }
$db->closeConn();
?>