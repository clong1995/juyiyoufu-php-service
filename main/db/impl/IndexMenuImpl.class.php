<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace db\impl;

use db\IndexMenu;

class IndexMenuImpl extends AbstractBase implements IndexMenu
{
    public function getAllByEmployeeId($employeeId)
    {
        return DB::query('
    SELECT index_menu.name as name,path,in_order,icon
    FROM index_menu 
	INNER JOIN privilege USING ( privilege_id ) 
	INNER JOIN menu_index_menu_group_relation USING ( index_menu_id )
	INNER JOIN employee_info USING ( index_menu_group_id ) 
    WHERE employee_info.employee_id =  :employeeId
    ORDER BY in_order
    ',
            ['employeeId' => $employeeId]
        );
    }

}