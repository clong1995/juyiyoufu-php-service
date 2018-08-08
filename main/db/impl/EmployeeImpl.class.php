<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace main\db\impl;

use main\db\Employee;


class EmployeeImpl extends AbstractMysqlBase implements Employee
{
    public function has(int $id, string $phone): array
    {
        return $this->exec->query('
            SELECT count( * ) AS count 
            FROM employee 
            WHERE phone = :phone
            AND id != :id
        ', ['id' => $id, 'phone' => $phone]);
    }
}