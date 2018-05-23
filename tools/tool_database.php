<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/23
 * Time: 18:54
 * @param $db_name
 * @return
 */

function queryDorBuildIdByName($db_name)
{
    $dor_build_query = "SELECT db_id FROM dormitory_builds WHERE db_name='$db_name'";
    $dor_build_result = mysql_query($dor_build_query) or die ('SQL语句有误：' . mysql_error());
    $dor_build = mysql_fetch_array($dor_build_result);
    return $dor_build['db_id'];
}

function queryPasswordByUno($u_no)
{
    $users_query = "SELECT u_password FROM users WHERE u_no='$u_no' ORDER BY u_id DESC";
    $users_result = mysql_query($users_query) or die ('SQL语句有误：' . mysql_error());
    $users = mysql_fetch_array($users_result);
    return $users['u_password'];
}