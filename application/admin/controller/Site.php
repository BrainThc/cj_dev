<?php
namespace app\admin\controller;
use think\Exception;

/**
 * 管理员权限组控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class Site extends Base
{
    public $error = '';

    public function _initialize(){
        parent::_initialize();
    }

    //配置信息展示页
    public function index(){
        //获取所有信息
        $list = $this->model->where('pid',0)
            ->order('id','asc')
            ->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    //获取 一级 / 二级 配置列表
    public function get_config_list(){
        $site_pid = input('site_pid',0);
        $where['pid'] = $site_pid;
        $list = $this->model->where($where)->select();
        returnJson(true,'success',$list);
    }

    //创建配置
    public function create_config(){
        $data = input('post.');
        try {
            if ( empty($data['site_key']) || empty($data['site_name']) )
                throw new Exception('请填写配置信息');

            $insertData['site_key'] = trim($data['site_key']);
            $insertData['site_name'] = trim($data['site_name']);
            $insertData['site_type'] = empty($data['site_type']) ? 0 : intval($data['site_type']);
            $insertData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);

            //检查配置关键词和配置名是否存在
            $checkState = $this->model->where('site_key',$insertData['site_key'])->find();
            if( !empty($checkState) )
                throw new Exception('配置关键词：“'.$insertData['site_key'].'” 已存在');

            $checkState = $this->model->where('site_name',$insertData['site_name'])->find();
            if( !empty($checkState) )
                throw new Exception('配置名：“'.$insertData['site_name'].'”已存在');

            $this->model->startTrans();
            //添加数据
            if( $this->model->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //日志记录
            if ( $this->LogIn($this->logModel::INSERT, '添加站点配置：' . $insertData['site_name'],$insertData) === false )
                throw new Exception('网络错误，操作失败');

            $this->model->commit();
        } catch (Exception $e) {
            $this->model->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //单个修改
    public function update_config(){
        $data = input('post.');
        if( $this->update_set($data) == false ){
            returnJson(false,$this->error);
        }
        returnJson(true,'保存成功');
    }

    //批量更新配置
    public function update_all_config(){
        $data = input('post.');
        if( empty($data['info']) ){
            returnJson(false,'参数错误');
        }
        foreach( $data['info'] as $info){
            if( $this->update_set($info) === false ){
                returnJson(false,$this->error);
            }
        }
        returnJson(true,'保存成功');
    }

    //更新配置
    public function update_set($data){
        try {
            if (empty($data['site_name']) || empty($data['id']) )
                throw new Exception('参数错误');

            $where['site_name'] = trim($data['site_name']);
            $where['id'] = intval($data['id']);
            //检查配置是否存在
            $checkInfo = $this->model->where($where)->find();
            if( empty($checkInfo) )
                throw new Exception('配置'.$where['site_name'].'不存在');

            //没有修改过不更新操作
            if($checkInfo['site_value'] == $data['site_value']){
                return true;
            }
            $updateData['pid'] = empty($data['pid']) ? 0 : $data['pid'];
            //检查操作类型
            $type = empty($data['type']) ? '' : $data['type'];
            $logMsg = '';
            $updateData['edit_time'] = time();
            switch($type){
                case 'back' :
                    $updateData['site_value'] = $checkInfo['last_value'];
                    $logMsg = "编辑站点 “{$data['site_name']}” 恢复上一次的内容：：{$updateData['site_value']}";
                    break;
                case 'reset' :
                    $updateData['last_value'] = '';
                    $updateData['site_value'] = '';
                    $logMsg = "编辑站点 “{$data['site_name']}” 配置内容：重置为空";
                    break;
                default :
                    $updateData['last_value'] = $checkInfo['site_value'];
                    $updateData['site_value'] = empty($data['site_value']) ? '' : $data['site_value'];
                    $logMsg = "编辑站点 “{$data['site_name']}” 配置内容：{$updateData['site_value']}";
                    break;
            }
            $this->model->startTrans();
            //更新数据
            $updateState = $this->model->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，操作失败');

            //日志记录
            $updateData['where'] = $where;
            if ( $this->LogIn($this->logModel::UPDATES, $logMsg,$updateData) === false )
                throw new Exception('网络错误，操作失败');

            $this->model->commit();
        } catch (Exception $e) {
            $this->model->rollback();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

}