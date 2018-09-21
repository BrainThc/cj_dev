CREATE TABLE IF NOT EXISTS `yg_sys_user` (
  `sys_user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '管理员索引id',
  `username` varchar(50) NOT NULL COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `keyCode` varchar(6) NOT NULL COMMENT '身份秘钥',
  `group_id` int(11) NOT NULL DEFAULT 0 COMMENT '所属权限组', 
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '账号状态 0 已删除 1正常',
  `reg_ip` char(15) NOT NULL COMMENT '注册ip',
  `reg_time` int(10) NOT NULL DEFAULT 0 COMMENT '注册时间',
  `login_count` int(11) NOT NULL COMMENT '登录次数',
  `last_ip` char(15) NOT NULL COMMENT '注册ip',
  `last_time` int(10) NOT NULL DEFAULT 0 COMMENT '上一次登录时间',
  `desc` varchar(255) NOT NULL COMMENT '账号备注'
) ENGINE=InnoDB COMMENT '管理员表';

CREATE TABLE IF NOT EXISTS `yg_sys_user_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `sys_user_id` int(11) NOT NULL COMMENT '管理员id',
  `type` varchar(11) NOT NULL COMMENT '操作类型',
  `description` text NOT NULL DEFAULT '' COMMENT '描述',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `add_ip` char(15) NOT NULL DEFAULT '' COMMENT '操作ip'
) ENGINE=InnoDB COMMENT '管理员操作日志';

CREATE TABLE IF NOT EXISTS `yg_sys_user_group`(
  `group_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '权限组索引',
  `group_name` varchar(50) NOT NULL COMMENT '权限组名',
  `value` text NOT NULL COMMENT '权限内容',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 0禁用 1正常 2超级管理员',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `edit_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '管理员权限组';

CREATE TABLE IF NOT EXISTS `yg_site_config`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '配置索引id',
  `site_name` varchar(255) NOT NULL UNIQUE COMMENT '配置名',
  `pid` int(11) NOT NULL COMMENT '父级配置id 0为一级',
  `site_value` text NOT NULL DEFAULT '' COMMENT '配置值',
  `last_value` text NOT NULL DEFAULT '' COMMENT '上一次的值'
) ENGINE=InnoDB COMMENT '系统配置表';

CREATE TABLE IF NOT EXISTS `yg_menu`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '菜单索引id',
  `menu_name` varchar(255) NOT NULL COMMENT '菜单名',
  `menu_url`  text NOT NULL COMMENT '跳转链接',
  `menu_icon` text NOT NULL COMMENT '菜单icon图',
  `pid` int(11) NOT NULL COMMENT '父级菜单id 0为一级菜单',
  `sequence` int(3) NOT NULL COMMENT '排序 由大到小',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `edit_time` int(10) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB COMMENT '导航菜单表';

CREATE TABLE IF NOT EXISTS `yg_sys_user_token`(
)