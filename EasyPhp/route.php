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

//默认index
if (!$route) $route = 'index';

//路由数组
$routeArr = explode('/', $route);

//域
$domain = $space[$server_name];

//过滤器
$filterPath = DIR . '/main/view/' . $domain . '/filter.php';
if (file_exists($filterPath)) {//不存在
    include $filterPath . '';
}


$realRoute = '';
//检查登录和权限
if (!($route == 'login' || strpos($route, 'api/login/') === 0)) {//不是login
    //检查注册的id
    if (!Util::getSession('user_id')) {
        Util::notFound('Not logged in!');
    }
    //查找权限的算法
    $privilege = Util::getSession('privilege');
    $temp = '';
    for ($i = 0, $len = count($routeArr); $i < $len; ++$i) {
        $temp .= '/' . $routeArr[$i];
        $temp = ltrim($temp, '/');
        if (in_array($temp, $privilege))
            $realRoute = $temp;
    }
    //是否有权使用
    if (!$realRoute) {
        Util::notFound('No permission to use!');
    }
} else {
    $realRoute = $route;
}

//重置路由数组
$routeArr = explode('/', $realRoute);

//执行路由
if ($routeArr[0] === 'api') {
    //=====>api路由<=====\\
    //聚合请求参数
    $param = array_merge($_GET, $_POST, $_FILES);
    define('PARAM', $param);

    $filePath = DIR . 'main/api/' . $routeArr[1] . '.php';
    header('Content-Type:application/json');
    if (!file_exists($filePath)) {//不存在
        Util::notFound($route);
    }

    //第一个是命令的key,往后走才是URL的参数
    define('ORDER', $routeArr[2]);

    //销毁变量
    Util::destroy([
        &$route,
        &$routeArr,
        &$param,
        &$spacePath,
        &$server_name
    ]);

    //统一json输出
    include $filePath . '';
    exit();
} else {
    //=====>页面路由<====\\
    $isChild = false;
    if (count($routeArr) == 1) {//不是子模块
        define('PATH', DIR . 'main/view/' . $domain . '/' . $routeArr[0] . '/');
    } else {//是子模块
        $isChild = true;
        define('PATH', DIR . 'main/view/' . $domain . '/' . $routeArr[0] . '/part/' . $routeArr[1] . '/');
    }

    //模块地址
    $filePath = PATH . 'app.html';
    if (!file_exists($filePath)) {//不存在
        Util::notFound($filePath);
    }

    //通过地址扩充get
    $param = str_replace($realRoute, '', $route);
    if ($param != '') {
        $param = ltrim($param, '/');
        $param = explode('/', $param);
    } else {
        $param = [];
    }
    //参数集合
    define('PARAM', $param);
    //销毁变量
    Util::destroy([
        &$route,
        &$realRoute,
        &$routeArr,
        &$spacePath,
        &$param,
        &$server_name
    ]);

    if (!$isChild) {
        //组装页面
        include DIR . 'main/view/' . $domain . '/header.php';
        echo Util::readFile($filePath);
        echo '</body></html>';
    } else {
        //分隔符
        $span = Util::random(10);

        //css
        echo Util::readFile(PATH . 'style.css').$span;
        //js
        include PATH . 'data.php';
        echo Util::readFile(PATH . "script.js").$span;
        //html
        echo Util::readFile($filePath).$span;
    }
    exit();
}