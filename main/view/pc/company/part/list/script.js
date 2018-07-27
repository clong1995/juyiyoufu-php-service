ejs.ready(() => {
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
    }))



});