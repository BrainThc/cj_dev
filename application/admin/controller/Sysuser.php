<?php
namespace app\admin\controller;
use app\admin\model\SysUserModel;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class Sysuser extends Base
{

    public function __construct()
    {
        parent::__construct();
        $this->sysUserModel = model('SysUser');
    }


    //列表主页
    public function index()
    {

        echo 123;
        echo '这里是管理员管理列表';
//        return $this->fetch();
    }

    public function getSysUserList(){
        $size = input('page') ? intval(input('page')) : 1;
        $sysUserModel = model('SysUser');
//        $sysUserModel->issetUser('admin',true);
        //列表筛选
        $status = input('state');
        $sql = 'SELECT * FROM '.$sysUserModel->getTable();
        $list = $sysUserModel->query($sql);
        p($list);
    }

    public function add(){
        echo '这里是添加管理员页面';
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
