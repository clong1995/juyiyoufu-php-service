<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace db\impl;

use db\Privilege;

class PrivilegeImpl extends AbstractBase implements Privilege
{
    public function getAllByEmployeeId($employeeId)
    {
        return DB::query(
            'SELECT path FROM privilege INNER JOIN role_privilege_relation USING ( privilege_id ) INNER JOIN employee_info USING ( role_id ) WHERE employee_info.employee_id = :employeeId',
            ['employeeId' => $employeeId]
        );
    }

    public function getAll()
    {
        return DB::query('SELECT privilege.privilege_id AS id,privilege_info.name,info,privilege_type.NAME AS type,path FROM privilege_info INNER JOIN privilege_type USING (privilege_type_id) INNER JOIN privilege USING ( privilege_id )');
    }

}