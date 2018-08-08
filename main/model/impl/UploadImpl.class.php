<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);


namespace main\model\impl;


use main\db\conn\Mysql;
use main\model\Upload;
use main\db\impl;
use \Exception;

class UploadImpl implements Upload
{
    private $mysql = null;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }
    public function image(array $files, int $size = 1024, array $allowed = []): array
    {

        $handle = $this->mysql->pdo;

        //检查目录是否存在
        if (!is_dir(DIR . 'file/'))
            return ['state' => 'fail', 'data' => ['info' => '服务器不存在需要的目录']];

        //判断是图片
        $imgType = ['gif', 'jpeg', 'jpg', 'pjpeg', 'x-png', 'png'];
        $ext = explode('/', $files["type"])[1];
        if (!in_array($ext, $imgType))
            return ['state' => 'fail', 'data' => ['info' => '文件非通用图片类型或者不是图片']];

        //判断图片大小
        if ($files["size"] > $size * 1024)
            return ['state' => 'fail', 'data' => ['info' => '图片超大']];

        //过滤扩展名
        if (count($allowed)) {
            if (!in_array($ext, $allowed))
                return ['state' => 'fail', 'data' => ['info' => '文件类型不允许']];
        }

        //摘要文件
        $md5 = md5_file($files['tmp_name']);

        //存入数据库
        $file = new impl\FileImpl($handle);

        //查询是否已存在
        $count = $file->count(['id' => $md5]);

        if ($count)
            return ['state' => 'success', 'data' => ['id' => $md5, 'info' => '文件已存在服务器中']];

        //保存文件
        $res = move_uploaded_file($files["tmp_name"], DIR . "file/" . $md5);

        if (!$res)
            return ['state' => 'fail', 'data' => ['info' => '文件转存失败']];

        //数据库记录
        try{
            $file->insert([
                [
                    'id' => $md5,
                    'ext' => $ext,
                    'path' => 'file',
                    'name' => $files['name']
                ]
            ]);
        }catch (Exception $e){
            return ['state' => 'fail', 'data' => ['info' => '文件保存数据库失败']];
        }

        return ['state' => 'success', 'data' => ['id' => $md5]];
    }

    public function file($files, $path, $size = 1024, $allowed)
    {
        // TODO: Implement file() method.
    }

}