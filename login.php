<meta charset="utf-8">
<head>
    <meta charset="utf-8">
    <title>登陆</title>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/answer.css" rel="stylesheet">
    <link href="css/myquestion.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
</head>
<?php
session_start();
require "header.php";
?>
<div class="main-content">
    <div class="left-content">
        <div class="title">
            <strong>登录</strong>
        </div>
        <div class="register-contain">
            <form action="login.php" method="post">
                <input id="telphone" type="text" name="name" placeholder="name" value="">
                <input id="password" type="password" name="password" placeholder="password">
                <input id="bntregistere" type="submit" name="submit" value="登录">
            </form>
            <div>
<?php
include_once "config.php";
if(isset($_SESSION['name'])){
    echo "<script>alert('你已经登陆');window.location.href='index.php'</script>";
}else {
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $value) {
            $value = security_filter($value);
            $_POST[$key] = $value;
        }
        $username = $_POST['name'];
        $password = $_POST['password'];
        if ($username === 'admin') {
            $sql = 'select * from admin where username = ?';
        } else {
            $sql = 'select * from teacher where username = ?';
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($username));
        $content = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($content);
        if (array_search($password, $content, true)) {
            if (isset($content['teacherno'])) {
                $_SESSION['name'] = $content['teacherno'];
            } else {
                $_SESSION['name'] = 'admin';
            }
            header('location:index.php');
        } else {
            echo "<script>alert('用户名密码错误');window.location.href='login.php'</script>";
        }
    }
}

?>