<?php

/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/3
 * Time: 9:53
 */
namespace app\home\controller;

use app\admin\controller\Common;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;

//前台首页控制器
class Entry extends Controller{



    public  function  index(){

//        进行数据库2张表进行关联  进行有结果集操作  相当于打开文件

        $data = Model::q("SELECT * FROM  stu s JOIN grade g ON s.gid=g.gid");

        //          make()加载模板  默认路径目录是./app/admin/view/entry/lists.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件

        return view::make()->with(compact('data'));




    }



    public  function  show(){

//        $get=$_GET['sid'];
//        p($get);exit;

        //        进行数据库2张表进行关联  进行有结果集操作  相当于打开文件
        //     获得提交过来数据进行where条件进行条件对比显示出来

        $data= Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid WHERE sid={$_GET['sid']}");

        //          make()加载模板  默认路径目录是./app/admin/view/entry/lists.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件


        return view::make()->with(compact('data'));


//        return view::make();


    }



}