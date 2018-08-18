//全自动公共方法
ejs.ready(() => {

    let nav = ejs.query('#nav'),
        main = ejs.query('#main'),
        domain = document.location.pathname.split('/')[1];

    //添加
    ejs.on('.add', nav, 'click', t => ejs.link('/' + domain + '/add'));

    //编辑
    ejs.on('.edit', main, 'click', t => ejs.link('/' + domain + '/edit/' + ejs.attr(t.parentNode.parentNode, 'data-id')));

    //删除
    ejs.on('.delete', main, 'click', t => {
        let item = t.parentNode.parentNode;
        ejs.ajax('/api/' + domain + '/delete', {
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

    //详情
    ejs.on('.detail', main, 'click', t => {
        alert('待开发!');
        //ejs.link('/' + domain + '/detail?id=' + ejs.attr(t.parentNode.parentNode, 'data-id'))
    });
});

//需要外界参数的方法
//翻页
function page(callback) {
    let page = ejs.query('#page'),
        main = ejs.query('#main'),
        domain = document.location.pathname.split('/')[1];

    ejs.on('SPAN', page, 'click', t => {
        if (!ejs.hasClass(t, 'active')) {
            ejs.ajax('/api/' + domain + '/getPage', {
                method: 'POST',
                data: {
                    page: ejs.html(t)
                },
                success: res => {
                    if (res.state) {
                        //添加新的
                        let newPage = '';
                        res.data.forEach(v => newPage += '<div class="item">' + callback(v) + '</div>');
                        //清除上一页
                        ejs.empty(main, newPage);
                        //更改页数样式
                        ejs.removeClass(ejs.query('.active', page), 'active');
                        ejs.addClass(t, 'active');
                    } else {
                        //TODO 错误提示
                        ejs.log(res, 'error');
                    }
                }
            });
        }
    });
}

