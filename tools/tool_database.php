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

function queryDorBuildIdBySno($s_no)
{
    $db_query = "SELECT db_id FROM dormitories WHERE d_id=(SELECT d_id FROM students WHERE s_no=$s_no) ORDER BY d_id";// 检索记录行 $start_from - ($start_from+15)
    $db_result = mysql_query($db_query) or die ('SQL语句有误：' . mysql_error());
    $db = mysql_fetch_array($db_result);
    return $db['db_name'];
}

function queryDorBuildPriceById($db_id)
{
    $dor_build_query = "SELECT d_price FROM dormitory_builds WHERE db_id=$db_id ORDER BY db_id";
    $dor_build_result = mysql_query($dor_build_query) or die ('SQL语句有误：' . mysql_error());
    $dor_build = mysql_fetch_array($dor_build_result);
    return $dor_build['d_price'];
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
    $dor_num_id_now = mysql_fetch_array($dor_num_now_id_result);
    return $dor_num_id_now;
}

function queryIsDorExistByDorNameAndDorBuildId($db_id, $dor_name)
{
    $dor_query = "SELECT d_id FROM dormitories WHERE db_id=$db_id AND d_name=$dor_name";
    $dor_result = mysql_query($dor_query) or die ('SQL语句有误：' . mysql_error());
    $dor = mysql_fetch_array($dor_result);
    if ($dor['d_id'] != "") {
        return true;
    }else return false;
}

function queryIsSameDorByUserNo($user_no_1, $user_no_2)
{
    $stu_query_1 = "SELECT d_id FROM students WHERE s_no=$user_no_1";
    $stu_result_1 = mysql_query($stu_query_1) or die ('SQL语句有误：' . mysql_error());
    $stu_1 = mysql_fetch_array($stu_result_1);
    $stu_query_2 = "SELECT d_id FROM students WHERE s_no=$user_no_2";
    $stu_result_2 = mysql_query($stu_query_2) or die ('SQL语句有误：' . mysql_error());
    $stu_2 = mysql_fetch_array($stu_result_2);
    if ($stu_1['d_id'] == $stu_2['d_id']) {
        return true;
    }else return false;
}
/**
 * 用户相关查询
 * @param $u_no
 * @return
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

function queryIsUserExistByNo($u_no){
    $users_query = "SELECT u_no FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysql_query($users_query) or die ('SQL语句有误：' . mysql_error());
    $users = mysql_fetch_array($users_result);
    $stu_query = "SELECT s_no FROM students WHERE s_no='$u_no' ORDER BY s_id DESC";
    $stu_result = mysql_query($stu_query) or die ('SQL语句有误：' . mysql_error());
    $stu = mysql_fetch_array($stu_result);
    if ($users['u_no'] != "" && $stu['s_no'] != "") {
        return true;
    }else return false;
}