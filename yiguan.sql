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
  `desc` varchar(255) NOT NULL COMMENT '账号备注',
) ENGINE=InnoDB COMMENT '管理员表';

/*添加索引*/
ALTER TABLE  `yg_sys_user` ADD INDEX (  `group_id` );

/**
token秘钥表
 */
CREATE TABLE IF NOT EXISTS `yg_sys_user_token`(
)

/**
用户操作记录表
 */
CREATE TABLE IF NOT EXISTS `yg_sys_user_log`(
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
  'edit_time' int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
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
  `image` text NOT NULL COMMENT '默认图',
  `width` varchar(11) NOT NULL DEFAULT '' COMMENT '广告位宽度 0则为定义的',
  `height` varchar(11) NOT NULL DEFAULT '' COMMENT '广告位高度 0则为定义的',
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
  `file` text NOT NULL DEFAULT '' COMMENT '所在文件夹标识',
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