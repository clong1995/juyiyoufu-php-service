function module(dom, path) {
    //查询是否存在了

    ejs.ajax('/' + path, {
        res: 'text',
        success: res => {
            let doman = path.split('/')[1];
            let span = res.substr(-10, 10);
            let arr = res.split(span);
            //保存
            //console.log(path, arr);

            //css隔离域
            let style = '';
            ejs.trim(arr[0], {char: '}', position: 'right'}).split('}').forEach(v => style += '.' + doman + ' ' + v + '}');
            style = ejs.replaceAll(style,{'\n':''});
            let newStyle = ejs.createDom('style');
            newStyle.appendChild(ejs.textNode(style));
            ejs.append(document.head,newStyle);

            //html隔离域
            ejs.html(dom, `<div class="${doman}" id="${doman}">${arr[2]}</div>`);

            //js
            let id = 'js'+new Date().getTime();
            let newScript = ejs.createDom("script",{id:id});
            newScript.text = `(function(){const DOMAIN = ejs.query('#${doman}');${arr[1]};ejs.remove(ejs.query('#${id}'));})()`;
            ejs.append(document.head,newScript);
        }
    });
}