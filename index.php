<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>成绩管理系统</title>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/answer.css" rel="stylesheet">
</head>
<?php
    session_start();
	require "header.php";
	$htmlFormat ='<iframe  height="600px" width="750px" name="left" frameborder="0" src="table.php"></iframe>
';
?>
</div>
<div class="main-content">
    <div class="left-content">
        <div class="title">
            <strong>主页</strong>
        </div>
        <div class="main-body" style="">
              <?php echo $htmlFormat;?>

       </div>
        <div class="select">
            <form action="search.php" method="post">
            <h2>查询单个学生信息：<input type="text" name="uname" value="" placeholder="请输入学号"></h2>
            <input  type="submit" value="搜索">
            </form>
        </div>
    </div>
    <div class="right-nav">
        <div class="menu">
            <?php
            require_once'rightnav.php';
            ?>
        </div>
    </div>
</div>
<div class="footer"></div>
</body>
</html>