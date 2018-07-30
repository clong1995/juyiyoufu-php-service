<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

declare(strict_types=1);

namespace main\db\impl;

use main\db\Privilege;

class PrivilegeImpl extends AbstractMysqlBase implements Privilege
{


    public function getAllByEmployeeId(int $employeeId): array
    {
        return $this->exec->query('
            SELECT 
              path 
            FROM 
              privilege 
            INNER JOIN role_privilege_relation USING ( privilege_id ) 
            INNER JOIN employee_info USING ( role_id ) 
            WHERE 
              employee_info.employee_id = :employeeId
          ', ['employeeId' => $employeeId]
        );
    }

    /**
     * 根据id获取权限
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return $this->exec->query('
            SELECT
                privilege.privilege_id AS id,
                privilege_info.name,
                info,
                privilege_info.privilege_type_id AS type,
                path 
            FROM
                privilege_info
                INNER JOIN privilege USING ( privilege_id ) 
            WHERE
                privilege.privilege_id = :id
        ', ['id' => $id]);
    }

    /**
     * 返回所有权限
     * @return array
     */
    public function getAll(): array
    {
        return $this->exec->query('
          SELECT 
            privilege.privilege_id AS id,
            privilege_info.name,
            info,
            privilege_type.NAME AS type,
            path 
          FROM 
            privilege_info 
          INNER JOIN privilege_type USING (privilege_type_id) 
          INNER JOIN privilege USING ( privilege_id )');
    }

    /**
     * 用于分页
     * @param int $start
     * @param int $size
     * @return array
     */
    public function getLimit(int $start, int $size): array
    {
        return $this->exec->query('
          SELECT 
            privilege.privilege_id AS id,
            privilege_info.name,
            info,
            privilege_type.NAME AS type,
            path 
          FROM 
            privilege_info 
          INNER JOIN privilege_type USING (privilege_type_id) 
          INNER JOIN privilege USING ( privilege_id ) 
          LIMIT :start,:size
          ', [
            'start' => $start,
            'size' => $size
        ]);
    }
}