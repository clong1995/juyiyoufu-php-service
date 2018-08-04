let nav = ejs.query('#nav'),
    main = ejs.query('#main');
//增加注册用户
ejs.on('.add', nav, 'click', t => ejs.link('/pc/company/part/add'));

//删除
ejs.on('.delete', main, 'click', t => {
    let item = t.parentNode.parentNode;
    ejs.ajax('/api/company/delete', {
        method: 'POST',
        data: {
            id: ejs.attr(item, 'data-id')
        },
        success: data => {
            if (data['state'] === 'success') {
                ejs.remove(item)
            } else {

            }
        }
    })
});


//修改
ejs.on('.edit', main, 'click', t => ejs.link('/pc/company/part/edit', {
    id: ejs.attr(t.parentNode.parentNode, 'data-id')
}));


//详情
ejs.on('.detail', main, 'click', t => ejs.link('/pc/company/part/detail', {
    id: ejs.attr(t.parentNode.parentNode, 'data-id')
}));

//翻页
page(v => `<div class="item">
    <div class="inner" data-id="${v.id}">
        <div class="row">
            <span class="title">名称:</span>${v.name}
        </div>
        <div class="row row2">
            <span class="title">类型:</span>${v.type}
        </div>
        <div class="row row3">
            <span class="title">资源:</span>${v.path}
        </div>
        <div class="row row4">
            <span class="title">说明:</span>
            <p>${v.info}</p>
        </div>
        <div class="option">
            <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
            <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
        </div>
    </div>
</div>`);