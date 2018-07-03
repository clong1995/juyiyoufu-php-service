<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 1:58
 */

namespace db\impl;

use \PDO;

final class DB
{
    //数据库链接信息
    private static $connInfo = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'nurse',
        'username' => 'nurse',
        'passwd' => 'nurse'
    ];

    //PDO
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

    //查询
    public static function query($sql, $param = [])
    {
        $pdostatement = self::pdo()->prepare($sql);
        $res =  $pdostatement->execute($param);
        if($res){
            $res =  $pdostatement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $res;
    }

    //更新
    public static function update($sql, $param = [])
    {
        $pdostatement = self::pdo()->prepare($sql);
        $res = true;
        if(isset($param[0])){//批处理
            foreach ($param as $value) {
                $res = $pdostatement->execute($value);
                if (!$res) break;
            }
        }else{
            $res = $pdostatement->execute($param);
        }
        if($res){
            $res =  ['count' => $pdostatement->rowCount(), 'id' => self::pdo()->lastInsertId()];
        }
        return $res;
    }

    //防止内部开发者注入，其实没有这个必要，就是防止写出蹩脚的代码
    public static function clean($keys)
    {
        foreach ($keys as $item => $value) {
            $keys[$item] = preg_replace('/[^0-9a-zA-Z_]+/', '', $value);
        }
        return $keys;
    }
}