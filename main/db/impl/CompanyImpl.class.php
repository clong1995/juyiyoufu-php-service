<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

declare(strict_types=1);

namespace main\db\impl;

use main\db\Company;

class CompanyImpl extends AbstractMysqlBase implements Company
{

    public function getAll(): array
    {
        return $this->exec->query('
            SELECT
                company.id as id,
                company.name as company,
                employee_info.name as employee,
                employee.phone as phone,
                provinces.province as province,
                cities.city as city,
                areas.area as area,
                company.logo as logo,
	            file.path as path
            FROM
                company
                LEFT JOIN provinces ON company.province = provinces.provinceid
                LEFT JOIN cities ON company.city = cities.cityid
                LEFT JOIN areas ON company.area = areas.areaid
                LEFT JOIN employee_info USING(employee_id)
                LEFT JOIN employee on employee.id = employee_info.employee_id
                LEFT JOIN file on file.id = company.logo
	');
    }

    public function getLimit(int $start, int $size): array
    {
        return $this->exec->query('
            SELECT
                company.id as id,
                company.name as company,
                employee_info.name as employee,
                employee.phone as phone,
                provinces.province as province,
                cities.city as city,
                areas.area as area,
                company.logo as logo,
	            file.path as path
            FROM
                company
                LEFT JOIN provinces ON company.province = provinces.provinceid
                LEFT JOIN cities ON company.city = cities.cityid
                LEFT JOIN areas ON company.area = areas.areaid
                LEFT JOIN employee_info USING(employee_id)
                LEFT JOIN employee on employee.id = employee_info.employee_id
                LEFT JOIN file on file.id = company.logo
            LIMIT :start,:size
	', [
            'start' => $start,
            'size' => $size
        ]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return $this->exec->query('
            SELECT 
                company.id as id,
                company.NAME AS company,
                logo,
                province,
                city,
                area,
                info,
                license,
                license_img,
                employee_id,
                employee_info.NAME AS employee,
                employee.phone AS phone 
            FROM company 
            LEFT JOIN employee_info USING ( employee_id ) 
            LEFT JOIN employee on  employee_info.employee_id = employee.id 
            where company.id = :id
	', ['id' => $id]);
    }


    public function has(int $id, string $license): array
    {
        return $this->exec->query('
            SELECT count( * ) AS count 
            FROM company 
            WHERE license = :license
            AND id != :id
        ', ['id' => $id, 'license' => $license]);
    }

}