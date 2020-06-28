<?php
header("content-type:text/html;charset=utf-8");
include './Action/dbPdoManage.php';
error_reporting(E_ALL);
#接受删除的id号
$chatid = isset($_GET['chatid']) ? $_GET['chatid'] : '';
if($chatid != ''){
    $sql = "delete from chat where chatId=".$chatid;
    $r = $db->execSql($sql);
    if($r){
        $sql = "ALTER table chat AUTO_INCREMENT=1";
        $rse = $db->execSql1($sql);
        if($rse){
        $db->showMessage('删除成功','index.php');
        }
    }
    else{
        $db->showMessage('删除失败','index.php');
    }
}
else{
    $db->showMessage('删除失败，参数错误，请联系管理员','index.php');
}
$db->closeConn();
?>