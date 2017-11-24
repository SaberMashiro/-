<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = 'grades';

try{
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password,array(PDO::ATTR_PERSISTENT => true));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);//关闭PDO仿真，过滤宽字节注入
}catch(PDOException $e){
    die("Connection Failed".$e->getMessage());
}

function security_filter($value)
{
    if(isset($value)){
        //这条语句主要用来处理XSS攻击
        $value = htmlspecialchars($value,ENT_QUOTES);
        //SQL语句全用的预处理，SQL注入什么的，不存在的
        return $value;
    }else{
        return -1;
        echo "<script>alert('请不要不输入');window.history.back(-1);</script>";
    }
}

?>