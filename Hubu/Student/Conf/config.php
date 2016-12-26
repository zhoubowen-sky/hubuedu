<?php
//config.php是我们当前自己项目的配置文件，我们可以通过修改该文件达到配置变量的目录
//这个文件在系统运行过程中会覆盖convertion.php的配置变量

return array(
	//'配置项'=>'配置值'
    'URL_MODEL'             =>  1,     // URL访问模式,可选参数0、1、2、3,代表以下四种模式： 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    //让页面显示追踪日志信息
    'SHOW_PAGE_TRACE'       => true,   // 显示页面Trace信息
    //URL大小写敏感设置，PHP本身不敏感，但是TP为了安全做了敏感设置
    'URL_CASE_INSENSITIVE'  =>  false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    
    /* 数据库连接相关的配置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'hubuedu',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口  /* 默认3306 */
    'DB_PREFIX'             =>  'hubu_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    //以下字段缓存，在DEBUG模式是不起作用的，设置为false也不起作用
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8 
    
    
    
    
);