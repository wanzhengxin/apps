<?php
// +----------------------------------------------------------------------
define('APP_PATH', __DIR__ . '/../app/');

// 定义配置文件目录
define('CONF_PATH', __DIR__. '/../conf/');

// 加载框架引导文件，单一入口文件起安全监测作用
// define('BIND_MODULE','publicapp/scan/scan');//绑定入口文件
require __DIR__ .'/../thinkphp/start.php';