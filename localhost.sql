-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?09 �?30 �?09:18
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ygkj`
--
CREATE DATABASE `ygkj` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ygkj`;

-- --------------------------------------------------------

--
-- 表的结构 `yg_adv_list`
--

CREATE TABLE IF NOT EXISTS `yg_adv_list` (
  `adv_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '���������id',
  `pos_id` int(11) NOT NULL COMMENT '�������λid',
  `adv_title` varchar(255) NOT NULL COMMENT '������',
  `adv_img` text NOT NULL COMMENT 'ͼƬ��ַ',
  `adv_url` text NOT NULL COMMENT '��ת��ַ',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '��ʼʱ��',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='���ͼ��' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_adv_position`
--

CREATE TABLE IF NOT EXISTS `yg_adv_position` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '���λ����id',
  `pos_name` varchar(255) NOT NULL COMMENT '���λ��',
  `pos_desc` varchar(255) NOT NULL COMMENT '���λ����',
  `image` text NOT NULL COMMENT 'Ĭ��ͼ',
  `width` varchar(11) NOT NULL DEFAULT '' COMMENT '���λ���� 0��Ϊ�����',
  `height` varchar(11) NOT NULL DEFAULT '' COMMENT '���λ�߶� 0��Ϊ�����',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='���λ��' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_article`
--

CREATE TABLE IF NOT EXISTS `yg_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��������id',
  `art_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '��Ŀ����id',
  `title` varchar(255) NOT NULL COMMENT '���±���',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo�ؼ���',
  `description` text NOT NULL COMMENT '�������',
  `content` text NOT NULL COMMENT '��������',
  `sequence` tinyint(3) NOT NULL DEFAULT '0' COMMENT '��������',
  `read_group` tinyint(3) NOT NULL DEFAULT '0' COMMENT '�Ķ�Ȩ�� 0������ 1ע���û� 2����Ա',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '�Ķ���',
  `recommend` tinyint(2) NOT NULL DEFAULT '0' COMMENT '�Ƿ��Ƽ� 1�� 0��',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '����״̬ 1����� 2����� 0���ʧ��',
  `is_show` tinyint(2) NOT NULL DEFAULT '1' COMMENT '�Ƿ���ʾ 1��ʾ 0����',
  `deleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '�Ƿ���ɾ�� 1��ɾ�� 0δɾ��',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='���±�' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_article_cate`
--

CREATE TABLE IF NOT EXISTS `yg_article_cate` (
  `art_cate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '������Ŀ����id',
  `cate_name` varchar(255) NOT NULL COMMENT '��Ŀ����',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '�ϼ���Ŀҳ',
  `sequence` tinyint(3) NOT NULL DEFAULT '0' COMMENT '�����ɴ�С',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`art_cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='������Ŀ��' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_images_upload`
--

CREATE TABLE IF NOT EXISTS `yg_images_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `user_type` int(11) NOT NULL COMMENT '0 ��Ա�û� 1��̨',
  `user_id` int(11) NOT NULL COMMENT '�û�id',
  `file` text NOT NULL COMMENT '�����ļ��б�ʶ',
  `url` text NOT NULL COMMENT 'ͼƬ·��',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ͼƬ�ϴ���¼' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_menus`
--

CREATE TABLE IF NOT EXISTS `yg_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�˵�����id',
  `menu_name` varchar(255) NOT NULL COMMENT '�˵���',
  `menus_type` int(11) NOT NULL COMMENT '�������� ��Ӧmenus_type ����',
  `menu_url` text NOT NULL COMMENT '��ת����',
  `menu_icon` text NOT NULL COMMENT '�˵�iconͼ',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '�����˵�id 0Ϊһ���˵�',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '���� �ɴ�С',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�޸�ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�����˵���' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_menus_type`
--

CREATE TABLE IF NOT EXISTS `yg_menus_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `type_name` varchar(255) NOT NULL COMMENT '������',
  `desc` text NOT NULL COMMENT '����',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�����˵�����' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_mobild_code`
--

CREATE TABLE IF NOT EXISTS `yg_mobild_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `mobile` varchar(50) NOT NULL COMMENT '�ֻ���',
  `code` varchar(10) NOT NULL COMMENT '��֤��code',
  `add_time` int(10) NOT NULL COMMENT '����ʱ��',
  `finished_time` int(10) NOT NULL COMMENT 'ʧЧʱ��',
  `add_ip` varchar(50) NOT NULL COMMENT '����ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='�ֻ���֤���' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yg_site_config`
--

CREATE TABLE IF NOT EXISTS `yg_site_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��������id',
  `site_key` varchar(255) NOT NULL COMMENT '���ùؼ���',
  `site_name` varchar(255) NOT NULL COMMENT '������',
  `pid` int(11) NOT NULL COMMENT '��������id 0Ϊһ��',
  `site_value` text NOT NULL COMMENT '����ֵ',
  `site_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0�ı� 1ͼƬ',
  `last_value` text NOT NULL COMMENT '��һ�ε�ֵ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_key` (`site_key`),
  UNIQUE KEY `site_name` (`site_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ϵͳ���ñ�' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `yg_site_config`
--

INSERT INTO `yg_site_config` (`id`, `site_key`, `site_name`, `pid`, `site_value`, `site_type`, `last_value`) VALUES
(1, 'web_config', '站点配置', 0, '', 0, ''),
(2, 'web_name', '网站名称', 1, '', 0, ''),
(3, 'web_url', '网站网址', 1, '', 0, ''),
(4, 'web_email', '站点邮箱', 1, '', 0, ''),
(5, 'web_title', '网站标题', 1, '', 0, ''),
(6, 'web_seo_keywords', '关键词', 1, '', 0, ''),
(7, 'web_seo_description', '网站简介', 1, '', 0, ''),
(8, 'web_phone', '联系电话', 1, '', 0, ''),
(9, 'web_mphone', '联系手机', 1, '', 0, ''),
(10, 'web_qq', 'QQ', 1, '', 0, ''),
(11, 'web_logo', '网站logo', 1, '', 1, ''),
(12, 'company_address', '公司地址', 1, '', 0, ''),
(13, 'web_copyright', '版权信息', 1, '', 0, ''),
(14, 'web_record', '备案信息', 1, '', 0, ''),
(15, 'sys_config', '系统参数', 0, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `yg_sys_user`
--

CREATE TABLE IF NOT EXISTS `yg_sys_user` (
  `sys_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����Ա����id',
  `username` varchar(50) NOT NULL COMMENT '����Ա�û���',
  `password` varchar(50) NOT NULL COMMENT '����',
  `keyCode` varchar(6) NOT NULL COMMENT '������Կ',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '����Ȩ����',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '�˺�״̬ 0 ��ɾ�� 1����',
  `reg_ip` char(15) NOT NULL COMMENT 'ע��ip',
  `reg_time` int(10) NOT NULL DEFAULT '0' COMMENT 'ע��ʱ��',
  `login_count` int(11) NOT NULL COMMENT '��¼����',
  `last_ip` char(15) NOT NULL COMMENT 'ע��ip',
  `last_time` int(10) NOT NULL DEFAULT '0' COMMENT '��һ�ε�¼ʱ��',
  `desc` varchar(255) NOT NULL COMMENT '�˺ű�ע',
  PRIMARY KEY (`sys_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����Ա��' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yg_sys_user`
--

INSERT INTO `yg_sys_user` (`sys_user_id`, `username`, `password`, `keyCode`, `group_id`, `status`, `reg_ip`, `reg_time`, `login_count`, `last_ip`, `last_time`, `desc`) VALUES
(1, 'admin', '4b6ce2f7db3cf15316614c102bb69bc4', 'd8d784', 1, 1, '0', 0, 10, '127.0.0.1', 1538292200, '0'),
(2, 'test', 'f38529929f52e0884d3cb67e30b27255', '', 6, 1, '127.0.0.1', 1538289203, 0, '', 0, ''),
(3, 'test1', 'c54830f20f2d0724762a25447caf5c93', '', 2, 1, '127.0.0.1', 1538289490, 0, '', 0, ''),
(4, 'test2', '0ea50878dca20dab933e53877718c526', '', 8, 1, '127.0.0.1', 1538289551, 0, '', 0, ''),
(5, 'admin1', 'd96b9557c698055255befd006aa6d5ea', '046f46', 8, 1, '127.0.0.1', 1538289603, 5, '127.0.0.1', 1538298899, '');

-- --------------------------------------------------------

--
-- 表的结构 `yg_sys_user_group`
--

CREATE TABLE IF NOT EXISTS `yg_sys_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ȩ��������',
  `group_name` varchar(50) NOT NULL COMMENT 'Ȩ������',
  `value` text NOT NULL COMMENT 'Ȩ������',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '״̬ 0',
  `add_time` int(10) NOT NULL COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL COMMENT '�޸�ʱ��',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����ԱȨ����' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `yg_sys_user_group`
--

INSERT INTO `yg_sys_user_group` (`group_id`, `group_name`, `value`, `status`, `add_time`, `edit_time`) VALUES
(1, '超级管理员', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,menus_create,menus_update,menus_del,article,article_cate,article_cate_create_view,article_cate_create,article_cate_update_view,article_cate_update,article_list,article_create_view,article_create,article_create_view,article_update,article_recomm,article_deleted,goods,goods_list,order,order_list,market,market_banner_pos,market_banner_content,template,template_pc,template_wap,sys_user,sys_user_list,sys_user_create_view,sys_user_create,sys_user_update_view,sys_user_update,sys_user_del,sys_user_group,sys_user_group_create_view,sys_user_group_create,sys_user_group_update,sys_user_group_power_update,sys_user_group_update,sys_user_group_default,log,sys_user_log', 2, 1537281475, 1538290593),
(2, '超级', 'home', 0, 1538203519, 1538203519),
(3, '测试账号', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,article,article_cate,article_cate_create,order,order_list,market,market_banner_pos,template,sys_user,sys_user_list_create,log,sys_user_log', 0, 1538205451, 1538205451),
(4, '测试组', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,article,article_cate,article_cate_create,order,order_list,market,market_banner_pos,template,sys_user,sys_user_list_create,log,sys_user_log', 1, 1538205706, 1538215385),
(5, '测试添加', 'home', 1, 1538206152, 1538206152),
(6, '只有主页权限的权限组（修改过的）', 'home,home_show,goods,order,template', 1, 1538206246, 1538215567),
(7, '1', 'home,log,sys_user_log', 1, 1538289342, 1538292512),
(8, '2', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,menus_create,menus_update,menus_del,log,sys_user_log', 1, 1538289519, 1538298930);

-- --------------------------------------------------------

--
-- 表的结构 `yg_sys_user_log`
--

CREATE TABLE IF NOT EXISTS `yg_sys_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `sys_user_id` int(11) NOT NULL COMMENT '����Աid',
  `type` varchar(11) NOT NULL COMMENT '��������',
  `description` text NOT NULL COMMENT '����',
  `add_time` int(10) NOT NULL COMMENT '����ʱ��',
  `add_ip` char(15) NOT NULL COMMENT '����ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����Ա������־' AUTO_INCREMENT=136 ;

--
-- 转存表中的数据 `yg_sys_user_log`
--

INSERT INTO `yg_sys_user_log` (`id`, `sys_user_id`, `type`, `description`, `add_time`, `add_ip`) VALUES
(1, 1, 'signIn', '用户登陆', 1537280871, '127.0.0.1'),
(2, 1, 'signIn', '用户登陆', 1537280928, '127.0.0.1'),
(3, 1, 'signIn', '用户登陆', 1537281491, '127.0.0.1'),
(4, 1, 'signIn', '用户登陆', 1537283702, '127.0.0.1'),
(5, 1, 'signIn', '用户登陆', 1538012412, '127.0.0.1'),
(6, 1, 'update', '初始化超级管理员权限配置', 1538012422, '127.0.0.1'),
(7, 1, 'signIn', '用户登陆', 1538013638, '127.0.0.1'),
(8, 1, 'signIn', '用户登陆', 1538013869, '127.0.0.1'),
(9, 1, 'insert', '添加站点配置：站点配置', 1538014198, '127.0.0.1'),
(10, 1, 'insert', '添加站点配置：系统参数', 1538014210, '127.0.0.1'),
(11, 1, 'insert', '添加站点配置：网站名称', 1538014244, '127.0.0.1'),
(12, 1, 'insert', '添加站点配置：网站网址', 1538014323, '127.0.0.1'),
(13, 1, 'insert', '添加站点配置：站点邮箱', 1538014342, '127.0.0.1'),
(14, 1, 'insert', '添加站点配置：网站标题', 1538014349, '127.0.0.1'),
(15, 1, 'insert', '添加站点配置：站点配置', 1538014907, '127.0.0.1'),
(16, 1, 'insert', '添加站点配置：网站名称', 1538015066, '127.0.0.1'),
(17, 1, 'insert', '添加站点配置：网站网址', 1538015107, '127.0.0.1'),
(18, 1, 'insert', '添加站点配置：站点邮箱', 1538015118, '127.0.0.1'),
(19, 1, 'insert', '添加站点配置：系统参数', 1538015573, '127.0.0.1'),
(20, 1, 'insert', '添加站点配置：站点配置', 1538017247, '127.0.0.1'),
(21, 1, 'insert', '添加站点配置：网站名称', 1538017276, '127.0.0.1'),
(22, 1, 'insert', '添加站点配置：网站网址', 1538017290, '127.0.0.1'),
(23, 1, 'insert', '添加站点配置：站点邮箱', 1538017302, '127.0.0.1'),
(24, 1, 'insert', '添加站点配置：网站标题', 1538017326, '127.0.0.1'),
(25, 1, 'insert', '添加站点配置：关键词', 1538017357, '127.0.0.1'),
(26, 1, 'insert', '添加站点配置：网站简介', 1538017378, '127.0.0.1'),
(27, 1, 'insert', '添加站点配置：联系电话', 1538017408, '127.0.0.1'),
(28, 1, 'insert', '添加站点配置：联系手机', 1538017419, '127.0.0.1'),
(29, 1, 'insert', '添加站点配置：QQ', 1538017435, '127.0.0.1'),
(30, 1, 'insert', '添加站点配置：网站logo', 1538017453, '127.0.0.1'),
(31, 1, 'insert', '添加站点配置：公司地址', 1538017569, '127.0.0.1'),
(32, 1, 'insert', '添加站点配置：版权信息', 1538018065, '127.0.0.1'),
(33, 1, 'insert', '添加站点配置：备案信息', 1538018143, '127.0.0.1'),
(34, 1, 'insert', '添加站点配置：系统参数', 1538018311, '127.0.0.1'),
(35, 1, 'update', '初始化超级管理员权限配置', 1538019947, '127.0.0.1'),
(36, 1, 'signIn', '用户登陆', 1538019950, '127.0.0.1'),
(37, 1, 'update', '初始化超级管理员权限配置', 1538021131, '127.0.0.1'),
(38, 1, 'update', '初始化超级管理员权限配置', 1538021538, '127.0.0.1'),
(39, 1, 'signIn', '用户登陆', 1538184860, '127.0.0.1'),
(40, 1, 'insert', '添加权限组：超级', 1538203519, '127.0.0.1'),
(41, 1, 'insert', '添加权限组：测试账号', 1538205451, '127.0.0.1'),
(42, 1, 'insert', '添加权限组：测试组', 1538205706, '127.0.0.1'),
(43, 1, 'insert', '添加权限组：测试添加', 1538206152, '127.0.0.1'),
(44, 1, 'insert', '添加权限组：只有主页权限的权限组', 1538206246, '127.0.0.1'),
(45, 1, 'signIn', '用户登陆', 1538210990, '127.0.0.1'),
(46, 1, 'signIn', '用户登陆', 1538210996, '127.0.0.1'),
(47, 1, 'signIn', '用户登陆', 1538211006, '127.0.0.1'),
(48, 1, 'update', '编辑权限组：', 1538211513, '127.0.0.1'),
(49, 1, 'update', '编辑权限组：', 1538211537, '127.0.0.1'),
(50, 1, 'signIn', '用户登陆', 1538211549, '127.0.0.1'),
(51, 1, 'signIn', '用户登陆', 1538211558, '127.0.0.1'),
(52, 1, 'update', '编辑权限组：只有主页权限的权限组（修改过的）', 1538211702, '127.0.0.1'),
(53, 1, 'update', '禁用管理员管理员：', 1538212434, '127.0.0.1'),
(54, 1, 'update', '禁用权限组：只有主页权限的权限组（修改过的）', 1538212582, '127.0.0.1'),
(55, 1, 'update', '正常权限组：只有主页权限的权限组（修改过的）', 1538212592, '127.0.0.1'),
(56, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538212703, '127.0.0.1'),
(57, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538212755, '127.0.0.1'),
(58, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538212772, '127.0.0.1'),
(59, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538212802, '127.0.0.1'),
(60, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538212811, '127.0.0.1'),
(61, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538212833, '127.0.0.1'),
(62, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538212894, '127.0.0.1'),
(63, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538213005, '127.0.0.1'),
(64, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538213034, '127.0.0.1'),
(65, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538213049, '127.0.0.1'),
(66, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538213073, '127.0.0.1'),
(67, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538213156, '127.0.0.1'),
(68, 1, 'update', '编辑权限组：只有主页权限的权限组（修改过的）', 1538213618, '127.0.0.1'),
(69, 1, 'update', '初始化超级管理员权限配置', 1538213635, '127.0.0.1'),
(70, 1, 'update', '初始化超级管理员权限配置', 1538214320, '127.0.0.1'),
(71, 1, 'update', '编辑权限组：测试组', 1538215385, '127.0.0.1'),
(72, 1, 'update', '编辑权限组：只有主页权限的权限组（修改过的）', 1538215431, '127.0.0.1'),
(73, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 禁用 状态', 1538215501, '127.0.0.1'),
(74, 1, 'update', '设置权限组：只有主页权限的权限组（修改过的） 为 正常 状态', 1538215512, '127.0.0.1'),
(75, 1, 'signIn', '用户登陆', 1538215548, '127.0.0.1'),
(76, 1, 'signIn', '用户登陆', 1538215557, '127.0.0.1'),
(77, 1, 'update', '编辑权限组：只有主页权限的权限组（修改过的）', 1538215567, '127.0.0.1'),
(78, 1, 'signIn', '用户登陆', 1538215575, '127.0.0.1'),
(79, 1, 'signIn', '用户登陆', 1538215584, '127.0.0.1'),
(80, 1, 'signIn', '用户登陆', 1538270423, '127.0.0.1'),
(81, 1, 'insert', '添加管理员：test', 1538289203, '127.0.0.1'),
(82, 1, 'insert', '添加权限组：1', 1538289342, '127.0.0.1'),
(83, 1, 'insert', '添加管理员：test1', 1538289490, '127.0.0.1'),
(84, 1, 'insert', '添加权限组：2', 1538289519, '127.0.0.1'),
(85, 1, 'insert', '添加管理员：test2', 1538289551, '127.0.0.1'),
(86, 1, 'insert', '添加管理员：admin1', 1538289603, '127.0.0.1'),
(87, 1, 'signIn', '用户登陆', 1538290224, '127.0.0.1'),
(88, 1, 'signIn', '用户登陆', 1538290507, '127.0.0.1'),
(89, 1, 'update', '初始化超级管理员权限配置', 1538290593, '127.0.0.1'),
(90, 1, 'signIn', '用户登陆', 1538290605, '127.0.0.1'),
(91, 1, 'update', '编辑管理员信息：', 1538291924, '127.0.0.1'),
(92, 1, 'signIn', '用户登陆', 1538292200, '127.0.0.1'),
(93, 5, 'signIn', '用户登陆', 1538292250, '127.0.0.1'),
(94, 1, 'update', '编辑管理员信息：', 1538292286, '127.0.0.1'),
(95, 1, 'update', '编辑管理员id: 5 信息', 1538292353, '127.0.0.1'),
(96, 5, 'signIn', '用户登陆', 1538292484, '127.0.0.1'),
(97, 1, 'update', '编辑权限组：1', 1538292502, '127.0.0.1'),
(98, 5, 'signIn', '用户登陆', 1538292504, '127.0.0.1'),
(99, 1, 'update', '编辑权限组：1', 1538292512, '127.0.0.1'),
(100, 5, 'signIn', '用户登陆', 1538292515, '127.0.0.1'),
(101, 5, 'signIn', '用户登陆', 1538293233, '127.0.0.1'),
(102, 1, 'update', '编辑管理员id: 5 信息', 1538293411, '127.0.0.1'),
(103, 1, 'update', '编辑管理员管理员：', 1538294299, '127.0.0.1'),
(104, 1, 'update', '状态正常管理员管理员：admin1', 1538294368, '127.0.0.1'),
(105, 1, 'update', '设置管理员账号：admin1 状态为 ：已禁用', 1538294428, '127.0.0.1'),
(106, 1, 'update', '设置管理员账号：admin1 状态为 ：状态正常', 1538294457, '127.0.0.1'),
(107, 1, 'update', '设置管理员账号：admin1 状态为 ：已禁用', 1538294463, '127.0.0.1'),
(108, 5, 'signIn', '用户登陆', 1538294465, '127.0.0.1'),
(109, 5, 'signIn', '用户登陆', 1538294469, '127.0.0.1'),
(110, 5, 'signIn', '用户登陆', 1538294471, '127.0.0.1'),
(111, 5, 'signIn', '用户登陆', 1538294727, '127.0.0.1'),
(112, 5, 'signIn', '用户登陆', 1538294902, '127.0.0.1'),
(113, 1, 'update', '设置管理员账号：admin1 状态为 ：状态正常', 1538296606, '127.0.0.1'),
(114, 1, 'update', '设置管理员账号：admin1 状态为 ：已禁用', 1538296619, '127.0.0.1'),
(115, 5, 'signIn', '用户登陆', 1538296622, '127.0.0.1'),
(116, 5, 'signIn', '用户登陆', 1538296623, '127.0.0.1'),
(117, 5, 'signIn', '用户登陆', 1538296634, '127.0.0.1'),
(118, 5, 'signIn', '用户登陆', 1538296635, '127.0.0.1'),
(119, 5, 'signIn', '用户登陆', 1538296636, '127.0.0.1'),
(120, 5, 'signIn', '用户登陆', 1538296639, '127.0.0.1'),
(121, 5, 'signIn', '用户登陆', 1538296645, '127.0.0.1'),
(122, 1, 'update', '编辑管理员id: 5 信息', 1538296829, '127.0.0.1'),
(123, 1, 'update', '设置管理员账号：admin1 状态为 ：状态正常', 1538297042, '127.0.0.1'),
(124, 5, 'signIn', '用户登陆', 1538297050, '127.0.0.1'),
(125, 1, 'update', '设置管理员账号：admin1 状态为 ：已禁用', 1538297065, '127.0.0.1'),
(126, 1, 'update', '注销管理员账号：admin1', 1538297453, '127.0.0.1'),
(127, 1, 'update', '编辑管理员id: 5 信息', 1538298452, '127.0.0.1'),
(128, 1, 'update', '注销管理员账号：admin1', 1538298461, '127.0.0.1'),
(129, 1, 'update', '编辑管理员id: 5 信息', 1538298862, '127.0.0.1'),
(130, 1, 'update', '注销管理员账号：admin1', 1538298870, '127.0.0.1'),
(131, 1, 'update', '编辑管理员id: 5 信息', 1538298890, '127.0.0.1'),
(132, 5, 'signIn', '用户登陆', 1538298899, '127.0.0.1'),
(133, 5, 'signIn', '用户登陆', 1538298902, '127.0.0.1'),
(134, 1, 'update', '编辑权限组：2', 1538298930, '127.0.0.1'),
(135, 5, 'signIn', '用户登陆', 1538298932, '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
