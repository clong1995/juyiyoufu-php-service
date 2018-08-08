<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);

namespace main\model\impl;

use main\db\conn\Mysql;
use main\model\Power;
use main\db\impl;
use \Exception;

class PowerImpl implements Power
{
    //数据库句柄
    private $mysql = null;
    private $pageSize = 10;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * 增加权限
     * @param array $data
     * @return array
     */
    public function add(array $data): array
    {
        //TODO 过滤数据

        try {
            //开启事物
            $this->mysql->transaction(function ($pdo) use ($data) {
                //T1:增加权限
                $privilege = new impl\PrivilegeImpl($pdo);
                $res = $privilege->insert([
                    ['path' => $data['path']]
                ]);

                //T2:增加权限信息
                $privilegeInfo = new impl\PrivilegeInfoImpl($pdo);
                $privilegeInfo->insert([
                    ['privilege_id' => $res['id'], 'name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
                ]);
            });
        } catch (Exception $e) {
            //TODO 写日志
            return ['state' => 'fail', 'data' => '增加权限失败!'];
        }

        return ['state' => 'success', 'data' => '添加成功'];
    }

    /**
     * @param $data
     * @return array
     */
    public function update(array $data): array
    {
        try {
            //开启事物
            $this->mysql->transaction(function ($handle) use ($data) {
                //T1:修改权限
                $privilege = new impl\PrivilegeImpl($handle);
                $privilege->update([
                    ['path' => $data['path']]
                ], [
                    ['privilege_id' => $data['id']]
                ]);

                //T2:修改权限信息
                $privilegeInfo = new impl\PrivilegeInfoImpl($handle);
                $privilegeInfo->update([
                    ['name' => $data['name'], 'info' => $data['info'], 'privilege_type_id' => $data['type']]
                ], [
                    ['privilege_id' => $data['id']]
                ]);
            });
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '修改失败'];
        }

        return ['state' => 'success', 'data' => '修改成功'];
    }


    public function delById(int $id): array
    {
        $handle = $this->mysql->pdo;
        $returnData = ['state' => 'success', 'data' => '删除成功'];
        $privilege = new impl\PrivilegeImpl($handle);

        //TODO 查询这个人是否真的有这个权限

        //执行删除
        try {
            $privilege->delete([['privilege_id' => $id]]);
        } catch (Exception $e) {
            $returnData = ['state' => 'fail', 'data' => '权限删除失败'];
        }
        return $returnData;
    }

    /**
     * 获取所有权限
     * @return array
     */
    public function getAll(): array
    {
        $handle = $this->mysql->pdo;
        $privilege = new impl\PrivilegeImpl($handle);
        try {
            $res = $privilege->getAll();
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取权限列表失败'];
        }
        return ['state' => 'success', 'data' => $res];
    }


    /**
     * TODO 判断结果正确性
     * @param $id
     * @return mixed
     */
    public function getById(int $id): array
    {
        $handle = $this->mysql->pdo;
        $privilege = new impl\PrivilegeImpl($handle);
        try {
            $res = $privilege->getById($id);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取权限失败'];
        }
        return ['state' => 'success', 'data' => $res[0]];
    }

    /**
     * 获取管线类型
     * @return array
     */
    public function getAllType(): array
    {
        $handle = $this->mysql->pdo;
        $privilegeType = new impl\PrivilegeTypeImpl($handle);
        try {
            $res = $privilegeType->select(['privilege_type_id', 'name']);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取权类型限列表失败'];
        }

        return ['state' => 'success', 'data' => $res];
    }

    /**
     * 获取总页数
     * @param int $pageSize
     * @return array
     */
    public function totalPage(): array
    {
        $handle = $this->mysql->pdo;
        $privilege = new impl\PrivilegeImpl($handle);
        try {
            $res = ceil($privilege->count() / $this->pageSize);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取总页数失败'];
        }
        return ['state' => 'success', 'data' => $res];
    }

    /**
     * 用于分页
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getPage(int $page): array
    {
        $handle = $this->mysql->pdo;
        $privilege = new impl\PrivilegeImpl($handle);
        $start = ($page - 1) * $this->pageSize;
        try {
            $res = $privilege->getLimit($start, $this->pageSize);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取权限列表失败'];
        }
        return ['state' => 'success', 'data' => $res];
    }
}