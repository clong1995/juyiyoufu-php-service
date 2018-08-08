<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);

namespace main\model\impl;


use main\model\Regional;
use main\db\impl;
use main\db\conn\Mysql;
use \Exception;

class RegionalImpl implements Regional
{
    private $mysql = null;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    public function province(): array
    {
        $handle = $this->mysql->pdo;
        $province = new impl\ProvincesImpl($handle);
        try {
            $res = $province->select(['provinceid', 'province']);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取省份失败！'];
        }
        return ['state' => 'success', 'data' => $res];
    }

    public function city(int $id): array
    {
        $handle = $this->mysql->pdo;
        $city = new impl\CitiesImpl($handle);
        try {
            $res = $city->select(['cityid', 'city'], ['provinceid' => $id]);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取市区失败！'];
        }
        return ['state' => 'success', 'data' => $res];
    }

    public function area(int $id): array
    {
        $handle = $this->mysql->pdo;
        $area = new impl\AreasImpl($handle);
        try {
            $res = $area->select(['areaid', 'area'], ['cityid' => $id]);
        } catch (Exception $e) {
            return ['state' => 'fail', 'data' => '获取区县失败！'];
        }
        return ['state' => 'success', 'data' => $res];
    }

}