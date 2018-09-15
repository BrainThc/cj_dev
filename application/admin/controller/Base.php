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
        $userId = session('sys_user_id');
        $username = session('user_name');
        $group_id = session('group_id');
        if( empty($userId) && empty($username) && empty($group_id) ){
            $this->redirect('admin/login/index');
        }


    }

    public function menus(){

    }
}
