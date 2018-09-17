<?php
namespace app\admin\controller;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class Sysuser extends Base
{

    //列表主页
    public function index()
    {

        echo 123;
        echo '这里是管理员管理列表';
//        return $this->fetch();
    }

    public function getSysUserList(){
        $size = 16;
        p(input());
        $sysUserModel = model('SysUser');
        $sysUserModel->getTable();
        echo $sysUserModel;
    }

    /**
     * 创建新管理员接口
     */
    public function createUser(){

    }

    /**
     * 更改管理员信息
     */
    public function updateUser(){

    }

}
