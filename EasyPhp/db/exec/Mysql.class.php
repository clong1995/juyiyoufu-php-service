<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-21
 * Time: 下午6:18
 */

namespace EasyPhp\db\exec;

use \PDO;

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
    public function query($sql, array $param = [])
    {
        $pdostatement = $this->pdo->prepare($sql);
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
    public function update($sql, array $param = [])
    {
        $pdostatement = $this->pdo->prepare($sql);
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
                $data = $res ? ['id' => $this->pdo->lastInsertId()] : [];
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
    public function key(array $param)
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