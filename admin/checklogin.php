<?php
header("content-type:text/html;charset=utf-8");
include '../Action/dbPdoManage.php';
error_reporting(E_ALL);
#开启session
session_start();
#接受表单数据
$user = isset($_POST['username']) ? $_POST['username'] : '';
$pwd = isset($_POST['password']) ? $_POST['password'] : '';

#判断数据合法性
if( $user != '' && $pwd != ''){
    $sql = "select count(userId) as 'c' from user where userName='".$user."' and passWord='".$pwd."' and identity=0";
    // $sql = "select count(adminId) as 'c' from admin where adminUser='".$user."' and adminPwd='".md5($pwd)."'";
    $result = $db->getOneData($sql);
    if($result['c'] == '1'){
        $sql1 = "select nickName from user where userName='".$user."'";
        // print_r($sql1);
        $result1 = $db->getOneData($sql1);
        // var_dump($result1);
        // print_r($result1);
        // echo $result1 ;
        $name = array_values($result1)[0];
        $_SESSION['name'] = $name;
        // echo $namevalue[0];
        // if($result1 == true){
            $db->showMessage('登陆成功','main.php');
        // }
    }
    else{
        $db->showMessage('登陆失败,可能的原因：1.账号或密码错误！2.您不是管理员！','login.php');
    }
}
else{
    $db->showMessage('请填写账户或密码！','login.php');
}
?>