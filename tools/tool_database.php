<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/23
 * Time: 18:54
 * @param $db_name
 * @return
 */

/**
 * 宿舍相关查询
 */
function queryDorBuildIdByName($db_name)
{
    $dor_build_query = "SELECT db_id FROM dormitory_builds WHERE db_name='$db_name'";
    $dor_build_result = mysql_query($dor_build_query) or die ('SQL语句有误：' . mysql_error());
    $dor_build = mysql_fetch_array($dor_build_result);
    return $dor_build['db_id'];
}
function queryDorBuildNameById($db_id)
{
    $db_query = "SELECT db_name FROM dormitory_builds WHERE db_id=$db_id ORDER BY db_id";// 检索记录行 $start_from - ($start_from+15)
    $db_result = mysql_query($db_query) or die ('SQL语句有误：' . mysql_error());
    $db = mysql_fetch_array($db_result);
    return $db['db_name'];
}
function queryDorIdByDorBuildIdAndDorName($dor_build_id,$d_name)
{
    $d_query = "SELECT d_id FROM dormitories WHERE d_name=$d_name AND db_id=$dor_build_id";// 检索记录行 $start_from - ($start_from+15)
    $d_result = mysql_query($d_query) or die ('SQL语句有误：' . mysql_error());
    $dor = mysql_fetch_array($d_result);
    return $dor['d_name'];
}

function queryDorStuNumNowAndIdByUserNo($user_no)
{
    $dor_num_now_id_query = "SELECT d_id,d_stu_num_now FROM dormitories WHERE d_id=(SELECT d_id FROM students WHERE s_no='$user_no')";
    $dor_num_now_id_result = mysql_query($dor_num_now_id_query) or die ('SQL语句有误：' . mysql_error());
    $dor_num__id_now = mysql_fetch_array($dor_num_now_id_result);
    return $dor_num__id_now;
}
/**
 * 用户相关查询
 */
function queryNameByUno($u_no)
{
    $users_query = "SELECT u_name FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysql_query($users_query) or die ('SQL语句有误：' . mysql_error());
    $users = mysql_fetch_array($users_result);
    return $users['u_name'];
}
function queryPasswordByUno($u_no)
{
    $users_query = "SELECT u_password FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysql_query($users_query) or die ('SQL语句有误：' . mysql_error());
    $users = mysql_fetch_array($users_result);
    return $users['u_password'];
}