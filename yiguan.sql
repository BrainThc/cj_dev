CREATE TABLE IF NOT EXISTS `yg_sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '管理员',
  `username` varchar(50) NOT NULL COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `keyCode` varchar(6) NOT NULL COMMENT '身份秘钥',
  `powerGroup` int(11) NOT NULL DEFAULT 0 COMMENT '所属权限组', 
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '账号状态 0 已删除 1正常',
  `reg_ip` char(15) NOT NULL COMMENT '注册ip',
  `reg_time` int(10) NOT NULL DEFAULT 0 COMMENT '注册时间',
  `login_count` int(11) NOT NULL COMMENT '登录次数',
  `last_time` int(10) NOT NULL DEFAULT 0 COMMENT '上一次登录时间',
  `desc` varchar(255) NOT NULL COMMENT '账号备注'
) COMMENT '管理员表';

CREATE TABLE IF NOT EXISTS `yg_sys_user_log`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT ``


)