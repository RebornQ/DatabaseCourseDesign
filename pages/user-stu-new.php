<?php
require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';

$page_from = $_GET['from'];
//$edit_target = $_GET['edit_target'];
//$sno = $_GET['sno'];
//$uno = $_GET['uno'];

$permission_read = "true";
$permission_read = "readonly='$permission_read'";
// 判断用户权限，赋予不同的标签权限
if ($user_permission == -1) {
    header("Location: ?r=permission-denied");
    exit();
//        echo "<script>history.back()</script>";
} else {
    $permission_show = "style=\"display: none;\"";
    if ($user_permission == 0) {
        $permission_read = "";
    }
}

$add = $_POST['add'];
$u_no = $_POST['user-no'];
$u_name = $_POST['user-name'];
$u_password = $_POST['user-password'];
$u_password_repeat = $_POST['user-password-repeat'];
$stu_sex = $_POST['user-sex'];
$stu_age = $_POST['user-age'];
$stu_department = $_POST['user-department'];
$stu_grade = $_POST['user-grade'];
$stu_phone = $_POST['user-phone'];
//$stu_dor_build = $_POST['user-dor-build'];
$stu_dor_build = $_GET['db_name_select'];//修复当from=dorlist时，select的disable属性为disabled导致的$stu_dor_build为空，使得添加数据失败
$stu_dor = $_POST['user-dor'];
$stu_bed = $_POST['user-bed'];
$stu_dor_build_id = queryDorBuildIdByName($conn,$stu_dor_build);

// 查询 所有的宿舍楼名
$users_all_dor_builds_query = "SELECT db_name FROM dormitory_builds ORDER BY db_id";
$users_all_dor_builds_result = mysqli_query($conn,$users_all_dor_builds_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$users_all_dor_builds = mysqli_fetch_array($users_all_dor_builds_result);
$users_all_dor_build_query = "SELECT db_name,db_id FROM dormitory_builds ORDER BY db_id";
$users_all_dor_build_result = mysqli_query($conn,$users_all_dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
$users_all_dor_build = mysqli_fetch_array($users_all_dor_build_result);

// 查询 该楼的所有宿舍号
$dor_build_select_name = $_GET['db_name_select'];
$dor_build_select_id = "1";
if (isset($dor_build_select_name)) {
    $dor_build_select_id = queryDorBuildIdByName($conn,$dor_build_select_name);
    $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='$dor_build_select_id'";
} else $dor_list_query = "SELECT d_name FROM dormitories WHERE db_id='{$users_all_dor_build['db_id']}'";
$dor_list_result = mysqli_query($conn,$dor_list_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$dor_list = mysqli_fetch_array ($dor_list_result);
$dor_lists_query = "SELECT d_bed_num FROM dormitories WHERE db_id='{$users_all_dor_build['db_id']}'";
$dor_lists_result = mysqli_query($conn,$dor_lists_query) or die ('SQL语句有误：' . mysqli_error($conn));
$dor_list = mysqli_fetch_array($dor_lists_result);

//查询 目标宿舍楼该宿舍的id和床位数以及当前已入住人数
$dor_details_now = mysqli_fetch_array(mysqli_query($conn,"SELECT d_id,d_stu_num_now,d_bed_num FROM dormitories WHERE d_name='$stu_dor' AND db_id='$stu_dor_build_id'"));
// 查询 睡目标宿舍该床的同学的学号（判断是否已有人）
$result_bed_details_now = mysqli_query($conn,"SELECT s_no FROM students WHERE s_bed='$stu_bed' AND d_id='{$dor_details_now['d_id']}'");
//$bed_details_now = mysqli_fetch_array($result_bed_details_now);

//$stu_dor_id = queryDorIdByDorBuildIdAndDorName($conn,$stu_dor_build_id, $stu_dor);


?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增学生</title>
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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增学生</strong> /
                    <small>New Student</small>
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
                                window.location.href = "?r=user-stu-new" + "&db_name_select=" + data + "&from=<?php echo $page_from?>";

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
                                if ($user_permission == -1 || $page_from == "dorlist") {
                                    echo "<select name='user-dor-build' id='user-dor-build' disabled='disabled' onchange='request(this.id)'>";
                                } else {
                                    echo "<select name='user-dor-build' id='user-dor-build' onchange='request(this.id)'>";
                                }
                                // 把 所有宿舍楼 遍历到数组中，输出
                                while ($dor_builds = mysqli_fetch_array($users_all_dor_builds_result)) {
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
                                while ($db_dor = mysqli_fetch_array($dor_list_result)) {
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
                                for ($i = 1; $i <= $dor_list['d_bed_num']; $i++) {
                                    if ($i == '1') {
                                        echo "<option value='$i' selected='selected'>$i</option>";
                                    } else {
                                        echo "<option value='$i' >$i</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-no" class="am-u-sm-3 am-form-label">学号</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-no" name="user-no"
                                       placeholder="请输入你的学号" <?php echo $permission_read ?> value="">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">姓名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" name="user-name"
                                       placeholder="请输入你的姓名" <?php echo $permission_read ?>>
                                <small>输入你的名字，让我们记住你。</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-sex" class="am-u-sm-3 am-form-label">性别</label>
                            <div class="am-u-sm-9">
                                <select name="user-sex" <?php echo $permission_read ?>>
                                    <option value="">请选择 性别</option>
                                    <option value="男">男</option>
                                    <option value="女">女</option>
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-age" class="am-u-sm-3 am-form-label">年龄</label>
                            <div class="am-u-sm-9">
                                <input type="number" pattern="[0-9]*" id="user-age" name="user-age"
                                       placeholder="输入你的年龄" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-department" class="am-u-sm-3 am-form-label">所在院系</label>
                            <div class="am-u-sm-9">
                                <select name="user-department" data-placeholder="请选择学院" <?php echo $permission_read ?>>
                                    <option value="">你所在的院系</option>
                                    <option value="电气工程学院">电气工程学院</option>
                                    <option value="机械工程学院">机械工程学院</option>
                                    <option value="材料科学与工程学院">材料科学与工程学院</option>
                                    <option value="化工与环境学院">化工与环境学院</option>
                                    <option value="信息与通信工程学院">信息与通信工程学院</option>
                                    <option value="仪器与电子学院">仪器与电子学院</option>
                                    <option value="计算机工程学院">计算机工程学院</option>
                                    <option value="管理学院">管理学院</option>
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-grade" class="am-u-sm-3 am-form-label">年级</label>
                            <div class="am-u-sm-9">
                                <select name="user-grade" data-placeholder="请选择年级" <?php echo $permission_read ?>>
                                    <option value="">你所在的年级</option>
                                    <option value="大一">大一</option>
                                    <option value="大二">大二</option>
                                    <option value="大三">大三</option>
                                    <option value="大四">大四</option>
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">电话</label>
                            <div class="am-u-sm-9">
                                <input type="tel" id="user-phone" name="user-phone"
                                       placeholder="输入你的电话号码" <?php echo $permission_read ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-password" class="am-u-sm-3 am-form-label">登录密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password" name="user-password"
                                       placeholder="若修改密码，则直接输入你的登录密码；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-password-repeat" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-password-repeat" name="user-password-repeat"
                                       placeholder="若修改密码，则再次输入你的新密码；否则忽略该项不填">
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
/* 修改 信息 */
if ($add != "") {

    // 超管 和 普管权限
    if ($user_permission != -1) {
        $isUserExist = queryIsUserExistByNo($conn,$u_no);
        if ($u_no == "") {
//            echo "<script>alert('学号 不能为空！');history.back()</script>";
            echo "<script>showErrorBox('学号 不能为空！');</script>";
            exit ();
        } else if ($isUserExist) {
            echo "<script>showErrorBox('用户已存在！');</script>";
            exit ();
        }
        if ($u_name == "") {
            echo "<script>showErrorBox('姓名 不能为空！');</script>";
            exit ();
        }
        if ($stu_sex == "") {
            echo "<script>showErrorBox('性别 不能为空！');</script>";
            exit ();
        }
        if ($stu_age == "") {
            echo "<script>showErrorBox('年龄 不能为空！');</script>";
            exit ();
        }
        if ($stu_department == "") {
            echo "<script>showErrorBox('所在院系 不能为空！');</script>";
            exit ();
        }
        if ($stu_grade == "") {
            echo "<script>showErrorBox('年级 不能为空！');</script>";
            exit ();
        }
        if ($stu_phone == "") {
            echo "<script>showErrorBox('电话 不能为空！');</script>";
            exit ();
        }

        // 设置密码
        if ($u_password != "" && $u_password_repeat != "") {
            if ($u_password != $u_password_repeat) {
                echo "<script>showErrorBox('两次输入密码不一致！请重新输入！');</script>";
                exit ();
            }
            if ($user_permission != -1) {
                $u_password_md5 = md5($u_password);
                if (mysqli_num_rows($result_bed_details_now) != 0) {// 若存在，即床已有人睡，则与学生间互换宿舍
                    echo "<script>showErrorBox('该宿舍床位已有人，请重新选择！');</script>";
//                    echo "<script>alert('该宿舍床位已有人，请重新选择！');history.back()</script>";
                    exit ();
                } else {
//                    echo "<script>showInfoBox('$stu_dor_build',null);</script>";
                    mysqli_query($conn,"INSERT INTO students (s_no,s_sex,s_age,s_department,s_grade,s_phone,d_id,s_bed) VALUE ($u_no, '$stu_sex', $stu_age, '$stu_department', '$stu_grade', '$stu_phone', {$dor_details_now['d_id']}, $stu_bed)") or die ('SQL语句有误：' . mysqli_error($conn));
                    mysqli_query($conn,"INSERT INTO users (u_no, u_name, u_permission, u_password) VALUES ($u_no, '$u_name', '-1', '$u_password_md5')") or die ('SQL语句有误：' . mysqli_error($conn));
                    $num_now_temp = $dor_details_now ['d_stu_num_now'] + 1;
                    mysqli_query($conn,"UPDATE dormitories SET d_stu_num_now='$num_now_temp' WHERE d_id='{$dor_details_now['d_id']}'") or die ('SQL语句有误：' . mysqli_error($conn));
                    echo "<script>showInfoBox('学号 $u_no 已添加！', function() { location.href='?r=list-dormitories&db_id=$dor_build_select_id';});</script>";
                    exit ();
                }
            }
        } else {
            echo "<script>showErrorBox('密码不能为空！请重新输入密码！');</script>";
            exit ();
        }
    }
}
?>
