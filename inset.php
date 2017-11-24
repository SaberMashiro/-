<meta charset="utf-8">
<?php
session_start();
include_once "config.php";
if(@$_SESSION['name']==='admin'){
    ?>
    <form action="inset.php" method="post" name="form1" enctype="multipart/form-data">
        <table width="400" border="1" cellpadding="1"  bgcolor="#999999">
            <tr bgcolor="#FFCC33">
                <td width="103" height="25" align="right">学号</td>
                <td height="25">
                    <input name="studentno" type="text" id="studentno" size="20" maxlength="100">
                </td>
            </tr>
            <tr bgcolor="#FFCC33">
                <td height="25" align="right">姓名</td>
                <td height="25" colspan="2" align="left">
                    <input name="studentname" type="text" id="studentname" size="20" maxlength="100">
                </td>
            </tr>
            <tr bgcolor="#FFCC33">
                <td width="103" height="25" align="right">课程编号</td>
                <td width="289" height="25" colspan="2" align="left">
                    PHP为9501，PYTHON为9502
                    <input name="courseno" type="text" id="courseno" size="20" maxlength="100">
                </td>
            </tr>
            <tr bgcolor="#FFCC33">
                <td height="25" align="right">成绩</td>
                <td height="25" colspan="2" align="left">
                    <input name="pre" type="text" id="fond[]" value="">平时
                    <input name="last" type="text" id="fond[]" value="">期末
                    <input name="total" type="text" id="fond[]" value="">总分
                </td>
            </tr>
            <tr align="center" bgcolor="#FFCC33">
                <td height="25" colspan="3">
                    <input type="submit" name="submit" value="提交">
                    <input type="reset" name="reset" value="重置">
                </td>
            </tr>
        </table>
    </form>
<?php
    if(isset($_POST['submit'])){
        foreach($_POST as $key=>$value){
            $value = security_filter($value);
            $POST[$key] = $value;
        }
        $studentno = $_POST['studentno'];
        $studentname = $_POST['studentname'];
        $courseno = $_POST['courseno'];
        $pregrade = $_POST['pre'];
        $lastgrade = $_POST['last'];
        $totalgrade = $_POST['total'];

        $sql = "insert into student values(?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($studentno,$studentname));
        $sql = "insert into score values (?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($courseno,$studentno,$pregrade,$lastgrade,$totalgrade));
        echo "<script>alert('添加成功')</script>";
    }

}else{
    echo "<script>alert('你没有这份权限');window.location.href='table.php'</script>";
}