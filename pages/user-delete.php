<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/26
 * Time: 17:08
 */

require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';

/**
 * 根据传进来的 编号NO 删除用户
 */
$delete_no = $_GET ['delete_no'];
$isDelete = $_GET['isdelete'];
$page_from = $_GET['from'];
if ($delete_no != "" && $isDelete == "true") {
    if ($user_permission != 0) {
        echo "<script>alert('权限不足！！');location.href='?r=$page_from';</script>";
        exit();
    }
    $dor_num_now_id = queryDorStuNumNowAndIdByUserNo($delete_no);
    $dor_num_now = $dor_num_now_id['d_stu_num_now'] - 1;
    mysql_query ( "UPDATE dormitories SET d_stu_num_now='$dor_num_now' WHERE d_id='{$dor_num_now_id['d_id']}'" ) or die ('SQL语句有误：' . mysql_error());
    $delete_query1 = "DELETE FROM students WHERE s_no='$delete_no'";
    $delete_query2 = "DELETE FROM users WHERE u_no='$delete_no'";
    mysql_query($delete_query1) or die ('删除错误' . mysql_error());
    mysql_query($delete_query2) or die ('删除错误' . mysql_error());
    echo "<script>alert('学号为 " . $delete_no . "的学生已删除');location.href='?r=$page_from';</script>";
}