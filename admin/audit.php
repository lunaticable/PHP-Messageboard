<?php
header("content-type:text/html;charset=utf-8");
include '../Action/dbPdoManage.php';
error_reporting(E_ALL);
#接受删除的id号
$aid = isset($_GET['chatid']) ? $_GET['chatid'] : '';
// echo $aid;
$chatispost = 1;
// echo $chatispost;
if($aid != '' && $chatispost != ''){
    $sql = "update chat set chatIsPost='".$chatispost."' where chatId=".$aid;
    $r = $db->execSql($sql);
    if($r == true){
        $db->showMessage('审核通过','main.php');
    }
    else{
        $db->showMessage('审核失败','main.php');
    }
}
else{
    $db->showMessage('参数错误，请联系管理员','main.php');
}
$db->closeConn();
?>