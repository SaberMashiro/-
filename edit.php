<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>成绩修改</title>
<link href="css/main.css" rel="stylesheet">
<link href="css/answer.css" rel="stylesheet">
</head>
<?php
session_start();
include_once "config.php";
foreach ($_GET as $key => $value) {
    $value = security_filter($value);
    $_GET[$key] = $value;
}
$_SESSION['uid'] = @$_GET['uid'];
if(isset($_SESSION['name'])){
    if($_SERVER['REQUEST_METHOD']=='GET'){
    echo"<table  style='border: 1px solid ;margin: 10px auto;width:100%;text-align: center'  >" ;
    echo"<tr>
 <th style=' background-color: #4A8091;'>课程名</th>
  <th style=' background-color: #4A8091;'>学号</th>
  <th style=' background-color: #4A8091;'>姓名</th>
  <th style=' background-color: #4A8091;'>平时分数</th>
  <th style=' background-color: #4A8091;'>期末分数</th>
  <th style=' background-color: #4A8091;'>总分</th>
  </tr>";
?>
                <strong>修改成绩</strong>
            </div>
            <?php
                $sql = "select distinct course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from score,student,course where course.courseno in (select courseno from course where course.teacherno=?) and student.studentno=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($_SESSION['name'],@$_GET['uid']));
                $row = $stmt->fetch();
                echo "<form action='edit.php' method='post'>";
                echo "<tr>";
                echo "<td style='background-color: #c7ddef;'>{$row['coursename']}</td>";
                echo "<td style='background-color: #c7ddef;'>{$row['studentno']}</td>";
                echo "<td style='background-color: #c7ddef;'>{$row['studentname']}</td>";
                echo "<td style='background-color: #c7ddef;'><input type='text' name='pregrade' value='{$row['pregrade']}'></td>";
                echo "<td style='background-color: #c7ddef;'><input type='text' name='lastgrade' value='{$row['lastgrade']}'></td>";
                echo "<td style='background-color: #c7ddef;'><input type='text' name='totalgrade' value='{$row['totalgrade']}'></td>";
                echo "<td style='background-color: #c7ddef;'><input type=\"submit\" name=\"submit\" value=\"提交\"></td>";
                echo "</tr>";
    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        foreach($_POST as $key=>$value){
            $value = security_filter($value);
            $POST[$key] = $value;
        }
        $courseno = $pdo->query("select courseno from course where teacherno='".$_SESSION['name']."'")->fetch()['courseno'];
        //$_POST[pregrade],$_POST[lastgrade],$_POST[totalgrade],$SESSION
        $sql = "update score set pregrade=?,lastgrade=?,totalgrade=? where studentno = ? and courseno =? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($_POST['pregrade']),$_POST['lastgrade'],$_POST['totalgrade'],$_SESSION['uid'],$courseno);
        echo "修改成功，正在跳转<script>window.location.href='table.php'</script>";
    }
}else{
    echo "<script>alert('你没有这份权限');window.history.back();</script>";
}
?>
</html>
