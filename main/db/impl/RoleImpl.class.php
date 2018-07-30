<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

declare(strict_types=1);

namespace main\db\impl;

use main\db\Role;

class RoleImpl extends AbstractMysqlBase implements Role
{
    /**
     * @param int $start
     * @param int $size
     * @return array
     */
    public function getLimit(int $start, int $size): array
    {
        return $this->exec->query('
            SELECT
                role_id,
                role_info.name AS role_name,
                role_info.info AS role_info,
                group_concat(privilege_type.name) AS privilege_type,
                group_concat(privilege_info.privilege_id) as privilege_id,
                group_concat(privilege_info.name) as privilege_name
            FROM
                role
            INNER JOIN role_info USING ( role_id )
            INNER JOIN role_privilege_relation USING ( role_id )
            INNER JOIN privilege_info USING ( privilege_id )
            INNER JOIN privilege_type USING ( privilege_type_id )
            group by role_id
            LIMIT :start,:size', [
            'start' => $start,
            'size' => $size
        ]);
    }

    /**
     * @param int $roleId
     * @param int $privilegeId
     * @return array
     */
    public function relPrivilege(int $roleId, int $privilegeId): array
    {
        return $this->exec->update('INSERT INTO role_privilege_relation (role_id, privilege_id) VALUES (:roleId,:privilegeId)', [
            ['roleId' => $roleId, 'privilegeId' => $privilegeId]
        ]);
    }

    /**
     * @param int $roleId
     * @return array
     */
    public function getById(int $roleId): array
    {
        return $this->exec->query('
            SELECT 
                role_id, 
                role_info.name as role_name, 
                role_info.info as role_info, 
                privilege_info.privilege_id as privilege_id, 
                privilege_type.name as privilege_type, 
                privilege_info.name as privilege_name 
            FROM role 
            INNER JOIN role_info USING ( role_id ) 
            INNER JOIN role_privilege_relation USING ( role_id ) 
            INNER JOIN privilege_info USING ( privilege_id ) 
            INNER JOIN privilege_type USING ( privilege_type_id )
            WHERE
            role_id = :roleId
        ', ['roleId' => $roleId]);
    }

    /**
     * @param int $roleId
     * @param int $privilegeId
     * @return array
     */
    public function delPrivilege(int $roleId, int $privilegeId): array
    {
        return $this->exec->update('DELETE FROM role_privilege_relation WHERE role_id = :roleId AND privilege_id = :privilegeId', [
            ['roleId' => $roleId, 'privilegeId' => $privilegeId]
        ]);
    }
}