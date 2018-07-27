<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-10
 * Time: 下午4:28
 */

namespace db\impl;

use db\Company;
use conn\mysql;

class CompanyImpl extends AbstractBase implements Company
{



    public function getAll()
    {
        return mysql::query('
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

    public function getById($id)
    {
        return mysql::query('
            SELECT 
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
	',['id'=>$id]);
    }


    public function has($id, $license)
    {
         $res = mysql::query('
            SELECT count( * ) AS count 
            FROM company 
            WHERE license = :license
            AND id != :id
        ',['id'=>$id,'license'=>$license]);

        if($res['state'] == 'success'){
            $res['data']=$res['data'][0];
        }

        return $res;
    }

}