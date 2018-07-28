<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午6:07
 */

namespace EasyPhp\db\handle;

use \Exception;
use \PDO;
use \PDOException;

/**
 * 获取Mysql链接句柄的静态抽象类
 * Class AbstractMysql
 * @package db\handle
 */
abstract class AbstractMysql
{
    public $pdo = null;
    public function __construct($connInfo)
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . $connInfo['host'] . ";port=" . $connInfo['port'] . ";dbname=" . $connInfo['dbname'],
                $connInfo['username'],
                $connInfo['passwd'],
                array(PDO::ATTR_PERSISTENT => true)//持久链接
            );
        } catch (PDOException $e) {
            die("数据库连接失败" . $e->getMessage());
        }
    }

    /*
     *protected abstract function getHandle();
     * /

    /*
     protected function pdo($connInfo)
    {
        $pdo = null;
        try {
            $pdo = new PDO(
                "mysql:host=" . $connInfo['host'] . ";port=" . $connInfo['port'] . ";dbname=" . $connInfo['dbname'],
                $connInfo['username'],
                $connInfo['passwd'],
                array(PDO::ATTR_PERSISTENT => true)//持久链接
            );
        } catch (PDOException $e) {
            die("数据库连接失败" . $e->getMessage());
        }
        return $pdo;
    }*/

    /**
     * @param callable $fn
     * @throws Exception
     */
    public function transaction(callable $fn)
    {
        $this->pdo->beginTransaction();
        try {
            $fn($this->pdo);
            //提交事物
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }


}