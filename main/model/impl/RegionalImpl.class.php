<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Regional;
use db\impl;

class RegionalImpl implements Regional
{
    public function province()
    {
        $province = new impl\ProvincesImpl();
        return $province->select(['provinceid','province']);
    }

    public function city($id)
    {
        $province = new impl\CitiesImpl();
        return $province->select(['cityid','city'],['provinceid'=>$id]);
    }

    public function ares($id)
    {
        $province = new impl\AreasImpl();
        return $province->select(['areaid','area'],['cityid'=>$id]);
    }

}