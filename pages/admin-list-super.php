<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 17:33
 */


//Todo Add:1.搜索 2.新增 4.批量删除

require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';

////修复Permission为-1或1时?r=admin-list-super仍可访问的问题
//if ($user_permission != 0) {
//    header("Location: ?r=permission-denied");
//}


//分页：http://www.runoob.com/w3cnote/php-mysql-pagination.html
$num_rec_per_page = 10;   // 每页显示数量
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $num_rec_per_page;

//分页查询超级管理员记录
$super_admin_query_page = "SELECT * FROM users WHERE u_permission=0 ORDER BY u_id LIMIT {$start_from}, {$num_rec_per_page}";// 检索记录行 $start_from - ($start_from+15)
$super_admin_result_page = mysql_query($super_admin_query_page) or die ('SQL语句有误：' . mysql_error());
$super_admins_count_page = mysql_num_rows($super_admin_result_page);

?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>超级管理员列表</title>
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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">超级管理员列表</strong> /
                    <small>Super Admins</small>
                </div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6" <?php if ($user_permission != 0) echo 'style="display: none;"' ?>>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增
                            </button>
                            </button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span>
                                批量删除
                            </button>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field">
                        <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
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
                                <th class="table-id">编号</th>
                                <th class="table-author am-hide-sm-only">姓名</th>
                                <th class="table-set" <?php if ($user_permission != 0) echo 'style="display: none;"' ?>>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--遍历超级管理员-->
                            <?php
                            // 结果集遍历到数组
                            while ($super_admins = mysql_fetch_array($super_admin_result_page)) {
                                ?>
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td><?php echo $super_admins['u_no'] ?></td>
                                    <td class="am-hide-sm-only"><a
                                                href="?r=user-admin-super&uno=<?php echo $super_admins['u_no'] ?>"><?php echo $super_admins['u_name'] ?></a>
                                    </td>
                                    <td <?php if ($user_permission != 0) echo 'style="display: none;"' ?>>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                                        type="button"
                                                        onclick="location.href='?r=user-admin-super&uno=<?php echo $super_admins['u_no'] ?>'"><span
                                                            class="am-icon-pencil-square-o"></span>
                                                    编辑
                                                </button>
                                                <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                    <span class="am-icon-trash-o"></span> 删除
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="am-cf">
                            共 <?php echo $super_admins_count ?> 条记录
                            <?php
                            if ($start_from + $num_rec_per_page > $super_admins_count) {
                                echo "本页从 $start_from - $super_admins_count 条记录";
                            } else {
                                $end_with = $start_from + $num_rec_per_page;
                                echo "本页从 $start_from - $end_with 条记录";
                            }
                            ?>
                            <!-- 本页从 --><?php //echo $start_from ?><!-- - --><?php //echo $start_from + $num_rec_per_page ?><!-- 条记录-->
                            <div class="am-fr">
                                <ul class="am-pagination">
                                    <?php
                                    $total_records = $super_admins_count;  // 统计总共的记录条数
                                    $total_pages = ceil($total_records / $num_rec_per_page);  // 计算总页数
                                    echo "<li><a href='?r=admin-list-super&page=1'>" . '|<' . "</a></li>"; // 第一页
                                    $page_forward = $page - 1;
                                    if ($page_forward > 0) {
                                        echo "<li><a href='?r=admin-list-super&page=$page_forward'>«</a></li>";
                                    } else {
                                        echo "<li class=\"am-disabled\"><a href='?r=admin-list-super&page=$page_forward'>«</a></li>";
                                    }
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $page_current = "page_current$i";
                                        echo "<li id='$page_current'><a href='?r=admin-list-super&page=" . $i . "'>" . $i . "</a></li> ";
                                        if ($page == $i) {
                                            echo "<script>document.getElementById('page_current$i').className='am-active'</script>";
                                        }
                                    };
                                    $page_next = $page + 1;
                                    if ($page_next <= $total_pages) {
                                        echo "<li><a href='?r=admin-list-super&page={$page_next}'>»</a></li>";
                                    } else {
                                        echo "<li class=\"am-disabled\"><a href='?r=admin-list-super&page=$page_next'>»</a></li>";
                                    }
                                    echo "<li><a href='?r=admin-list-super&page=$total_pages'>" . '>|' . "</li> "; // 最后一页
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <hr/>
                        <p>注：.....</p>
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
</body>
</html>
