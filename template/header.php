<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 19:57
 */
?>
<!--<link rel="stylesheet" href="../assets/css/amazeui.min.css"/>-->
<div class="am-topbar-brand">
    <strong>Seal</strong>
    <small>宿舍管理系统后台</small>
</div>

<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
        data-am-collapse="{target: '#topbar-collapse'}">
    <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span>
</button>
<div class="am-collapse am-topbar-collapse" id="topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
        <li class="am-dropdown" data-am-dropdown>
            <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                <span class="am-icon-users"></span> <?php echo $username ?> <span class="am-icon-caret-down"></span>
            </a>
            <ul class="am-dropdown-content">
                <?php
                // 判断 用户权限，以设置显示的不同页面
                switch ($user_permission) {
                    case 0 :
                        $data_href = "?r=user-admin_super&uno={$users['u_no']}";
                        break;
                    case 1 :
                        $data_href = "?r=user-admin_normal&uno={$users['u_no']}";
                        break;
                    case -1 :
                        $data_href = "?r=user-stu&uno={$users['u_no']}&edit_target=self";
                        break;
                }
                ?>
                <li><a href='<?php echo $data_href?>'><span class="am-icon-user"></span> 资料</a></li>
                <li><a href="?r=outlogin"><span class="am-icon-power-off"></span> 退出</a></li>
            </ul>
        </li>
        <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
</div>