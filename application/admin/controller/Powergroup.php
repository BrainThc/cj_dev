<?php
namespace app\admin\controller;
class Powergroup extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->sysUserId = session('sys_user_id');
    }

    public function index(){
        echo $this->sysUserId;
        return $this->fetch();
    }

    /**
     * 获取所有权限组
     */
    public function getGroupList(){
        $json['status'] = 0;
        $model = model('Powergroup');
        $json['ad'] = $model->getAll();
        exit(json_encode($json));
        //配置分页
    }
}