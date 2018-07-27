<?php
use EasyPhp\util\Util;

$salt = Util::randStr(6) . time();
if (!Util::hasSession('salt'))
    Util::setSession('salt', $salt)
?>
<div class="header" id="header">
    <span class="title">巨蚁医护</span>
    <span class="close">
        <i class="iconfont">&#xe606;</i>
    </span>
    <!--<span class="setting">
        <i class="iconfont">&#xe61f;</i>
    </span>-->
</div>
<div id="login" class="login">
    <input class="salt" type="hidden" value="<?= Util::getSession('salt', $salt) ?>"/>
    <div class="icon">
        <i class="iconfont">&#xe639;</i>
    </div>
    <!--<input class="phone" type="text" placeholder="手机号" maxlength="11" onkeyup="value=value.replace(/[^\d]/g,'')"/>-->
    <input class="phone" type="text" placeholder="手机号" maxlength="11" autofocus="autofocus"/>
    <div class="icon">
        <i class="iconfont">&#xe65a;</i>
    </div>
    <input class="password" type="password" placeholder="密码" minlength="6" maxlength="20"/>
    <button class="login-btn">登录</button>
    <div class="msg"></div>
</div>