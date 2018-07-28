<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace main\model\impl;

use main\db\conn\Mysql;
use main\model\Power;
use main\db\impl;
use \Exception;

class PowerImpl implements Power
{
    //数据库句柄
    private $mysql = null;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * 增加权限
     * @param $data
     * @return array|mixed
     * @throws Exception
     */
    public function add($data)
    {
        //TODO 过滤数据

        try{
            //开启事物
            $this->mysql->transaction(function ($pdo) use ($data){
                //T1:增加权限
                $privilege = new impl\PrivilegeImpl($pdo);
                $res = $privilege->insert([
                    ['path' => $data['path']]
                ]);

                //T2:增加权限信息
                $privilegeInfo = new impl\PrivilegeInfoImpl($pdo);
                $privilegeInfo->insert([
                    ['privilege_id' => $res['data']['id'], 'name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
                ]);
            });
        }catch (Exception $e){
            return ['state' => 'fail', 'data' => '添加失败','exception'=>$e];
        }

        return ['state' => 'success', 'data' => '添加成功'];
    }

    /**
     * TODO 要开启事物
     * @param $data
     * @return array
     */
    public function update($data)
    {
        $returnData = ['state' => 'success', 'data' => '修改成功'];
        $privilege = new impl\PrivilegeImpl($this->handle);

        //权限修改
        $privilege->update([
            ['path' => $data['path']]
        ], [
            ['privilege_id' => $data['id']]
        ]);

        //修改信息
        $privilegeInfo = new impl\PrivilegeInfoImpl($this->handle);
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
        $privilege = new impl\PrivilegeImpl($this->handle);

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
        $privilege = new impl\PrivilegeImpl($this->handle);
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
        $privilege = new impl\PrivilegeImpl($this->handle);
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
        $privilegeType = new impl\PrivilegeTypeImpl($this->handle);
        $res = $privilegeType->select(['privilege_type_id', 'name']);
        return $res;
    }

}