//翻页
page(v => `<div class="inner" data-id="${v['id']}">
                <div class="row row1">
                    <img src="/${v['path']} . '/' . ${v['logo']}">
                </div>
                <div class="row row2"><span class="title">公司名称</span>${v['company']}</div>
                <div class="row row3"><span class="title">负责人</span>${v['employee']}</div>
                <div class="row row4"><span class="title">联系电话</span>${v['phone']}</div>
                <div class="row row4"><span
                            class="title">地址</span>${v['province']}${v['city']}${v['area']}</div>
                <div class="option">
                    <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                    <button class="detail"><i class="iconfont">&#xe60e;</i>详情</button>
                    <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
                </div>
            </div>`);