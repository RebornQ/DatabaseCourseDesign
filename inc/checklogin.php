<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 21:33
 */

// 获得 登录 所存放的cookie值
$user = $_COOKIE ['user'];
$user_permission = $_COOKIE ['user_permission'];
//session_start();
//$user = $_SESSION['user'];
//$user_type = $_SESSION ['user_type'];

// 判断是否 登录
if ($user == "") {
    // 重定向页面到 登录页面
    header ( "Location: ?r=login" );
    exit ();
} else {
    $query = "SELECT * FROM users WHERE u_no='$user'";
    $result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
    $users = mysql_fetch_array ( $result );
//    $username = "管理员：" . $users ['u_name'];
    // 查到用户的个人信息，以备使用
    switch ($user_permission) {
        case 0 :
//            $query = "SELECT * FROM users WHERE u_no='$user'";
//            $result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
//            $users = mysql_fetch_array ( $result );
            $username = "超管：" . $users ['u_name'];
            $user_no = $users ['u_no'];
            $user_name = $users ['u_name'];
            break;
//        case 1 :
//            $query = "SELECT * FROM dor_admin WHERE da_no='$user'";
//            $result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
//            $users = mysql_fetch_array ( $result );
//            $username = "楼管{$users ['da_no']}：" . $users ['da_name'];
//            break;
        case -1 :
//            $query = "SELECT * FROM students WHERE s_no='$user'";
//            $result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
//            $users = mysql_fetch_array ( $result );
            $username = "学生 {$users ['u_name']}：" . $users ['u_no'];
            $user_no = $users ['u_no'];
            $user_name = $users ['u_name'];
            break;
        default :
            break;
    }
}