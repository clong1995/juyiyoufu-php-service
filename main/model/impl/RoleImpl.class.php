<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Role;
use db\impl;

class RoleImpl implements Role
{
    public function getAll()
    {
        //TODO 过滤数据
        $role = new impl\RoleImpl();
        $res = $role->getAll();
        $data = $res['data'];
        $map = [];
        foreach ($data as $value) {
            $role_id = $value['role_id'];
            if (!array_key_exists($role_id, $map))
                $map[$role_id] = [
                    'role' => [
                        'name' => $value['role_name'],
                        'info' => $value['role_info']
                    ],
                    'privilege' => []
                ];

            array_push($map[$role_id]['privilege'], [
                'name' => $value['privilege_name'],
                'type' => $value['privilege_type'],
            ]);
        }

        return $map;
    }

    public function getAllById($roleId)
    {
        //TODO 过滤数据
        $role = new impl\RoleImpl();
        $res = $role->getAllById($roleId);
        $data = $res['data'];
        $map = [];
        foreach ($data as $key => $value) {
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

    public function relPrivilege($roleId, $privilegeId)
    {
        $returnData = ['state' => 'success', 'data' => '关联成功'];
        $role = new impl\RoleImpl();
        $res = $role->relPrivilege($roleId, $privilegeId);
        if ($res['state'] != 'success')
            $returnData = ['state' => 'fail', 'data' => '关联失败'];

        return $returnData;
    }
}