<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

declare(strict_types=1);

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
     * @param $key
     * @param $value
     */
    public static function replaceSession($key, $value)
    {
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
        self::response(['state' => false, 'data' => $mag]);
        exit();
    }

    /**
     * 输出
     * @param $arr
     */
    public static function response($arr)
    {
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param array $data
     */
    public static function JSData(array $data)
    {
        echo 'const DATA = ' . json_encode($data, JSON_UNESCAPED_UNICODE) . ';';
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
     * @param int $length
     * @param array $type
     * @return string
     */
    public static function random($length = 4, $type = ['number', 'string', 'symbol','time'])
    {
        $number = '0123456789';
        $string = 'abcdefghijklmnopqrstuvwxyz';
        $symbol = '~!@#$%^&*()_+/*-<>?{}|:".-=`;,/';
        $time = time();

        $characters = '';
        foreach ($type as $value) {
            if ($value == 'number') {
                $characters .= $number;
            } else if ($value == 'string') {
                $characters .= $string;
            } else if ($value == 'symbol') {
                $characters .= $symbol;
            } else if ($value == 'time') {
                $characters .= $time;
            }
        }

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function readFile(string $path): string
    {
        $content = '';
        if (file_exists($path)) {
            $fileSize = filesize($path);
            if ($fileSize) {//有内容
                $content = file_get_contents($path);
            }
        } else {
            self::notFound($path);
        }
        return $content;
    }
}