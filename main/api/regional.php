<?php

use model\impl;
switch (ORDER) {
    /*case 'province'://添加
        break;*/
    case 'city'://添加
        $regional = new impl\RegionalImpl();
        $res = $regional->city(PARAM['id']);
        response($res['state'], $res['data']);
        break;
    case 'area'://添加
        $regional = new impl\RegionalImpl();
        $res = $regional->area(PARAM['id']);
        response($res['state'], $res['data']);
        break;
}