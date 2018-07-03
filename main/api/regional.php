<?php

use model\impl;
switch (ORDER) {
    case 'province'://添加
        $regional = new impl\RegionalImpl();
        $regional->province();
        break;
    case 'city'://添加
        $regional = new impl\RegionalImpl();
        $regional->city(0);
        break;
    case 'area'://添加
        $regional = new impl\RegionalImpl();
        $regional->ares(0);
        break;
}