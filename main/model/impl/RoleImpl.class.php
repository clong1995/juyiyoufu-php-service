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
    private $handle = null;

    public function __construct()
    {
        $mysql = new Mysql();
        $this->handle = $mysql->pdo;
    }

    public function update(array $data): array
    {
        $role = new impl\RoleInfoImpl($this->handle);
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


    /**
     * @param array $data
     * @return array
     */
    public function delPrivilege(array $data): array
    {
        $role = new impl\RoleImpl($this->handle);
        try {
            $role->delPrivilege((int)$data['roleId'],(int)$data['privilegeId']);
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '解除角色关联权限失败！'];
        }
        return ['state' => 'success', 'data' => '解除角色关联权限成功！'];
    }

    /**
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getPage(int $page, int $size): array
    {
        $role = new impl\RoleImpl($this->handle);
        $start = ($page - 1) * $size;
        try {
            $res = $role->getLimit($start, $size);
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '获取角色列表失败！'];
        }

        $map = [];
        foreach ($res as $value) {
            $role_id = $value['role_id'];
            //if (!array_key_exists($role_id, $map))
            $map[$role_id] = [
                'role' => [
                    'name' => $value['role_name'],
                    'info' => $value['role_info']
                ],
                'privilege' => []
            ];

            $privilege_id_arr = explode(',', $value['privilege_id']);
            $privilege_type_arr = explode(',', $value['privilege_type']);
            $privilege_name_arr = explode(',', $value['privilege_name']);


            foreach ($privilege_id_arr as $item2 => $value2) {
                array_push($map[$role_id]['privilege'], [
                    'id' => $value2,
                    'name' => $privilege_name_arr[$item2],
                    'type' => $privilege_type_arr[$item2]
                ]);
            }
        }

        return $map;
    }

    /**
     * @param int $roleId
     * @return array
     */
    public function getById(int $roleId): array
    {
        //TODO 过滤数据
        $role = new impl\RoleImpl($this->handle);
        $res = $role->getById($roleId);
        $map = [];
        foreach ($res as $key => $value) {
            if (!$key) {
                $map['role'] = [
                    'id' => $value['role_id'],
                    'name' => $value['role_name'],
                    'info' => $value['role_info']
                ];
                $map['privilege'] = [];
            }

            $map['privilege'][$value['privilege_id']] = [
                'name' => $value['privilege_name'],
                'type' => $value['privilege_type'],
            ];
        }
        return $map;
    }

    public function relPrivilege(int $roleId, int $privilegeId): array
    {
        $role = new impl\RoleImpl($this->handle);
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
    public function totalPage(int $pageSize): array
    {
        $role = new impl\RoleImpl($this->handle);
        try {
            $res = ceil($role->count() / $pageSize);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取总页数失败'];
        }
        return ['state' => 'success', 'data' => $res];
    }
}