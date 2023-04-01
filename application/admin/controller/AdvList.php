<?php
namespace app\admin\controller;
use think\Exception;

/**
 * 广告位控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class AdvList extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }

    //管理页面
    public function adv_list(){
        $ids = input('param.id',0);
        if( $ids <= 0 ){
            noPermission();
        }
        //检查广告位是否存在
        $posModel = nModel('AdvPosition');
        $info = $posModel->where('pos_id',$ids)->find();
        if( empty($info) ){
            noPermission();
        }
        $this->assign('info',$info);
        return $this->fetch();
    }

    //获取广告内容列表
    public function get_adv_list(){
        $data = input('post.');
        if( empty($data['pos_id']) || intval($data['pos_id']) <= 0 ){
            returnJson(false,'参数错误');
        }
        $where = [];
        $where['pos_id'] = ['=',intval($data['pos_id'])];

        $adv_id = empty($data['adv_id']) ? 0 : intval($data['adv_id']);
        if( $adv_id > 0 ){
            $where['adv_id'] = ['=',$adv_id];
        }

        $keyword = empty($data['keyword']) ? '' : trim($data['keyword']);
        if( !empty($keyword) ){
            $where['adv_title'] = ['like',"%{$keyword}%"];
        }
        $page = intval(input('page',1));
        $size = input('limit',10);
        $pageLimit = (($page - 1) * $size).','.$size;
        $count = $this->model->where($where)
            ->order('start_time asc,end_time asc,sequence desc')
            ->count();
        $list = $this->model->where($where)
            ->order('start_time asc,end_time asc,sequence desc')
            ->limit($pageLimit)
            ->select();
        $t = time();
        if( !empty($list) ){
            foreach( $list as $k => $v ){
                $v['show_type'] = '未生效';
                $v['oldSequence'] = $v['sequence'];
                if( $v['start_time'] == 0 && $v['end_time'] == 0 ){
                    $v['show_type'] = '生效中';
                }else if( $v['start_time'] <= $t && $v['end_time'] == 0  ){
                    $v['show_type'] = '生效中';
                }else if( $v['start_time'] == 0 && $v['end_time'] >= $t  ){
                    $v['show_type'] = '生效中';
                }else if( $v['start_time'] <= $t && $v['end_time'] >= $t  ){
                    $v['show_type'] = '生效中';
                }
                $v['start_date'] = empty($v['start_time']) ? '' : date('Y-m-d H:i',$v['start_time']);
                $v['end_date'] = empty($v['end_time']) ? '' : date('Y-m-d H:i',$v['end_time']);
                if( $v['start_date'] == '' && $v['end_date'] == '' ){
                    $v['start_date'] = $v['end_date'] = '永久有效';
                }
                $list[$k] = $v;
            }
        }
        returnJson(true,'success',$list,['count'=>$count]);
    }

    //添加广告页
    public function add(){
        $ids = input('param.id',0);
        if( $ids <= 0 ){
            noPermission();
        }

        //检查广告位是否存在
        $posModel = nModel('AdvPosition');
        $info = $posModel->where('pos_id',$ids)->find();
        if( empty($info) ){
            noPermission();
        }
        $this->assign('info',$info);
        return $this->fetch();
    }

    //添加广告
    public function create_adv(){
        $data = input('post.');
        try{

            $pos_id = empty($data['pos_id']) ? 0 : intval($data['pos_id']);
            if( $pos_id <= 0 )
                throw new Exception('参错错误');

            //检查广告位是否存在
            $posModel = nModel('AdvPosition');
            $info = $posModel->where('pos_id',$pos_id)->find();
            if( empty($info) )
                throw new Exception('参错错误');

            $t = time();
            $insertData['pos_id'] = $info['pos_id'];
            $insertData['adv_img'] = empty($data['adv_img']) ? '' : trim($data['adv_img']);
            if( empty($insertData['adv_img']) )
                throw new Exception('缺少广告图');

            $insertData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            $insertData['adv_url'] = empty($data['adv_url']) ? '' : trim($data['adv_url']);
            $insertData['adv_title'] = empty($data['adv_title']) ? '' : trim($data['adv_title']);
            $insertData['start_time'] = empty($data['start_time']) ? 0 : strtotime($data['start_time']);
            $insertData['end_time'] = empty($data['end_time']) ? 0 : strtotime($data['end_time']);
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            $this->model->startTrans();
            if( $this->model->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            if( $this->LogIn($this->logModel::INSERT,'添加 '.$info['pos_name'].' 广告',$insertData) === false )
                throw new Exception('网络错误，添加失败');

            $this->model->commit();
        }catch( Exception $e ){
            $this->model->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //编辑页面
    public function edit(){
        $posId = input('param.posId',0);
        $ids = input('param.id',0);
        if( $posId <= 0 || $ids <= 0 ){
            noPermission();
        }
        //检查广告位是否存在
        $posModel = nModel('AdvPosition');
        $pos_info = $posModel->where('pos_id',$posId)->find();
        if( empty($pos_info) ){
            noPermission();
        }
        //获取广告信息
        $where['adv_id'] = $ids;
        $where['pos_id'] = $posId;
        $info = $this->model->where($where)->find();
        if( empty($info) ){
            noPermission();
        }
        $info['start_time'] = empty($info['start_time']) ? '' : date('Y-m-d',$info['start_time']);
        $info['end_time'] = empty($info['end_time']) ? '' : date('Y-m-d',$info['end_time']);
        $info['width'] = $pos_info['width'];
        $info['height'] = $pos_info['height'];
        $this->assign('info',$info);
        return $this->fetch();
    }

    //添加广告
    public function update_adv(){
        $data = input('post.');
        try{
            $pos_id = empty($data['pos_id']) ? 0 : intval($data['pos_id']);
            $adv_id = empty($data['adv_id']) ? 0 : intval($data['adv_id']);
            if( $pos_id <= 0 || $adv_id <=0 )
                throw new Exception('参错错误x1');

            //检查广告位是否存在
            $posModel = nModel('AdvPosition');
            $pos_info = $posModel->where('pos_id',$pos_id)->find();
            if( empty($pos_info) )
                throw new Exception('参错错误');

            //获取广告信息
            $where['adv_id'] = $adv_id;
            $where['pos_id'] = $pos_id;
            $info = $this->model->where($where)->find();
            if( empty($info) )
                throw new Exception('参错错误');

            if (empty($data['adv_img']))
                throw new Exception('缺少广告图');

            $t = time();
            $param_type = array(
                'pos_id'       => 'intval',
                'adv_id'       => 'intval',
                'sequence'  => 'intval',
                'start_time'  => 'dateTime',
                'end_time'  => 'dateTime',
            );
            $updateData = setUpdateData($info->toArray(),$data,['edit_time'=>$t,'adv_img'=>$data['adv_img']],$param_type);
            if(!empty($updateData)){
                $this->model->startTrans();
                $updateState = $this->model->where($where)->update($updateData);
                if (empty($updateState))
                    throw new Exception('网络错误，保存失败');

                //添加日志
                $updateData['where'] = $where;
                if ($this->LogIn($this->logModel::UPDATES, '编辑 ' . $pos_info['pos_name'] . ' 广告id:' . $info['adv_id'], $updateData) === false)
                    throw new Exception('网络错误，保存失败');

                $this->model->commit();
            }
        }catch( Exception $e ){
            $this->model->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    //添加广告
    public function update_sequence(){
        $data = input('post.');
        try{
            $adv_id = empty($data['adv_id']) ? 0 : intval($data['adv_id']);
            if( $adv_id <=0 )
                throw new Exception('参错错误');

            //获取广告信息
            $where['adv_id'] = $adv_id;
            $info = $this->model->where($where)->find();

            if( empty($info) )
                throw new Exception('参错错误');

            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            $this->model->startTrans();
            $updateState = $this->model->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $updateData['where'] = $where;
            if ($this->LogIn($this->logModel::UPDATES, '编辑广告id:'.$info['adv_id'].' 排序 ', $updateData) === false)
                throw new Exception('网络错误，记录失败');

            $this->model->commit();
        }catch( Exception $e ){
            $this->model->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    public function del_adv(){
        $adv_id = intval(input('post.id',0));
        try{
            if( $adv_id <= 0 )
                throw new Exception('参数错误');

            $where['adv_id'] = ['=',$adv_id];
            //获取广告信息
            $info = $this->model->where('adv_id',$adv_id)->find();
            if( empty($info) )
                throw new Exception('网络错误，操作失败');

            $this->model->startTrans();
            $status =$this->model->where($where)->delete();
            if( empty($status) )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $updateData['where'] = $where;
            if ($this->LogIn($this->logModel::DEL, '删除广告id：'.$info['adv_id'], $updateData) === false)
                throw new Exception('网络错误，操作失败');

            $this->model->commit();
        }catch( Exception $e ){
            $this->model->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'删除成功');
    }

}