<?php
namespace app\admin\controller;
use app\admin\model\Log as LogModel;
use think\Exception;

class City extends Base
{
    //获取地区列表
    public function get_city_list(){
        $pid = input('post.pid',0);
        $cityModel = model('City');
        $list = $cityModel->getCitySonList($pid);
        returnJson(true,'success',$list);
    }

    public function create_city(){
        $data = input('post.');
        $pid = empty($data['pid']) ? 0 : intval($data['pid']);
        try{
            if( empty($data['name']) || $pid < 0 )
                throw new Exception('参数错误');

            //检查是否重复
            $where['name'] = trim($data['name']);
            $where['pid'] = $pid;
            $cityModel = model('City');
            $checkInfo = $cityModel->where($where)->find();
            if( !empty($checkInfo) )
                throw new Exception(' 该类型 '.$where['name'].' 已存在');

            //添加操作
            $cityModel->startTrans();
            $insertData = $where;
            if( $cityModel->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //记录日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加地区：'.$insertData['name']) === false )
                throw new Exception('网络错误，添加失败');

            $cityModel->commit();
        }catch( Exception $e ){
            $cityModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

}