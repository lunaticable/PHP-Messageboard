<?php
#获取记录数
$count = $db->getOneData("select count(chatId) as 'c' from chat where chatIsPost=0");
// print_r($count);
// var_dump( $_SESSION['nickname']);
// print_r( $_SESSION['name']);
?>
<div class="nav">
    <div class="container">
        <div class="nav-center row">
            <a class="nav-btn" href="http://localhost/message/index.php">留言板</a>
            <?php if($_SESSION != '' && !empty($_SESSION)){?>
                <?php if($res['identity'] == 0){?>
                <a class="nav-btn" href="http://localhost/message/admin/login.php" target="_blank">管理留言</a>
                <div class="tip">
                    <div class="text"><?php echo $count['c'] ?></div>
                </div>
                <?php }?>
            <?php }?>
            
            <div class="btn-right">
                <?php if($_SESSION == "" || empty($_SESSION)){?>
                <button class="btn btn-success btn-md wt-top" data-toggle="modal" data-target="#loginSource">登 录</button>
                <?php } ?>
                <?php if($_SESSION && !empty($_SESSION)){?>
                <span style="color:#fff;font-size:18px;line-height:44px;">嗨，<?php echo $_SESSION['name'];?></span>
                <button class="btn btn-danger btn-md wt-left" data-toggle="modal" data-target="#exitSource">退出登录</button>
                <?php }?>
            </div>
        </div>
                <!-- 退出提示框 -->
                <div class="modal fade" id="exitSource" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">提示</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            确定退出微留言吗？，再想一下哦。
                            <div class="container-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-white" data-dismiss="modal">取 消</button>
                        <button id="exit-btn" type="button" class="btn btn-md btn-danger" onclick="exit();">退 出</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>