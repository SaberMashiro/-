<?php
session_start();
$_SESSION = array(); //清除SESSION值.
session_destroy();  //清除服务器的sesion文件
header('location:table.php');
?>