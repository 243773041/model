<?php
//设置命名空间
//用于其他PHP文件页面载入这个文件
namespace houdunwang\model;

class Model {
	//       调用未定义的静态方法会自动执行此方法 默认是q('arc') q('tag')  $name方法名称q()   $arguments方法参数 arc  tag
	public static function __callStatic( $name, $arguments ) {
//		获取当前的类名 get_called_class（)获取当前主调类的类名
		$className = get_called_class();
//		p($className); exit;
		//system\model\Arc
		//strrchr字符串截取 变成 \Arc
		//ltrim 去除左边的\ 变成 Arc
		//strtolower 变成 arc
//		$table	 表名
		$table = strtolower(ltrim(strrchr($className,'\\'),'\\'));
//		实例化对象类Base()  $name并且调用q()方法   $arguments方法参数q('arc')值 arc tag
		//		实例化对象类Base()  $name并且调用q()方法
		//  $name 默认是 with（）方法  和make()方法 名称  $arguments参数值是$data,$tag
//        跳转到./houdunwang/view/Base.php  找到Base()类 里面的 with（）方法  和make()方法
		return call_user_func_array([new Base($table),$name],$arguments);
	}
}