<?php
/**
 * 打印函数
 * @param $var
 */
function p($var){
	echo '<pre style="background: #ccc;padding: 10px;border-radius: 5px;">';
	print_r($var);
	echo '</pre>';
}

//c('database.db_name');
//c('captcha.length');
//设置配置文件方法
function c($path){
//	函数把字符串打散转为数组
	$arr = explode('.',$path);
//	转为数组
	//$arr = ['database','db_name'];
//	默认是../system/config/database.php
	$config = include '../system/config/' . $arr[0] . '.php';
	return isset($config[$arr[1]]) ? $config[$arr[1]] : NULL;
}


function go($url){
	header('Location:' . $url);
	exit;
}







