<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午2:15
 */

declare(strict_types=1);

namespace main\db;


interface Base
{
    public function insert(array $param): array;

    public function delete(array $condition): array;

    public function update(array $param, array $condition): array;

    public function select(array $field, array $condition): array;

    public function count(array $condition): int;
}