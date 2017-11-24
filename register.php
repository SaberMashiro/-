<meta charset="utf-8">
<?php
 include "header.php";
?>

<title>STUDENTSCORE</title>
<link href="css/main.css" rel="stylesheet">
<link href="css/answer.css" rel="stylesheet">
<link href="css/myquestion.css" rel="stylesheet">
<link href="css/register.css" rel="stylesheet">
<style>
    table{

        border-collapse: collapse;/*合并单元格*/
        line-height: 2;
        border-spacing: 0;/*表格之间空隙为0*/
        width:100%;
        text-align: center;
    }
    th{
        background-color: #4A8091;
    }
    td{
        /* width: 40px;*/
        /*  background-color: #c7ddef;*/
    }
    .id{
        width: 100%;
        line-height:2 ;
    }
    table *{
        border: 1px solid ;
    }
    tr{
        line-height: 2;
    }
</style>
<div class="main-content">
    <div class="left-content">
        <div class="title">
            <strong>注册教师信息</strong>
        </div>

        <div class="register-contain">
            <form action="register.php" method="post">
                <input id="no" type="text" name="teacherno" placeholder="[教师工号]">
                <input type="text" name="name" placeholder="[姓名]" value="<?php echo empty(@$_COOKIE['name'])?'':$_COOKIE['name']?>">
                <input id="username" type="text" name="username" placeholder="[用户名]">
                <input id="password" type="password" name="password" placeholder="[密码]">
                <input id="passwordsec" type="password" name="passwordsec" placeholder="[再次密码]">
                <input id="bntregistere" type="submit" name="submit" value="一定要输入完整信息哦,不然不让你注册">
            </form>
<?php
    if(isset($_POST['submit'])) {
        include_once "config.php";
        if ($_POST['pw'] === $_POST['repw']) {
            $username = isset($_POST['un']) ? $_POST['un'] : '';
            $password = isset($_POST['pw']) ? $_POST['pw'] : '';
            $teacher_name = isset($_POST['name']) ? $_POST['name'] : '';
            $teacher_num = isset($_POST['num']) ? $_POST['num'] : '';

            $sql = "Insert into teacher values(?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($teacher_num, $teacher_name, $username, $password));
            echo "<script>alert(\"注册成功\");window.location.href='login.php'</script>";
        } else {
            echo "<script>alert('两次密码不相同');window.location.href='register.php'</script>";
        }
    }
?>