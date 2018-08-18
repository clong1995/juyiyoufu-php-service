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
use main\model\Company;
use \Exception;
use main\db\impl;

class CompanyImpl implements Company
{

    private $mysql = null;
    private $pageSize = 6;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * TODO 这里应该开启事物
     * 增加权限
     * @param $data
     * @return array
     */
    public function add(array $data): array
    {
        //TODO 过滤数据

        //拿到 pdo
        $handle = $this->mysql->pdo;
        $company = new impl\CompanyImpl($handle);
        //查询公司是否存在
        $res = $company->count(['license' => $data['license']]);
        if (!$res) {
            $employee = new impl\EmployeeImpl($handle);
            //查询是否存在员工
            $res = $employee->count(['phone' => $data['phone']]);
            if (!$res) {
                try {
                    $this->mysql->transaction(function ($handle) use ($data) {
                        //T1:增加员工
                        $employee = new impl\EmployeeImpl($handle);
                        $employeeRes = $employee->insert([[
                            'phone' => $data['phone'],
                            'password' => strtoupper(md5('123456'))
                        ]]);

                        //T2:增加公司
                        $company = new impl\CompanyImpl($handle);
                        $companyRes = $company->insert([[
                            'name' => $data['companyName'],
                            'province' => (int)$data['province'],
                            'city' => (int)$data['city'],
                            'area' => (int)$data['area'],
                            'license' => $data['license'],
                            'license_img' => $data['licenseImg'],
                            'info' => $data['info'],
                            'employee_id' => (int)$employeeRes['id']
                        ]]);

                        //T3:增加员工信息
                        $employeeInfo = new impl\EmployeeInfoImpl($handle);
                        $employeeInfo->insert([[
                            'employee_id' => (int)$employeeRes['id'],
                            'name' => $data['name'],
                            'company_id' => (int)$companyRes['id'],
                            'role_id' => 2,
                            'menu_group_id' => 2
                        ]]);
                    });
                } catch (Exception $e) {
                    //TODO 日志
                    return ['state' => false, 'data' => '添加失败'];
                };

            } else {
                //员工已存在
                return ['state' => false, 'data' => '员工添已存在'];
            }
        } else {
            //公司已存在
            return ['state' => false, 'data' => '公司已存在'];
        }

        return ['state' => true, 'data' => '添加成功'];
    }

    /**
     * 修改公司
     * @param $data
     * @return array
     */
    public function update(array $data): array
    {
        //查询公司是否存在
        try {
            //开启事物
            $this->mysql->transaction(function ($handle) use ($data) {
                //T1:查询公公司是否存在
                $company = new impl\CompanyImpl($handle);
                $res = $company->has((int)$data['id'], (string)$data['license']);
                if ($res[0]['count'] == 0) {
                    //T2:查询是否存在员工
                    $employee = new impl\EmployeeImpl($handle);
                    $res = $employee->has((int)$data['employee'], (string)$data['phone']);
                    if ($res[0]['count'] == 0) {
                        //T3:修改员工
                        $employee->update([[
                            'phone' => $data['phone'],
                            'password' => strtoupper(md5('123456'))
                        ]], [[
                            'id' => $data['employee']
                        ]]);

                        //T3:修改员工信息
                        $employeeInfo = new impl\EmployeeInfoImpl($handle);
                        $employeeInfo->update([[
                            'name' => $data['name']
                        ]], [[
                            'employee_id' => $data['employee']
                        ]]);

                        //T4修改公司
                        $company->update([[
                            //TODO
                            'name' => $data['companyName'],
                            'province' => $data['province'],
                            'city' => $data['city'],
                            'area' => $data['area'],
                            'info' => $data['info'],
                            'license' => $data['license'],
                            'license_img' => $data['licenseImg']
                        ]], [
                            ['id' => $data['id']]
                        ]);
                    } else {
                        return ['state' => false, 'data' => '负责人电话已存在!'];
                    }
                } else {
                    return ['state' => false, 'data' => '公司已存在!'];
                }
            });
        } catch (Exception $e) {
            return ['state' => false, 'data' => '修改失败!'];
        }
        return ['state' => true, 'data' => '修改成功!'];
    }

    /**
     *
     */
    public function getAll(): array
    {
        $company = new impl\CompanyImpl();
        $res = $company->getAll();
        return $res;
    }


    /**
     * 根据id删除公司
     * @param $id
     * @return array|bool
     */
    public function delete(int $id): array
    {
        $handle = $this->mysql->pdo;
        $company = new impl\CompanyImpl($handle);
        try {
            $company->delete([['id' => $id]]);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '删除失败'];
        }
        return ['state' => true, 'data' => '删除成功'];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $handle = $this->mysql->pdo;
        $company = new impl\CompanyImpl($handle);
        try {
            $res = $company->getById($id);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取公司失败'];
        }

        return ['state' => true, 'data' => $res];
    }

    /**
     * 获取指定页的内容
     * @param int $page
     * @return array
     */
    public function getPage(int $page): array
    {
        $handle = $this->mysql->pdo;
        $company = new impl\CompanyImpl($handle);
        $start = ($page - 1) * $this->pageSize;
        try {
            $res = $company->getLimit($start, $this->pageSize);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取公司失败'];
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
        $company = new impl\CompanyImpl($handle);
        try {
            $res = ceil($company->count() / $this->pageSize);
        } catch (Exception $e) {
            return ['state' => false, 'data' => '获取总页数失败'];
        }
        return ['state' => true, 'data' => $res];
    }

}