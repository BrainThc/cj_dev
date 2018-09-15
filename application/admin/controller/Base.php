<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sysUserId = session('sys_user_id');
        $this->sysUsername = session('user_name');
        $this->group_id = session('group_id');
        if( empty($this->sysUserId) && empty($this->sysUsername) && empty($this->group_id) ){
            $this->redirect('admin/login/index');
        }


    }

    public function menus(){
        $menus = array(
            '主页' => array('power'=>'home','child'=>array(),'status'=>1),
            '系统设置' => array('power'=>'home','child'=>array(),'status'=>1),
            '管理员管理' => array('power'=>'home','child'=>array(),'status'=>1)
        );
    }

}
