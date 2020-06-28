<?php
header("content-type:text/html;charset=utf-8");
include '../Action/dbPdoManage.php';
error_reporting(E_ALL);
session_start();
if(!empty($_SESSION)){
    $res = $db->getOneData("select idenTity from user where nickName='".$_SESSION['name']."'");
    // print_r($res);
    // echo $res['identity'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/swiper.min.css">
</head>
<body>
    <?php include "../hearder.php"; ?>
    <?php if(empty($_SESSION)){ ?>
    <div class="container">
        <div class="login-box">
            <div class="login">
                <form id="login" name="login" action="checklogin.php" method="post">
                    <div class="logo">
                        <h2>欢迎登录留言管理系统</h2>
                    </div>
                    <div class="login-from">
                        <div class="user">
                            <input class="text_value" id="username" name="username" type="text" value="" placeholder="请输入账号">
                            <input class="text_value" id="password" name="password" type="password" value="" placeholder="请输入密码">
                        </div>
                    </div>
                    <div class="go-login">
                        <a target="_blank"><input type="submit" value="登录"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php }?>
    <?php if($_SESSION && $res['identity'] == 1){?>
        <div class="container">
        <div class="login-box">
            <div class="login">
                <div class="logo">
                    <h2>您不是管理员，请前往微留言<a href="../index.php">首页</a></h2>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <?php if($_SESSION && $res['identity'] == 0){?>
        <div class="container">
        <div class="login-box">
            <div class="login">
                <div class="logo">
                    <h2>您已登录微留言后台管理系统，请前往<a href="./main.php">后台管理页面</a></h2>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</body>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/swiper.min.js"></script>
<script>
        function exit(){
        location.href="../exit.php?";
    }
</script>
</html>