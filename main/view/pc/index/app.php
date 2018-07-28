<?php
declare(strict_types=1);

use main\model\impl;

//获取菜单
$indexMenu = new impl\IndexMenuImpl();
$res = $indexMenu->getIndexMenu();
$menu = $res['data'];
?>
<div class="left" id="left">
    <!--logo-->
    <div class="logo">
        <img src="">
    </div>
    <div class="list">
        <?php
        foreach ($menu as &$value) {
            ?>
            <a class="item" href="/<?= $value['path'] ?>" target="main"><i class="iconfont"><?= $value['icon'] ?></i><?= $value['name'] ?></a>
            <?php
        }
        ?>
    </div>
</div>
<div class="nav" id="nav">
    <!-- 搜索 -->
    <div class="search">
        <input type="text" placeholder="搜索...">
        <div class="search-btn">
            <i class="iconfont">&#xe603;</i>
        </div>
    </div>
    <div class="menu">
        <div class="item msg">
            <i class="iconfont">&#xe696;</i>
        </div>
        <div class="item span">|</div>
        <div class="item headImg">
            <img src="">
        </div>
        <div class="item span">|</div>
        <div class="item win winSetting">
            <i class="iconfont">&#xe612;</i>
        </div>
        <div class="item win winMin">
            <i class="iconfont">&#xe616;</i>
        </div>
        <div class="item win winMax">
            <i class="iconfont">&#xe62c;</i>
        </div>
        <div class="item win winClose">
            <i class="iconfont">&#xe600;</i>
        </div>
    </div>
</div>
<!--<iframe class="main" name="main" src="/--><?//= $menu[0]['path'] ?><!--"></iframe>-->
<!--<iframe class="main" src="/power/add"></iframe>-->