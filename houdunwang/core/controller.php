<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/7/30
 * Time: 23:23
 */
//设置命名空间
//用于其他PHP文件页面加载这个文件
namespace houdunwang\core;

//设置一个父类  用于子类继承  子类在../app/home/controller/Entry.php文件
class Controller{
//         跳转地址$url属性参数 用于跳转到 其他网页的属性
//back() 方法可加载历史列表中的前一个 URL（如果存在）。
    private $url = 'window.history.back()';
//       添加成功和失败提示  提示页面 跳转地址 属性参数  用于下面成功提示   和失败提示  的属性 共享

        private $template;
//       提示消息参数
        private $msg;

//            跳转地址$url 参数
    protected  function setRedirect($url){

        $this->url = "location.href='{$url}'";
//        把结果返回到原来参数源地址
        return $this;

    }

//    成功提示

    protected function success($msg){
//        设置提示消息参数  $msg  如编辑成功  删除成功    添加成功
        $this->msg = $msg;
//        跳转到 提示成功页面地址./view/success.php
        $this->template = './view/success.php';
        return $this;
    }

//    失败提示
    protected function error($msg){
//        设置提示消息参数
        $this->msg =$msg;
        //        跳转到 提示成功页面地址./view/error.php
        $this->template = './view/error.php';

        return $this;

    }
//    载入模板      进行自动触发  函数的类的对象当做字符串使用的时候返回的值
    public function  __toString(){
//        提示成功路径   ./view/success.php
        include  $this->template;
//         必须 return字符串才能自动触发 __toString    进行自动触发  函数的类的对象当做字符串使用的时候返回的值
        return '';

    }


}