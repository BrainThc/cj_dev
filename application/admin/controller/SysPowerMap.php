<?php
namespace app\admin\controller;
use think\Exception;

class SysPowerMap extends Base
{

    public function index(){
        $power_list = $this->model->select();
        $power_list = setTree($power_list);
        $this->assign('power_list',$power_list);
        return $this->fetch();
    }

    public function create_map(){
        $post_data = input('post.');
        try{
            if( empty($post_data['name']) || empty($post_data['power']) || empty($post_data['act']) || empty($post_data['op']) ){
                throw new Exception('网络错误，添加失败');
            }
            //检查是否重命名
            $info = $this->model->field('*')->where(['name'=>$post_data['name']])->select();
            pe($info);
        }catch( Exception $e ){
            $e->getMessage();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }
    //初始化设置
    public function inSet($list,$pid=0){
        $data['pid'] = $pid;
        $data['name'] = $list['name'];
        $data['power'] = $list['power'];
        $data['act'] = $list['act'];
        $data['op'] = empty($list['op']) ? '' : $list['op'];
        if( !$map_id = $this->model->insertGetId($data) ){
            return false;
        }
        if( !empty($list['child']) ){
            foreach( $list['child'] as $child ){
                $this->inSet($child,$map_id);
            }
        }
        return true;
    }

    //更新
    public function edit(){

    }

}
