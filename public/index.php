<?php
//composer的自动载入  可以实现自动载入文件
$str=include '../vendor/autoload.php';

//调用框架启动类的run方法
// 实现单入口调用控制整个网站/便于维护和管理

//导入类\houdunwang\core\
//实际就是相当于加载了这个../houdouwang/core/Boot.php 文件
//在调用对象 Boot类 静态 run()方法
\houdunwang\core\Boot::run();
//print_r($str);
//echo 123;