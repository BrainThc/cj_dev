<?php
namespace app\lily\controller;
// 引入Db类
use think\Db;
// 引入控制器类
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //这里是后台日志使用
        $logModel = new \app\admin\model\Log();
        $data = [
            'sys_user_id' => 0,
            'type'  =>  '观看记录',
            'description'  =>  '有人看了',
            'desc_data'  =>  '',
            'add_time' => time(),
            'add_ip'   => Request()->ip(),
        ];
        if( $logModel->insert($data) === false ){
//            return false;
        }
        return $this->fetch();
    }

}
