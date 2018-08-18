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

    /**
     * @param int $userId
     * @param int $type
     * @return array
     * @throws \Exception
     */
    public function getAllByUserId(int $userId, int $type): array
    {
        return $this->exec->query('
            SELECT 
              path 
            FROM 
              privilege 
            INNER JOIN role_privilege_relation USING ( privilege_id ) 
            INNER JOIN user_info USING ( role_id ) 
            WHERE (privilege_type = 8 OR privilege_type = :type)
            AND user_info.user_id = :userId
          ', [
                'userId' => $userId,
                'type' => $type
            ]
        );
    }

    /**
     * 根据id获取权限
     * @param int $id
     * @return array
     */
    /*public function getById(int $id): array
    {
        return $this->exec->query('
            SELECT
                privilege_id AS id,
                name,
                info,
                privilege_type AS type,
                path 
            FROM
                privilege
            WHERE
                privilege_id = :id
        ', ['id' => $id]);
    }*/

    /**
     * 返回所有权限
     * @return array
     */
    /*public function getAll(): array
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
    }*/

    /**
     * 用于分页
     * @param int $start
     * @param int $size
     * @return array
     * @throws \Exception
     */
    public function getLimit(int $start, int $size): array
    {
        return $this->exec->query('
          SELECT 
            privilege_id AS id,
            privilege.name AS name,
            privilege.info AS info,
            path,
            type.name AS type
          FROM 
            privilege
          LEFT JOIN type ON privilege_type = type_id
          LIMIT :start,:size
          ', [
            'start' => $start,
            'size' => $size
        ]);
    }
}