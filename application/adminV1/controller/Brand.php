<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Brand extends Base
{
    public function _initialize()
    {
        parent::_initialize();

    }

    public function index(){
        echo '品牌管理';
    }


}