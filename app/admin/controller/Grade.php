<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/1
 * Time: 20:50
 */

namespace app\admin\controller;
//类名导入 controller（）对象类 父类方法调用 success（）setRedirect（）
//就是 调用../houdunwang/core/Controller.php 文件  controller（）类  success（）方法 和setRedirect（）方法
use houdunwang\core\Controller;

use houdunwang\view\View;

use system\model\Grade as GradeModel;

class Grade extends Common{

//    班级列表


    public function lists(){


//        调用GradeModel get方法  继承父类方法houdunwang\model\Model   save方法方法不存在 跳转到Base类 执行    get()方法
        $data= GradeModel::get();
        //          make()加载模板  默认路径目录是./app/admin/view/entry/lists.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件



        return View::make()->with(compact('data'));


    }

//   添加

    public function store(){

        if(IS_POST){

            //            调用GradeModelsave方法  继承父类方法houdunwang\model\Model
//              save方法方法不存在 跳转到Base类 执行  save方法
            GradeModel::save($_POST);
//            把添加结果返回出去    success('添加成功')弹出提示   setRedirect('index.php')返回首页
            return $this->setRedirect('?s=admin/grade/lists')->success('添加成功');
        }

        //          make()加载模板  默认路径目录是./app/admin/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件

        return View::make();
    }

//    编辑功能
    public function update(){

        $gid = $_GET['gid'];
        if(IS_POST){

            //     调用GradeModel where方法update()方法  继承父类方法houdunwang\model\Model
//      where方法update()方法 方法方法不存在 跳转到Base类 执行  where方法 update()方法
        GradeModel::where("gid={$gid}")->update($_POST);

            return $this->setRedirect('?s=admin/grade/lists')->success('修改成功');

        }
        //        调用GradeModel find方法  继承父类方法houdunwang\model\Model
//      find方法 方法不存在 跳转到Base类 执行  find方法
        $oldData = GradeModel::find($gid);
        // 调用../houdunwang/view/Base.php  找到Base()类 里面的
//              with（）方法   分配变量
//              和make()方法 加载模板  默认为首页
        //         把变量名变为键名，变量值变为键值
        return View::make()->with(compact('oldData'));

    }


//    删除功能
    public function remove(){
        //     调用GradeModel where方法 destory()方法  继承父类方法houdunwang\model\Model
//      where方法 destory()方法不存在 跳转到Base类 执行  where方法 destory()方法 方法

        GradeModel::where("gid={$_GET['gid']}")->destory();

        //        把删除结果返回出去    success('删除成功')弹出提示   setRedirect('index.php')返回首页
//        调用父类方法  success('删除成功')->setRedirect('index.php')
//        success（）setRedirect（） 父类方法 在../houdouwang/core/Controller.php 文件中

        return $this->setRedirect('?s=admin/grade/lists')->success('删除成功');


    }

}