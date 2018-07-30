ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    let page = ejs.query('#page');

    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/power/add'));

    //删除
    ejs.on('.delete', main, 'click', t => {
        let item = t.parentNode.parentNode;
        ejs.ajax('/api/power/delById', {
            method: 'POST',
            data: {
                id: ejs.attr(item, 'data-id')
            },
            success: data => {
                if (data.state === 'success')
                    ejs.remove(item);
                else {
                    //TODO 错误提示
                    alert();
                }
            }
        });
    });

    //编辑
    ejs.on('.edit', main, 'click', t => ejs.link('/power/edit?id=' + ejs.attr(t.parentNode.parentNode, 'data-id')));

    //翻页
    ejs.on('SPAN', page, 'click', t => {
        if (!ejs.hasClass(t, 'active')) {
            ejs.ajax('/api/power/getPage', {
                method: 'POST',
                data: {
                    page: ejs.html(t)
                },
                success: res => {
                    if (res.state === 'success') {
                        //添加新的
                        let newPage = '';
                        res.data.forEach(v => newPage +=
                            `<div class="item">
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
                            </div>`
                        );
                        //清除上一页
                        ejs.empty(main, newPage);
                        //更改页数样式
                        ejs.removeClass(ejs.query('.active',page),'active');
                        ejs.addClass(t,'active');
                    } else {
                        //TODO 错误提示
                        alert();
                    }
                }
            });
        }
    });
});