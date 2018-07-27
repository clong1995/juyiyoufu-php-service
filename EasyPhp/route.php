<?php

use EasyPhp\util\Util;

//设置时间
date_default_timezone_set("PRC");
//定义根目录
define('DIR', realpath(dirname(__FILE__) . '/../') . '/');
//自动加载
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    $file = DIR . $class_name . '.class.php';
    if (file_exists($file)) {
        require_once $file . '';
    } else {
        exit('not found ' . $file);
    }
});
//开启session
session_start();
//接收路由
$route = $_GET['route'];
$_GET['route'] = null;
unset($_GET['route']);


//视图层空间
$spacePath = DIR . '/main/view/space.php';
if (!file_exists($spacePath)) {//不存在
    exit($filterPath . ' not found');
}
include $spacePath . '';
$server_name = $_SERVER['SERVER_NAME'];
if (!isset($space[$server_name])) {
    exit($server_name . ' is not in space');
}
$domain = $space[$server_name];
//默认index
if (!$route) $route = 'index';
//路由数组
$routeArr = explode('/', $route);
if($routeArr[0] !== 'api'){
    $route = $domain . '/' . $route;
    array_unshift($routeArr,$domain);
}



//过滤器
$filterPath = DIR . '/main/view/' . $domain . '/filter.php';
if (!file_exists($filterPath)) {//不存在
    exit($filterPath . ' not found');
}


include $filterPath . '';

//聚合请求参数
$param = array_merge($_GET, $_POST, $_FILES);
define('PARAM', $param);


//=====>api路由
if ($routeArr[0] === 'api') {
    $filePath = DIR . 'main/api/' . $routeArr[1] . '.php';
    header('Content-Type:application/json');
    if (!file_exists($filePath)) {//不存在
        Util::notFound($route);
    }

    //第一个是命令的key,往后走才是URL的参数
    define('ORDER', $routeArr[2]);

    //通过地址扩充get
    for ($i = 3, $len = count($routeArr); $i < $len; ++$i) {
        $param[$routeArr[$i]] = $routeArr[++$i];
    }

    Util::destroy([
        &$route,
        &$routeArr,
        &$param,
        &$spacePath,
        &$server_name,
        &$domain,
        &$filterPath
    ]);

    //统一json输出
    include $filePath . '';
    exit();
}

if (count($routeArr) === 2) {//不是子模块
    define('PATH', DIR . 'main/view/' . $domain . '/' . $routeArr[1] . '/');
} else {//不是子模块
    define('PATH', DIR . 'main/view/' . $domain . '/' . $routeArr[1] . '/part/' . $routeArr[2] . '/');
}

//载入模块
$filePath = PATH . 'app.php';
if (!file_exists($filePath)) {//part不存在
    Util::notFound($filePath);
}

//销毁变量
Util::destroy([
    &$route,
    &$routeArr,
    &$param,
    &$spacePath,
    &$server_name
]);

//组装页面
include DIR . 'main/view/' . $domain . '/header.php';
include $filePath . '';
include DIR . 'main/view/' . $domain . '/footer.php';

