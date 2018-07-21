<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

namespace model;


interface Power
{
    /**
     * 添加权限
     * @param $data
     * @return mixed
     */
    public function add($data);

    public function update($data);

    /**
     * 删除权限
     * @param $id
     * @return mixed
     */
    public function delById($id);

    /**
     * 获取所有权限
     * @return mixed
     */
    public function getAllPower();

    public function getPowerById($id);

    /**
     * 获取权限类型
     * @return mixed
     */
    public function getAllType();
}