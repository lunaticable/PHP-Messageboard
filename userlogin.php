<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
#开启session
session_start();
#接受表单数据
$user = isset($_POST['username']) ? $_POST['username'] : '';
$pwd = isset($_POST['password']) ? $_POST['password'] : '';
// echo $user;
// echo $pwd;


#判断数据合法性
if( $user != '' && $pwd != ''){
    $sql = "select count(userId) as 'c' from user where userName='".$user."' and passWord='".$pwd."'";
    $result = $db->getOneData($sql);
    // print_r($result);
    // echo $result['c'];
    if($result['c'] == '1'){
        $sql1 = "select nickName from user where userName='".$user."'";
        // print_r($sql1);
        $result1 = $db->getOneData($sql1);
        // var_dump($result1);
        // print_r($result1);
        // echo $result1 ;
        $name = array_values($result1)[0];
        $_SESSION['name'] = $name;
        // var_dump($_SESSION);
        // echo $namevalue[0];
        // if($result1 == true){
            $db->showMessage('登陆成功','index.php');
        // }
    }
    else{
        $db->showMessage('登陆失败,请检查账号和密码是否正确！，或其他原因导致登录失败','index.php');
    }
}
else{
    $db->showMessage('请填写账户或密码！','index.php');
}
?>