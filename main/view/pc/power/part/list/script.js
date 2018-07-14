ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/pc/power/part/add'));
    //删除
    ejs.on('.delete', main, 'click', t => {
        ejs.ajax('/api/power/delById', {
            method: 'POST',
            data: {
                id: 0
            },
            success: data => {
                if (data.state === 'success')
                    ejs.remove(t.parentNode.parentNode);
                //非法删除要从后端解决
            }
        });
    });

});