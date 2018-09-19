<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use app\admin\model\Log as LogModel;
class Log extends Base
{
    public function index()
    {
        $logModel = model('Log');
        $where = [];
        $keyword = input('keyword','');
        if( $keyword != ''){
            $where['username'] = ['like',"%{$keyword}%"];
        }
        //配置显示用户
        if( $this->is_super ){//只有超级用户才能查看所有会员
            $sys_user_id = intval(input('sys_user_id'));
            if( $sys_user_id > 0 ){
                $where['sys_user_id'] = ['=',$sys_user_id];
            }
        }else{
            $where['sys_user_id'] = ['=',$this->sysUserId];
        }
        $log_type = input('type','');
        if( $log_type != '' ){
            $where['type'] = ['=',$log_type];
        }
        $start_date = input('start_time','');
        $start_time = strtotime($start_date);
        $end_date = input('end_time','');
        $end_time = strtotime($end_date);
        if( !empty($start_date) && !empty($end_date) ){
            $where['add_time'] = ['between',$start_time.','.$end_time];
        }else if( !empty($start_date) ){
            $where['add_time'] = ['>=',$start_time];
        }else if( !empty($end_date) ){
            $where['add_time'] = ['<=',$start_time];
        }
        $list = Db::table($logModel->getTable().' l')
            ->join($logModel->getTable('sys_user').' u','u.sys_user_id = l.sys_user_id')
            ->field('l.*,u.username')
            ->where($where)
            ->order('add_time','desc')
            ->paginate(15);
        if( !empty($list) ){
            foreach( $list as $k => $row ){
                $row['type'] = isset(LogModel::$map_type[$row['type']]) ? LogModel::$map_type[$row['type']] : $row['type'];
                $list[$k] = $row;
            }
        }
        $this->assign('list',$list);
        $page = $list->render();
        $this->assign('page',$page);
        return $this->fetch();
    }

}
