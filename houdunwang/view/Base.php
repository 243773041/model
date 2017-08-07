<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/7/30
 * Time: 20:19
 */
//设置命名空间
//用于其他php文件加载这个php页面
namespace houdunwang\view;


class Base{
    //保存分配变量的属性
    private $data = [];

    //模板路径
    private $template;

//      分配变量
    public function with($data){
        $this->data= $data;
//     把值返回出去  到 ./houdunwang/view/view.php 文件的
        return $this;


    }

//    制作模板

    //		Array
//		(
//			[0] => home
//			[1] => entry
//			[2] => index
//

    public  function  make(){

//        默认路径目录文件 app/home/view/entry/index.php   为首页
//        APP常量 默认值是home          CONTROLLER常量 默认值是entry      ACTION 默认值是index
//        默认路径目录文件../app/home/view/entry/index.php  为首页
        $this->template ='../app/' . APP . '/view/' . CONTROLLER . '/' .ACTION . '.php';
//        把值返回出去  到 ./houdunwang/view/view.php 文件的
        return $this;

    }

//    载入模板   进行自动触发  函数的类的对象当做字符串使用的时候返回的值
    public function __toString(){
//        把键名变为变量名，键值变为变量值 相当于 $data = ['title'=>'我是文章标题']；
          extract($this->data);

//        p($sty );
//        默认路载入径目录文件 app/home/view/entry/index.php
        include $this->template;
//        必须 return字符串才能自动触发 __toString  进行自动触发  函数的类的对象当做字符串使用的时候返回的值
       return '' ;
    }


}