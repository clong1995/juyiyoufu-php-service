<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

namespace EasyPhp\util;

final class Util
{
    /**
     * 查询session
     * @param $key
     * @return bool
     */
    public static function hasSession($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    /**
     * 获取cession
     * @param $key
     * @return null
     */
    public static function getSession($key)
    {
        return self::hasSession($key) ? $_SESSION[$key] : null;
    }

    /**
     * 增加session
     * @param $key
     * @param $value
     */
    public static function setSession($key, $value)
    {
        if (self::hasSession($key))
            exit('session已存在！');
        $_SESSION[$key] = $value;
    }

    /**
     * 删除session
     * @param $key
     */
    public static function delSession($key)
    {
        if ($key === 'ALL') {
            session_destroy();
        } else {
            if (!self::hasSession($key))
                exit('要删除的session不存在！');
            unset($_SESSION[$key]);
        }

    }

    /**
     * 更新session
     * @param $key
     * @param $value
     */
    public static function updateSession($key, $value)
    {
        if (!self::hasSession($key))
            exit('session不存在！');
        $_SESSION[$key] = $value;
    }

    /**
     * 销毁session
     * @param $varArr
     */
    public static function destroy($varArr)
    {
        foreach ($varArr as &$value) {
            $value = null;
            unset($value);
        }
    }

    /**
     * 404
     * @param $mag
     */
    public static function notFound($mag)
    {
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        self::response('fail', ['massage' =>  $mag]);
        exit();
    }

    /**
     * 输出
     * @param $type
     * @param $arr
     */
    public static function response($type, $arr)
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

    /**
     * 输出
     * @param $length
     * @return string
     */
    public static function randStr($length)
    {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789~!@#$%^&*()_+`-=<>?,./{}|[]';
        $len = strlen($str) - 1;
        $rand = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $rand .= $str[$num];
        }
        return $rand;
    }


    /**
     * 下划线转驼峰
     * @param $str
     * @return null|string|string[]
     */
    public static function camelize($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return $str;
    }

    /**
     * 驼峰转下划线
     * @param $str
     * @return null|string|string[]
     */
    public static function underscored($str)
    {
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;
    }


    /**
     * 发起http请求
     * @param $url
     * @param array $opt
     * @return mixed
     */
    public static function request($url, $opt = [
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

    /**
     * 发起http请求
     * @param $urls
     * @param $callback
     * @param null $custom_options
     * @return bool
     */
    public static function rolling_curl($urls, $callback, $custom_options = null)
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


}