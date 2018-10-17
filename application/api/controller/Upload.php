<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Exception;

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
        try{
            if( empty($_file) )
                throw new Exception('fail');

            $fileType = input('get.dir','user');

            //图片保存路径
            $fileSave = $_file->validate(['size'=>'2097152','ext'=>'jpg,png,gif'])->move(__UPLOAD_SAVE_PATH__.$fileType);
            if( $fileSave === false )
                throw new Exception($_file->getError());

            //图片记录
            $info['file'] = str_replace("\\","/",__UPLOAD_PATH__.$fileType.DS.$fileSave->getSaveName());
            //图片提交记录用于图库
            $userType = input('get.utype','user');
            $userId = intval(input('get.uid','0'));
            switch($userType){
                case 'admin' :
                    $userId = session('sys_user')['sys_user_id'];
                    $userType = 1;
                    break;
                default :
                    $userType = 0;
                    break;
            }
            $data['user_type'] = $userType;
            $data['user_id'] = $userId;
            $data['url'] = $info['file'];
            $data['add_time'] = time();
            Db::table('yg_images_upload')->insert($data);

        }catch( Exception $e ){
            $info = [];
            returnJson(false,$e->getMessage(),$info);
        }
        returnJson(true,'success',$info);
    }


}
?>