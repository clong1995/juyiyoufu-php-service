<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);

namespace main\model\impl;


use EasyPhp\util\Util;
use main\model\Menu;
use main\db\impl;
use main\db\conn\Mysql;
use \Exception;

class MenuImpl implements Menu
{
    //数据库句柄
    private $mysql = null;
    private $pageSize = 20;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * 用于分页
     * @param int $page
     * @return array
     */
    public function getPage(int $page): array
    {
        $handle = $this->mysql->pdo;
        $menu = new impl\MenuImpl($handle);
        $start = ($page - 1) * $this->pageSize;
        try {
            $res = $menu->getLimit($start, $this->pageSize);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取权限菜单失败'];
        }
        return ['state' => true, 'data' => $res];
    }

    /**
     * 获取当前用户菜单
     * @return array
     */
    public function getIndex(): array
    {
        $handle = $this->mysql->pdo;
        $menu = new impl\MenuImpl($handle);
        try {
            $res = $menu->getAllByEmployeeId((int)Util::getSession('user_id'));
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => false, 'data' => '获取首页菜单失败！'];
        }

        foreach ($res as &$value) {
            $value = str_replace('pc/', '', $value);
        }

        return ['state' => true, 'data' => $res];
    }

    /**
     * 获取总页数
     * @return array
     */
    public function totalPage(): array
    {
        $handle = $this->mysql->pdo;
        $menu = new impl\MenuImpl($handle);
        try {
            $res = ceil($menu->count() / $this->pageSize);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取总页数失败'];
        }
        return ['state' => true, 'data' => $res];
    }

    /**
     * 获取管线类型
     * @return array
     */
    public function getAllType(): array
    {
        $handle = $this->mysql->pdo;
        $menuType = new impl\MenuTypeImpl($handle);
        try {
            $res = $menuType->select(['menu_type_id', 'name']);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取菜单型限列表失败'];
        }

        return ['state' => true, 'data' => $res];
    }

    public function add(array $data): array
    {
        //开启事物
        $res = $this->mysql->transaction(function ($pdo) use ($data) {
            //T1:添加菜单
            $menu = new impl\MenuImpl($pdo);
            $res = $menu->insert([
                ['name' => $data['name'], 'parent' => $data['parent']]
            ]);

            //T2:添加菜单信息
            $menuInfo = new impl\MenuInfoImpl($pdo);
            $menuInfo->insert([
                ['menu_id' => $res['id'], 'in_order' => $data['icon'], 'menu_type_id' => $data['type'], 'info' => $data['info']]
            ]);

            //T3 绑定权限

        });

        return $res? ['state'=>true,'data'=>'添加成功']:['state'=>false,'data'=>'添加失败'];
    }

    public function delete(int $id): array
    {
        // TODO: Implement delete() method.
        return [];
    }

    public function update(array $data): array
    {
        // TODO: Implement update() method.
        return [];
    }

}