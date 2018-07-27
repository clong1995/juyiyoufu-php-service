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

class PowerImpl extends AbstractBase implements Power
{

    /**
     * TODO 这里应该开启事物
     * 增加权限
     * @param $data
     * @return array
     */
    public function add($data)
    {

        $pdo = $this->pdo;

        $returnData = ['state' => 'success', 'data' => '添加成功'];

        //TODO 过滤数据
        $privilege = new impl\PrivilegeImpl();


        //增加权限
        $res = $privilege->insert([
            ['path' => $data['path']]
        ]);

        //增加权限信息
        $privilegeInfo = new impl\PrivilegeInfoImpl();
        $res = $privilegeInfo->insert([
            ['privilege_id' => $res['data']['id'], 'name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
        ]);



        if ($res['state'] != 'success') {//失败
            $returnData['state'] = 'fail';
            $returnData['data'] = '权限增加失败';
        }

        return $returnData;
    }

    /**
     * TODO 要开启事物
     * @param $data
     * @return array
     */
    public function update($data)
    {
        $returnData = ['state' => 'success', 'data' => '修改成功'];
        $privilege = new impl\PrivilegeImpl();

        //权限修改
        $privilege->update([
            ['path' => $data['path']]
        ], [
            ['privilege_id' => $data['id']]
        ]);

        //修改信息
        $privilegeInfo = new impl\PrivilegeInfoImpl();
        $res = $privilegeInfo->update([
            ['name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
        ], [
            ['privilege_id' => $data['id']]
        ]);

        if ($res['state'] != 'success') {
            $returnData = ['state' => 'fail', 'data' => '修改失败'];
        }
        return $returnData;
    }


    public function delById($id)
    {
        $returnData = ['state' => 'success', 'data' => '删除成功'];
        $privilege = new impl\PrivilegeImpl();

        //查询这个人是否真的有这个权限

        //执行删除
        $res = $privilege->delete([['privilege_id' => $id]]);
        if ($res['state'] != 'success') {//失败
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
     * TODO 判断结果正确性
     * @param $id
     * @return mixed
     */
    public function getPowerById($id)
    {
        $privilege = new impl\PrivilegeImpl();
        $res = $privilege->getPowerById($id);
        if ($res['state'] != 'success') {
            $res['data'] = '根据id获取权限失败';
        } else {
            $res['data'] = $res['data'][0];
        }
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