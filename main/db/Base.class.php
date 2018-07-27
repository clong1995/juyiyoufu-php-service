<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午2:15
 */

namespace main\db;


interface Base
{
    public function insert($param);

    public function delete($condition);

    public function update($param, $condition);

    public function select($field, $condition);

    public function count($condition);
}