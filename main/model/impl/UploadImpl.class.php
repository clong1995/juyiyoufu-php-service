<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Upload;
use db\impl;

class UploadImpl implements Upload
{
    public function image($files, $path, $size = 1024, $allowed = [])
    {

        //检查目录是否存在
        if (!is_dir(DIR . $path . '/'))
            return ['type'=>'fail','data'=>['info' => '服务器不存在需要的目录']];
            //response('fail', '服务器不存在需要的目录');

        //判断是图片
        $imgType = ['gif', 'jpeg', 'jpg', 'pjpeg', 'x-png', 'png'];
        $ext = explode('/', $files["type"])[1];
        if (!in_array($ext, $imgType))
            return ['type'=>'fail','data'=>['info' => '文件非通用图片类型或者不是图片']];
            //response('fail', '文件非通用图片类型或者不是图片');

        //判断图片大小
        if ($files["size"] > $size * 1024)
            return ['type'=>'fail','data'=>['info' => '图片超大']];
            //response('fail', '图片超大');

        //过滤扩展名
        if (count($allowed)) {
            if (!in_array($ext, $allowed))
                return ['type'=>'fail','data'=>['info' => '文件类型不允许']];
                //response('fail', '文件类型不允许');
        }

        //摘要文件
        $md5 = md5_file($files['tmp_name']);

        //存入数据库
        $file = new impl\FileImpl();

        //查询是否已存在
        $res = $file->select(['id'], [
            'id' => $md5
        ]);
        if (count($res))
            return ['type'=>'success','data'=>['id' => $md5, 'info' => '文件已存在服务器中']];

        //保存文件
        $res = move_uploaded_file($files["tmp_name"], DIR . "file/" . $md5);

        if (!$res)
            return ['type'=>'fail','data'=>['info' => '文件转存失败']];
            //response('fail', '文件转存失败');

        //数据库记录
        $res = $file->insert([
            [
                'id' => $md5,
                'ext' => $ext,
                'path' => $path,
                'name' => $files['name']
            ]
        ]);

        //成功
        if ($res['state'] !== 'success')
            return ['type'=>'fail','data'=>['info' => '文件保存数据库失败']];

        return ['type'=>'success','data'=>['id'=>$md5]];
    }

    public function file($files, $path, $size = 1024, $allowed)
    {
        // TODO: Implement file() method.
    }

}