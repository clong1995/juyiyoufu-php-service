<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Power;
use db\impl;

class PowerImpl implements Power
{
    /**
     * 增加权限
     * @param $data
     * @return array
     */
    public function add($data)
    {
        $returnData = ['state' => 'success', 'data' => '添加成功'];

        //TODO 过滤数据

        //增加权限
        $privilege = new impl\PrivilegeImpl();
        $res = $privilege->insert([
            ['path' => $data['path']]
        ]);
        if ($res['count']) {//成功
            //增加权限信息
            $privilegeInfo = new impl\PrivilegeInfoImpl();
            $res = $privilegeInfo->insert([
                ['privilege_id' => $res['id'], 'name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
            ]);
            if (!$res['count']) {//失败
                $returnData['state'] = 'fail';
                $returnData['data'] = '权限信息增加失败';
            }
        } else {//失败
            $returnData['state'] = 'fail';
            $returnData['data'] = '权限增加失败';
        }

        return $returnData;
    }


    public function delById($id)
    {
        $returnData = ['state' => 'success', 'data' => '删除成功'];
        $privilege = new impl\PrivilegeImpl();

        //查询这个人是否真的有这个权限
        $res = $privilege->getByEmployeeId(getSession('id'));

        //执行删除
        $res = $privilege->delete([['id' => $id]]);
        if (!$res['count']) {//失败
            $returnData['state'] = 'fail';
            $returnData['data'] = '权限删除失败';
        }
        return $returnData;
    }

    /**
     * 获取所有权限
     * @return array|bool
     */
    public function getAllPower()
    {
        $privilege = new impl\PrivilegeImpl();
        $res = $privilege->getAll();
        return $res;
    }

    /**
     * 获取管线类型
     * @return array|bool
     */
    public function getAllType()
    {
        $privilegeType = new impl\PrivilegeTypeImpl();
        $res = $privilegeType->select(['privilege_type_id', 'name']);
        return $res;
    }

}