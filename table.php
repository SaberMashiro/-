<?php
    session_start();
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/CSS">
        <!--
        .page a:link {
            color: #0000FF;
            text-decoration: none;
        }
        .page a:visited {
            text-decoration: none;
            color: #0000FF;
        }
        .page a:hover {
            text-decoration: none;
            color: #0000FF;
        }
        .page a:active {
            text-decoration: none;
            color: #0000FF;
        }
        .page{color:#0000FF;}
        -->
        tr:hover {
            text-decoration: none;
            color: #0000FF;
            font-weight: 300;
        }
        tr{
            line-height: 40px;
        }
    </style>
</head>
<body>
<table width="530" height="103" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">

    <?php
    require_once 'config.php';
    $type = @$_GET['type'];

    $Page_size=4;//设置页面显示的记录数
    $stmt = $pdo->query("select * from score group by studentno");
    $count = $stmt->columnCount();
    $page_count = ceil($count/$Page_size);

    $init=1;
    $page_len=7;
    $max_p=$page_count;
    $pages=$page_count;

    //判断当前页码
    if(empty($_GET['page'])||$_GET['page']<0){
        $page=1;
    }else {
        $page=$_GET['page'];
    }

    $offset=$Page_size*($page-1);// $offset:页面开始位置  $Page_size:结束位置
    if(@$_SESSION['name']!=='admin') {
        if($type==1) {
            $sql = "select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno where teacherno=? order by score.pregrade desc limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(@$_SESSION['name']));
        }else if($type==2){
            $sql = " select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno where teacherno=? order by score.lastgrade desc limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(@$_SESSION['name']));
        }else if($type==3){
            $sql = " select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno where teacherno=? order by score.totalgrade desc limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(@$_SESSION['name']));
        }else{
            $sql = "select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno where teacherno=? order by score.totalgrade desc limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(@$_SESSION['name']));
        }
    }else{
        $sql = " select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    $content = $stmt->fetchAll();
    //var_dump($content);
    echo"<table  style='border: 1px solid ;margin: 10px auto;width:100%;text-align: center'  >" ;
    echo"<tr>
 <th style=' background-color: #4A8091;'>课程名</th>
  <th style=' background-color: #4A8091;'>学号</th>
  <th style=' background-color: #4A8091;'>姓名</th>
  <th style=' background-color: #4A8091;'>平时分数</th>
  <th style=' background-color: #4A8091;'>期末分数</th>
  <th style=' background-color: #4A8091;'>总分</th>
  <th style=' background-color: #4A8091;' colspan='2' >操作</th>
</tr>";
        foreach($content as $num => $row){
            echo "<tr>";
            echo "<td style='background-color: #c7ddef;'>{$row['coursename']}</td>";
            echo "<td style='background-color: #c7ddef;'>{$row['studentno']}</td>";
            echo "<td style='background-color: #c7ddef;'>{$row['studentname']}</td>";
            echo "<td style='background-color: #c7ddef;'>{$row['pregrade']}</td>";
            echo "<td style='background-color: #c7ddef;'>{$row['lastgrade']}</td>";
            echo "<td style='background-color: #c7ddef;'>{$row['totalgrade']}</td>";
            echo"<td style='background-color: #c7ddef;'><a href='edit.php?uid={$row['studentno']}'>修改</a></td>";
            echo "</tr>";
        }
    echo"</table>";

    $page_len = ($page_len%2)?$page_len:$page_len+1;//页码个数
    $pageoffset = ($page_len-1)/2;//页码个数左右偏移量

    $key='<div class="page">';
    $key.="<span>$page/$pages</span> "; //第几页,共几页
    if($page!=1){
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">第一页</a> "; //第一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页</a>"; //上一页
    }else {
        $key.="第一页 ";//第一页
        $key.="上一页"; //上一页
    }
    if($pages>$page_len){
//如果当前页小于等于左偏移
        if($page<=$pageoffset){
            $init=1;
            $max_p = $page_len;
        }else{//如果当前页大于左偏移
//如果当前页码右偏移超出最大分页数
            if($page+$pageoffset>=$pages+1){
                $init = $pages-$page_len+1;
            }else{
//左右偏移都存在时的计算
                $init = $page-$pageoffset;
                $max_p = $page+$pageoffset;
            }
        }
    }
    for($i=$init;$i<=$max_p;$i++){
        if($i==$page){
            $key.=' <span>'.$i.'</span>';
        } else {
            $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>";
        }
    }
    if($page!=$pages){
        $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">下一页</a> ";//下一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">最后一页</a>"; //最后一页
    }else {
        $key.="下一页 ";//下一页
        $key.="最后一页"; //最后一页
    }
    $key.='</div>';
    ?>
   <tr>
        <td colspan="2" bgcolor="#E0EEE0"><div align="center"><?php echo $key?></div></td>
    </tr>
</table>
</body>
</html>
