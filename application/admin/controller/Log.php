<?php
namespace app\admin\controller;
class Log extends Base
{
    //获取日志
    public function getAll(){
        $size = input('limit',10);
        $page = input('page',1);
        $pageLimit = (($page - 1) * $size).','.$size;
        $where = [];
        $keyword = input('keyword','');
        if( $keyword != ''){
            $where['u.username'] = ['like',"%{$keyword}%"];
        }
        //配置显示用户
        if( $this->is_super ){//只有超级用户才能查看所有会员
            $sys_user_id = intval(input('sys_user_id'));//id筛选
            if( $sys_user_id > 0 ) {
                $where['l.sys_user_id'] = ['=', $sys_user_id];
            }
        }else{
            $where['l.sys_user_id'] = ['=',$this->sysUserId];
        }
        $log_type = input('type','');
        if( $log_type != '' ){
            $where['l.type'] = ['=',$log_type];
        }
        $start_date = input('start_time','');
        $start_time = strtotime($start_date);
        $end_date = input('end_time','');
        $end_time = strtotime($end_date);
        if( !empty($start_date) && !empty($end_date) ){
            $where['l.add_time'] = ['between',$start_time.','.$end_time];
        }else if( !empty($start_date) ){
            $where['l.add_time'] = ['>=',$start_time];
        }else if( !empty($end_date) ){
            $where['l.add_time'] = ['<=',$start_time];
        }
        $sysUserModel = model('SysUser');
        $list = $this->model->alias('l')
            ->join($sysUserModel->getTable('sys_user').' u','u.sys_user_id = l.sys_user_id','left')
            ->field('l.*,u.username')
            ->where($where)
            ->order('l.add_time','desc')
            ->limit($pageLimit)->select();

        $count = $this->model->alias('l')
            ->join($sysUserModel->getTable('sys_user').' u','u.sys_user_id = l.sys_user_id','left')
            ->field('l.*,u.username')
            ->where($where)
            ->count();
        if( !empty($list) ){
            foreach( $list as $k => $row ){
                $row['username'] = empty($row['username']) ? '游客' : $row['username'];
                $row['type'] = isset($this->logModel::$map_type[$row['type']]) ? $this->logModel::$map_type[$row['type']] : $row['type'];
                $row['add_time'] = date('Y-m-d H:i:s',$row['add_time']);
                $list[$k] = $row;
            }
        }
        returnJson(true,'success',$list,['count'=>$count]);
    }

}
