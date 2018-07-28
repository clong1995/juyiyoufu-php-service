<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

declare(strict_types=1);

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
    private $connInfo = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'nurse',
        'username' => 'nurse',
        'passwd' => 'jyyf2018'
    ];

    public function __construct()
    {
        parent::__construct($this->connInfo);
    }
}