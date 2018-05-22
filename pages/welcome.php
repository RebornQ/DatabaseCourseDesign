<?php
session_start();
include('../inc/connect.php');//链接数据库
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
} else {
    $userRow = $_SESSION['user'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆成功</title>
</head>
<body>
欢迎光临<?php echo $userRow; ?>
</body>
</html>