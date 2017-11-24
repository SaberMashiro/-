<meta charset="utf-8">
<?php
include_once "config.php";
foreach ($_POST as $key=>$value){
    $value = security_filter($value);
    $_POST[$key] = $value;
}
$username = $_POST['uname'];
$sql = "select course.coursename,student.studentno,student.studentname,score.pregrade,score.lastgrade,score.totalgrade from student join (course join score on course.courseno=score.courseno)on student.studentno=score.studentno where student.studentno=?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($username));
$content = $stmt->fetchAll();

echo"<table  style='border: 1px solid ;margin: 10px auto;width:100%;text-align: center'  >" ;
echo"<tr>
 <th style=' background-color: #4A8091;'>课程名</th>
  <th style=' background-color: #4A8091;'>学号</th>
  <th style=' background-color: #4A8091;'>姓名</th>
  <th style=' background-color: #4A8091;'>平时分数</th>
  <th style=' background-color: #4A8091;'>期末分数</th>
  <th style=' background-color: #4A8091;'>总分</th>
  </tr>";
foreach($content as $num => $row){
    echo "<tr>";
    echo "<td style='background-color: #c7ddef;'>{$row['coursename']}</td>";
    echo "<td style='background-color: #c7ddef;'>{$row['studentno']}</td>";
    echo "<td style='background-color: #c7ddef;'>{$row['studentname']}</td>";
    echo "<td style='background-color: #c7ddef;'>{$row['pregrade']}</td>";
    echo "<td style='background-color: #c7ddef;'>{$row['lastgrade']}</td>";
    echo "<td style='background-color: #c7ddef;'>{$row['totalgrade']}</td>";
    echo "</tr>";
}

echo"</table>";
?>