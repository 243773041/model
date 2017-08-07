<?php

/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/7/30
 * Time: 17:27
 */

//设置命名空间

//用于其他php文件页面加载这个php文件

namespace houdunwang\core;

//框架启动类

class Boot{

//     设置一个方法管理初始化  执行应用
    public static function run(){

        //注册错误处理
        self::handleError();
//        echo 'run test';
//        初始化框架
//        静态调用init()方法 开启session  设置时区 定义是否POST提交的常量
        self::init();
//        执行应用      控制器 应用启动
//         静态调用  appRun()方法  进行类名导入
//       执行了这个操作 new app\home\controller\Entry index()
//        加载了../app/home/controller/Entry.php 文件
//          实例化话对象Entry类   调用了  index()方法
        self::appRun();



    }

//composer require filp/whoops

    private static function handleError(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }




//    执行应用
    private static function appRun() {

        //?s=home/entry/index
//            控制器    默认是home/entry/index
      $s = isset($_GET['s']) ? strtolower($_GET['s']) : 'home/entry/index';
//        把字符串打散为数组 进行组合类名  用于加载 自动文件
      $arr=explode('/',$s);

//        p($arr);
/*        Array
        (
            [0] => home
            [1] => entry
            [2] => index
            )*/
//        1.把应用比如："home"定义为常量APP
//        2.在houdunwang/view/view.php文件里的View类的make方法组合模板路径，需要用的应用比如:home的名字
//        3.home是默认应用，有可能为admin后台应用，所以不能写死home
          define('APP',$arr[0]); // 默认是home

          define('CONTROLLER',$arr[1]); //默认是entry

          define('ACTION',$arr[2]);//默认是index

//        组合类名app\home\controller\Entry

    $className ="\app\\{$arr[0]}\controller\\" . ucfirst($arr[1]);

//               调用控制器里面的方法 默认是 app\home\controller\Entry index()
//        导入类   app\home\controller\Entry   默认自动加载这个文件  ../app/home/controller/Entry.php 文件

//        实例化对象Entry      Entry是对象   index()是方法
//
//        app\home\controller\Entry index()     在../app/home/controller/Entry.php文件 的Entry()类index()方法

//        echo 输出 index()方法中 return过来的值
      echo  call_user_func_array([new $className,$arr[2]],[]);

    }



//    初始化框架
    private static function  init(){
//        echo '123';

//        开启session
    session_id() || session_start();

//        设置时区
    date_default_timezone_set('PRC');
//    定义是否POST提交的常量
   define('IS_POST',$_SERVER['REQUEST_METHOD']== 'POST' ? true : false);

    }

}