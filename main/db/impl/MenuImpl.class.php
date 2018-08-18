<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

declare(strict_types=1);

namespace main\db\impl;

use main\db\Menu;
use \Exception;

class MenuImpl extends AbstractMysqlBase implements Menu
{
    /**
     * @param int $userId
     * @param int $type
     * @return array
     * @throws Exception
     */
    public function getAllByUserId(int $userId,int $type): array
    {
        $res = $this->exec->query('
                SELECT
                    menu_id AS id,
                    menu.name AS name,
                    in_order,
                    icon,
                    path,
                    type_id as type,
                    parent_id as parent
                FROM
                    menu
                left JOIN type ON menu_type_id = type_id
                left JOIN privilege USING ( privilege_id )
                left JOIN role_privilege_relation USING ( privilege_id )
                left JOIN user_info USING ( role_id ) 
                WHERE user_id = :userId 
                AND privilege_type = :type
            ',
            [
                'userId' => $userId,
                'type'=>$type
            ]
        );
        return $res;
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
            menu.menu_id as id,
            menu.name as name,
            path,
            in_order,
            icon,
            menu_type.name as type
            FROM menu 
            INNER JOIN menu_type USING ( menu_type_id )
            INNER JOIN privilege USING ( privilege_id )
            INNER JOIN menu_role_relation USING ( menu_id )
            ORDER BY in_order
            LIMIT :start,:size
          ', [
            'start' => $start,
            'size' => $size
        ]);
    }

}