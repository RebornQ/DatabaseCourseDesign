<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 20:32
 */

//查询超级管理员记录
$super_admin_query = "SELECT * FROM users WHERE u_permission=0 ORDER BY u_id DESC";
$super_admin_result = mysql_query ( $super_admin_query ) or die ( 'SQL语句有误：' . mysql_error () );
$super_admins_count = mysql_num_rows ( $super_admin_result );

//查询普通管理员记录
$normal_admin_query = "SELECT * FROM users WHERE u_permission=1 ORDER BY u_id DESC";
$normal_admin_result = mysql_query ( $normal_admin_query ) or die ( 'SQL语句有误：' . mysql_error () );
$normal_admins_count = mysql_num_rows ( $normal_admin_result );

// 查询所有学生记录
$student_query = "SELECT * FROM users WHERE u_permission=-1 ORDER BY u_id DESC";
$student_result = mysql_query ( $student_query ) or die ( 'SQL语句有误：' . mysql_error () );
$students_count = mysql_num_rows ( $result );

?>
<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">

        <ul class="am-list admin-sidebar-list">
            <li><a href="../pages/index.php"><span class="am-icon-home"></span> 首页</a></li>
            <li><a href="../pages/user.php" class="am-cf"><span class="am-icon-check"></span> 个人资料<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#object-nav'}"><span class="am-icon-user-secret"></span> 对象管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="object-nav">
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> 超管<span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $super_admins_count?></span></a></li>
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> 宿管<span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $normal_admins_count?></span></a></li>
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> 学生<span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $students_count?></span></a></li>
                </ul>
            </li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#dormitory-nav'}"><span class="am-icon-calendar"></span> 宿舍管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="dormitory-nav">
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> C18<span class="am-badge am-badge-secondary am-margin-right am-fr">3</span></a></li>
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> C19<span class="am-badge am-badge-secondary am-margin-right am-fr">2</span></a></li>
                    <li><a href="../pages/404.php"><span class="am-icon-table"></span> C21<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>
                </ul>
            </li>
            <li><a href="../pages/outlogin.php"><span class="am-icon-sign-out"></span> 注销</a></li>
        </ul>

        <div class="am-panel am-panel-default admin-sidebar-panel">
            <div class="am-panel-bd">
                <p><span class="am-icon-bookmark"></span> 公告</p>
                <p>时光静好，与君语；细水流年，与君同。—— 来自最爱你们的宿管</p>
            </div>
        </div>
<!--        <div class="am-panel am-panel-default admin-sidebar-panel">-->
<!--            <div class="am-panel-bd">-->
<!--                <p><span class="am-icon-tag"></span> wiki</p>-->
<!--                <p>Welcome to the Amaze UI wiki!</p>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
