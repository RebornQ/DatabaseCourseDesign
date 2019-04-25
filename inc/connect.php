<?php
error_reporting ( 0 );
header ( 'Content-Type:text/html;charset=utf-8' ); // 页面字符集utf-8
                                                   
// 常量参数
define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'root' );
define ( 'DB_PWD', '***REMOVED***' );
define ( 'DB_NAME', 'sql_bigwork' );

// 第一步，连接MYSQL服务器
$conn = mysqli_connect ( DB_HOST, DB_USER, DB_PWD ) or die ( '连接MySQL服务器 失败！' . mysqli_connect_error() );
// 第二步，选择指定的数据库
mysqli_select_db ( $conn,DB_NAME ) or die ( '数据库错误，错误信息：' . mysqli_error ($conn) );

// 设置字符集
mysqli_query ( $conn,'SET NAMES UTF8' ) or die ( '字符集设置错误' . mysqli_error ($conn) );
// 设置中国时区
date_default_timezone_set ( 'PRC' ); 
