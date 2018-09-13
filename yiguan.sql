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
) COMMENT '管理员表';

CREATE TABLE IF NOT EXISTS `yg_sys_user_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '索引id',
  `sys_user_id` int(11) NOT NULL COMMENT '管理员id',
  `type` varchar(11) NOT NULL COMMENT '操作类型',
  `description` text NOT NULL COMMENT '描述',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `add_ip` char(15) NOT NULL COMMENT '操作ip'
) COMMENT '管理员操作日志';

CREATE TABLE IF NOT EXISTS `yg_sys_user_group`(
  `group_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '权限组索引',
  `group_name` varchar(50) NOT NULL COMMENT '权限组名',
  `value` text NOT NULL COMMENT '权限内容',
  `status` tinyint(1) NOT NULL COMMENT '状态 0禁用 1正常',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  `edit_time` int(10) NOT NULL COMMENT '修改时间'
) COMMENT '管理员权限组';

CREATE TABLE IF NOT EXISTS `yg_sys_user_token`(
)