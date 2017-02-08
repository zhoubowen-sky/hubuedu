<?php
//这里使用单例模式连接数据库

class Db {
    static private $_instance;//存储DB的对象，单例模式
    static private $_connectSource;//连接数据库的资源
    //数据库的配置信息
    private $_dbConfig = array(
        'host'     => '120.27.104.19',
        'user'     => 'root',
        'password' => '',
        'database' => 'hubuedu_data',
    );
    //构造函数
    private function __construct() {
    }
    //访问单例的公共方法
    static public function getInstance() {
        //判断是否已经实例化了这个对象，如果已经实例化了，就不需要重新new一个
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //连接数据库的函数
    public function connect() {
        if(!self::$_connectSource) {
            self::$_connectSource = @mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);

            if(!self::$_connectSource) {
                throw new Exception('mysql connect error ' . mysql_error());
                //die('mysql connect error' . mysql_error());
            }
            	
            mysql_select_db($this->_dbConfig['database'], self::$_connectSource);//选择数据库
            mysql_query("set names UTF8", self::$_connectSource);//设置字符集
        }
        return self::$_connectSource;
    }
}





/*
$connect = Db::getInstance()->connect();

var_dump($connect);

$sql = "select * from hubu_course_class";
$result = mysql_query($sql, $connect);
echo mysql_num_rows($result);
var_dump($result);

*/






