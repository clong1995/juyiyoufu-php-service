ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    let city = ejs.query('.city',main);
    let area = ejs.query('.area',main);
    let optionDom = ejs.createDom('option');
    let licenseImg = ejs.query('.licenseImg', main);

    //头像上传
    NEW(ejs.root + 'ui/upload.ui', {
        accept: ['image/png', 'image/jpeg'],
        dom: licenseImg,
        action: '/api/upload/file',
        content: licenseImg,
        callback: res => {
            ejs.css(licenseImg, {
                color: 'transparent'
            });
            ejs.html(ejs.query('span', licenseImg), '重新上传');
            if (res.state === 'success') {
                ejs.query('input[name="licenseImg"]', main).value = res.data.id;
            } else {
                //上传失败
            }
        }
    });


    //市联动
    ejs.on('.province',main,'change',t=>{
        let id = t.value;
        ejs.ajax('/api/regional/city',{
            method:'POST',
            data:{
                id:id
            },
            success:data=>{
                ejs.empty(city,optionDom.cloneNode());
                ejs.empty(area,optionDom.cloneNode());
                data['data'].forEach(v=>{
                    let optionDomClone = optionDom.cloneNode();
                    ejs.attr(optionDomClone,{
                        value:v['cityid']
                    });
                    ejs.html(optionDomClone,v['city']);
                    ejs.append(city,optionDomClone);
                });
            }
        })
    });

    //区县联动
    ejs.on('.city',main,'change',t=>{
        let id = t.value;
        ejs.ajax('/api/regional/area',{
            method:'POST',
            data:{
                id:id
            },
            success:data=>{
                ejs.empty(area,optionDom.cloneNode());
                data['data'].forEach(v=>{
                    let optionDomClone = optionDom.cloneNode();
                    ejs.attr(optionDomClone,{
                        value:v['areaid']
                    });
                    ejs.html(optionDomClone,v['area']);
                    ejs.append(area,optionDomClone);
                });
            }
        })
    });



    //保存
    ejs.on('.save', nav, 'click', t =>{
        let form = ejs.query('.form', main);
        NEW(ejs.root + 'ui/form.ui', {
            form: form,
            action: '/api/company/add',
            verify: {
                'companyName': 'string 20',
                'license': 'string 50',
                'licenseImg': 'string 32',
                'name': 'string 5',
                'phone': 'number 11',
                'province': 'number 6',
                'city': 'number 6',
                'area': 'number 6',
                'info': 'string 100'
            }
        }, res => {
            if (res.state !== 'success') {
                let field = ejs.query('*[name="' + res.data.name + '"]', form);
                let td = field.parentNode;

                if (td.tagName !== 'TD') {
                    td = td.parentNode;
                }

                ejs.addClass(td, 'error');
                let error = ejs.query('.error', form);
                let info = ejs.createDom();
                ejs.addClass(info, 'info');
                ejs.html(info, res.data.msg);
                ejs.append(error, info);
            }else{
                ejs.link('/pc/company/part/list');
            }
        });
    });

    ejs.on('.error', main, 'click', t => {
        ejs.query('.info', t, true).forEach(v => ejs.remove(v));
        ejs.removeClass(t, 'error');
    });

    //返回
    ejs.on('.back', nav, 'click', t => ejs.link('/pc/company/part/list'));
});