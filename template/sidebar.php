<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 20:32
 */

//查询超级管理员记录
$super_admin_query = "SELECT * FROM users WHERE u_permission=0 ORDER BY u_id DESC";
$super_admin_result = mysqli_query($conn,$super_admin_query) or die ('SQL语句有误：' . mysqli_error($conn));
$super_admins_count = mysqli_num_rows($super_admin_result);

//查询普通管理员记录
$normal_admin_query = "SELECT * FROM users WHERE u_permission=1 ORDER BY u_id DESC";
$normal_admin_result = mysqli_query($conn,$normal_admin_query) or die ('SQL语句有误：' . mysqli_error($conn));
$normal_admins_count = mysqli_num_rows($normal_admin_result);

// 查询所有学生记录
$student_query = "SELECT * FROM users WHERE u_permission=-1 ORDER BY u_id DESC";
$student_result = mysqli_query($conn,$student_query) or die ('SQL语句有误：' . mysqli_error($conn));
$students_count = mysqli_num_rows($student_result);

//查询所有宿舍楼记录
$dormitory_builds_query = "SELECT * FROM dormitory_builds ORDER BY db_id ";
$dormitory_builds_result = mysqli_query($conn,$dormitory_builds_query) or die ('SQL语句有误：' . mysqli_error($conn));
$dormitory_builds_count = mysqli_num_rows($dormitory_builds_result);

//查询所有宿舍记录
$dormitories_query = "SELECT * FROM dormitories ORDER BY db_id ";
$dormitories_result = mysqli_query($conn,$dormitories_query) or die ('SQL语句有误：' . mysqli_error($conn));
$dormitories_count = mysqli_num_rows($dormitories_result);

?>
<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">

        <ul class="am-list admin-sidebar-list">
            <li><a href="?r=index"><span class="am-icon-home"></span> 首页</a></li>
            <?php
            // 判断 用户权限，以设置显示的不同页面
            switch ($user_permission) {
                case 0 :
                    $data_href = "?r=user-admin-super&uno={$users['u_no']}";
                    break;
                case 1 :
                    $data_href = "?r=user-admin-normal&uno={$users['u_no']}&edit_target=self";
                    break;
                case -1 :
                    $data_href = "?r=user-stu&sno={$users['u_no']}&edit_target=self";
                    break;
            }
            ?>
            <li><a href="<?php echo $data_href ?>" class="am-cf"><span class="am-icon-check"></span> 个人资料<span
                            class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#object-nav'}"><span class="am-icon-user-secret"></span>
                    对象管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="object-nav">
                    <li <?php if ($user_permission == -1 || $user_permission == 1) echo 'style="display: none;"' ?>><a
                                href="?r=list-admin-super"><span class="am-icon-table"></span> 超管<span
                                    class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $super_admins_count ?></span></a>
                    </li>
                    <li <?php if ($user_permission == -1 || $user_permission == 1) echo 'style="display: none;"' ?>><a
                                href="?r=list-admin-normal"><span class="am-icon-table"></span> 普管<span
                                    class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $normal_admins_count ?></span></a>
                    </li>
                    <li><a href="?r=list-stu"><span class="am-icon-table"></span> 学生<span
                                    class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $students_count ?></span></a>
                    </li>
                </ul>
            </li>
            <li <?php if ($user_permission != -1) echo 'style="display: none;"' ?>>
                <a href="?r=list-dormitories&db_id=<?php $db = mysqli_fetch_array(mysqli_query($conn,"SELECT db_id FROM dormitories WHERE d_id=(SELECT d_id FROM students WHERE s_no=$user_no) ORDER BY d_id"));  echo $db['db_id']?>" class="am-cf"><span
                            class="am-icon-file"></span> 我的宿舍<span
                            class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a>
            </li>
            <li class="admin-parent" <?php if ($user_permission == -1) echo 'style="display: none;"' ?>>
                <a class="am-cf" data-am-collapse="{target: '#dormitory-nav'}"><span class="am-icon-calendar"></span>
                    宿舍管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="dormitory-nav">
                    <!--<li><a href="?r=404"><span class="am-icon-table"></span> C18<span-->
                    <!--     class="am-badge am-badge-secondary am-margin-right am-fr">3</span></a></li>-->
                    <!-- <li><a href="?r=404"><span class="am-icon-table"></span> C19<span-->
                    <!--遍历宿舍楼-->
                    <?php
                    // 结果集遍历到数组
                    while ($dormitory_builds = mysqli_fetch_array($dormitory_builds_result)) {
                        ?>
                        <li><a href="?r=list-dormitories&db_id=<?php echo $dormitory_builds['db_id'] ?>"><span
                                        class="am-icon-table"></span> <?php echo $dormitory_builds['db_name'] ?>
                                <span
                                        class="am-badge am-badge-secondary am-margin-right am-fr">共<?php echo mysqli_num_rows(mysqli_query($conn,"SELECT dormitories.db_id FROM dormitories WHERE db_id={$dormitory_builds['db_id']} ORDER BY db_id ")) ?>
                                    个宿舍</span></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li><a href="?r=outlogin"><span class="am-icon-sign-out"></span> 注销</a></li>
        </ul>

        <div class="am-panel am-panel-default admin-sidebar-panel">
            <div class="am-panel-bd">
                <p><span class="am-icon-bookmark"></span> 公告</p>
                <p>时光静好，与君语；细水流年，与君同。—— 来自最爱你们的Seal</p>
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
