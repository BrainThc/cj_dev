<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;

class Article extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->articleModel = model('Article');
    }

    public function index(){
        $where = [];
        //关键词搜索
        $keyword = input('keyword','');
        if( $keyword != '' ){
            $where['title'] = ['like',"%{$keyword}%"];
        }
        //栏目筛选
        $art_cate_id = intval(input('cate_id',0));
        if( $art_cate_id > 0 ){
            $where['art_cate_id'] = ['=',$art_cate_id];
        }
        //状态筛选
        $status = intval(input('status',0));
        if( $status > 0 ){
            $where['status'] = ['=',$status];
        }

        $order['sequence'] = 'desc';
        $order['add_time'] = 'desc';
        $order['article_id'] = 'desc';

        $list = Db::table($this->articleModel->getTable())
            ->where($where)
            ->order($order)
            ->paginate(15);

        if( !empty($list) ){
            foreach( $list as $key => $value ){
                $value['edit_date'] = date('Y-m-d H:i:s',$value['edit_time']);
                $list[$key] = $value;
            }
        }

        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
        return $this->fetch();
    }

    //添加页
    public function add(){
        return $this->fetch();
    }

    //添加文章提交
    public function create_article(){
    }

    //编辑页面
    public function edit(){
        return $this->fetch();
    }

}