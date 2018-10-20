<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Goodscate extends Base
{
    public function _initialize()
    {
        parent::_initialize();

    }

    public function index(){
        echo '商品分类管理';
    }


}