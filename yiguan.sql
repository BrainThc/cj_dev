/**
管理员表
 */
CREATE TABLE IF NOT EXISTS `yg_sys_user` (
  `sys_user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '管理员索引id',
  `username` varchar(50) NOT NULL COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `keyCode` varchar(6) NOT NULL COMMENT '身份秘钥',
  `group_id` int(11) NOT NULL DEFAULT 0 COMMENT '所属权限组', 
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '账号状态 0 已删除 1正常',
  `reg_ip` varchar(15) NOT NULL COMMENT '注册ip',
  `reg_time` int(10) NOT NULL DEFAULT 0 COMMENT '注册时间',
  `login_count` int(11) NOT NULL COMMENT '登录次数',
  `last_ip` varchar(15) NOT NULL COMMENT '注册ip',
  `last_time` int(10) NOT NULL DEFAULT 0 COMMENT '上一次登录时间',
  `desc` varchar(255) NOT NULL COMMENT '账号备注'
) ENGINE=InnoDB COMMENT '管理员表';

/*添加索引*/
ALTER TABLE  `yg_sys_user` ADD INDEX (  `group_id` );


INSERT INTO `yg_sys_user` (`sys_user_id`, `username`, `password`, `keyCode`, `group_id`, `status`, `reg_ip`, `reg_time`, `login_count`, `last_ip`, `last_time`, `desc`) VALUES
(1, 'admin', '4b6ce2f7db3cf15316614c102bb69bc4', 'd8d784', 1, 1, '0', 0, 32, '127.0.0.1', 1539741596, '')

/**
token秘钥表
 */
-- CREATE TABLE IF NOT EXISTS `yg_sys_user_token`(
-- )

/**
用户操作记录表
 */
CREATE TABLE IF NOT EXISTS `yg_sys_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `sys_user_id` int(11) NOT NULL COMMENT '管理员id',
  `type` varchar(11) NOT NULL COMMENT '操作类型',
  `description` text NOT NULL DEFAULT '' COMMENT '描述',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `add_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '操作ip'
) ENGINE=InnoDB COMMENT '管理员操作日志';

/**
权限组列表
 */
CREATE TABLE IF NOT EXISTS `yg_sys_user_group`(
  `group_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '权限组索引',
  `group_name` varchar(50) NOT NULL COMMENT '权限组名',
  `value` text NOT NULL COMMENT '权限内容',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 0禁用 1正常 2超级管理员',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '管理员权限组';


INSERT INTO `yg_sys_user_group` (`group_id`, `group_name`, `value`, `status`, `add_time`, `edit_time`) VALUES
(1, '超级管理员', 'home,home_show,sys_user,sys_user_group,sys_user_group_update_view,sys_user_group_update,sys_user_group_update,sys_user_group_default,log,sys_user_log', 2, 1537281475, 1539570998)

/**
系统配置表
 */
CREATE TABLE IF NOT EXISTS `yg_site_config`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '配置索引id',
  `site_key` varchar(255) NOT NULL UNIQUE COMMENT '配置关键词',
  `site_name` varchar(255) NOT NULL UNIQUE COMMENT '配置名',
  `pid` int(11) NOT NULL COMMENT '父级配置id 0为一级',
  `site_value` text NOT NULL DEFAULT '' COMMENT '配置值',
  `site_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0文本 1图片',
  `last_value` text NOT NULL DEFAULT '' COMMENT '上一次的值',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '上一次修改时间'
) ENGINE=InnoDB COMMENT '系统配置表';

/**
导航管理表
 */
CREATE TABLE IF NOT EXISTS `yg_menus`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '菜单索引id',
  `menu_name` varchar(255) NOT NULL COMMENT '菜单名',
  `menus_type_id` int(11) NOT NULL COMMENT '导航类型 对应menus_type 索引',
  `menu_url`  text NOT NULL DEFAULT '' COMMENT '跳转链接',
  `menu_icon` text NOT NULL DEFAULT '' COMMENT '菜单icon图',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父级菜单id 0为一级菜单',
  `sequence` int(3) NOT NULL DEFAULT 0 COMMENT '排序 由大到小',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '导航菜单表';

/**
导航类型
 */
CREATE TABLE IF NOT EXISTS `yg_menus_type`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `type_name` varchar(255) NOT NULL COMMENT '类型名',
  `desc` text NOT NULL DEFAULT '' COMMENT '描述',
  `sequence` tinyint(3) NOT NULL COMMENT '排序 由大到小',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '导航菜单类型';

/**
文章栏目类型
 */
CREATE TABLE IF NOT EXISTS `yg_article_cate`(
  `art_cate_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '文章栏目索引id',
  `cate_name` varchar(255) NOT NULL COMMENT '栏目名称',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '上级栏目页',
  `sequence` tinyint(3) NOT NULL DEFAULT 0 COMMENT '排序由大到小',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间'
) ENGINE=InnoDB COMMENT '文章栏目表';

/**
文章表
 */
CREATE TABLE IF NOT EXISTS `yg_article`(
  `article_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '文章索引id',
  `art_cate_id` int(11) NOT NULL DEFAULT 0 COMMENT '栏目索引id',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键词',
  `description` text NOT NULL DEFAULT '' COMMENT '简介描述',
  `content` text NOT NULL DEFAULT '' COMMENT '文章内容',
  `img` text NOT NULL DEFAULT '' COMMENT '文章列表图',
  `icon` text NOT NULL DEFAULT '' COMMENT '文章缩略图',
  `sequence` tinyint(3) NOT NULL DEFAULT 0 COMMENT '文章排序',
  `read_group` tinyint(3) NOT NULL DEFAULT 0 COMMENT '阅读权限 0所有人 1注册用户 2管理员',
  `read_num` int(11) NOT NULL DEFAULT 0 COMMENT '阅读数',
  `recommend` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否推荐 1是 0否',
  `status` tinyint(2) NOT NULL DEFAULT 2 COMMENT '文章状态 1已审核 2审核中 0审核失败',
  `is_show` tinyint(2) NOT NULL DEFAULT 1 COMMENT '是否显示 1显示 0隐藏',
  `deleted` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否已删除 1已删除 0未删除',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '管理员id',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间'
) ENGINE=InnoDB COMMENT '文章表';

/**
广告位表
 */
CREATE TABLE IF NOT EXISTS `yg_adv_position`(
  `pos_id` int(11) NOT NULL NULL AUTO_INCREMENT PRIMARY KEY COMMENT '广告位索引id',
  `pos_name` varchar(255) NOT NULL COMMENT '广告位名',
  `pos_desc` varchar(255) NOT NULL COMMENT '广告位描述',
  `pos_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '广告位类型 1 单图片 2视频 3 图片幻灯片轮播 4 多图',
  `pos_adv_num` int(5) NOT NULL DEFAULT 0 COMMENT '广告位展示数 0为不限制',
  `image` text NOT NULL COMMENT '默认图占位图',
  `width` varchar(11) NOT NULL DEFAULT '' COMMENT '广告位宽度 0则为定义的',
  `height` varchar(11) NOT NULL DEFAULT '' COMMENT '广告位高度 0则为定义的',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '广告位状态 1正常 0关闭',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间'
) ENGINE=InnoDB COMMENT '广告位表';

/**
广告图列表
 */
CREATE TABLE IF NOT EXISTS `yg_adv_list`(
  `adv_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '广告索引你id',
  `pos_id`  int(11) NOT NULL COMMENT '所属广告位id',
  `adv_title` varchar(255) NOT NULL COMMENT '广告标题',
  `adv_img` text NOT NULL COMMENT '图片地址',
  `adv_url` text NOT NULL COMMENT '跳转地址',
  `sequence` tinyint(3) NOT NULL COMMENT '排序 由大到小',
  `start_time` int(10) NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '结束时间',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间'
) ENGINE=InnoDB COMMENT '广告图表';

/**
图库资源记录表
 */
CREATE TABLE IF NOT EXISTS `yg_images_upload`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `user_type` int(11) NOT NULL COMMENT '0 会员用户 1后台',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `url` text NOT NULL DEFAULT '' COMMENT '图片路径',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间'
) ENGINE=MyISAM COMMENT '图片上传记录';

/**
手机验证码表
 */
CREATE TABLE IF NOT EXISTS `yg_mobild_code`(
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
 `mobile` varchar(50) NOT NULL COMMENT '手机号',
 `code` varchar(10) NOT NULL COMMENT '验证码code',
 `add_time` int(10) NOT NULL COMMENT '添加时间',
 `finished_time` int(10) NOT NULL COMMENT '失效时间',
 `add_ip` varchar(50) NOT NULL COMMENT '添加ip'
) ENGINE=MyISAM COMMENT '手机验证码表';

/**
 *  省市区表
 */
CREATE TABLE IF NOT EXISTS `yg_city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id' ,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '城市名',
) ENGINE=InnoDB  COMMENT '省市区表' ;

/**
 * 留言主表
 */
CREATE TABLE IF NOT EXISTS `yg_message_list` (
  `mess_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `author_id` int(11) NOT NULL COMMENT '作者id 0 为游客',
  `author_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '作者类型 0 会员 1管理员',
  `author_name` varchar(255) NOT NULL DEFAULT '' COMMENT '作者',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `contant` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `wechat` varchar(255) NOT NULL DEFAULT '' COMMENT '微信账号',
  `qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'qq',
  `content` text NOT NULL DEFAULT '' COMMENT '留言内容',
  `remark` text NOT NULL DEFAULT '' COMMENT '备注',
  `read_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已读 0 否 1 是',
  `reply_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已回复 0 否 1 是',
  `author_read_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '作者是否已读 0 否 1 是',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB  COMMENT '留言主表';

/**
 * 留言回复表
 */
CREATE TABLE IF NOT EXISTS `yg_message_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `mess_id` int(11) NOT NULL DEFAULT 0 COMMENT '跟随的留言id',
  `author_id` int(11) NOT NULL COMMENT '作者id',
  `author_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '作者类型 0 会员 1管理员',
  `mess_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL DEFAULT '' COMMENT '回复内容',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB  COMMENT '留言回复表' ;


/**
 * 商品分类表
 */
CREATE TABLE IF NOT EXISTS `yg_goods_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `cate_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id' ,
  `sequence` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序 ',
  `cate_icon` text NOT NULL DEFAULT '' COMMENT '分类icon',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB  COMMENT '商品分类表' ;

/**
 * 商品属性类目
 */
CREATE TABLE IF NOT EXISTS `yg_goods_category_prop` (
  `prop_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '属性类目id',
  `cate_id` int(11) NOT NULL COMMENT '分类id',
  `prop_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性类目名',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '类目备注',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已删除 0 否 1 是',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB  COMMENT '商品分类属性类目表';

/**
 * 商品销售属性值表
 */
CREATE TABLE IF NOT EXISTS `yg_goods_category_prop_val` (
  `prop_val_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '属性值id',
  `prop_id` int(11) NOT NULL DEFAULT '' COMMENT '属性类目id',
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值名',
  `val_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '显示类型 0 文字 1 图片 2 颜色',
  `val_img` text NOT NULL DEFAULT '' COMMENT '属性值图片',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值备注 或 说明',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已删除 0 否 1 是',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB  COMMENT '商品分类属性值表';

/**
 * 商品表
 */
CREATE TABLE IF NOT EXISTS `yg_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '商品id',
  `goods_name` varchar(255) NOT NULL COMMENT '商品名',
  `brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '品牌id',
  `goods_cate` int(11) NOT NULL DEFAULT 0 COMMENT '商品分类cate_id',
  `goods_price` double(11,2) NOT NULL DEFAULT 0 COMMENT '商品基础价格',
  `goods_number` varchar(100) NOT NULL DEFAULT '' COMMENT '商品货号',
  `sequence` tinyint(3) NOT NULL DEFAULT 0 COMMENT '排序',
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '审核状态 0 未通过 1 通过',
  `sales_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否上架 0 否 1 是',
  `recommend` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否推荐 0 否 1 是',
  `deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否删除 0 否 1 是',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '商品表';

/**
 * 商品sku表
 */
CREATE TABLE IF NOT EXISTS `ys_goods_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'sku_id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `item_price` double(11,2) NOT NULL COMMENT 'sku价格',
  `item_image` text NOT NULL DEFAULT '' COMMENT 'SKU 商品图片',
  `item_number` varchar(100) NOT NULL DEFAULT '' COMMENT 'SKU商品货号',
  `sales_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sku状态 0 未上架 1已上架 ',
  `deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '删除状态 0 未删除 1已删除 ',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间'
) ENGINE=InnoDB COMMENT '商品sku表';

/**
 * 商品信息
 */
CREATE TABLE IF NOT EXISTS `ys_goods_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `goods_id` int(11) NOT NULL COMMENT '主商品索引id',
  `list_image` text NOT NULL DEFAULT '' COMMENT '列表图',
  `images_list` text NOT NULL DEFAULT '' COMMENT '展示图列表 第一张为默认显示图',
  `goods_details` text NOT NULL DEFAULT '' COMMENT '商品详情',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间'
) ENGINE=InnoDB COMMENT '商品图片信息';

/**
 * 商品sku属性表
 */
CREATE TABLE IF NOT EXISTS `yg_goods_item_prop`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `goods_id` int(11) NOT NULL COMMENT '主商品索引id',
  `item_id` int(11) NOT NULL COMMENT 'sku商品id',
  `prop_val_id` int(11) NOT NULL COMMENT '属性值索引id',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间'
) ENGINE=InnoDB COMMENT '商品sku属性表';
