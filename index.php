<?php
header("content-type:text/html;charset=utf-8");
include 'Action/dbPdoManage.php';
error_reporting(E_ALL);
session_start();
// 翻页代码开始
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// 定义显示的记录数
$pagesize = 5;
// 获取总记录数
$recount = $db->getOneData("select count(chatId) as 'c' from chat where chatIsPost= 1");
// 计算有多少页
$pagecount = ceil($recount['c'] / $pagesize);
// 判断搜索框页码范围
if($page <= 1) $page = 1;
if($page >$pagecount) $page = $pagesize;
if($pagecount == 0 || $pagecount==1) $page = 1;
if($pagecount == 0) $pagecount = 1;
// 计算索引号
$index = ($page-1)*$pagesize;
#获取留言数据
$rs = $db->getMoreData("select * from chat  where chatIsPost= 1 order by chatId desc limit ".$index.",".$pagesize."");
// foreach($rs as $k=>$v){

//     echo "$k --- $v <br />";

// }
// echo $arrayresult;
// $num = count($rs);
// echo count($rs);
// echo $num;);
// print_r( $_SESSION);
// var_dump($_SESSION);
if($_SESSION != '' && !empty($_SESSION)){
$res = $db->getOneData("select idenTity from user where nickName='".$_SESSION['name']."'");
// print_r($res);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>你好，微留言</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/swiper.min.css">
    <style>
        .swiper-container {
      width: 100%;
      height: 100%;

    }
    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;

      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
    </style>
</head>
<body>
    <?php include "hearder.php"; ?>
    <div class="container">
        <div class="message">
            <div class="row">
                <div class="content">
                    <!-- Swiper -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img style="width:100%;height:60%;" src="./images/bgimg.jpg" alt="..."></div>
                            <div class="swiper-slide"><img style="width:100%;height:60%;" src="./images/img1.jpg" alt="..."></div>
                            <div class="swiper-slide"><img style="width:100%;height:60%;" src="./images/img2.jpg" alt="..."></div>
                            <div class="swiper-slide"><img style="width:100%;height:60%;" src="./images/img3.jpg" alt="..."></div>
                            <div class="swiper-slide"><img style="width:100%;height:60%;" src="./images/img4.png" alt="..."></div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <form id="ly" name="ly" method="post" <?php if(!empty($_SESSION)) echo 'action="save.php"'; ?>>
                        <div class="input-box" style="margin-top:20px;">
                            <textarea id="chatContent" name="chatContent" style="width:1058px;height:150px;resize:none;" placeholder="发表你的心情吧" ></textarea>
                            <!-- <a class="submit" href="">发送</a> -->
                            <input class="submit" type="submit" <?php if(empty($_SESSION)) {echo 'value="请先登录"';}else{echo 'value="发送"';} ?>>
                        </div>
                    </form>
                    <div class="comments-box">
                    <?php 
                    if( empty($rs)){ 
                        echo "暂无评论，快来发表你的心情吧！^_^";
                    }
                    else{
                    ?>
                    <?php for ( $i=0; $i<=count($rs)-1; $i++) { ?>
                    <div class="comments">
                        <div><h5>ID号：<?php echo $rs[$i]['chatId']; ?></h5></div>
                        <?php $sql = "select nickName from chat where chatId='".$rs[$i]['chatId']."' "?>
                        <?php $result = $db->getOneData($sql)?>
                        <?php if(!empty($_SESSION) && $_SESSION['name'] == $result['nickname']){?>
                        <button id="del-btn" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteSource"><a class="aclear" href="javascript:delt(<?php echo $rs[$i]['chatId']; ?>)">删除</a></button>
                        <button id="modify-btn" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modifySource">修改</button>
                        <?php } ?>
                        <div class="user-reviews"><?php echo $rs[$i]['chatContent']; ?></div>
                        <div class="admin-reviews"><span>管理员回复</span>：<?php echo $rs[$i]['chatReContent']; ?></div>
                    </div>
                    <!--弹出修改提示窗口-->
                    <div class="modal fade" id="modifySource" role="dialog" aria-labelledby="gridSystemModalLabel">
                        <div class="modal-dialog" role="document">
                            <form id="modifyform" name="modifyform" action="modify.php?chatid=<?php echo $rs[$i]['chatId']?>" method="POST" onsubmit = "return modifycheck()">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="gridSystemModalLabel">修改</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            这是你之前的留言：<br/>
                                            <textarea id="chatContent" name="chatContent" style="width:535px;height:150px;resize:none;" placeholder="" disabled="disabled"><?php $sql1 = "select chatContent from chat where chatId='".$rs[$i]['chatId']."' "?><?php $result1 = $db->getOneData($sql1)?><?php print_r($result1['chatcontent']); ?></textarea>
                                            写下您的新留言：<br/>
                                            <textarea id="rechatContent" name="rechatContent" style="width:535px;height:150px;resize:none;" placeholder="" ></textarea>
                                            <p id="contenttip" style="color:red;font-size:14px;"></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
                                        <button id="modify-btn" type="submit" class="btn btn-xs btn-warning">修 改</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }}?>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-view">
            当前第<?php echo $page ?>页/共<?php echo $pagecount ?>页
        </div>
        <div class="page-count">
            <ul>
                <a href="index.php?page=1"><li>首页</li></a>
                <?php if( $page !=1 ) {?>
                <a href="index.php?page=<?php echo $page-1; ?>"><li>上一页</li></a>
                <?php } ?>
                <?php 
                $maxpage = $page + 5;
                if($maxpage > $pagecount){
                    $maxpage = $pagecount;
                }
                ?>
                <?php for($i=$page; $i<=$maxpage; $i++) {?>
                <a href="index.php?page=<?php echo $i;?>"><li><?php echo $i;?></li></a>
                <?php }?>
                <?php if( $page !=$pagecount ) {?>
                <a href="index.php?page=<?php echo $page+1; ?>"><li>下一页</li></a>
                <?php } ?>
                <a href="index.php?page=<?php echo $pagecount; ?>"><li>尾页</li></a>
            </ul>
        </div>
        <!-- 登录弹框 -->
        <div class="modal fade" id="loginSource" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <form id="login-box" name="login-box" action="userlogin.php" method="POST"  onsubmit = "return logincheck()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">登录</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                欢迎登录微留言^_^！
                                <div class="input-group input-group-md marginvalue">
                                    <span class="input-group-addon" id="sizing-addon1">账号</span>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
                                </div>
                                <div class="input-group input-group-md marginvalue">
                                    <span class="input-group-addon" id="sizing-addon1">密码</span>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md btn-white" data-dismiss="modal">取 消</button>
                            <button id="login-btn" type="submit" class="btn btn-md btn-success">登 录</button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-danger btn-md" id="regs" data-toggle="modal" data-target="#registeredSource">注 册</button>
            </div>
        </div>
        <!-- 注册弹框 -->
        <div class="modal fade" id="registeredSource" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <form id="registered-box" name="registered-box" action="registered.php" method="POST"  onsubmit = "return check()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">注册</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                欢迎注册微留言账户^_^！
                                <div class="container-fluid">
                                    <div class="input-group input-group-md marginvalue">
                                        <span class="input-group-addon" id="sizing-addon1">手机号</span>
                                        <input id="resusernm" name="resusernm" type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="input-group input-group-md marginvalue">
                                        <span class="input-group-addon" id="sizing-addon1">昵&nbsp&nbsp&nbsp称</span>
                                        <input id="nickname" name="nickname" type="text" class="form-control" placeholder="Nickname" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="input-group input-group-md marginvalue">
                                        <span class="input-group-addon" id="sizing-addon1">密&nbsp&nbsp&nbsp码</span>
                                        <input id="respwd" name="respwd" type="password" class="form-control" minlength="6" maxlength="25" placeholder="Password" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="input-group input-group-md marginvalue">
                                        <span class="input-group-addon" id="sizing-addon1">密&nbsp&nbsp&nbsp码</span>
                                        <input id="respwds" name="respwds" type="password" class="form-control" minlength="6" maxlength="25" placeholder="再次输入密码" aria-describedby="sizing-addon1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md btn-white" data-dismiss="modal">取 消</button>
                            <button id="login-btn" type="submit" class="btn btn-md btn-danger">注 册</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--弹出删除资源警告窗口-->
        <div class="modal fade" id="deleteSource" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            1.确定要删除该留言？删除后不可恢复；<br/>
                            2.若删除失败，请刷新页面重试！
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
                        <button id="del1" type="submit" class="btn btn-xs btn-danger">删 除</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>
<script src="./js/swiper.min.js"></script>
<script>
        var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
    function check(){
        var number = document.getElementById("resusernm").value;
        
        if(number == ""){
            alert("手机号不能为空");
            return false;
            }
        if(/^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{8}$/.test(number) == false){	//使用正则表达式
            alert("手机号的格式不对");
            return false;
            }
        var nickname = document.getElementById("nickname").value;
        if(nickname == ""){
            alert("昵称不能为空");
            return false;
            }
        if(nickname.length<4 || nickname.length > 25){
            alert("昵称长度不超过25，不少于4");
            return false;
            }
        var pwd = document.getElementById("respwd").value;
        if(pwd == ""){
            alert("密码不能为空");
            return false;
            }
        if(pwd.length < 6){
            alert("密码的长度太短，应大于6");
            return false;
            }
        if(pwd.length > 12){
            alert("密码的长度太长，应该小于12");
            return false;
            }
        var pwd2  = document.getElementById("respwds").value;
        if(pwd != pwd2){
            alert("两次输入的密码不一样，请重新输入");
            return false;
            }
        location.href="registered.php";
        return true;
    }
    function logincheck(){
        var username = document.getElementById("username").value;
        if(username == ""){
            alert("账号不能为空");
            return false;
            }
        var password = document.getElementById("password").value;
        if(password == ""){
            alert("密码不能为空");
            return false;
            }
    }
    function exit(){
        location.href="exit.php?";
    }
    var d = document.getElementById("del1");
		console.log(d);
		function delt(id){
			// console.log(d);
			d.onclick = function(){
				location.href="userdel.php?chatid="+id;
				// alert("nihao");
			}
		}
    function modifycheck(){
        var rechatcontent = document.getElementById("rechatContent").value;
        var contenttip = document.getElementById("contenttip");
        if(rechatcontent == ''){
            contenttip.innerText="留言不能为空!";
            return false;
        }
    }
</script>
</html>
<?php
$db->closeConn();
?>