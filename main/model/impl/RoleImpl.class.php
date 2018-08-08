<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);

namespace main\model\impl;


use main\model\Role;
use main\db\impl;
use main\db\conn\Mysql;
use \Exception;

class RoleImpl implements Role
{
    //数据库句柄
    private $pageSize = 6;
    private $mysql = null;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    public function update(array $data): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleInfoImpl($handle);
        try {
            $role->update([
                ['name' => $data['name'], 'info' => $data['info']]
            ], [
                ['role_id' => $data['id']]
            ]);
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '获取角色列表失败！'];
        }
        return ['state' => 'success', 'data' => '修改角色成功!'];
    }

    public function add(array $data): array
    {
        try {
            //开启事物
            $this->mysql->transaction(function ($handle) use ($data) {
                //T1:创建角色
                $role = new impl\RoleImpl($handle);
                $res = $role->insert([['name' => $data['role_name']]]);
                $role_id = $res['id'];

                //T2:添加角色信息
                $roleInfo = new impl\RoleInfoImpl($handle);
                $roleInfo->insert([['role_id' => $role_id, 'name' => $data['name'], 'info' => $data['info']]]);

                //T3:权限关联角色
                $insertData = [];
                foreach (explode(",", $data['privilege']) as $value) {
                    array_push($insertData, [
                        'role_id' => $role_id,
                        'privilege_id' => $value
                    ]);
                }
                $RolePrivilegeRelation = new impl\RolePrivilegeRelationImpl($handle);
                $RolePrivilegeRelation->insert($insertData);
            });
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '添加角色失败！'];
        }
        return ['state' => 'success', 'data' => '添加角色成功!'];
    }


    /**
     * @param array $data
     * @return array
     */
    public function delPrivilege(array $data): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        try {
            $role->delPrivilege((int)$data['roleId'], (int)$data['privilegeId']);
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '解除角色关联权限失败！'];
        }
        return ['state' => 'success', 'data' => '解除角色关联权限成功！'];
    }

    /**
     * @param int $page
     * @return array
     */
    public function getPage(int $page): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        $start = ($page - 1) * $this->pageSize;
        try {
            $res = $role->getLimit($start, $this->pageSize);
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '获取角色列表失败！'];
        }

        $map = [];
        foreach ($res as $value) {
            $role = [
                'role' => [
                    'id' => $value['role_id'],
                    'name' => $value['role_name'],
                    'info' => $value['role_info']
                ],
                'privilege' => []
            ];

            if ($value['privilege_id'] != '') {
                $privilege_id_arr = explode(',', $value['privilege_id']);
                $privilege_type_arr = explode(',', $value['privilege_type']);
                $privilege_name_arr = explode(',', $value['privilege_name']);
                foreach ($privilege_id_arr as $item2 => $value2) {
                    array_push($role['privilege'], [
                        'id' => $value2,
                        'name' => $privilege_name_arr[$item2],
                        'type' => $privilege_type_arr[$item2]
                    ]);
                }
            }
            array_push($map, $role);
        }

        return ['state' => 'success', 'data' => $map];
    }

    /**
     * @param int $roleId
     * @return array
     */
    public function getById(int $roleId): array
    {
        //TODO 过滤数据
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        $res = $role->getById($roleId);
        $data = $res[0];
        $map = [
            'id' => $data['role_id'],
            'name' => $data['role_name'],
            'info' => $data['role_info'],
            'privilege' => []
        ];

        foreach ($res as $value) {
            array_push($map['privilege'], [
                'id' => $value['privilege_id'],
                'name' => $value['privilege_name'],
                'type' => $value['privilege_type']
            ]);
        }
        return ['state' => 'success', 'data' => $map];
    }

    public function relPrivilege(int $roleId, int $privilegeId): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        try {
            $role->relPrivilege($roleId, $privilegeId);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '关联失败'];
        }
        return ['state' => 'success', 'data' => '关联成功'];
    }

    /**
     * 获取总页数
     * @param int $pageSize
     * @return array
     */
    public function totalPage(): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        try {
            $res = ceil($role->count() / $this->pageSize);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取总页数失败'];
        }
        return ['state' => 'success', 'data' => $res];
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        $handle = $this->mysql->pdo;
        $role = new impl\RoleImpl($handle);
        try {
            $role->delete([['role_id' => $id]]);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '删除角色失败'];
        }
        return ['state' => 'success', 'data' => '删除角色成功'];
    }
}