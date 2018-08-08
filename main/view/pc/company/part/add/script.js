let main = ejs.query('#main');
let city = ejs.query('.city', main);
let area = ejs.query('.area', main);
let optionDom = ejs.createDom('option');
let licenseImg = ejs.query('.licenseImg', main);

//证件上传
NEW(ejs.root + 'ui/upload.ui', {

    accept: ['image/png', 'image/jpeg'],
    dom: licenseImg,
    action: '/api/upload/file',
    content: licenseImg,
    callback: res => {
        if (res.state === 'success') {
            ejs.css(licenseImg, {
                color: 'transparent'
            });
            ejs.html(ejs.query('span', licenseImg), '重新上传');
            ejs.query('input[name="licenseImg"]', main).value = res.data.id;
        } else {
            alert(res['data']);
            //上传失败
        }
    }
});


//市联动
ejs.on('.province', main, 'change', t => {
    let id = t.value;
    ejs.ajax('/api/regional/city', {
        method: 'POST',
        data: {
            id: id
        },
        success: data => {
            ejs.empty(city, optionDom.cloneNode());
            ejs.empty(area, optionDom.cloneNode());
            data['data'].forEach(v => {
                let optionDomClone = optionDom.cloneNode();
                ejs.attr(optionDomClone, {
                    value: v['cityid']
                });
                ejs.html(optionDomClone, v['city']);
                ejs.append(city, optionDomClone);
            });
        }
    })
});

//区县联动
ejs.on('.city', main, 'change', t => {
    let id = t.value;
    ejs.ajax('/api/regional/area', {
        method: 'POST',
        data: {
            id: id
        },
        success: data => {
            ejs.empty(area, optionDom.cloneNode());
            data['data'].forEach(v => {
                let optionDomClone = optionDom.cloneNode();
                ejs.attr(optionDomClone, {
                    value: v['areaid']
                });
                ejs.html(optionDomClone, v['area']);
                ejs.append(area, optionDomClone);
            });
        }
    })
});


//保存
save({
    'companyName': 'string 20',
    'license': 'string 50',
    'licenseImg': 'string 32',
    'name': 'string 5',
    'phone': 'number 11',
    'province': 'number 6',
    'city': 'number 6',
    'area': 'number 6',
    'info': 'string 100'
});