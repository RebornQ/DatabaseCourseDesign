<?php
require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';

$edit_target = $_GET['edit_target'];
$sno = $_GET['sno'];
$target_no = $_GET['tno'];
//$uno = $_GET['uno'];

$save = $_POST['save'];
$u_no = $_POST['user-no'];
$u_name = $_POST['user-name'];
$u_password = $_POST['user-password'];
$u_password_new = $_POST['user-password-new'];
$u_password_repeat = $_POST['user-password-repeat'];
$stu_sex = $_POST['user-sex'];
$stu_age = $_POST['user-age'];
$stu_department = $_POST['user-department'];
$stu_grade = $_POST['user-grade'];
$stu_phone = $_POST['user-phone'];
$stu_dor_build = $_POST['user-dor-build'];
$stu_dor = $_POST['user-dor'];
$stu_bed = $_POST['user-bed'];
$stu_dor_build_id = queryDorBuildIdByName($stu_dor_build);

$permission_read = "true";
$permission_read = "readonly='$permission_read'";
// 判断用户权限，赋予不同的标签权限
if ($edit_target == "self") {
    $permission_show = "";
    if ($sno == "" || ($user_permission == -1 && $sno != $user_no)) {
        echo "<script>history.back()</script>";
    } else {
        if ($user_permission == 0) {
            $permission_read = "";
        }
    }
} else if ($edit_target == "others") {
    if ($target_no == "" && $user_permission == -1) {
        header("Location: ?r=permission-denied");
        exit();
    }
    if ($sno == "" || ($user_permission == -1 && $sno != $user_no && !queryIsSameDorByUserNo($sno, $target_no))) {
        header("Location: ?r=permission-denied");
        exit();
//        echo "<script>history.back()</script>";
    } else {
        $permission_show = "style=\"display: none;\"";
        if ($user_permission == 0) {
            $permission_read = "";
        }
    }
}

// 查询 当前用户的所有信息
$users_stu_current_query = "SELECT * FROM students WHERE s_no='$sno' ORDER BY s_id DESC";
$users_stu_current_result = mysql_query($users_stu_current_query) or die ('SQL语句有误：' . mysql_error());
$users_stu_current = mysql_fetch_array($users_stu_current_result);
//echo "<script>alert('{$users_stu_current['s_no']}');</script>";

// 查询 学生的所有信息
$users_stu_query = "SELECT * FROM students WHERE s_no='$sno' ORDER BY s_id DESC";
$users_stu_result = mysql_query($users_stu_query) or die ('SQL语句有误：' . mysql_error());
$users_stu = mysql_fetch_array($users_stu_result);

// 查询 当前学生名字
$users_stu_current_name_query = "SELECT u_name FROM users WHERE u_no='{$users_stu_current['s_no']}' ORDER BY u_id DESC";
$users_stu_current_name_result = mysql_query($users_stu_current_name_query) or die ('SQL语句有误：' . mysql_error());
$users_stu_current_name_list = mysql_fetch_array($users_stu_current_name_result);

// 查询 当前学生所在的宿舍楼名
$user_stu_current_dor_build_query = "SELECT dormitory_builds.db_name, dormitory_builds.db_id FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$users_stu_current['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
$user_stu_current_dor_build_result = mysql_query($user_stu_current_dor_build_query) or die ('SQL语句有误：' . mysql_error());
$user_stu_current_dor_build = mysql_fetch_array($user_stu_current_dor_build_result);
// 查询 该楼的所有宿舍号
$dor_build_select_name = $_GET['db_name_select'];
$dor_build_select_id = "1";
if (isset($dor_build_select_name)) {
    $dor_build_select_id = queryDorBuildIdByName($dor_build_select_name);
    $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='$dor_build_select_id'";
} else $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='{$user_stu_current_dor_build['db_id']}'";
//$dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='{$user_stu_current_dor_build['db_id']}'";
$dor_list_result = mysql_query($dor_list_query) or die ('SQL语句有误：' . mysql_error());
//$dor_list = mysql_fetch_array ($dor_list_result);
// 查询 当前学生所在的宿舍号
$users_stu_current_dor_query = "SELECT * FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$users_stu_current['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
$users_stu_current_dor_result = mysql_query($users_stu_current_dor_query) or die ('SQL语句有误：' . mysql_error());
$users_stu_current_dor = mysql_fetch_array($users_stu_current_dor_result);
//$users_stu_current_dor_name = $users_stu_current_dor_name['d_name'];

// 查询 所有的宿舍楼名
$users_all_dor_builds_query = "SELECT db_name FROM dormitory_builds ORDER BY db_id";
$users_all_dor_builds_result = mysql_query($users_all_dor_builds_query) or die ('SQL语句有误：' . mysql_error());
//$users_all_dor_builds = mysql_fetch_array($users_all_dor_builds_result);


/* 修改 信息 */
if ($save != "") {

    // 超级管理员权限
    if ($user_permission == 0) {
        if ($u_name == "") {
            echo "<script>alert('姓名 不能为空！');history.back()</script>";
            exit ();
        }
        if ($stu_sex == "") {
            echo "<script>alert('性别 不能为空！');history.back()</script>";
            exit ();
        }
        if ($stu_age == "") {
            echo "<script>alert('年龄 不能为空！');history.back()</script>";
            exit ();
        }
        if ($stu_department == "") {
            echo "<script>alert('所在院系 不能为空！');history.back()</script>";
            exit ();
        }
        if ($stu_grade == "") {
            echo "<script>alert('年级 不能为空！');history.back()</script>";
            exit ();
        }
        if ($stu_phone == "") {
            echo "<script>alert('电话 不能为空！');history.back()</script>";
            exit ();
        }

        mysql_query("UPDATE users SET u_name='$u_name' WHERE u_no='$u_no'") or die ('SQL语句有误：' . mysql_error());;
        mysql_query("UPDATE students SET s_sex='$stu_sex',s_age='$stu_age',s_department='$stu_department',s_grade='$stu_grade',s_phone='$stu_phone' WHERE s_no='$u_no'") or die ('SQL语句有误：' . mysql_error());;
        echo "<script>alert('信息更新成功！');location.href='?r=user-stu&sno=$sno&edit_target=others'</script>";
    }

    // 超管 和 普管 可更换学生床位宿舍
    if ($user_permission != -1) {
        $dor_details_now = mysql_fetch_array(mysql_query("SELECT d_id,d_stu_num_now,d_bed_num FROM dormitories WHERE d_name='$stu_dor' AND db_id='$stu_dor_build_id'"));//查询 目标宿舍楼该宿舍的id和床位数以及当前已入住人数
        $result_bed_details_now = mysql_query("SELECT s_no FROM students WHERE s_bed='$stu_bed' AND d_id='{$dor_details_now['d_id']}'");// 查询 睡目标宿舍该床的同学的学号（判断是否已有人）
        $bed_details_now = mysql_fetch_array($result_bed_details_now);
        if (mysql_num_rows($result_bed_details_now) != 0) {// 若存在，即床已有人睡，则与学生间互换宿舍
            mysql_query("UPDATE students SET s_bed='{$users_stu['s_bed']}',d_id='{$users_stu['d_id']}' WHERE s_no='{$bed_details_now['s_no']}'");//先把自己的位置换给目标
            mysql_query("UPDATE students SET s_bed='$stu_bed',d_id='{$dor_details_now['d_id']}' WHERE s_no='{$users_stu['s_no']}'");//目标位置换给自己

//            echo "<script>alert('学号 {$users_stu['s_no']} 与 {$bed_details_now['s_no']} 已互换宿舍！');location.href='?r=user-stu&db={$user_stu_current_dor_build['db_name']}'</script>";
            echo "<script>alert('学号 {$users_stu['s_no']} 与 {$bed_details_now['s_no']} 已互换宿舍！');location.href='?r=user-stu&sno=$sno&edit_target=others'</script>";
            exit ();
        } else {
            mysql_query("UPDATE students SET s_bed='$stu_bed',d_id='{$dor_details_now['d_id']}' WHERE s_no='{$users_stu['s_no']}'");
            if ($stu_dor != $users_stu_current_dor ['d_name'] || $stu_dor_build_id != $users_stu_current_dor['db_id']) {
                $num_now_temp = $users_stu_current_dor ['d_stu_num_now'] - 1;
                mysql_query("UPDATE dormitories SET d_stu_num_now='$num_now_temp' WHERE d_id='{$users_stu['d_id']}'");
                $num_now_temp = $dor_details_now ['d_stu_num_now'] + 1;
                mysql_query("UPDATE dormitories SET d_stu_num_now='$num_now_temp' WHERE d_id='{$dor_details_now['d_id']}'");
            }

//            echo "<script>alert('学号 {$users_stu['s_no']} 已更换宿舍与床位！');location.href='?r=dorstu&db={$studor['db_no']}'</script>";
            echo "<script>alert('学号 {$users_stu['s_no']} 已更换宿舍与床位！');location.href='?r=user-stu&sno=$sno&edit_target=others'</script>";
            exit ();
        }
    }

    // 学生更改密码
    if ($u_password != "" && $u_password_new != "" && $u_password_repeat != "") {
        if (md5($u_password) != queryPasswordByUno($sno)) {
            echo "<script>alert('登录密码错误！请重新输入！');history.back()</script>";
            exit ();
        }
        if ($u_password_new != $u_password_repeat) {
            echo "<script>alert('两次输入密码不一致！请重新输入！');history.back()</script>";
            exit ();
        }
        if ($user_permission == -1) {
            $passMD5Temp = md5($u_password_new);
            mysql_query("UPDATE users SET u_password='$passMD5Temp' WHERE u_no='$sno'");
//            echo "<script>alert('密码更改成功！请重新登录！');location.href='?r=user-stu&sno=$sno'</script>";
            echo "<script>alert('密码更改成功！请重新登录！');location.href='?r=outlogin'</script>";
            exit ();
        }
    } else {
        echo "<script>alert('密码不能为空！请重新输入密码！');history.back()</script>";
        exit ();
    }

}
?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>个人资料</title>
    <meta name="description" content="这是一个 user 页面">
    <meta name="keywords" content="user">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<!-- header start -->
<header class="am-topbar am-topbar-inverse admin-header">
    <?php require 'template/header.php'; ?>
</header>
<!-- header end -->

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php require 'template/sidebar.php'; ?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">个人资料</strong> /
                    <small>Personal information</small>
                </div>
            </div>

            <hr/>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8"></div>

                <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                    <form class="am-form am-form-horizontal" method="post" name="edit">

                        <div class="am-form-group">
                            <label for="user-no" class="am-u-sm-3 am-form-label">学号</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-no" name="user-no" placeholder="请输入你的学号" readonly="true"
                                       value="<?php echo $users_stu_current['s_no'] ?>">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="user-name" placeholder="请输入你的姓名"
                                       value="<?php echo $users_stu_current_name_list['u_name'] ?>" <?php echo $permission_read ?>>
                                <small>输入你的名字，让我们记住你。</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-sex" class="am-u-sm-3 am-form-label">性别</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-sex" name="user-sex" placeholder="输入你的性别"
                                       value="<?php echo $users_stu_current['s_sex'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-age" class="am-u-sm-3 am-form-label">年龄</label>
                            <div class="am-u-sm-9">
                                <input type="number" pattern="[0-9]*" id="user-age" name="user-age" placeholder="输入你的年龄"
                                       value="<?php echo $users_stu_current['s_age'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-department" class="am-u-sm-3 am-form-label">所在院系</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-department" name="user-department" placeholder="输入你所在的院系"
                                       value="<?php echo $users_stu_current['s_department'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-grade" class="am-u-sm-3 am-form-label">年级</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-grade" name="user-grade" placeholder="输入你所在的年级"
                                       value="<?php echo $users_stu_current['s_grade'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">电话</label>
                            <div class="am-u-sm-9">
                                <input type="tel" id="user-phone" name="user-phone" placeholder="输入你的电话号码"
                                       value="<?php echo $users_stu_current['s_phone'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <script>
                            // 选中宿舍楼后输出该宿舍楼的所有宿舍给下一个select标签
                            // ?r=user-stu&sno=20180218&edit_target=others
                            function request(id) {
                                // var data = {db_name_select: document.getElementById(id).value};
                                var data = document.getElementById(id).value;
                                window.location.href = "?r=user-stu" + "&sno=<?php echo $sno?>" + "&edit_target=<?php echo $edit_target?>" + "&db_name_select=" + data;

                            }

                            // 在跳转的页面底部写上这些js
                            window.onload = function () {
                                // https://www.w3cschool.cn/lwp2e2/hqky12kg.html
                                var url = location.href;
                                var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
                                // console.log(paraString);
                                var paraObj = {};
                                for (i = 0; j = paraString[i]; i++) {
                                    paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
                                }
                                // console.log(paraObj);
                                var returnValue = paraObj['db_name_select'];
                                // console.log(returnValue);
                                setSelectChecked('user-dor-build', returnValue);
                                // if (typeof(returnValue) == "undefined") {
                                //     return "";
                                // } else {
                                //     return returnValue;
                                // }
                            };

                            function setSelectChecked(selectId, checkValue) {
                                var select = document.getElementById(selectId);
                                for (var i = 0; i < select.options.length; i++) {
                                    if (select.options[i].innerHTML === checkValue) {
                                        select.options[i].selected = true;
                                        break;
                                    }
                                }
                            }
                        </script>
                        <div class="am-form-group">
                            <label for="user-dor-build" class="am-u-sm-3 am-form-label">宿舍楼</label>
                            <div class="am-u-sm-9">
                                <?php
                                // 判断 用户权限，是否可编辑
                                if ($user_permission == -1) {
                                    echo "<select name='user-dor-build' disabled='disabled' id='user-dor-build' onchange='request(this.id)'>";
                                } else {
                                    echo "<select name='user-dor-build' id='user-dor-build' onchange='request(this.id)'>";
                                }
                                // 把 所有宿舍楼 遍历到数组中，输出
                                while ($dor_builds = mysql_fetch_array($users_all_dor_builds_result)) {
                                    if ($dor_builds['db_name'] == $user_stu_current_dor_build['db_name']) {
                                        echo "<option value='{$dor_builds['db_name']}' selected='selected'>{$dor_builds['db_name']}</option>";
                                    } else {
                                        echo "<option value='{$dor_builds['db_name']}'>{$dor_builds['db_name']}</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-dor" class="am-u-sm-3 am-form-label">宿舍号</label>
                            <div class="am-u-sm-9">
                                <?php
                                // 判断 用户权限，是否可编辑
                                if ($user_permission == -1) {
                                    echo "<select name='user-dor' disabled='disabled'>";
                                } else {
                                    echo "<select name='user-dor'>";
                                }
                                // 把该宿舍楼的 所有宿舍号 遍历到数组中，输出
                                while ($db_dor = mysql_fetch_array($dor_list_result)) {
                                    if ($db_dor['d_name'] == $users_stu_current_dor['d_name']) {
                                        echo "<option value='{$db_dor['d_name']}' selected='selected'>{$db_dor['d_name']}</option>";
                                    } else {
                                        echo "<option value='{$db_dor['d_name']}'>{$db_dor['d_name']}</option>";
                                    }
                                }
                                echo "</select>";
                                ?>

                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-bed" class="am-u-sm-3 am-form-label">床号</label>
                            <div class="am-u-sm-9">
                                <?php
                                // 判断 用户权限，是否可编辑
                                if ($user_permission == -1) {
                                    echo "<select name='user-bed' disabled='disabled'>";
                                } else {
                                    echo "<select name='user-bed'>";
                                }

                                // 输出该楼的 所有床位
                                for ($i = 1; $i <= $users_stu_current_dor['d_bed_num']; $i++) {
                                    if ($i == $users_stu_current['s_bed']) {
                                        echo "<option value='$i' selected='selected'>$i</option>";
                                    } else {
                                        echo "<option value='$i' >$i</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group" <?php echo $permission_show ?>>
                            <label for="user-password" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password" name="user-password"
                                       placeholder="若修改密码，则直接输入你的登录密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php echo $permission_show ?>>
                            <label for="user-password-new" class="am-u-sm-3 am-form-label">新密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password-new" name="user-password-new"
                                       placeholder="若修改密码，则直接输入你的新密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php echo $permission_show ?>>
                            <label for="user-password-repeat" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password-repeat" name="user-password-repeat"
                                       placeholder="若修改密码，则再次输入你的新密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                <input type="submit" name="save" value="保存修改"
                                       class="am-btn am-btn-primary" <?php if ($edit_target == "others" && $user_permission != -1) echo ""; else echo $permission_show ?>>
                                <a href="?r=user-delete&delete_no=<?php echo $sno ?>&isdelete=true&from=list-stu"><input
                                            type="button" onclick="return confirm('删除后无法恢复数据，是否继续？');" name="del"
                                            value="删除用户? "
                                            class="am-btn am-btn-default am-btn-sm am-fr" <?php if ($edit_target == "others" && $user_permission == 0) echo ""; else echo $permission_show ?>></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="admin-content-footer">
            <?php require 'template/footer.php'; ?>
        </footer>

    </div>
    <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
    <?php require 'template/footer.php'; ?>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>

<script src="assets/js/app.js"></script>
</body>
</html>
