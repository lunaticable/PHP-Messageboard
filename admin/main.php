<?php
header("content-type:text/html;charset=utf-8");
include '../Action/dbPdoManage.php';
error_reporting(E_ALL);
// 开启session
session_start();
//  判断是否为管理员
if($_SESSION != '' && !empty($_SESSION)){
	$res = $db->getOneData("select idenTity from user where nickName='".$_SESSION['name']."'");
	// print_r($res);
	if($res['identity'] == 1){
		die('您无权访问！');
	}
}
if(empty($_SESSION)){
	die('您无权访问！');
}
// 翻页代码开始
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// 定义显示的记录数
$pagesize = 10;
// 获取总记录数
$recount = $db->getOneData("select count(chatId) as 'c' from chat");
// 计算有多少页
$pagecount = ceil($recount['c'] / $pagesize);
// 判断搜索框页码范围
// echo $page; 
if($page <= 1) $page = 1;
if($page >$pagecount) $page = $pagesize;
if($pagecount == 0 || $pagecount==1) $page = 1;
if($pagecount == 0) $pagecount = 1;
// 计算索引号

$index = ($page-1)*$pagesize;
#获取留言数据

$rs = $db->getMoreData("select * from chat order by chatId desc limit ".$index.",".$pagesize."");
// print_r($rs);
// $user = $db->getMoreData("select * from admin order by adminId");
// print_r($user);
// 获取管理员姓名
// $adminname = isset($_GET['username']) ? $_GET['username'] : '';

// $_SESSION['adminname'] = $adminname;
// var_dump($_SESSION);
#审核状态
function showPostState($x){
	switch($x){
		case 0 : return '<span style="color:red;">未审核(不通过)</span>'; break;
		case 1 : return '<span style="color:green;">已审核（通过）</span>'; break;
		default: '<span style="color:red;">未审核（不通过）</span>';
	}
}
// echo $_SESSION['adminname']
?>
<!doctype html>
<html lang="ch">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<title>欢迎您，管理员</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script>
			$(function() {
				$(".meun-item").click(function() {
					$(".meun-item").removeClass("meun-item-active");
					$(this).addClass("meun-item-active");
					var itmeObj = $(".meun-item").find("img");
					itmeObj.each(function() {
						var items = $(this).attr("src");
						items = items.replace("_grey.png", ".png");
						items = items.replace(".png", "_grey.png")
						$(this).attr("src", items);
					});
					var attrObj = $(this).find("img").attr("src");;
					attrObj = attrObj.replace("_grey.png", ".png");
					$(this).find("img").attr("src", attrObj);
				});
				$("#topAD").click(function() {
					$("#topA").toggleClass(" glyphicon-triangle-right");
					$("#topA").toggleClass(" glyphicon-triangle-bottom");
				});
				$("#topBD").click(function() {
					$("#topB").toggleClass(" glyphicon-triangle-right");
					$("#topB").toggleClass(" glyphicon-triangle-bottom");
				});
				$("#topCD").click(function() {
					$("#topC").toggleClass(" glyphicon-triangle-right");
					$("#topC").toggleClass(" glyphicon-triangle-bottom");
				});
				$(".toggle-btn").click(function() {
					$("#leftMeun").toggleClass("show");
					$("#rightContent").toggleClass("pd0px");
				})
			})
		</script>
		<!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/slide.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/flat-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery.nouislider.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/main.css" />
	</head>

	<body>
		<div id="wrap">
			<!-- 左侧菜单栏目块 -->
			<div class="leftMeun" id="leftMeun">
				<div id="logoDiv">
					<p id="logoP"><img id="logo" alt="微留言" src="images/logo.png"><span>微留言</span></p>
				</div>
				<div id="personInfor">
					<p id="userName"><?php echo $_SESSION['name']; ?></p>
					<p>
						<a href="../exit.php">退出登录</a>
					</p>
				</div>
				<div class="meun-title">留言管理</div>
				<div class="meun-item meun-item-active" href="#sour" aria-controls="sour" role="tab" data-toggle="tab"><img src="images/icon_source.png">留言处理</div>
			</div>
			<!-- 右侧具体内容栏目 -->
			<div id="rightContent">
				<a class="toggle-btn" id="nimei">
					<i class="glyphicon glyphicon-align-justify"></i>
				</a>
				<!-- Tab panes -->
				<div class="tab-content">
					<!-- 资源管理模块 -->
					<div role="tabpanel" class="tab-pane active" id="sour">
						<div class="check-div form-inline topimgbox">
							
						</div>
						<div class="data-div">
							<div class="row tableHeader">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
									ID
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
									用户
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
									留言
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									回复的消息
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									时间
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									审核状态
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									操作
								</div>
							</div>
							<div class="tablebody">
								<?php for ( $i=0; $i<=count($rs)-1; $i++) { ?>
								<div class="row height-none">
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										<?php echo $rs[$i]['chatId']; ?>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										<?php echo $rs[$i]['nickName']; ?>
									</div>
									<div class="mes col-lg-3 col-md-3 col-sm-3 col-xs-3">
										<?php echo $rs[$i]['chatContent']; ?>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<?php echo $rs[$i]['chatReContent']; ?>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<?php echo $rs[$i]['chatDateTime']; ?>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										<?php echo showPostState($rs[$i]['chatIsPost']); ?>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#changeSource<?php echo $i?>">回复</button>
										<button class="btn btn-warning btn-xs" <?php if($rs[$i]['chatIsPost'] == 1){ echo 'disabled="disabled"';};?> data-toggle="modal" data-target="#audit"><a class="aclear" href="javascript:audi(<?php echo $rs[$i]['chatId']; ?>)">审核</a></button>
										<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteSource"><a class="aclear" href="javascript:delte(<?php echo $rs[$i]['chatId']; ?>)">删除</a></button>
									</div>
								</div>
								<!--回复消息弹出窗口-->
								<div class="modal fade" id="changeSource<?php echo $i?>" role="dialog" aria-labelledby="gridSystemModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="gridSystemModalLabel">回复内容</h4>
											</div>
											<form class="form-horizontal" id="form1" name="form1" action="replay.php?chatid=<?php echo $rs[$i]['chatId']; ?>" method="POST">
												<div class="modal-body">
													<div class="container-fluid">
														<div class="form-group ">
															<label for="sName" class="col-xs-3 control-label">内容：</label>
															<div class="col-xs-8 ">
																<textarea id="chatrecontent" name="chatrecontent" placeholder="输入您回复的内容"></textarea>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">取 消</button>
													<button type="submit" id="replay" class="btn btn-xs btn-green">回 复</button>
												</div>
											</form>
										</div>
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
							<!-- </div> -->
								<!--审核弹出框-->
								<div class="modal fade" id="audit" role="dialog" aria-labelledby="gridSystemModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
											</div>
											<div class="modal-body">
												<div class="container-fluid">
													请认真审核留言哦！
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-xs btn-danger" data-dismiss="modal">不通过</button>
												<button id="audit1" type="submit" class="btn btn-xs btn-green">通 过</button>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
						<!--页码块-->
						<footer class="footer">
							<div class="page-view">
								当前第<?php echo $page ?>页/共<?php echo $pagecount ?>页
							</div>
							<div class="page-count">
								<ul>
									<a href="main.php?page=1"><li>首页</li></a>
									<?php if( $page !=1 ) {?>
									<a href="main.php?page=<?php echo $page-1; ?>"><li>上一页</li></a>
									<?php } ?>
									<?php 
									$maxpage = $page + 5;
									if($maxpage > $pagecount){
										$maxpage = $pagecount;
									}
									?>
									<?php for($p=$page; $p<=$maxpage; $p++) {?>
									<a href="main.php?page=<?php echo $p;?>"><li><?php echo $p;?></li></a>
									<?php }?>
									<?php if( $page !=$pagecount ) {?>
									<a href="main.php?page=<?php echo $page+1; ?>"><li>下一页</li></a>
									<?php } ?>
									<a href="main.php?page=<?php echo $pagecount; ?>"><li>尾页</li></a>
								</ul>
							</div>
						</footer>

					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		var d = document.getElementById("del1");
		// console.log(d);
		function delte(id){
			// console.log(d);
			d.onclick = function(){
				location.href="del.php?chatid="+id;
				// alert("nihao");
			}
		}
		var r = document.getElementById("replay");
		function replay(id1){
			alert("nihao");
			
			r.onclick = function(){
				location.href="replay.php?chatid="+id1;
				// alert("nihao");
			}
		}
		var a = document.getElementById("audit1");
		function audi(id2){
			console.log(id2);
			
			a.onclick = function(){
				location.href="audit.php?chatid="+id2;
			}
		}
	</script>
</html>
<?php
$db->closeConn();
?>