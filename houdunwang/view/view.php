<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/7/30
 * Time: 20:17
 */
namespace houdunwang\view;

class view{
//调用未定义的静态方法会自动执行此方法  默认是with() make()方法  $name方法名称 with() make()   $arguments参数值是$data,$tag
    public  static  function __callStatic($name, $arguments){
        //		实例化对象类Base()  $name并且调用 with（）方法 make()方法
        //  $name 默认是 with（）方法  和make()方法 名称  $arguments参数值是$data,$tag
//        跳转到./houdunwang/view/Base.php  找到Base()类 里面的 with（）方法  和make()方法
//        return 把值 返回到./app/home/controller/Entry.php文件
        return call_user_func_array([new Base(),$name],$arguments);

    }


}