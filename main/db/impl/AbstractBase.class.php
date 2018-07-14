<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午6:07
 */

namespace db\impl;

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
        $keys = DB::clean(array_keys($param[0]));
        return DB::update('insert into ' . $this->tableName() . ' (' . implode(',', $keys) . ') values(:' . implode(',:', $keys) . ')', $param);
    }

    //根据条件
    public function delete($param)
    {
        $keys = DB::clean(array_keys($param[0]));
        $condition = [];
        foreach ($keys as $v)
            array_push($condition, $v . '=:' . $v);
        return DB::update('delete from ' . $this->tableName() . ' where ' . implode(' and ', $condition), $param);
    }

    //根据条件更新
    public function update($param, $condition)
    {
        //TODO 未测试
        /*$keys = DB::clean($param);
        $keys1 = DB::clean($condition);
        $field = [];
        foreach ($keys as $v) {
            array_push($field, $v . '=:' . $v);
        }
        $con = [];
        foreach ($keys1 as $v) {
            array_push($con, $v . '=:' . $v);
        }
        return DB::update('update ' . $this->tableName() . ' set ' . implode(',', $field) . ' where ' . implode(',', $con), $param);*/
    }

    //根据条件查询
    public function select($field, $condition = [])
    {
        $field = DB::clean($field);
        $sql = 'select ' . implode(',', $field) . ' from ' . $this->tableName();
        if (is_array($condition) && count($condition)) {
            $keys = DB::clean(array_keys($condition));
            $con = [];
            foreach ($keys as $v) {
                array_push($con, $v . '=:' . $v);
            }
            $sql .= ' where ' . implode(' and ', $con);
        }

        return DB::query($sql, $condition);
    }

    //根据条件计数
    public function count($condition)
    {
        $keys = DB::clean(array_keys($condition));
        $con = [];
        foreach ($keys as $v) {
            array_push($con, $v . '=:' . $v);
        }
        return DB::query('select count(*) as count from ' . $this->tableName() . ' where ' . implode(' and ', $con), $condition);
    }
}