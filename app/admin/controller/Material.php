<?php
/**
 * Created by PhpStorm.
 * User: 24377
 * Date: 2017/8/1
 * Time: 21:50
 */

namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Material as MaterialModel;

class Material extends Common {
    /**
     * 显示素材列表
     */
    public function lists() {
//        调用GradeModel save方法  继承父类方法houdunwang\model\Model   save方法方法不存在 跳转到Base类 执行    get()方法
        $data = MaterialModel::get();

        return View::make()->with(compact('data'));
    }

    /**
     * 增加素材
     * @return $this
     */
    public function store() {
        if ( IS_POST ) {
            //上传，返回上传的信息
            $info = $this->upload();
            //把上传之后的信息保存到数据库
            $data = [
                'path'        => $info['path'],
                'create_time' => time()
            ];
            MaterialModel::save( $data );
            return $this->setRedirect("?s=admin/material/lists")->success('上传成功');
        }

        return View::make();
    }

    private function upload() {
        //创建上传目录
        $dir = 'upload/' . date( 'ymd' );
        is_dir( $dir ) || mkdir( $dir, 0777, true );
        //设置上传目录
        $storage = new \Upload\Storage\FileSystem( $dir );
        $file    = new \Upload\File( 'upload', $storage );
        //设置上传文件名字唯一
        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName( $new_filename );

        //设置上传类型和大小
        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations( array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype( [ 'image/png', 'image/gif', 'image/jpeg' ] ),

            //You can also add multi mimetype validation
            //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size( '2M' )
        ) );

        //组合数组
        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions(),
            //自己组合的上传之后的完整路径
            'path'       => $dir . '/' . $file->getNameWithExtension(),
        );


        // Try to upload file
        try {
            // Success!
            $file->upload();

            return $data;
        } catch ( \Exception $e ) {
            // Fail!
            $errors = $file->getErrors();
            foreach ( $errors as $e ) {
                throw new \Exception( $e );
            }

        }
    }

    /**
     * 删除
     */
    public function remove() {


        $mid = $_GET['mid'];


        $data = MaterialModel::find($mid);
        //删除文件
        is_file($data['path']) && unlink($data['path']);

        //     调用MaterialModel where方法 destory()方法  继承父类方法houdunwang\model\Model
//      where方法 destory()方法不存在 跳转到Base类 执行  where方法 destory()方法 方法
        //删除数据库信息
        MaterialModel::where("mid={$mid}")->destory();

        //        把删除结果返回出去    success('删除成功')弹出提示   setRedirect('index.php')返回首页
//        调用父类方法  success('删除成功')->setRedirect('index.php')
//        success（）setRedirect（） 父类方法 在../houdouwang/core/Controller.php 文件中
        return $this->setRedirect("?s=admin/material/lists")->success('删除成功');

    }
}








