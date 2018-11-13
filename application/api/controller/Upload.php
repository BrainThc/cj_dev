<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Exception;
use think\Config;

class Upload extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function v(){
        return $this->fetch();
    }

    public function index(){
        $_file = request()->file('file');
        if( empty($_file) ){
            exit;
        }
        try{
            $fileType = input('get.dir','user');

            //图片保存路径
            $fileSave = $_file->validate(['size'=>'2097152','ext'=>'jpg,png,gif'])->move(__UPLOAD_SAVE_PATH__.$fileType);
            if( $fileSave === false )
                throw new Exception($_file->getError());

            //图片记录
            $info['file'] = str_replace("\\","/",__UPLOAD_PATH__.$fileType.DS.$fileSave->getSaveName());


        }catch( Exception $e ){
            $info = [];
            returnJson(false,$e->getMessage(),$info);
        }
        returnJson(true,'success',$info);
    }


}
?>