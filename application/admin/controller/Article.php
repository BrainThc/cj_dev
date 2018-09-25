<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Log as LogModel;
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
        $data = input('.post');
        try{
            //文章名
            $insertData['title'] = empty($data['title']) ? '' : trim($data['title']);
            if( $insertData == '' )
                throw new Exception('文章名不能为空');

            //关键词
            $insertData['keyword'] = empty($data['keyword']) ? '' : $data['keyword'];
            //描述
            $insertData['description'] = empty($data['description']) ? '' : $data['description'];
            $insertData['content'] = empty($data['content']) ? '' : $data['content'];

            $t = time();
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;

            $insertData['sequence'] = empty($insertData) ? 0 : intval($insertData['sequence']);
            $insertData['read_group'] = ArticleModel::$map_raeadgroup[$data['read_group']];

            Db::startTrans();
            if( Db::table($this->articleModel->getTable())->insertData($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //记录日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加文章：'.$insertData['title']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            retrunJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    /**
     *  设置文章推荐
     */
    public function set_recomm(){
        returnJson(false,'参数错误');
    }

    /*
     *  设置文章状态
     */
    public function set_status(){
        returnJson(false,'参数错误');
    }

    //编辑页面
    public function edit(){
        return $this->fetch();
    }

}