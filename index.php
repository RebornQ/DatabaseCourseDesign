<?php
// 单一入口模式
error_reporting(0); // 关闭错误显示
//$file = addslashes ( $_GET ['r'] ); // 接收文件名
//$action = $file == '' ? 'index' : $file; // 判断为空或者等于index

$action = $_GET['r'] == '' ? 'index' : $_GET['r']; //从url中取出action参数，如果没有提供action参数，就设置一个默认的'index'作为参数
include('pages/' . $action . '.php'); // 载入相应文件, 根据$action参数调用不同的代码文件，从而满足单一入口实现对应的不同的功能。