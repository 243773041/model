<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/3
 * Time: 8:46
 */

namespace app\admin\controller;
use houdunwang\view\View;
use system\model\User as UserModel;

class User extends Common{


//    修改密码


        public function changePassword(){

            if(IS_POST){
//                获得表单提交过来内容数据
              $post    =   $_POST;


//                1.先比较旧密码   获得 session
            $user =UserModel::where("uid =" . $_SESSION['user']['uid'])->get();

//                        提交过来的数据 跟数据库的密码进行对比
               if(!password_verify($post['oldPassword'],$user[0]['password'])){


                return $this->error('旧密码错误');

           }

//            2.2次密码是否一致

            if($post['newPassword'] != $post['confirmPassword']){

                return $this->error('2次密码不一致');

            }

//            3.修改

              $data   = ['password'=>password_hash($post['newPassword'],PASSWORD_DEFAULT)];
                UserModel::where('uid=' . $_SESSION['user']['uid'])->update($data);



                //            清除session
                session_unset();  //    删除变量
                session_destroy();//   删除文件

//         把修改结果返回出去    success('修改成功')弹出提示   setRedirect('s=admin/grade/lists.php')返回首页
//        调用父类方法  success('修改成功')->setRedirect('?s=admin/login/index'')
//        success（）setRedirect（） 父类方法 在../houdouwang/core/Controller.php 文件中
                return $this->setRedirect('?s=admin/login/index')->success('修改成功');

            }


            //          make()加载模板  默认路径目录是./app/admin/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）   with（）方法  和make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 with（）方法  和make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件
            return View::make();


        }





}