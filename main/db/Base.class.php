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
    public function insert(array $param);

    public function delete(array $condition);

    public function update(array $param, array $condition);

    public function select(array $field, array $condition);

    public function count(array $condition);
}