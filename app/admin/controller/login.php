<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/2
 * Time: 20:10
 */

namespace app\admin\controller;


use houdunwang\core\Controller;

use Gregwar\Captcha\CaptchaBuilder;

use houdunwang\view\View;
use system\model\User;


class login extends Controller{

//        登录页面
public function index(){

//    $password = password_hash('admin888',PASSWORD_DEFAULT);
//    echo $password;
      if(IS_POST){

         $post= $_POST;

//                判断验证码是否正确  提交过来的的验证码 跟存入到$_SESSION 验证对比
            if(strtolower($post['captcha']) != $_SESSION['captcha']  ){

//                显示对比结果
                return $this->error('验证码错误');

            }

//          用户名
        $data  = User::where("username='{$post['username']}'")->get();
//         用户名判断 用户名不存在
//          p( $data);exit;

         if(!$data) {

             return $this->error('用户名不存在');

         }
/*
          if($post['username']!=$data[0]['username']){

              return $this->error('用户名不存在');
          }*/


//                密码错误判断
        if(! password_verify($post['password'],$data[0]['password'])){


            return $this->error('密码错误');

        }
          //        7天免登陆



          if(isset($post['auto'])){
//                读取设置setcookie（）
//          读取/设置 session_name（）会话名称 session_id()会话id  函数会更新会话名称， 并返回 原来的 会话名称
//
//                  setcookie 设置读取 会话 时间到7天有效

              setcookie(session_name(),session_id(),time() + 7 * 24 * 3600 ,'/' );

          }else{

//                 重新 设置 会话时间  取消7天有效
            setcookie(session_name(),session_id(),0,'/');

          }

//        存session

        $_SESSION['user']=[
            'uid'       =>$data[0]['uid'],
            'username'  =>$data[0]['username']

        ];

//          把添加结果返回出去    success('登录成功')弹出提示   setRedirect('?s=admin/entry/index')返回后台默认首页
        return  $this->setRedirect( '?s=admin/entry/index' )->success( '登陆成功' );

      }


    //          make()加载模板  默认路径目录是./app/admin/view/entry/index.php
//        默认跳转到 houdunwang/view/view.php  执行对象类view（）  make()方法
//        未找到 触发了__callStatic（）方法 实例化对象类Base()
//  再次跳转到../houdunwang/view/Base.php  找到Base类 里面的 make()方法
//        return把值返回到了 ../houdunwang/core/Boot.php文件

    return View::make();





}





    public function captcha(){
//        声明图片类型
        header('Content-type: image/jpeg');
        $str     = substr( md5( microtime( true ) ), 0, 4 );
//        实例化图片对象
        $builder = new CaptchaBuilder($str );

        $builder->build();

        $builder->output();
        //把值存入到session
        $_SESSION['captcha'] = $builder->getPhrase();
    }


    public  function  out(){

        session_unset();

        session_destroy();

        return  $this->setRedirect( '?s=admin/login/index' )->success( '退出成功' );

    }




}