<?PHP
    use main\model\impl;
    //省份
    $province = new impl\RegionalImpl();
    $res = $province->province();
    $provinces = $res['data'];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>增加公司</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
    <table>
        <tr>
            <td class="title">公司名称</td>
            <td class="value"><input name="companyName" type="text"/></td>
        </tr>
        <tr>
            <td class="title">统一社会信用代码</td>
            <td class="value"><input name="license" type="text"/></td>
        </tr>
        <tr>
            <td class="title">负责人</td>
            <td>
                <input class="name" name="name" type="text"/>
            </td>
        </tr>
        <tr>
            <td class="title">手机号</td>
            <td>
                <input class="phone" name="phone" type="text"/>
                <span class="hint">（*登录账号）</span>
            </td>
        </tr>
        <tr>
            <td class="title">密码</td>
            <td>
                <input class="password" type="text" disabled="disabled" value="123456"/>
                <span class="hint">（*临时密码）</span>
            </td>
        </tr>
        <tr>
            <td class="title">公司地址</td>
            <td>

                <select class="province" name="province">
                    <option></option>
                    <?php

                        foreach ($provinces as $value){
                            ?>
                            <option value="<?=$value['provinceid']?>"><?=$value['province']?></option>
                    <?php
                        }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;
                <select class="city" name="city">
                </select>&nbsp;&nbsp;&nbsp;
                <select class="area" name="area">
                </select>
            </td>
        </tr>
        <tr>
            <td class="title">营业执照</td>
            <td>
                <input name="licenseImg" type="hidden" value="">
                <div class="licenseImg">
                    <i class="iconfont">
                        &#xe61b;
                        <br>
                        <span>上传照片</span>
                    </i>
                </div>
            </td>
        </tr>
        <tr>
            <td class="title">备注</td>
            <td>
                <textarea name="info"></textarea>
            </td>
        </tr>
    </table>
    </form>
</div>