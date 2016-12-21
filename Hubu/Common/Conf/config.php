<?php
//config.php是我们当前自己项目的配置文件，我们可以通过修改该文件达到配置变量的目录
//这个文件在系统运行过程中会覆盖convertion.php的配置变量
//此文件配置的信息三个模块都生效

return array(
    'DEFAULT_MODULE'        =>  'Student',  // 默认模块
    'MULTI_MODULE'          =>  true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    
);