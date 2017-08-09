<?php
//设置命名空间
//用于其他页面文件载入这个文件
namespace houdunwang\model;
use PDO;
use PDOException;
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/7/26
 * Time: 21:37
 */

//创建一个数据库的类

class  Base{

//    保存PDO对象的静态属性
    private static $pdo = null;
//    保存表名属性
    private  $table;
    //保存where   条件属性
    private $where;

//    创建自动连接数据库的构造方法  传入的参数是表名
    public function __construct($table){
//        调用当前数据库的方法
        $this->connect();

        $this->table=$table;
    }


//    创建链接到MYSQL方法  链接数据库
    private function connect(){
//          如果构造方法多次执行,那么此方法也会多次执行,用静态属性可以把对象保存起来不丢失,
//          第一次self::$pao为null，那么就正常链接数据库
//          第2次self::$pao 已经保存了pao对象，不为NULL了，这样不用再次链接mysql

        if (is_null(self::$pdo)) {
            //使用PDO连接数据库，如果有异常错误，就会被catch捕捉到
            try {
//       $dsn数据库源   数据库类型mysql 127.0.0.1主机地址   数据库名dbname=c83
//                .c('database.db_host') 调用../houdouwang/core/functions.php文件  c()函数
				$dsn = 'mysql:host='.c('database.db_host').';dbname=' . c('database.db_name');
//               $username链接数据库的用户账号
                $username =c('database.db_user');
//                $password 链接数据库的密码
                $password = c('database.db_password');

//                $dsn数据库源 ，$username链接数据库的用户账号  ，$password 链接数据库的密码
                $pdo = new PDO($dsn,$username,$password);
//                   设置错误属性，要设置成异常错误，因为需要被catch捕获
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                设置   数据库字符集编码
                $pdo->exec( "SET NAMES " . c('database.db_charset') );


                //把PDO对象放入到静态属性中
                self::$pdo = $pdo;

            } catch (PDOException $e) {
                //异常错误  终止
                exit($e->getMessage());

            }


        }

    }


//    获取全部数据      $table参数  arc tag
    public function get(){
//        where条件
//        调用where（）方法 如果有条件就输出 没有 就输出默认的空字符串
        $where = $this->where ? "WHERE {$this->where}" : '';
//            显示数据库里表的信息  select * from arc    select * from tag
        $sql = "SELECT * FROM {$this->table} $where";
        //执行sql操作
        //query 执行调用当前数据库进行 有结果集的操作 select,show,... 相当于打开文件
        $result = self::$pdo->query($sql);
//        获得关联数组   只得到关联⽅式的数据
        $data =$result->fetchAll(PDO::FETCH_ASSOC);
//        再把 结果返回出去 显示
//        p($data);
        return $data;

    }


//    查询单条数据
    public  function find($id){
//        调用  主键 方法 获得对应的参数值$id
        $priKey = $this->getPriKey();
//            找到数据库 表 $this->table =arc 主键对应的键值  例如aid是主键   aid=37  键值就是37
//         select * from   arc   where  aid =37;
        $sql = "SELECT * FROM {$this->table} WHERE {$priKey}={$id}";
//        调用有结果集的查询方法
        $data = $this->q($sql);
//    指针指向它的"当前"元素初始指向插入到数组中的第一个元素  主键对应的键值第一位 返回出去
        return current($data);

    }


//    录入内容
    public function save($post){
        //查询当前表信息
        $tableInfo = $this->q("DESC {$this->table}");
        $tableFields = [];
        //获取当前表的字段 [title,click]
        foreach ($tableInfo as $info){
            $tableFields[] = $info['Field'];
        }
        //循环post提交过来的数据
        //Array
//		(
//			[title] => 标题,
//			[click] => 100,
//			[captcha] => abc,
//		)
        $filterData = [];
        foreach ($post as $f => $v){
            //如果属于当前表的字段，那么保留，否则就过滤
//            函数搜索数组中是否存在指定的值
            if(in_array($f,$tableFields)){
                $filterData[$f] = $v;
            }
        }
//      Array
//		  (
//			[title] => 标题,
//			[click] => 100,
//		)

        //字段   返回包含数组中所有键名的一个新数组  = 获得键名
        $field = array_keys($filterData);
//        把数组元素组合为字符串 以,开始  函数返回由数组元素组合成的字符串  title,click
        $field = implode(',',$field);
//        p($field);exit;
        //值  返回数组的所有值(非键名):   = 获得键值
        $values = array_values($filterData);
//        把数组元素组合为字符串 以,开始  函数返回由数组元素组合成的字符串 "wwqw","qwq"
        $values = '"' . implode('","',$values)  . '"';
//        p($values);exit;
//            $field 键名      $values键值
//            组合成录入添加SQL语句
//             insert into   arc      (title,clcik) values ('122','1213')
        $sql = "INSERT INTO {$this->table} ({$field}) VALUES ({$values})";
//        把结果返回出去  调用无结果集的方法  相当于打开数据库表的操作
        return $this->e($sql);
    }




//修改
   public function update($data){
//        删除时进行判断是否有 where条件 如果没有进行阻止 防止误修改整个数据库的其他数据
        if(!$this->where){
            exit('delete必须有where条件');

        }
        //Array
//		(
//			[title] => 标题,
//			[click] => 100,
//		)
//        设置 变量赋值空字符串 用来赋值遍历每次出来的值 $set.="{$field}='{$value}',";
        $set ='';

        foreach($data as $field => $value  ){

//            组合  字符串 例如title='标题',click=' 100',
            $set .="{$field}='{$value}',";


        }
//        去掉右边的,点 变成了例如title='标题',click=' 100'
        $set = rtrim($set,',');

//        p($set);exit();

//     进行修改数据库 例如  $this->table= arc   $set= title='标题',click=' 100'     $this->where= aid=37
//        update   arc  set   title='标题',click=' 100'   where aid=37;

        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->where}";

//        把结果返回出去  调用无结果集的方法  相当于打开数据库表的操作
        return $this->e($sql);


    }






//where条件
    public  function  where($where){
//        传入条件参数值例如"aid={$_GET['aid']}" 储存起来参数值   条件参数值
        $this->where=$where;
//        再把储存起来参数值返回出去
        return $this;

    }


//    摧毁删除数据

    public  function destory(){
//        删除时进行判断是否有 where条件 如果没有进行阻止 防止误删除整个数据库的其他数据
        if(!$this->where){
            exit('delete必须有where条件');

        }

//       删除数据         $this->table传入表名参数值     $this->where传入的  where条件参数值
        $sql = "DELETE FROM {$this->table}  WHERE {$this->where} ";
//          把结果返回出去  调用无结果集的方法  相当于打开数据库表的操作
        return $this->e($sql);

    }



//      获得主键

    private function getPriKey(){
//        查询表结构
        $sql = "DESC {$this->table}";
//        调用有结果集的查询方法   相当于打开文件
        $data = $this->q($sql);
        //主键
        $primaryKey = '';
        foreach ($data as $v){
//            如果  主键等于 aid 就证明他是主键
            if($v['Key'] == 'PRI'){
//
                $primaryKey = $v['Field'];
                break;
            }
        }

        return $primaryKey;
    }





//    执行有结果集的操作
    public  function q($sql){
        //query 执行调用当前数据库进行 有结果集的操作 select,show,...


//           //query  相当于打开数据库 表的操作
            $result = self::$pdo->query($sql);
//            p($result);
//            获得关联数组的数据   只得到关联⽅式的数据
            return $result->fetchAll( PDO::FETCH_ASSOC );

    }

//    执行没有结果集的操作
    public  function  e($sql){
//exec 执行调用当前数据库进行 有无结果集的操作 delete ,insert....


//            exec 相当于打开数据库 表的操作
           $afRows  = self::$pdo->exec($sql);
//            把结果返回显示出去
            return $afRows;





    }


}