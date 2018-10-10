<?php
namespace app\upload\controller;
use think\Controller;
use think\Bb;
use think\Exception;

class Index extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function v(){
        return $this->fetch();
    }

    public function index(){
        $data = request()->post();
        p($data);
        exit;
        $_file = request()->file("files");
        try{
            if( empty($_file) )
                throw new Exception('fail');

            $fileType = 'user';
            $file =request()->file("files");
            //图片保存路径
            $fileSave = $file->validate(['size'=>'2097152','ext'=>'jpg,png,gif'])->move(__UPLOAD_SAVE_PATH__);
            if( $fileSave === false )
                throw new Exception($file->getError());

            //图片记录
            $info['file'] = __UPLOAD_PATH__.$fileSave->getSaveName();
        }catch( Exception $e ){
            $info = [];
            returnJson(false,$e->getMessage(),$info);
        }
        returnJson(true,'success',$info);
    }


}
?>