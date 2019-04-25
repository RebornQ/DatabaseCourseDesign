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
function queryDorBuildIdByName($conn, $db_name)
{
    $dor_build_query = "SELECT db_id FROM dormitory_builds WHERE db_name='$db_name'";
    $dor_build_result = mysqli_query($conn,$dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_build = mysqli_fetch_array($dor_build_result);
    return $dor_build['db_id'];
}
function queryDorBuildNameById($conn, $db_id)
{
    $db_query = "SELECT db_name FROM dormitory_builds WHERE db_id=$db_id ORDER BY db_id";// 检索记录行 $start_from - ($start_from+15)
    $db_result = mysqli_query($conn,$db_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $db = mysqli_fetch_array($db_result);
    return $db['db_name'];
}

function queryDorBuildIdBySno($conn, $s_no)
{
    $db_query = "SELECT db_id FROM dormitories WHERE d_id=(SELECT d_id FROM students WHERE s_no=$s_no) ORDER BY d_id";// 检索记录行 $start_from - ($start_from+15)
    $db_result = mysqli_query($conn,$db_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $db = mysqli_fetch_array($db_result);
    return $db['db_name'];
}

function queryDorBuildPriceById($conn, $db_id)
{
    $dor_build_query = "SELECT d_price FROM dormitory_builds WHERE db_id=$db_id ORDER BY db_id";
    $dor_build_result = mysqli_query($conn,$dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_build = mysqli_fetch_array($dor_build_result);
    return $dor_build['d_price'];
}

function queryDorIdByDorBuildIdAndDorName($conn, $dor_build_id,$d_name)
{
    $d_query = "SELECT d_id FROM dormitories WHERE d_name=$d_name AND db_id=$dor_build_id";// 检索记录行 $start_from - ($start_from+15)
    $d_result = mysqli_query($conn,$d_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor = mysqli_fetch_array($d_result);
    return $dor['d_name'];
}

function queryDorStuNumNowAndIdByUserNo($conn, $user_no)
{
    $dor_num_now_id_query = "SELECT d_id,d_stu_num_now FROM dormitories WHERE d_id=(SELECT d_id FROM students WHERE s_no='$user_no')";
    $dor_num_now_id_result = mysqli_query($conn,$dor_num_now_id_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_num_id_now = mysqli_fetch_array($dor_num_now_id_result);
    return $dor_num_id_now;
}

function queryIsDorExistByDorNameAndDorBuildId($conn, $db_id, $dor_name)
{
    $dor_query = "SELECT d_id FROM dormitories WHERE db_id=$db_id AND d_name=$dor_name";
    $dor_result = mysqli_query($conn,$dor_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor = mysqli_fetch_array($dor_result);
    if ($dor['d_id'] != "") {
        return true;
    }else return false;
}

function queryIsSameDorByUserNo($conn, $user_no_1, $user_no_2)
{
    $stu_query_1 = "SELECT d_id FROM students WHERE s_no=$user_no_1";
    $stu_result_1 = mysqli_query($conn,$stu_query_1) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu_1 = mysqli_fetch_array($stu_result_1);
    $stu_query_2 = "SELECT d_id FROM students WHERE s_no=$user_no_2";
    $stu_result_2 = mysqli_query($conn,$stu_query_2) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu_2 = mysqli_fetch_array($stu_result_2);
    if ($stu_1['d_id'] == $stu_2['d_id']) {
        return true;
    }else return false;
}
/**
 * 用户相关查询
 * @param $u_no
 * @return
 */
function queryNameByUno($conn, $u_no)
{
    $users_query = "SELECT u_name FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysqli_query($conn,$users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    return $users['u_name'];
}
function queryPasswordByUno($conn, $u_no)
{
    $users_query = "SELECT u_password FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysqli_query($conn,$users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    return $users['u_password'];
}

function queryIsUserExistByNo($conn, $u_no){
    $users_query = "SELECT u_no FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysqli_query($conn,$users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    $stu_query = "SELECT s_no FROM students WHERE s_no='$u_no' ORDER BY s_id DESC";
    $stu_result = mysqli_query($conn,$stu_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu = mysqli_fetch_array($stu_result);
    if ($users['u_no'] != "" && $stu['s_no'] != "") {
        return true;
    }else return false;
}