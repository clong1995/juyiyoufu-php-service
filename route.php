<?php
date_default_timezone_set("PRC");
define('DIR', dirname(__FILE__) . '/');

//接收路由
$route = $_GET['route'];
$_GET['route'] = null;
unset($_GET['route']);


if (!$route) $route = 'index';

//路由数组
$routeArr = explode('/', $route);

//聚合请求参数
$param = array_merge($_GET, $_POST,$_FILES);


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

    //自动加载
    autoload();
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

//几个方法
function autoload()
{
    spl_autoload_register(function ($class_name) {
        $class_name = str_replace('\\', '/', $class_name);
        $file = DIR . 'main/' . $class_name . '.class.php';
        if (file_exists($file)) {
            require_once $file.'';
        }else{
            notFound($file);
        }
    });
}

function destroy($varArr)
{
    foreach ($varArr as &$value) {
        $value = null;
        unset($value);
    }
}

//404
function notFound($mag){
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    response('fail', array('massage' => 'not found ' . $mag));
    exit();
}

//输出
function response($type, $arr)
{
    $res = array();
    if ($type === 'success') {
        $res['state'] = 'success';
    } else {
        $res['state'] = 'fail';
    }
    $res['data'] = $arr;
    exit(json_encode($res, JSON_UNESCAPED_UNICODE));
}

//发起http请求
function request($url, $opt = [
    'method' => 'GET',
    'data' => [],
    'head' => []
])
{
    $curl = curl_init(); // 启动一个CURL会话
    $query_str = '';
    if (sizeof($opt['data'])) {
        $query_str = http_build_query($opt['data']);
    }
    if ($query_str && $opt['method'] == 'GET') {
        $url .= '?' . $query_str;
    }
    if ($opt['method'] !== 'GET') {
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query_str); // Post提交的数据包
    }

    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);//不使用缓存


    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        $tmpInfo .= curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return json_decode($tmpInfo, true); // 返回数据
}

function rolling_curl($urls, $callback, $custom_options = null)
{

    $rolling_window = 5;
    $rolling_window = (sizeof($urls) < $rolling_window) ? sizeof($urls) : $rolling_window;

    $master = curl_multi_init();
    $curl_arr = array();

    //设置curl参数
    $std_options = array(CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5);
    $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;

    //初始化curl资源队列
    $arr_chs = array();
    for ($i = 0; $i < $rolling_window; $i++) {
        $arr_chs[$urls[$i]] = curl_init();
        $options[CURLOPT_URL] = $urls[$i];
        curl_setopt_array($arr_chs[$urls[$i]], $options);
        curl_multi_add_handle($master, $arr_chs[$urls[$i]]);
    }

    do {
        while (($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM) ;
        if ($execrun != CURLM_OK) {
            break;
        }
        while ($done = curl_multi_info_read($master)) {
            $info = curl_getinfo($done['handle']);
            if ($info['http_code'] == 200) {

                $content = curl_multi_getcontent($done['handle']);
                $callback($content);

                //新建一个curl资源并加入并发队列
                if ($i < sizeof($urls)) {
                    $arr_chs[$urls[$i]] = curl_init();
                    $options[CURLOPT_URL] = $urls[$i];  // increment i
                    curl_setopt_array($arr_chs[$urls[$i]], $options);
                    curl_multi_add_handle($master, $arr_chs[$urls[$i]]);
                    //TODO 要累加i
                }

                curl_multi_remove_handle($master, $done['handle']);
                curl_close($done['handle']);
            } else {

                echo curl_errno($done['handle']), ":", curl_error($done['handle']), "\n";
            }
        }
    } while ($running);

    curl_multi_close($master);
    return true;
}