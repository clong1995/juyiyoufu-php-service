ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/pc/role/part/add'));
    //编辑
    ejs.on('.edit', main, 'click', t => {
        ejs.link('/pc/role/part/edit', {
            id: ejs.attr(t.parentNode.parentNode, 'data-id')
        });
    });

});