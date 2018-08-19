//翻页
page(v => {
    let p1 = `<div class="inner" data-id="${v['role']['id']}">
                <div class="row">
                    <span class="title">名称:</span>${v['role']['name']}
                </div>
                <div class="row">
                    <span class="title">说明:</span>${v['role']['info']}
                </div>
                <div class="row row3">
                    <span class="title">权限:</span>
                    <ul>`;

    let p2 = '';
    v['privilege'].forEach(v1 => {
        p2 += `<li>
                <span class="name">${v1['name']}</span>
                <span class="type">${v1['type']}</span>
                <span class="option li-detail"><i class="iconfont">&#xe60e;</i></span>
            </li>`;
    });

    let p3 = `</ul>
                </div>
                <div class="option">
                    <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                    <button class="detail"><i class="iconfont">&#xe60e;</i>详情</button>
                    <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
                </div>
            </div>`;

    return p1 + p2 + p3;
});