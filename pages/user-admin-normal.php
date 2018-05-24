<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 17:33
 */

require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';

////修复Permission为-1时?r=user-admin-normal&uno=20180301仍可访问的问题
//if ($user_permission != 0 || $user_permission != 1) {
//    header("Location: ?r=permission-denied");
//}

$uno = $_GET['uno'];

$permission_read = "true";
$permission_read = "readonly='$permission_read'";
// 判断用户权限，赋予不同的标签权限
if ($uno == "" || ($user_permission == 1 && $uno != $user_no)) {
    echo "<script>history.back()</script>";
} else {
    if ($user_permission == 0) {
        $permission_read = "";
    }
}

// 查询 当前用户的所有信息
$users_current_query = "SELECT * FROM users WHERE u_no='$uno' ORDER BY u_id DESC";
$users_current_result = mysql_query($users_current_query) or die ('SQL语句有误：' . mysql_error());
$users_current = mysql_fetch_array($users_current_result);

$an_save = $_POST['an_save'];
$an_no = $_POST['admin-no-normal'];
$an_name = $_POST['admin-name-normal'];
$an_password = $_POST['admin-password-normal'];
$an_password_new = $_POST['admin-password-normal-new'];
$an_password_repeat = $_POST['admin-password-normal-repeat'];
/* 修改 信息 */
if ($an_save != "") {

    // 超级管理员权限
    if ($user_permission == 0) {
        if ($an_name == "") {
            echo "<script>alert('姓名 不能为空！');history.back()</script>";
            exit ();
        }

        mysql_query("UPDATE users SET u_name='$an_name' WHERE u_no='$an_no'") or die ('SQL语句有误：' . mysql_error());;
        echo "<script>alert('信息更新成功！');location.href='?r=user-admin-normal&uno=$uno'</script>";
    }

    // 普管更改密码
    if ($an_password != "" && $an_password_new != "" && $an_password_repeat != "") {
        if (md5($an_password) != queryPasswordByUno($uno)) {
            echo "<script>alert('登录密码错误！请重新输入！');history.back()</script>";
            exit ();
        }
        if ($an_password_new != $an_password_repeat) {
            echo "<script>alert('两次输入密码不一致！请重新输入！');history.back()</script>";
            exit ();
        }
        if ($user_permission == 1) {
            $passMD5Temp = md5($an_password_new);
            mysql_query("UPDATE users SET u_password='$passMD5Temp' WHERE u_no='$uno'");
//            echo "<script>alert('密码更改成功！请重新登录！');location.href='?r=user-admin-normal&uno=$uno'</script>";
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
                            <label for="admin-no-normal" class="am-u-sm-3 am-form-label">管理员号</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="admin-no-normal" name="admin-no-normal" placeholder="请输入你的管理员号" readonly="true"
                                       value="<?php echo $users_current['u_no'] ?>">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="admin-name-normal" class="am-u-sm-3 am-form-label">姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="admin-name-normal" name="admin-name-normal" placeholder="请输入你的姓名"
                                       value="<?php echo $users_current['u_name'] ?>" <?php echo $permission_read ?>>
                                <small>输入你的名字，让我们记住你。</small>
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_permission != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-normal" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="admin-password-normal" name="admin-password-normal"
                                       placeholder="若修改密码，则直接输入你的登录密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_permission != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-normal-new" class="am-u-sm-3 am-form-label">新密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="admin-password-normal-new" name="admin-password-normal-new"
                                       placeholder="若修改密码，则直接输入你的新密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_permission != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-normal-repeat" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="admin-password-normal-repeat" name="admin-password-normal-repeat"
                                       placeholder="若修改密码，则再次输入你的新密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                <input type="submit" name="an_save" value="保存修改" class="am-btn am-btn-primary" <?php if ($user_permission != 1) echo 'style="display: none;"' ?>>
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
