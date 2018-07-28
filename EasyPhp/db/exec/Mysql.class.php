<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

declare(strict_types=1);

namespace EasyPhp\db\exec;

use \PDO;
use \Exception;

class Mysql
{
    private $pdo = null;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 查询
     * @param $sql
     * @param array $param
     * @return array|bool
     */
    public function query(string $sql, array $param = []) : array
    {
        $data = [];
        $pdostatement = $this->pdo->prepare($sql);
        $res = $pdostatement->execute($param);
        if ($res) {
            $data = $pdostatement->fetchAll(PDO::FETCH_ASSOC);
        }else{
            new Exception('SQL:'.$sql.'\nPARAMS:'.json_encode($param));
        }
        return $data;
    }

    /**
     * 更新
     * @param $sql
     * @param array $param
     * @return array
     */
    public function update(string $sql, array $param = []) : array
    {
        $pdostatement = $this->pdo->prepare($sql);
        $res = true;
        $data = [];

        //批处理
        foreach ($param as $key=>$value) {
            $res = $pdostatement->execute($value);
            if (!$res) {
                new Exception('AT:'.$key.'\nSQL:'.$sql.'\nPARAMS:'.json_encode($value));
                break;
            }
        }

        //只有一条，返回id
        if (count($param) == 1) {
            $type = strtolower(substr($sql, 0, 1));
            if ($type == 'u') {//更新
                $data = $res ? ['count' => $pdostatement->rowCount()] : [];
            } else if ($type == 'i') {//插入
                $data = $res ? ['id' => $this->pdo->lastInsertId()] : [];
            } else {//删除
                $data = [];
            }
        }

        return $data;
    }

    /**
     * 检查模式，返回key
     * @param $param
     * @return mixed
     */
    public function key(array $param) : array
    {
        if (is_array(reset($param))) {
            $keys = array_keys($param[0]);
            //检查模式是否一致
            foreach ($param as $key=>$value) {
                if (array_keys($value) !== $keys) {
                    new Exception('nAT:'.$key.'\nKEY:'.json_encode($value));
                    break;
                }
            }
        } else {
            $keys = array_keys($param);
            if($keys[0] === 0){//索引数组
                $keys = $param;
            }
        }
        //过滤非法值
        foreach ($keys as &$value) {
            $value = preg_replace('/[^0-9a-zA-Z_]+/', '', $value);
        }
        return $keys;
    }
}