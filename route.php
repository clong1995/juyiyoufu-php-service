<?php


session_start();
//接收路由
$route = $_GET['route'];
$_GET['route'] = null;
unset($_GET['route']);

define('DIR', dirname(__FILE__) . '/');
date_default_timezone_set("PRC");

//工具函数
include DIR . 'util.php';

//请求头限制
$head = getallheaders();
if($head['Host'] !== 'nurse.juyiyoufu.com')
    notFound('非法部署的应用！');
if(strpos($head['User-Agent'],'Electron') ==false)
    notFound('非法客户端！');


//自动加载
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    $file = DIR . 'main/' . $class_name . '.class.php';
    if (file_exists($file)) {
        require_once $file . '';
    } else {
        notFound($file);
    }
});

//检查登录和权限
if (!strstr($route, '/login')) {//不是login页面
    //检查注册的id
    if (!getSession('id')){
        notFound('未登录！');
        //TODO 未登录的处理
        //关闭当前窗口
        //重新打开登录窗口
    }
    //判断权限
    if (!in_array($route, getSession('privilege')))
        notFound('无权使用！');
}


if (!$route) $route = 'index';

//路由数组
$routeArr = explode('/', $route);

//聚合请求参数
$param = array_merge($_GET, $_POST, $_FILES);


//=====>api路由
if ($routeArr[0] === 'api') {
    $filePath = DIR . 'main/api/' . $routeArr[1] . '.php';
    header('Content-Type:application/json');
    if (!file_exists($filePath)) {//不存在
        notFound($route);
    }

    //第一个是命令的key,往后走才是URL的参数
    define('ORDER', $routeArr[2]);

    //通过地址扩充get
    for ($i = 3, $len = count($routeArr); $i < $len; ++$i) {
        $param[$routeArr[$i]] = $routeArr[++$i];
    }
    define('PARAM', $param);

    destroy([
        &$route,
        &$routeArr,
        &$param
    ]);

    //统一json输出
    include $filePath . '';
    exit();
}


if ($routeArr[0] === 'pc') {
    $view = '/pc/';//====>pc路由
    array_shift($routeArr);
} else {
    $view = '/web/';//=====>web路由
}

if (strstr($route, '/part/')) {//是子模块
    define('PATH', DIR . 'main/view' . $view . $routeArr[0] . '/part/' . $routeArr[2] . '/');
} else {//不是子模块
    define('PATH', DIR . 'main/view' . $view . $routeArr[0] . '/');
}


//载入模块
$filePath = PATH . 'app.php';
if (!file_exists($filePath)) {//part不存在
    notFound($filePath);
}
define('PARAM', $param);

//销毁变量
destroy([
    &$route,
    &$routeArr,
    &$param
]);

//组装页面
include DIR . 'main/view' . $view . 'header.php';
include $filePath . '';
include DIR . 'main/view/' . $view . 'footer.php';

