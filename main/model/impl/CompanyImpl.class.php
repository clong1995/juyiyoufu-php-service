<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Company;
use db\impl;

class CompanyImpl implements Company
{


    /**
     * TODO 这里应该开启事物
     * 增加权限
     * @param $data
     * @return array
     */
    public function add($data)
    {
        $returnData = ['state' => 'success', 'data' => '添加成功'];
        //TODO 过滤数据
        $company = new impl\CompanyImpl();
        //查询公司是否存在
        $companyCountRes = $company->count(['license' => $data['license']]);
        if ($companyCountRes['state'] == 'success' && $companyCountRes['data']['count'] == 0) {

            $employee = new impl\EmployeeImpl();
            //查询是否存在员工
            $employeeCountRes = $employee->count(['phone' => $data['phone']]);
            if ($employeeCountRes['state'] == 'success' && $employeeCountRes['data']['count'] == 0) {
                //TODO 开启事物
                //增加员工
                $employeeRes = $employee->insert([
                    [
                        'phone' => $data['phone'],
                        'password' => strtoupper(md5('123456'))
                    ]
                ]);

                if ($employeeRes['state'] == 'success') {
                    //增加公司
                    $companyRes = $company->insert([
                        [
                            'name' => $data['companyName'],
                            'province' => (int)$data['province'],
                            'city' => (int)$data['city'],
                            'area' => (int)$data['area'],
                            'license' => $data['license'],
                            'license_img' => $data['licenseImg'],
                            'info' => $data['info'],
                            'employee_id' => (int)$employeeRes['data']['id']
                        ]
                    ]);

                    if ($companyRes['state'] == 'success') {
                        //增加员工信息
                        $employeeInfo = new impl\EmployeeInfoImpl();
                        $employeeInfoRes = $employeeInfo->insert([
                            [
                                'employee_id' => (int)$employeeRes['data']['id'],
                                'name' => $data['name'],
                                'company_id' => (int)$companyRes['data']['id'],
                                'role_id' => 2,
                                'index_menu_group_id' => 2
                            ]
                        ]);

                        if ($employeeInfoRes['state'] == 'success') {
                            //TODO 成功 提交事物
                        } else {
                            //TODO 添加员工信息失败 回滚
                            $returnData['state'] = 'fail';
                            $returnData['data'] = '员工信息添加失败';
                        }

                    } else {
                        //TODO 添加公司失败 回滚
                        $returnData['state'] = 'fail';
                        $returnData['data'] = '公司添加失败';
                    }

                } else {
                    //TODO 添加员工失败 回滚
                    $returnData['state'] = 'fail';
                    $returnData['data'] = '员工添加失败';
                }

            } else {
                //TODO 员工已存在 回滚
                $returnData['state'] = 'fail';
                $returnData['data'] = ['name' => 'phone', 'msg' => '员工添已存在'];
            }

        } else {
            //TODO 公司已存在
            $returnData['state'] = 'fail';
            $returnData['data'] = ['name' => 'license', 'msg' => '公司已存在'];
        }


        return $returnData;
    }

    /**
     * TODO 这里应该开启事物
     * 修改公司
     * @param $data
     * @return array
     */
    public function update($data){
        $returnData = ['state' => 'success', 'data' => '添加成功'];
        //TODO 过滤数据
        $company = new impl\CompanyImpl();
        //查询公司是否存在
        $companyCountRes = $company->has($data['id'],$data['license']);
        if ($companyCountRes['state'] == 'success' && $companyCountRes['data']['count'] == 0) {
            $employee = new impl\EmployeeImpl();
            //查询是否存在员工
            $employeeCountRes = $employee->has(['id'=>$data['employee_id'],'phone' => $data['phone']]);
            //TODO 开启事物
            //修改员工
            $employeeRes = $employee->insert([
                [
                    'phone' => $data['phone'],
                    'password' => strtoupper(md5('123456'))
                ]
            ]);



        }else{//TODO 公司已存在
            $returnData['state'] = 'fail';
            $returnData['data'] = ['name' => 'license', 'msg' => '公司已存在'];
        }
        return $returnData;
    }

    /**
     *
     */
    public function getAll()
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
    public function delete($id)
    {
        $company = new impl\CompanyImpl();
        $res = $company->delete([['id' => $id]]);
        return $res;
    }


    public function getById($id)
    {
        // TODO: Implement getById() method.
        $company = new impl\CompanyImpl();
        //$res = $company->select(['name', 'logo', 'province', 'city', 'area', 'info', 'license', 'license_img'], ['id' => $id]);
        $res = $company->getById($id);
        return $res;
    }




}