<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/2
 * Time: 20:19
 */

namespace app\admin\controller;

//导入 ../houdunwang/core/Controller.php文件 里  Controller类
use houdunwang\core\Controller;

// 继承../houdunwang/core/Controller.php文件 里 父类方法


class Common extends Controller {

    public function __construct() {
        //如果没有登陆
        if(!isset($_SESSION['user'])){
//              跳转到登录界面
            go('?s=admin/login/index');
        }
    }
}