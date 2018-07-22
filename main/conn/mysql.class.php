<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

namespace conn;

use \PDO;
use \PDOException;

final class mysql
{
//数据库链接信息
    private static $connInfo = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'nurse',
        'username' => 'nurse',
        'passwd' => 'jyyf2018'
    ];

    /**
     * PDO
     * @return null|PDO
     */
    private static function pdo()
    {
        $pdo = null;
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$connInfo['host'] . ";port=" . self::$connInfo['port'] . ";dbname=" . self::$connInfo['dbname'],
                self::$connInfo['username'],
                self::$connInfo['passwd'],
                array(PDO::ATTR_PERSISTENT => true)//持久链接
            );
        } catch (PDOException $e) {
            die("数据库连接失败" . $e->getMessage());
        }
        return $pdo;
    }

    /**
     * 查询
     * @param $sql
     * @param array $param
     * @return array|bool
     */
    public static function query($sql, $param = [])
    {
        $pdostatement = self::pdo()->prepare($sql);
        $res = $pdostatement->execute($param);
        $data = [];
        if ($res) {
            $data = $pdostatement->fetchAll(PDO::FETCH_ASSOC);
        }
        $res = $res ? ['state' => 'success', 'data' => $data] : ['state' => 'fail', 'data' => $data];
        return $res;
    }

    /**
     * 更新
     * @param $sql
     * @param array $param
     * @return array|bool
     */
    public static function update($sql, $param = [])
    {
        $pdo = self::pdo();
        $pdostatement = $pdo->prepare($sql);
        $res = true;
        $data = [];
        //批处理
        foreach ($param as $value) {
            $res = $pdostatement->execute($value);
            if (!$res) break;
        }
        //只有一条，返回id
        if (count($param) == 1) {
            $type = strtolower(substr($sql, 0, 1));
            if ($type == 'u') {//更新
                $data = $res ? ['count' => $pdostatement->rowCount()] : [];
            } else if ($type == 'i') {//插入
                $data = $res ? ['id' => $pdo->lastInsertId()] : [];
            } else {//删除
                $data = [];
            }
        }
        $res = $res ? ['state' => 'success', 'data' => $data] : ['state' => 'fail', 'data' => $data];
        return $res;
    }

    /**
     * 检查模式，返回key
     * @param $param
     * @return mixed
     */
    public static function key($param)
    {
        if (is_array(reset($param))) {
            $isEqual = true;
            $keys = array_keys($param[0]);
            //检查模式是否一致
            foreach ($param as $value) {
                if (array_keys($value) !== $keys) {
                    $isEqual = !$isEqual;
                    break;
                }
            }
            if (!$isEqual) {
                $keys = [];
            }
        } else {
            $isIndexArr = true;
            foreach ($param as $key => $value) {
                if (is_string($key)) {
                    $isIndexArr = !$isIndexArr;
                    break;
                }
            }
            if (!$isIndexArr) { //kv数组
                $keys = array_keys($param);
            } else {
                $keys = $param;
            }
        }
        foreach ($keys as $key => $value) {
            $keys[$key] = preg_replace('/[^0-9a-zA-Z_]+/', '', $value);
        }
        return $keys;
    }
}