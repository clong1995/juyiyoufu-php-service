<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

namespace main\db\conn;

use EasyPhp\db\handle\AbstractMysql;

/**
 * 链接指定地址的Mysql静态类
 * Class Mysql
 * @package db\conn
 */
final class Mysql extends AbstractMysql
{

    /**
     * 数据库链接信息
     * @var array
     */
    private static $connInfo = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'nurse',
        'username' => 'nurse',
        'passwd' => 'jyyf2018'
    ];

    /**
     * 获取当前链接信息的数据库句柄
     * @return null|\PDO
     */
    public static function getHandle(){
        return self::pdo(self::$connInfo);
    }

}