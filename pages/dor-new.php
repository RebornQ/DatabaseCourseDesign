<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/26
 * Time: 02:39
 */

require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';


$permission_read = "true";
$permission_read = "readonly='$permission_read'";
// 判断用户权限，赋予不同的标签权限
if ($user_permission == -1) {
    header("Location: ?r=permission-denied");
    exit();
} else {
    $permission_show = "style=\"display: none;\"";
    if ($user_permission == 0) {
        $permission_read = "";
    }
}

$add = $_POST['add'];
$stu_dor_build = $_GET['db_name_select'];//修复当from=dorlist时，select的disable属性为disabled导致的$stu_dor_build为空，使得添加数据失败
$stu_dor = $_POST['user-dor-new'];
$stu_dor_build_id = queryDorBuildIdByName($stu_dor_build);

// 查询 所有的宿舍楼名
$users_all_dor_builds_query = "SELECT db_name FROM dormitory_builds ORDER BY db_id";
$users_all_dor_builds_result = mysql_query($users_all_dor_builds_query) or die ('SQL语句有误：' . mysql_error());
//$users_all_dor_builds = mysql_fetch_array($users_all_dor_builds_result);
$users_all_dor_build_query = "SELECT db_name,db_id FROM dormitory_builds ORDER BY db_id";
$users_all_dor_build_result = mysql_query($users_all_dor_build_query) or die ('SQL语句有误：' . mysql_error());
$users_all_dor_build = mysql_fetch_array($users_all_dor_build_result);

// 查询 该楼的所有宿舍号
$dor_build_select_name = $_GET['db_name_select'];
$dor_build_select_id = "1";
if (isset($dor_build_select_name)) {
    $dor_build_select_id = queryDorBuildIdByName($dor_build_select_name);
    $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='$dor_build_select_id'";
} else $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='{$users_all_dor_build['db_id']}'";
$dor_list_result = mysql_query($dor_list_query) or die ('SQL语句有误：' . mysql_error());
?>

    <!doctype html>
    <html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>新增宿舍</title>
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
        <link rel="stylesheet" href="assets/css/css_msgbox/msgBoxLight.css"/>
    </head>
    <body>
    <!--[if lte IE 9]>
    <p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/"
                                                                            target="_blank">升级浏览器</a>
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
                    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增宿舍</strong> /
                        <small>New Dormitory</small>
                    </div>
                </div>

                <hr/>

                <div class="am-g">
                    <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8"></div>

                    <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                        <form class="am-form am-form-horizontal" method="post" name="add">

                            <script>
                                function request(id) {
                                    // var data = {db_name_select: document.getElementById(id).value};
                                    var data = document.getElementById(id).value;
                                    window.location.href = "?r=dor-new" + "&db_name_select=" + data;

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
                                // var theurl;
                                // theurl = request("url");
                                // if (theurl != '') {
                                //     location = theurl
                                // }
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
                                        echo "<select name='user-dor-build' id='user-dor-build' disabled='disabled' onchange='request(this.id)'>";
                                    } else {
                                        echo "<select name='user-dor-build' id='user-dor-build' onchange='request(this.id)'>";
                                    }
                                    // 把 所有宿舍楼 遍历到数组中，输出
                                    while ($dor_builds = mysql_fetch_array($users_all_dor_builds_result)) {
                                        if ($dor_builds['db_name'] == 'C1') {
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
                                <label for="user-dor-exist" class="am-u-sm-3 am-form-label">已存在宿舍号</label>
                                <div class="am-u-sm-9">
                                    <?php
                                    // 判断 用户权限，是否可编辑
                                    if ($user_permission == -1) {
                                        echo "<select name='user-dor-exist' disabled='disabled'>";
                                    } else {
                                        echo "<select name='user-dor-exist'>";
                                    }
                                    // 把该宿舍楼的 所有宿舍号 遍历到数组中，输出
                                    while ($db_dor = mysql_fetch_array($dor_list_result)) {
                                        if ($db_dor['d_name'] == '101') {
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
                                <label for="user-dor-new" class="am-u-sm-3 am-form-label">新增宿舍</label>
                                <div class="am-u-sm-9">
                                    <input type="text" id="user-dor-new" name="user-dor-new"
                                           placeholder="请输入新增的宿舍号" <?php echo $permission_read ?>>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                    <input type="submit" name="add" value="确认添加"
                                           class="am-btn am-btn-primary" <?php if ($user_permission != -1) echo ""; else echo $permission_show ?>>
                                    <!--                                <input type="button" name="forget" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr" onclick="showErrorBox()">-->
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

    <script type='text/javascript' src='assets/js/js_msgbox/jquery.msgBox.js'></script>
    <script>
        msgBoxImagePath = "assets/i/img_msgbox/";

        function showErrorBox(content) {
            $.msgBox({
                title: "警告",
                content: content,
                type: "error",
                buttons: [{value: "OK"}],
                success: function (result) {
                    if (result === "OK") {
                        history.back();
                    }
                }
            });
            // $.MsgBox.Confirm("温馨提示", content, function () {
            //     history.back();
            // });
        }

        function showInfoBox(content, callback) {
            $.msgBox({
                title: "提示",
                content: content,
                type: "info",
                buttons: [{value: "OK"}],
                success: function (result) {
                    if (result === "OK") {
                        if (typeof (callback) === 'function') {
                            callback();
                        }
                    }
                }
            });
        }
    </script>
    </body>
    </html>
<?php
if ($add != "") {
    // 超管 和 普管权限
    if ($user_permission != -1) {
        if ($stu_dor == "") {
            echo "<script>showErrorBox('宿舍 不能为空！');</script>";
            exit ();
        } else {
            $isDorExist = queryIsDorExistByDorNameAndDorBuildId($stu_dor_build_id, $stu_dor);
            if ($isDorExist) {
                echo "<script>showErrorBox('宿舍已存在！');</script>";
                exit ();
            }
        }
        mysql_query("INSERT INTO dormitories (db_id, d_name, d_stu_num_now, d_bed_num) VALUES ($stu_dor_build_id, '$stu_dor', '0', '4')") or die ('SQL语句有误：' . mysql_error());
        echo "<script>showInfoBox('宿舍  $stu_dor_build $stu_dor 已添加！', function() { location.href='?r=list-dormitories&db_id=$dor_build_select_id';});</script>";
        exit ();
    }
}
?>