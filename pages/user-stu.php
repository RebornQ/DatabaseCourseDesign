<?php
require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';

$edit_target = $_GET['edit_target'];
$sno = $_GET['sno'];
$uno = $_GET['uno'];

$permission_read = "true";
$permission_read = "readonly='$permission_read'";
// 判断用户权限，赋予不同的标签权限
if ($edit_target == "self") {
    if ($uno == "" || ($user_permission == -1 && $uno != $user_no)) {
        echo "<script>history.back()</script>";
    } else {
        if ($user_permission == 0 || $user_permission == 1) {
            $permission_read = "";
        }
    }
} else {
    if ($sno == "" || ($user_permission == -1 && $sno != $user_no)) {
        echo "<script>history.back()</script>";
    } else {
        if ($user_permission == 0 || $user_permission == 1) {
            $permission_read = "";
        }
    }
}

$users_stu_query = "SELECT * FROM students WHERE s_no='$sno' ORDER BY s_id DESC";
if ($edit_target == 'self') {
    $users_stu_query = "SELECT * FROM students WHERE s_no='$uno' ORDER BY s_id DESC";
}
$users_stu_result = mysql_query($users_stu_query) or die ('SQL语句有误：' . mysql_error());
$users_stu = mysql_fetch_array($users_stu_result);
//echo "<script>alert('$users_stu[s_no]');</script>";

// 查询 当前学生名字
$users_stu_name_query = "SELECT u_name FROM users WHERE u_no='{$users_stu['s_no']}' ORDER BY u_id DESC";
$users_stu_name_result = mysql_query($users_stu_name_query) or die ('SQL语句有误：' . mysql_error());
$users_stu_name = mysql_fetch_array($users_stu_name_result);

// 查询 当前学生所在的宿舍楼名
$user_stu_dor_build_query = "SELECT dormitory_builds.db_name, dormitory_builds.db_id FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$users_stu['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
$user_stu_dor_build_result = mysql_query($user_stu_dor_build_query) or die ('SQL语句有误：' . mysql_error());
$user_stu_dor_build_name = mysql_fetch_array($user_stu_dor_build_result);
// 查询 该楼的所有宿舍号
$dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='{$user_stu_dor_build_name['db_id']}'";
$dor_list_result = mysql_query($dor_list_query) or die ('SQL语句有误：' . mysql_error());
//$dor_list = mysql_fetch_array ($dor_list_result);
// 查询 当前学生所在的宿舍号
$users_stu_dor_query = "SELECT dormitories.d_name,dormitories.d_bed_num FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$users_stu['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
$users_stu_dor_result = mysql_query($users_stu_dor_query) or die ('SQL语句有误：' . mysql_error());
$users_stu_dor = mysql_fetch_array($users_stu_dor_result);
//$users_stu_dor_name = $users_stu_dor_name['d_name'];

$save = $_POST['save'];
$u_no = $_POST['user-no'];
$u_name = $_POST['user-name'];
$u_password = $_POST['user-password'];
$stu_sex = $_POST['user-sex'];
$stu_age = $_POST['user-age'];
$stu_department = $_POST['user-department'];
$stu_grade = $_POST['user-grade'];
$stu_phone = $_POST['user-phone'];
$stu_dor_build = $_POST['user-dor-build'];
$stu_dor = $_POST['user-dor'];
$stu_bed = $_POST['user-bed'];
/* 修改 信息 */
if ($save != "") {
//    echo "<script>alert($u_name)</script>";
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
        echo "<script>alert('信息更新成功！');location.href='?r=user-stu&sno=$sno'</script>";
    }

    // 超管 和 普管 可更换学生床位宿舍
    if ($user_permission != -1) {
        $dors = mysql_fetch_array ( mysql_query ( "SELECT d_id,d_numnow FROM dor WHERE d_no='$stu_dor' AND db_no='{$studor['db_no']}'" ) );
        $result_stu_nowbed = mysql_query ( "SELECT s_no FROM student WHERE s_bed='$stu_bed' AND d_id='{$dors['d_id']}'" );
        $stu_nowbed = mysql_fetch_array ( $result_stu_nowbed );
        if (mysql_num_rows ( $result_stu_nowbed ) != 0) {
            mysql_query ( "UPDATE student SET s_bed='{$stu['s_bed']}',d_id='{$stu['d_id']}' WHERE s_no='{$stu_nowbed['s_no']}'" );
            mysql_query ( "UPDATE student SET s_bed='$stu_bed',d_id='{$dors['d_id']}' WHERE s_no='{$stu['s_no']}'" );

            echo "<script>alert('学号 {$stu['s_no']} 与 {$stu_nowbed['s_no']} 已对换！');location.href='?r=dorstu&db={$studor['db_no']}'</script>";
            exit ();
        } else {
            mysql_query ( "UPDATE student SET s_bed='$stu_bed',d_id='{$dors['d_id']}' WHERE s_no='{$stu['s_no']}'" );
            if ($stu_dor != $studor ['d_no']) {
                $temp = $studor ['d_numnow'] - 1;
                mysql_query ( "UPDATE dor SET d_numnow='$temp' WHERE d_id='{$stu['d_id']}'" );
                $temp = $dors ['d_numnow'] + 1;
                mysql_query ( "UPDATE dor SET d_numnow='$temp' WHERE d_id='{$dors['d_id']}'" );
            }

            echo "<script>alert('学号 {$stu['s_no']} 已更换宿舍与床位！');location.href='?r=dorstu&db={$studor['db_no']}'</script>";
            exit ();
        }
    }

    // 学生更改密码
    if ($user_permission == -1 && $u_password != "") {
        mysql_query("UPDATE users SET u_password=md5($u_password) WHERE u_no='$sno'");
        echo "<script>alert('密码更改成功！');location.href='?r=user-stu&sno=$sno'</script>";
        exit ();
    }
}
//else if ($_REQUEST['forget']) {
//    echo "<script>alert('$u_no')</script>";
//}
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
                                       value="<?php echo $users_stu['s_no'] ?>">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="user-name" placeholder="请输入你的姓名"
                                       value="<?php echo $users_stu_name['u_name'] ?>" <?php echo $permission_read ?>>
                                <small>输入你的名字，让我们记住你。</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-sex" class="am-u-sm-3 am-form-label">性别</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-sex" name="user-sex" placeholder="输入你的性别"
                                       value="<?php echo $users_stu['s_sex'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-age" class="am-u-sm-3 am-form-label">年龄</label>
                            <div class="am-u-sm-9">
                                <input type="number" pattern="[0-9]*" id="user-age" name="user-age" placeholder="输入你的年龄"
                                       value="<?php echo $users_stu['s_age'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-department" class="am-u-sm-3 am-form-label">所在院系</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-department" name="user-department" placeholder="输入你所在的院系"
                                       value="<?php echo $users_stu['s_department'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-grade" class="am-u-sm-3 am-form-label">年级</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-grade" name="user-grade" placeholder="输入你所在的年级"
                                       value="<?php echo $users_stu['s_grade'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">电话</label>
                            <div class="am-u-sm-9">
                                <input type="tel" id="user-phone" name="user-phone" placeholder="输入你的电话号码"
                                       value="<?php echo $users_stu['s_phone'] ?>" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-dor-build" class="am-u-sm-3 am-form-label">宿舍楼</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-dor-build" name="user-dor-build" placeholder="输入你所在的宿舍楼"
                                       value="<?php echo $user_stu_dor_build_name['db_name'] ?>" <?php echo $permission_read ?>>
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
                                    if ($db_dor['d_name'] == $users_stu_dor['d_name']) {
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
                                for ($i = 1; $i <= $users_stu_dor['d_bed_num']; $i++) {
                                    if ($i == $users_stu['s_bed']) {
                                        echo "<option value='$i' selected='selected'>$i</option>";
                                    } else {
                                        echo "<option value='$i' >$i</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_permission != -1) echo 'style="display: none;"' ?>>
                            <label for="user-password" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password" name="user-password"
                                       placeholder="若修改密码，则直接输入你的新密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                <input type="submit" name="save" value="保存修改" class="am-btn am-btn-primary">
                                <!--                                <input type="submit" name="forget" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">-->
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
