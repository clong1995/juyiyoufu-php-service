<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace main\db\impl;

use main\db\User;


class UserImpl extends AbstractMysqlBase implements User
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