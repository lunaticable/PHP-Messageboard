<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
#开启session
session_start();
#接受表单数据
$user = isset($_POST['resusernm']) ? $_POST['resusernm'] : '';
$pwd = isset($_POST['respwd']) ? $_POST['respwd'] : '';
$nick = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$identity = 1;
// echo $user;
// echo $pwd;
// exit();
//查询是否有相同手机号
$sql1 = "select * from user where userName=".$user;
// echo $sql1;
//查询是否有相同用户名
$sql2 = "select * from user where nickName='".$nick."'";
$result1 = $db->getMoreData($sql1);
$result2 = $db->getMoreData($sql2);
// print_r($result1);
// print_r($result2);
// exit();
#判断数据合法性
if( $user != '' && $pwd != ''){
    if(empty($result1)){
        if(empty($result2)){
            $sql = "insert into user(userName,passWord,nickName,idenTity) values('".$user."','".$pwd."','".$nick."','".$identity."')";
            $result = $db->execSql($sql);
            if($result == true){
                    $db->showMessage('注册成功,请前往首页登录哦','index.php');
                // }
            }
            else{
                $db->showMessage('注册失败','index.php');
            }
        }else{
            $db->showMessage('用户名已存在，请更改用户名','index.php');
        }

    }else{
        $db->showMessage('手机号已注册，请更改手机号','index.php');
    } 
}
else{
    $db->showMessage('手机号或密码不能为空','index.php');
}
?>