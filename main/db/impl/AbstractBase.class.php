<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午6:07
 */

namespace db\impl;
use conn\mysql;

abstract class AbstractBase
{
    //强制要求子类定义这些方法
    //abstract protected function sql();

    //private $table = get_class($this);

    protected function tableName()
    {
        $name = get_class($this);
        $arr = explode('\\', $name);
        $className = array_pop($arr);
        $tableName = str_replace('Impl', '', $className);
        $tableName = lcfirst($tableName);
        $tableName = underscored($tableName);
        return strtolower($tableName);
    }

    // 增加
    public function insert($param)
    {
        $keys = mysql::key($param);
        $sql = 'insert into ' . $this->tableName() . ' (' . implode(',', $keys) . ') values(:' . implode(',:', $keys) . ')';
        return mysql::update($sql, $param);
    }

    //根据条件
    public function delete($condition)
    {
        $keys = mysql::key($condition);
        $con = [];
        foreach ($keys as $v)
            array_push($con, $v . '=:' . $v);
        return mysql::update('delete from ' . $this->tableName() . ' where ' . implode(' and ', $con), $condition);
    }

    /**
     * 根据条件更新
     * @param $param
     * @param array $condition
     * @return array|bool
     *
     * ([[],[]],[[],[]])
     *
     */
    public function update($param,$condition)
    {
        $keys = mysql::key($param);
        $field = [];
        foreach ($keys as $v) {
            array_push($field, $v . '=:' . $v);
        }

        $con = [];
        $keys = mysql::key($condition);
        foreach ($keys as $v) {
            array_push($con, $v . '=:' . $v);
        }

        $arr = [];
        foreach ($param as $key => $value)
            array_push($arr,array_merge($value,$condition[$key]));

        return mysql::update('update ' . $this->tableName() . ' set ' . implode(',', $field) . ' where ' . implode(',', $con), $arr);
    }

    //根据条件查询
    public function select($field, $condition = [])
    {
        $field = mysql::key($field);
        $sql = 'select ' . implode(',', $field) . ' from ' . $this->tableName();
        if (count($condition)) {
            $keys = mysql::key($condition);
            $con = [];
            foreach ($keys as $v) {
                array_push($con, $v . '=:' . $v);
            }
            $sql .= ' where ' . implode(' and ', $con);
        }
        return mysql::query($sql, $condition);
    }

    //根据条件计数
    public function count($condition)
    {
        $keys = mysql::key(array_keys($condition));
        $con = [];
        foreach ($keys as $v) {
            array_push($con, $v . '=:' . $v);
        }
            $res = mysql::query('select count(*) as count from ' . $this->tableName() . ' where ' . implode(' and ', $con), $condition);

        if($res['state'] == 'success'){
            $res['data']=$res['data'][0];
        }

        return $res;

    }
}