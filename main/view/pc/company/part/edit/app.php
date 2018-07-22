<?PHP

use model\impl;

//公司信息
$company = new impl\CompanyImpl();
$res = $company->getById(PARAM['id']);
$companyData = $res['data'][0];

//省份
$regional = new impl\RegionalImpl();
$res = $regional->province();
$provinces = $res['data'];

//获取市
$res = $regional->city($companyData['province']);
$cities = $res['data'];

//获取地区
$res = $regional->area($companyData['city']);
$areas = $res['data'];


?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>编辑公司</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
        <table>
            <tr>
                <td class="title">公司名称</td>
                <td class="value"><input name="companyName" type="text" value="<?= $companyData['company'] ?>"/></td>
            </tr>
            <tr>
                <td class="title">统一社会信用代码</td>
                <td class="value"><input name="license" type="text" value="<?= $companyData['license'] ?>"/></td>
            </tr>
            <tr>
                <td class="title">负责人</td>
                <td>
                    <input class="name" name="name" type="text" value="<?= $companyData['employee'] ?>"/>
                </td>
            </tr>
            <tr>
                <td class="title">手机号</td>
                <td>
                    <input class="phone" name='phone' type="text" value="<?= $companyData['phone'] ?>"/>
                    <span class="hint">（*登录账号）</span>
                </td>
            </tr>
            <tr>
                <td class="title">公司地址</td>
                <td>

                    <select class="province" name="province">
                        <?php
                        foreach ($provinces as $value) {
                            if ($value['provinceid'] == $companyData['province']) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?= $value['provinceid'] ?>" <?= $selected ?>><?= $value['province'] ?></option>
                            <?php
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;
                    <select class="city" name="city">
                        <?php
                        foreach ($cities as $value) {
                            if ($value['cityid'] == $companyData['city']) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?= $value['cityid'] ?>" <?= $selected ?>><?= $value['city'] ?></option>
                            <?php
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;
                    <select class="area" name="area">
                        <?php
                        foreach ($areas as $value) {
                            if ($value['areaid'] == $companyData['area']) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?= $value['areaid'] ?>" <?= $selected ?>><?= $value['area'] ?></option>
                            <?php
                        }
                        ?>
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
                            <span>修改照片</span>
                        </i>
                        <img src="/file/<?= $companyData['logo'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title">备注</td>
                <td>
                    <textarea name="info"><?= $companyData['info'] ?></textarea>
                </td>
            </tr>
        </table>
    </form>
</div>