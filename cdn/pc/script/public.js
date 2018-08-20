//保存模块
const modules = new Map();

//加载模块方法
function module(dom, path) {
    //模块域
    let doman = path.split('/')[1];

    //查询是否存在了
    if (modules.has(path)) {
        //加载html
        ejs.html(dom, `<div class="${doman}" id="${doman}">${modules.get(path).html}</div>`);
        modules.get(path).update();
        return;
    }
    ejs.ajax('/' + path, {
        res: 'text',
        success: res => {

            let span = res.substr(-10, 10);
            let arr = res.split(span);
            //保存
            //console.log(path, arr);

            //css隔离域
            let style = '';
            ejs.trim(arr[0], {
                char: '}',
                position: 'right'
            }).split('}').forEach(v => style += '.' + doman + ' ' + v + '}');
            style = ejs.replaceAll(style, {'\n': ''});
            let newStyle = ejs.createDom('style');
            newStyle.appendChild(ejs.textNode(style));
            ejs.append(document.head, newStyle);

            //html隔离域
            ejs.html(dom, `<div class="${doman}" id="${doman}">${arr[2]}</div>`);

            //缓存
            modules.set(path, {html: arr[2], update: null});
            //js
            let id = 'js' + new Date().getTime();
            let newScript = ejs.createDom("script", {id: id});
            newScript.text = `(function(){
                                const DOMAIN = ejs.query('#${doman}');
                                ${arr[1]};
                                init();
                                modules.get('${path}').update = update;
                                ejs.remove(ejs.query('#${id}'));
                            })()`;
            ejs.append(document.head, newScript);
        }
    });
}