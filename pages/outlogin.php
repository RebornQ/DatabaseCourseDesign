<?php
// 清除 cookie 值，退出登录
setcookie ( 'user', '', 0, '/' );
// 重定向页面到 登录页面
header ( "Location: login.php" );