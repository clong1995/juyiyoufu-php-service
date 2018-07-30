<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午6:07
 */
declare(strict_types=1);

namespace main\db\impl;

use EasyPhp\db\exec\Mysql;
use EasyPhp\util\Util;
use \PDO;

abstract class AbstractMysqlBase
{
    //强制要求子类定义这些方法
    //abstract protected function sql();

    //private $table = get_class($this);
    protected $exec = null;

    public function __construct(PDO $pdo)
    {
        $this->exec = new Mysql($pdo);
    }


    protected function tableName(): string
    {
        $name = get_class($this);
        $arr = explode('\\', $name);
        $className = array_pop($arr);
        $tableName = str_replace('Impl', '', $className);
        $tableName = lcfirst($tableName);
        $tableName = Util::underscored($tableName);
        return strtolower($tableName);
    }

    // 增加
    public function insert(array $param): array
    {
        $keys = $this->exec->key($param);
        $sql = 'insert into ' . $this->tableName() . ' (' . implode(',', $keys) . ') values(:' . implode(',:', $keys) . ')';
        return $this->exec->update($sql, $param);
    }

    //根据条件
    public function delete(array $condition): array
    {
        $keys = $this->exec->key($condition);
        $con = [];
        foreach ($keys as $v)
            array_push($con, $v . '=:' . $v);
        return $this->exec->update('delete from ' . $this->tableName() . ' where ' . implode(' and ', $con), $condition);
    }

    /**
     * 更新
     * @param array $param
     * @param array $condition
     * @return array
     */
    public function update(array $param, array $condition): array
    {
        //字段
        $keys = $this->exec->key($param);
        $field = [];
        foreach ($keys as $v) {
            array_push($field, $v . '=:' . $v);
        }

        //条件
        $con = [];
        $keys = $this->exec->key($condition);
        foreach ($keys as $v) {
            array_push($con, $v . '=:' . $v);
        }

        //集合参数
        $arr = [];
        foreach ($param as $key => $value)
            array_push($arr, array_merge($value, $condition[$key]));

        //执行
        return $this->exec->update('update ' . $this->tableName() . ' set ' . implode(',', $field) . ' where ' . implode(',', $con), $arr);
    }

    //根据条件查询
    public function select(array $field, array $condition = []): array
    {
        $field = $this->exec->key($field);
        $sql = 'select ' . implode(',', $field) . ' from ' . $this->tableName();
        if (count($condition)) {
            $keys = $this->exec->key($condition);
            $con = [];
            foreach ($keys as $v) {
                array_push($con, $v . '=:' . $v);
            }
            $sql .= ' where ' . implode(' and ', $con);
        }
        return $this->exec->query($sql, $condition);
    }

    //根据条件计数
    public function count(array $condition = []): int
    {
        $sql = 'select count(*) as count from ' . $this->tableName();
        $where = '';
        if (count($condition)) {
            $keys = $this->exec->key(array_keys($condition));
            $con = [];
            foreach ($keys as $v) {
                array_push($con, $v . '=:' . $v);
            }
            $where = ' where ' . implode(' and ', $con);
        }
        $sql .= $where;
        $res = $this->exec->query($sql, $condition);
        return (int)$res[0]['count'];
    }
}