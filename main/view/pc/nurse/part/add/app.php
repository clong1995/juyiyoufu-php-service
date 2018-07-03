<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>增加护工</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
        <table>
            <tbody>
            <tr>
                <td colspan="2" rowspan="6" width="40%">
                    <input name="headImg" type="hidden" value="">
                    <div class="headImg">
                        <i class="iconfont">
                            &#xe61b;
                            <br>
                            <span>上传照片</span>
                        </i>
                    </div>
                </td>
                <td width="15%" class="title">姓名</td>
                <td class="field">
                    <input name="name" type="text" autofocus>
                </td>
            </tr>
            <tr>
                <td class="title">性别</td>
                <td>
                    <input type="radio" name="sex" value="1">男&nbsp;
                    <input type="radio" name="sex" value="2">女
                </td>
            </tr>
            <tr>
                <td class="title">联系电话</td>
                <td>
                    <input name="phone" type="text">
                </td>
            </tr>
            <tr>
                <td class="title">出生日期</td>
                <td>
                    <input name="birth" type="date" value="2015-09-24"/>
                </td>
            </tr>
            <tr>
                <td class="title">从业日期</td>
                <td>
                    <input name="work" type="date" value="2015-09-24"/>
                </td>
            </tr>
            <tr>
                <td class="title">入职日期</td>
                <td>
                    <input name="entry" type="date" value="2015-09-24"/>
                </td>
            </tr>
            <tr>
                <td width="5%" class="title">居住地址</td>
                <td colspan="3">
                    <textarea name="loc"></textarea>
                </td>
            </tr>
            <tr>
                <td class="title">陪护项目</td>
                <td colspan="3">
                    <?php
                    for ($i = 0; $i < 4; ++$i) {
                        ?>
                        <span class="input-wrap">
                        <input type="checkbox" name="item[]" value="<?= $i ?>"/>挂号陪诊
                    </span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="title">陪护区域</td>
                <td colspan="3">
                    <select name="province">
                        <option>请选择</option>
                    </select>
                    省 &nbsp;
                    <select name="city">
                        <option>请选择</option>
                    </select>
                    市 &nbsp;
                    <select name="region">
                        <option>请选择</option>
                    </select>
                    区/县
                </td>
            </tr>
            <tr>
                <td class="title">vip标签</td>
                <td colspan="3">
                    <?php
                    for ($i = 0; $i < 4; ++$i) {
                        ?>
                        <span class="input-wrap">
                        <input type="checkbox" name="tag[]" value="1"/>金牌陪护
                    </span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="title">陪护病症</td>
                <td colspan="3">
                    <?php
                    for ($i = 0; $i < 18; ++$i) {
                        ?>
                        <span class="input-wrap">
                        <input type="checkbox" name="case[]" value="1"/>发烧
                    </span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="title">身份证号</td>
                <td colspan="3">
                    <input name="idCard" type="text">
                </td>
            </tr>
            <tr>
                <td class="title">身份证</td>
                <td colspan="3">
                    <input name="idCardImg" type="hidden" value="">
                    <span class="input-wrap idCardImg">
                        <i class="iconfont">&#xe61b;</i>上传身份证
                    </span>
                    <div class="idCardImgContent"></div>
                </td>
            </tr>
            <tr>
                <td class="title">工作证明</td>
                <td colspan="3">
                    <input name="workCardImg" type="hidden" value="">
                    <span class="input-wrap workCardImg">
                        <i class="iconfont">&#xe61b;</i>上传工作证
                    </span>
                    <div class="workCardImgContent">

                    </div>
                </td>
            </tr>
            <tr>
                <td class="title">护工简介</td>
                <td colspan="3">
                    <textarea name="intro"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>