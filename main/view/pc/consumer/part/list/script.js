ejs.ready(() => {
    let nav = ejs.query('#nav');
    //增加注册用户
    ejs.on('.add', nav, 'click', t => ejs.link('/pc/consumer/part/add'));
});