<?php
require 'inc/connect.php';//链接数据库
require 'inc/checklogin.php';

// 查询最新 15 条学生记录
$query = "SELECT students.*,users.u_name FROM students,users WHERE s_no=u_no AND u_permission=-1 ORDER BY s_id DESC LIMIT 15";
$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );

?>

<!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>首页</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
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
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> /
                    <small>最新消息</small>
                </div>
            </div>

            <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
                <li><a href="#" class="am-text-success"><span
                                class="am-icon-btn am-icon-user-md"></span><br/>超级管理员<br/><?php echo $super_admins_count?></a></li>
                <li><a href="#" class="am-text-warning"><span
                                class="am-icon-btn am-icon-user-md"></span><br/>普通管理员<br/><?php echo $normal_admins_count?></a></li>
                <li><a href="#" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>宿舍楼<br/>19</a>
                </li>
                <li><a href="#" class="am-text-secondary"><span
                                class="am-icon-btn am-icon-users"></span><br/>学生<br/><?php echo $students_count?></a></li>
            </ul>

            <div class="am-g">
                <div class="am-u-sm-12" <?php if ($user_permission == -1) echo 'style="display: none;"' ?>>
                    <table class="am-table am-table-bd am-table-striped admin-content-table">
                        <thead>
                        <tr>
<!--                            <th>ID</th>-->
                            <th>学号</th>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>年龄</th>
                            <th>所在院系</th>
                            <th>年级</th>
                            <th>电话</th>
                            <th>宿舍号</th>
                            <th>床号</th>
                        </tr>
                        </thead>
                        <tbody>

                        <!--遍历超级管理员-->
                        <?php
                        // 结果集遍历到数组
                        while ( $super_admins = mysql_fetch_array ( $super_admin_result ) ) {
                            ?>
                            <tr>
<!--                                <td>--><?php //echo $super_admins['u_id']?><!--</td>-->
                                <td><?php echo $super_admins['u_no']?></td>
                                <td><a href="#"><?php echo $super_admins['u_name']?></a></td>
                            </tr>
                        <?php }?>

                        <!--遍历普通管理员-->
                        <?php
                        // 结果集遍历到数组
                        while ( $normal_admins = mysql_fetch_array ( $normal_admin_result ) ) {
                            ?>
                            <tr>
                                <!--                                <td>--><?php //echo $normal_admins['u_id']?><!--</td>-->
                                <td><?php echo $normal_admins['u_no']?></td>
                                <td><a href="#"><?php echo $normal_admins['u_name']?></a></td>
                            </tr>
                        <?php }?>

                        <!--遍历学生-->
                        <?php
                        // 结果集遍历到数组
                        while ( $students = mysql_fetch_array ( $result ) ) {
                            ?>
                            <tr>
<!--                                <td>--><?php //echo $students['s_id']?><!--</td>-->
                                <td><?php echo $students['s_no']?></td>
                                <td><a href="?r=user-stu&sno=<?php echo $students['s_no']?>"><?php echo $students['u_name']?></a></td>
                                <td><?php echo $students['s_sex']?></td>
                                <td><?php echo $students['s_age']?></td>
                                <td><span class="am-badge am-badge-success"><?php echo $students['s_department']?></span></td>
                                <td><?php echo $students['s_grade']?></td>
                                <td><?php echo $students['s_phone']?></td>
                                <td><?php echo $students['d_id']?></td>
                                <td><?php echo $students['s_bed']?></td>
<!--                                --><?php
//                                // 查询 楼名 信息
//                                $query_db_name = "SELECT db_name FROM dor_build WHERE db_no =ANY(SELECT db_no FROM dor WHERE d_id='{$students['d_id']}')";
//                                $result_db_name = mysql_query ( $query_db_name ) or die ( 'SQL语句有误：' . mysql_error () );
//                                $db_names = mysql_fetch_array ( $result_db_name );
//                                ?>
<!--                                <td><span class="am-badge am-badge-secondary">--><?php //echo $db_names['db_name']?><!--</span></td>-->
<!--                                --><?php
//                                // 查询 宿舍 信息
//                                $query_d_no = "SELECT d_no FROM dor WHERE d_id='{$students['d_id']}'";
//                                $result_d_no = mysql_query ( $query_d_no );
//                                $d_no = mysql_fetch_array ( $result_d_no );
//                                ?>
<!--                                <td>--><?php //echo $d_no['d_no']?><!--</td>-->
<!--                                <td>--><?php //echo $students['s_bed']?><!--</td>-->
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
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
