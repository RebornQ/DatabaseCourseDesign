<?php
/**
 * Created by PhpStorm.
 * User: seal
 * Date: 2018/5/21
 * Time: 17:33
 */

error_reporting ( 0 ); // 关闭错误显示
if ($_REQUEST['login']) {
    header("Content-Type: text/html; charset=utf8");
//    if (!isset($_POST["submit"])) {
//        exit("错误执行");
//    }//检测是否有submit操作
//    session_start();
    include('inc/connect.php');//链接数据库
    if(isset($_COOKIE['user'])!="")
    {
        header("Location: ?r=index");
        exit;
    }
    $u_no = $_POST['u_no'];//post获得用户名表单值
    $u_passowrd = $_POST['u_password'];//post获得用户密码单值
    $u_passowrd = md5($u_passowrd);

    if ($u_no && $u_passowrd) {//如果用户名和密码都不为空
        $query = "SELECT * FROM users WHERE u_no = '$u_no' AND u_password='$u_passowrd'";//检测数据库是否有对应的username和password的sql
//        $query = "SELECT u_no,u_password u_password FROM admin WHERE a_no='$admin_no'";
        $result = mysqli_query($conn,$query) or die ( 'SQL语句有误：' . mysqli_error ($conn));//执行sql
        $rows = mysqli_num_rows($result);//返回一个数值
        //todo 要对rows做判断再执行下面
        $users = mysqli_fetch_array ( $result );
        $user_permission = $users['u_permission'];
        if ($rows) {//0 false 1 true
            // 把当前登录的用户号存到cookie中
            setcookie ( 'user_permission', $user_permission, 0, '/' );
            setcookie ( 'user', $u_no, 0, '/' );
            header("Location: ?r=index");
//            header("refresh:0;url=welcome.php");//如果成功跳转至welcome.html页面
            exit;
        } else {
            echo "<Script language=JavaScript>alert('用户名或密码错误!');history.back();</Script>";
        }
    } else {//如果用户名或密码有空
        echo "<Script language=JavaScript>alert('表单填写不完整!');history.back();</Script>";
    }
    mysqli_close();//关闭数据库
} else if ($_REQUEST['forget']) {
//    echo "Forget Password";
    echo "<Script language=JavaScript>alert('尚未开通此功能！请耐心等待！');history.back();</Script>";
}
?>

<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>用户登录</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>宿舍管理系统</h1>
<!--    <p>Integrated Development Environment<br/>代码编辑，代码生成，界面设计，调试，编译</p>-->
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h3>登录</h3>
    <hr>
    <div class="am-btn-group">
      <a href="#" class="am-btn am-btn-secondary am-btn-sm"><i class="am-icon-github am-icon-sm"></i> Github</a>
    </div>
    <br>
    <br>

    <form method="post" class="am-form" action="?r=login" name="login">
      <label for="u_no">用户名:</label>
      <input type="text" name="u_no" id="u_no" placeholder="请输入管理员号/楼管编号/学号" value="">
      <br>
      <label for="u_password">密码:</label>
      <input type="password" name="u_password" id="u_password" placeholder="请输入密码" value="">
      <br>
      <label for="remember-me">
        <input id="remember-me" type="checkbox">
        记住密码
      </label>
      <br />
      <div class="am-cf">
        <input type="submit" name="login" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
        <input type="submit" name="forget" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">
      </div>
    </form>
    <hr>
    <footer class="template_footer">
      <?php require 'template/footer.php';?>
    </footer>
  </div>
</div>
</body>
</html>