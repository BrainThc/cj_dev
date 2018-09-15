<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

}
