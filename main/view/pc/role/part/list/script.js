ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/role/add'));
    //编辑
    ejs.on('.edit', main, 'click', t => ejs.link('/role/edit', {
        id: ejs.attr(t.parentNode.parentNode, 'data-id')
    }));
    //删除
    ejs.on('.delete', main, 'click', t => {
        let target = t.parentNode.parentNode;
        ejs.ajax('/api/role/delete', {
            method: 'POST',
            data: {
                id: ejs.attr(target, 'data-id')
            },
            success: data => {
                if (data.state === 'success') {
                    ejs.remove(target);
                }else{
                    //TODO
                    alert();
                }
            }
        })
    });
    //TODO 详情

});