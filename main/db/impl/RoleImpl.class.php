<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace db\impl;

use db\Role;
use conn\mysql;

class RoleImpl extends AbstractBase implements Role
{
    public function getAll()
    {
        return mysql::query('
            SELECT
                role_id,
                role_info.name as role_name,
                role_info.info as role_info,
                privilege_type.name as privilege_type,
                privilege_info.name as privilege_name
            FROM
                role
            INNER JOIN role_info USING ( role_id )
            INNER JOIN role_privilege_relation USING ( role_id )
            INNER JOIN privilege_info USING ( privilege_id )
            INNER JOIN privilege_type USING ( privilege_type_id )
        ');
    }

    public function relPrivilege($roleId, $privilegeId)
    {
        return mysql::update('INSERT INTO role_privilege_relation (role_id, privilege_id) VALUES (:roleId,:privilegeId)', [
            ['roleId' => $roleId, 'privilegeId' => $privilegeId]
        ]);
    }

    /**
     *
     * @param $roleId
     * @return array|bool
     */
    public function getAllById($roleId)
    {
        return mysql::query('
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
}