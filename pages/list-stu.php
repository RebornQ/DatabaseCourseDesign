<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 17:33
 */


//Todo Add: 1.(批量)删除

require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';
include 'tools/tool_database.php';

////修复Permission为-1或1时?r=list-stu仍可访问的问题
//if ($user_permission != 0) {
//    header("Location: ?r=permission-denied");
//}

// 分页：http://www.runoob.com/w3cnote/php-mysql-pagination.html
$num_rec_per_page = 10;   // 每页显示数量
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $num_rec_per_page;

// 分页查询学生记录
$stu_query_page = "SELECT students.*,users.u_name FROM students,users WHERE s_no=u_no AND u_permission=-1 ORDER BY s_no LIMIT {$start_from}, {$num_rec_per_page}";// 检索记录行 $start_from - ($start_from+15)

// 搜索：https://segmentfault.com/a/1190000008063719 <-- mysql模糊查询LIKE
// mysql条件查询and or使用实例：http://www.manongjc.com/article/1439.html
$isSearch = $_GET['issearch'];
$keywords = $_POST['keywords'];
if ($isSearch == 'true' && $keywords != "") {
    $stu_query_page = "SELECT students.*,users.u_name FROM students,users WHERE s_no=u_no AND u_permission=-1 AND (s_no LIKE '%$keywords%' OR u_name LIKE '%$keywords%') ORDER BY s_no LIMIT {$start_from}, {$num_rec_per_page}";
}

$stu_result_page = mysql_query($stu_query_page) or die ('SQL语句有误：' . mysql_error());
$stu_count_page = mysql_num_rows($stu_result_page);
?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if ($isSearch == 'true') echo '搜索结果'; else echo '学生列表'; ?></title>
    <meta name="description" content="这是一个 table 页面">
    <meta name="keywords" content="table">
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
                <div class="am-fl am-cf"><strong
                            class="am-text-primary am-text-lg"><?php if ($isSearch == 'true') echo '搜索结果'; else echo '学生列表'; ?></strong>
                    /
                    <small><?php if ($isSearch == 'true') echo 'Search Results'; else echo 'Students'; ?></small>
                </div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6" <?php if ($user_permission != 0) echo 'style="display: none;"' ?>>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button id="bt_add_stu" type="button" class="am-btn am-btn-default"><span
                                        class="am-icon-plus"></span> 新增学生
                            </button>
                            </button>
                            <button id="bt_del" type="button" class="am-btn am-btn-default"><span
                                        class="am-icon-trash-o"></span>
                                批量删除
                            </button>
                        </div>
                    </div>
                </div>

                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" id="search-keywords" placeholder="请输入学号或姓名">
                        <span class="am-input-group-btn"><button class="am-btn am-btn-default" type="button" id="bt_search">搜索</button></span>
                    </div>
                </div>
            </div>

            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-check"><input type="checkbox"/></th>
                                <th class="table-id">学号</th>
                                <th class="table-author am-hide-sm-only">姓名</th>
                                <th>性别</th>
                                <th>年龄</th>
                                <th>所在院系</th>
                                <th>年级</th>
                                <th>电话</th>
                                <th>宿舍楼</th>
                                <th>宿舍号</th>
                                <th>床号</th>
                                <th class="table-set">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--遍历学生-->
                            <?php
                            // 结果集遍历到数组
                            while ($students = mysql_fetch_array($stu_result_page)) {
                                ?>
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <!--                                <td>-->
                                    <?php //echo $students['s_id']?><!--</td>-->
                                    <td><?php echo $students['s_no'] ?></td>
                                    <td>
                                        <a href="?r=user-stu&sno=<?php echo $students['s_no'] ?>&edit_target=<?php if ($students['s_no'] == $user_no) echo "self"; else echo "others"; ?>"><?php echo $students['u_name'] ?></a>
                                    </td>
                                    <td><?php echo $students['s_sex'] ?></td>
                                    <td><?php echo $students['s_age'] ?></td>
                                    <td>
                                        <span class="am-badge am-badge-success"><?php echo $students['s_department'] ?></span>
                                    </td>
                                    <td><?php echo $students['s_grade'] ?></td>
                                    <td><?php echo $students['s_phone'] ?></td>
                                    <?php
                                    // 查询 当前学生所在的宿舍楼名
                                    $user_stu_current_dor_build_query = "SELECT dormitory_builds.db_name, dormitory_builds.db_id FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$students['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
                                    $user_stu_current_dor_build_result = mysql_query($user_stu_current_dor_build_query) or die ('SQL语句有误：' . mysql_error());
                                    $user_stu_current_dor_build = mysql_fetch_array($user_stu_current_dor_build_result);
                                    // 查询 当前学生所在的宿舍号
                                    $users_stu_current_dor_query = "SELECT * FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$students['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
                                    $users_stu_current_dor_result = mysql_query($users_stu_current_dor_query) or die ('SQL语句有误：' . mysql_error());
                                    $users_stu_current_dor = mysql_fetch_array($users_stu_current_dor_result);
                                    ?>
                                    <td>
                                        <span class="am-badge am-badge-secondary"><?php echo $user_stu_current_dor_build['db_name'] ?></span>
                                    </td>
                                    <td><?php echo $users_stu_current_dor['d_name'] ?></td>
                                    <td><?php echo $students['s_bed'] ?></td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                                        type="button"
                                                        onclick="location.href='?r=user-stu&sno=<?php echo $students['s_no'] ?>&edit_target=<?php if ($students['s_no'] == $user_no) echo "self"; else echo "others"; ?>'">
                                                    <span class="am-icon-pencil-square-o"></span> <?php if ($students['s_no'] == $user_no || $user_permission == 0 || $user_permission == 1) echo "编辑"; else echo "查看"; ?>
                                                </button>
                                                <a href="?r=user-delete&delete_no=<?php echo $students['s_no'] ?>&isdelete=true&from=list-stu">
                                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger"
                                                            type="button" <?php if ($user_permission != 0) echo 'style="display: none;"' ?>
                                                            onclick="return confirm('删除后无法恢复数据，是否继续？');">
                                                        <span class="am-icon-trash-o"></span> 删除
                                                    </button>
                                                </a>
                                                <!--am-hide-sm-only属性会使display:none失效-->
                                                <!--<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"-->
                                                <!--type="button" -->
                                                <!--onclick="location.href='#'">-->
                                                <!--<span class="am-icon-trash-o"></span> 删除-->
                                                <!--</button>-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="am-cf">
                            共 <?php echo $students_count ?> 条记录
                            <?php
                            if ($start_from + $num_rec_per_page > $students_count) {
                                echo "本页从 $start_from - $students_count 条记录";
                            } else {
                                $end_with = $start_from + $num_rec_per_page;
                                echo "本页从 $start_from - $end_with 条记录";
                            }
                            ?>
                            <!-- 本页从 --><?php //echo $start_from ?><!-- - -->
                            <?php //echo $start_from + $num_rec_per_page ?><!-- 条记录-->
                            <div class="am-fr">
                                <ul class="am-pagination">
                                    <?php
                                    $total_records = $students_count;  // 统计总共的记录条数
                                    $total_pages = ceil($total_records / $num_rec_per_page);  // 计算总页数
                                    if ($isSearch == 'true' && $keywords != "") {
                                        echo "<li><a href='?r=list-stu&issearch=true&page=1'>" . '|<' . "</a></li>"; // 第一页搜索结果
                                        $page_forward = $page - 1;
                                        if ($page_forward > 0) {
                                            echo "<li><a href='?r=list-stu&issearch=true&page=$page_forward'>«</a></li>";
                                        } else {
                                            echo "<li class=\"am-disabled\"><a href='?r=list-stu&issearch=true&page=$page_forward'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            $page_current = "page_current$i";
                                            echo "<li id='$page_current'><a href='?r=list-stu&issearch=true&page=" . $i . "'>" . $i . "</a></li> ";
                                            if ($page == $i) {
                                                echo "<script>document.getElementById('page_current$i').className='am-active'</script>";
                                            }
                                        };
                                        $page_next = $page + 1;
                                        if ($page_next <= $total_pages) {
                                            echo "<li><a href='?r=list-stu&issearch=true&page={$page_next}'>»</a></li>";
                                        } else {
                                            echo "<li class=\"am-disabled\"><a href='?r=list-stu&issearch=true&page=$page_next'>»</a></li>";
                                        }
                                        echo "<li><a href='?r=list-stu&issearch=true&page=$total_pages'>" . '>|' . "</li> "; // 最后一页搜索结果
                                    } else {
                                        echo "<li><a href='?r=list-stu&page=1'>" . '|<' . "</a></li>"; // 第一页
                                        $page_forward = $page - 1;
                                        if ($page_forward > 0) {
                                            echo "<li><a href='?r=list-stu&page=$page_forward'>«</a></li>";
                                        } else {
                                            echo "<li class=\"am-disabled\"><a href='?r=list-stu&page=$page_forward'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            $page_current = "page_current$i";
                                            echo "<li id='$page_current'><a href='?r=list-stu&page=" . $i . "'>" . $i . "</a></li> ";
                                            if ($page == $i) {
                                                echo "<script>document.getElementById('page_current$i').className='am-active'</script>";
                                            }
                                        };
                                        $page_next = $page + 1;
                                        if ($page_next <= $total_pages) {
                                            echo "<li><a href='?r=list-stu&page={$page_next}'>»</a></li>";
                                        } else {
                                            echo "<li class=\"am-disabled\"><a href='?r=list-stu&page=$page_next'>»</a></li>";
                                        }
                                        echo "<li><a href='?r=list-stu&page=$total_pages'>" . '>|' . "</li> "; // 最后一页
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                        <hr/>
                        <p><a>注：.....</a></p>
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
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->

<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>

<script type="text/javascript">

    // js模拟表单post方式提交：https://blog.csdn.net/Inuyasha1121/article/details/40888831
    function postCall( url, params, target){
        var tempform = document.createElement("form");
        tempform.action = url;
        tempform.method = "post";
        tempform.style.display="none"
        if(target) {
            tempform.target = target;
        }

        for (var x in params) {
            var opt = document.createElement("input");
            opt.name = x;
            opt.value = params[x];
            tempform.appendChild(opt);
        }

        var opt = document.createElement("input");
        opt.type = "submit";
        tempform.appendChild(opt);
        document.body.appendChild(tempform);
        tempform.submit();
        document.body.removeChild(tempform);
    }

    $(function () {
        $("#bt_add_stu").click(function () {
            window.location.href = '?r=user-stu-new&db_name_select=C1&from=stulist';
        });
        $("#bt_del").click(function () {
            //window.location.href = '?r=user-delete&delete_no=<?php //echo $students['s_no'] ?>//&isdelete=true&from=index';
        });
        $("#bt_search").click(function(){
            var keyword = $("#search-keywords").val();
            postCall('?r=list-stu&issearch=true', {keywords : keyword });
        });
    });
</script>
</body>
</html>