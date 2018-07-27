ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/pc/power/part/add'));
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
            }
        });
    });

    //编辑
    ejs.on('.edit', main, 'click', t => ejs.link('/pc/power/part/edit?id=' + ejs.attr(t.parentNode.parentNode, 'data-id')))
});