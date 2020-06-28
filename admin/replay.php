<?php
header("content-type:text/html;charset=utf-8");
include '../Action/dbPdoManage.php';
error_reporting(E_ALL);
#接收数据
$id = isset($_GET['chatid']) ? $_GET['chatid'] : '';
// var_dump($id);
$recontent = isset($_POST['chatrecontent']) ? $_POST['chatrecontent'] : '';
if($id != '' && $recontent != ''){
    $sql = "update chat set chatRecontent='".$recontent."' where chatId=".$id;
    $res = $db->execSql($sql);
    if($res == true){
        $db->showMessage('回复成功','main.php');
    }
    else{
        $db->showMessage('回复失败','main.php');
    }
}
else{
    $db->showMessage('内容不能为空','main.php');
}
$db->closeConn();
?>