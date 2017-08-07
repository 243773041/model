<?php

/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/1
 * Time: 19:54
 */
//设置命名空间
//用于其他php文件载入这个文件
namespace app\admin\controller;
//类名导入 controller（）对象类 父类方法调用 success（）setRedirect（）
//就是 调用../houdunwang/core/Controller.php 文件  controller（）类  success（）方法 和setRedirect（）方法
use houdunwang\core\Controller;
//类名导入  view（）类 设置了 __callStatic（）方法调用未定义的静态方法会自动执行此方法  with（） make()方法
//再次跳转到../houdunwang/view/Base.php  找到Base()类 里面的 with（）方法  和make()方法
use houdunwang\view\View;



class Entry extends Common{

//            后台默认首页
        public function index() {

            //          make()加载模板  默认路径目录是./app/admin/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）  make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件

            return View::make();

        }


}