<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/2
 * Time: 9:07
 */

namespace app\admin\controller;


use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Grade;
use system\model\Material;
use system\model\Stu;

class Student extends Common {
    /**
     * 显示学生
     */
    public function lists(){
        //因为要显示班级信息所以需要关联
        $data = Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid");

        //          make()加载模板  默认路径目录是./app/home/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件
        return View::make()->with(compact('data'));
    }

    /**
     * 添加学生
     * @return $this
     */
    public function store(){
        if(IS_POST){
            //处理爱好，因为爱好提交过来是一个数组无法直接插入到数据库，把数组变为字符串
            if(isset($_POST['hobby'])){
                $_POST['hobby'] = implode(',',$_POST['hobby']);
            }
//            调用Stu save方法  继承父类方法houdunwang\model\Model
//              save方法方法不存在 跳转到Base类 执行  save方法
            Stu::save($_POST);
//            p($_POST);
            return $this->setRedirect('?s=admin/student/lists')->success('保存成功');
        }
        //            调用Grade Grade方法  继承父类方法houdunwang\model\Model
//              save方法方法不存在 跳转到Base类 执行  save方法
        //获得班级信息
        $gradeData = Grade::get();

//          调用Material Grade方法  继承父类方法houdunwang\model\Model
//              save方法方法不存在 跳转到Base类 执行  save方法
        //头像信息
        $materialData = Material::get();

        //          make()加载模板  默认路径目录是./app/home/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件

        return View::make()->with(compact('gradeData','materialData'));
    }

    /**
     * 修改
     */
    public function update(){
//        获得提交过来数据
        $sid = $_GET['sid'];
        if(IS_POST){
            //     调用stu: where方法update()方法  继承父类方法houdunwang\model\Model
//      where方法update()方法 方法方法不存在 跳转到Base类 执行  where方法 update()方法
            $_POST['hobby'] = implode(',',$_POST['hobby']);
            stu::where("sid={$sid}")->update($_POST);
            //            编辑成功提示
//       把添加结果返回出去    success('编辑成功')弹出提示   setRedirect('?s=admin/grade/list.php')返回首页
//        调用父类方法  success('编辑成功')->setRedirect('?s=admin/grade/list.php')
//        success（）setRedirect（） 父类方法 在../houdouwang/admin/Controller.php 文件中

            return $this->setRedirect('?s=admin/Student/lists')->success('修改成功');

        }

        //获取旧数据
        //        调用Stu find方法  继承父类方法houdunwang\model\Model
//      find方法 方法不存在 跳转到Base类 执行  find方法
        $oldData = Stu::find($sid);

        $oldData['hobby'] = explode(',',$oldData['hobby']);
//        p($oldData);
        //获得班级信息
        //        调用Grade get方法  继承父类方法houdunwang\model\Model
//      find方法 方法不存在 跳转到Base类 执行  find方法
        $gradeData = Grade::get();
        //头像信息
        //        调用Material get方法  继承父类方法houdunwang\model\Model
//      find方法 方法不存在 跳转到Base类 执行  find方法
        $materialData = Material::get();
// 调用../houdunwang/view/Base.php  找到Base()类 里面的
//              with（）方法   分配变量
//              和make()方法 加载模板  默认为首页
        //         把变量名变为键名，变量值变为键值
        return View::make()->with(compact('oldData','gradeData','materialData'));

    }



    /**
     * 删除
     */
    public function remove(){
        //     调用Stu where方法 destory()方法  继承父类方法houdunwang\model\Model
//      where方法 destory()方法不存在 跳转到Base类 执行  where方法 destory()方法 方法

        Stu::where("sid={$_GET['sid']}")->destory();
        //        把删除结果返回出去    success('删除成功')弹出提示   setRedirect('s=admin/grade/lists.php')返回首页
//        调用父类方法  success('删除成功')->setRedirect('index.php')
//        success（）setRedirect（） 父类方法 在../houdouwang/core/Controller.php 文件中

        return $this->setRedirect('?s=admin/Student/lists')->success('删除成功');

    }
}