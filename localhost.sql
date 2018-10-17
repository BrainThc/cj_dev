-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?10 �?17 �?09:02
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
  `sequence` tinyint(3) NOT NULL COMMENT '���� �ɴ�С',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '��ʼʱ��',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='���ͼ��' AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `yg_adv_list`
--

INSERT INTO `yg_adv_list` (`adv_id`, `pos_id`, `adv_title`, `adv_img`, `adv_url`, `sequence`, `start_time`, `end_time`, `add_time`, `edit_time`) VALUES
(1, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(2, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(3, 1, '656', 'http://yiguan2.com/uploads/adv/20181015/f69557e0306d7cbdb270ff8472182847.jpg', 'https://www.taobao.com', 9, 0, 1539014400, 0, 0),
(6, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(7, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(8, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(9, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(10, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(11, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(12, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(13, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(14, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(15, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(16, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(17, 1, '测试广告是', 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 'https://www.baidu.com', 3, 1539532800, 1539619200, 0, 0),
(18, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(19, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(20, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(21, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(22, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(23, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(24, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(25, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0),
(26, 1, '测试', 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 'https://www.jd.com', 4, 1538582400, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yg_adv_position`
--

CREATE TABLE IF NOT EXISTS `yg_adv_position` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '���λ����id',
  `pos_name` varchar(255) NOT NULL COMMENT '���λ��',
  `pos_desc` varchar(255) NOT NULL COMMENT '���λ����',
  `pos_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '���λ���� 1 ��ͼƬ 2��Ƶ 3 ͼƬ�õ�Ƭ�ֲ� ',
  `pos_adv_num` int(5) NOT NULL DEFAULT '0' COMMENT '���λչʾ�� 0Ϊ������',
  `image` text NOT NULL COMMENT 'Ĭ��ͼռλͼ',
  `width` varchar(11) NOT NULL DEFAULT '' COMMENT '���λ���� 0��Ϊ�����',
  `height` varchar(11) NOT NULL DEFAULT '' COMMENT '���λ�߶� 0��Ϊ�����',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '���λ״̬ 1���� 0�ر�',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�༭ʱ��',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='���λ��' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yg_adv_position`
--

INSERT INTO `yg_adv_position` (`pos_id`, `pos_name`, `pos_desc`, `pos_type`, `pos_adv_num`, `image`, `width`, `height`, `status`, `add_time`, `edit_time`) VALUES
(1, '首页轮播广告位', '首页轮播广告位', 3, 5, 'http://yiguan2.com/uploads/adv/20181011/538f17bf7cc0d66af10d33960260a808.jpg', '1024', '600', 1, 1539244717, 1539250634),
(2, '测试', '测试', 1, 0, '', '12', '23', 1, 1539577341, 1539577341),
(3, '用来测试用的', '全文', 1, 0, '', '222', '333', 1, 1539577352, 1539586077),
(4, '测试2', '测试2', 1, 0, '', '1', '2', 1, 1539585726, 1539585726);

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
  `img` text NOT NULL COMMENT '�����б�ͼ',
  `icon` text NOT NULL COMMENT '��������ͼ',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='���±�' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `yg_article`
--

INSERT INTO `yg_article` (`article_id`, `art_cate_id`, `title`, `keyword`, `description`, `content`, `img`, `icon`, `sequence`, `read_group`, `read_num`, `recommend`, `status`, `is_show`, `deleted`, `add_time`, `edit_time`) VALUES
(1, 1, '测试文章', '测试文章', '测试文章', '测试文章', '', '测试文章', 5, 0, 0, 1, 1, 1, 0, 0, 0),
(2, 1, '测试文章2', '测试文章2', '测试文章2', '测试文章2', ' ', ' ', 2, 0, 0, 0, 2, 1, 0, 0, 0),
(3, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', '', '', 6, 0, 0, 1, 2, 0, 0, 1539759838, 1539759838),
(4, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', 'http://yiguan2.com/uploads/adv/20181017/1d34d4e1e7c8d8758aa2b81c805cda79.jpg', '', 0, 0, 0, 0, 2, 0, 0, 1539759911, 1539759911),
(5, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', 'http://yiguan2.com/uploads/adv/20181017/1d34d4e1e7c8d8758aa2b81c805cda79.jpg', '', 0, 0, 0, 0, 2, 0, 0, 1539760060, 1539760060),
(6, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', 'http://yiguan2.com/uploads/adv/20181017/1d34d4e1e7c8d8758aa2b81c805cda79.jpg', '', 0, 0, 0, 0, 2, 0, 0, 1539760080, 1539760080),
(7, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', '', '', 0, 0, 0, 0, 2, 0, 0, 1539760088, 1539760088),
(8, 6, '标题标题这里是标题', '312312312', '', '<p>1232132132<img src="http://yiguan2.com/uploads/images/20181017/1539759836196698.jpg" title="1539759836196698.jpg" alt="flash2.jpg"/></p>', '', '', 0, 0, 0, 1, 2, 0, 0, 1539760108, 1539760108),
(9, 0, '312321', '', '', '<p>123123<br/></p>', '', '', 0, 0, 0, 0, 2, 0, 0, 1539761577, 1539761577),
(10, 0, '312321', '', '', '<p>123123<br/></p>', '', '', 0, 0, 0, 0, 2, 0, 0, 1539761580, 1539761580),
(11, 0, '312321', '', '', '<p>123123<br/></p>', '', '', 123, 0, 0, 1, 1, 1, 1, 1539761585, 1539761585),
(12, 0, '12321', '213213', '', '<p>21321</p>', '', '', 0, 0, 0, 0, 2, 0, 0, 1539761614, 1539761614),
(13, 5, '123213', '321', '23213213哇塞', '<p>12321321撒旦</p>', 'http://yiguan2.com/uploads/adv/20181017/1d34d4e1e7c8d8758aa2b81c805cda79.jpg', '', 0, 0, 0, 1, 2, 0, 0, 1539761708, 1539762500),
(14, 3, '测试分页用额', '撒旦撒多', '23123', '<p>2132132132</p>', 'http://yiguan2.com/uploads/adv/20181017/6866e0ac16bbf1bd21f3b814973abcd5.gif', '', 0, 1, 0, 0, 2, 0, 0, 1539762522, 1539762522);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='������Ŀ��' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `yg_article_cate`
--

INSERT INTO `yg_article_cate` (`art_cate_id`, `cate_name`, `pid`, `sequence`, `add_time`, `edit_time`) VALUES
(1, '栏目分类1', 0, 100, 0, 0),
(2, '栏目分类2', 1, 4, 0, 0),
(3, '栏目分类3', 1, 1, 0, 0),
(5, '第三级', 2, 127, 0, 0),
(6, '分类栏目4', 1, 2, 0, 0),
(7, '测试添加栏目', 6, 0, 1539070096, 1539070096),
(8, '测试添加多级', 7, 2, 1539070118, 1539070118),
(9, '测试添加多级栏目', 0, 2, 1539070129, 1539070129),
(10, '测试添加多级', 8, 7, 1539070141, 1539071685),
(11, '得了得了测试成功了', 8, 2, 1539070200, 1539071719),
(12, '我要换上级', 9, 122, 1539070207, 1539071731),
(15, '有文章栏目删除', 0, 0, 1539075124, 1539078965);

-- --------------------------------------------------------

--
-- 表的结构 `yg_images_upload`
--

CREATE TABLE IF NOT EXISTS `yg_images_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `user_type` int(11) NOT NULL COMMENT '0 ��Ա�û� 1��̨',
  `user_id` int(11) NOT NULL COMMENT '�û�id',
  `url` text NOT NULL COMMENT 'ͼƬ·��',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ͼƬ�ϴ���¼' AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `yg_images_upload`
--

INSERT INTO `yg_images_upload` (`id`, `user_type`, `user_id`, `url`, `add_time`) VALUES
(5, 0, 0, 'http://yiguan2.com/uploads/menus/20181011/3e4fbf88725a6c8092f7e0ae7ee6ad08.gif', 1539250659),
(2, 1, 1, 'http://yiguan2.com/uploads/logo/20181011/0268bfc1e7d6ec58cbefb5b5b7ef1692.jpg', 1539250454),
(3, 1, 1, 'http://yiguan2.com/uploads/logo/20181011/3d564e87e3b68337eb0dac097658d74a.jpg', 1539250597),
(4, 0, 0, 'http://yiguan2.com/uploads/adv/20181011/538f17bf7cc0d66af10d33960260a808.jpg', 1539250632),
(6, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/2f119aefd98a5ef5f3826fdf175ae05c.gif', 1539569150),
(7, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/a9117a97d057c35f6bcd3fe39fc26c6e.gif', 1539569219),
(8, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/076d29ef48130a89fed41d389be4916f.gif', 1539569986),
(9, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/49ace19b22538eec30d23b5affbc1d23.gif', 1539570040),
(10, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/f69557e0306d7cbdb270ff8472182847.jpg', 1539570936),
(11, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/749c1a433ba7a633bfbdf2f587be27b2.jpg', 1539572248),
(12, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/a20ad7ebf87b3eb37d755f5272882baa.jpg', 1539572259),
(13, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/6ada557ccd39ee981af39c2c6f29bc8b.jpg', 1539573285),
(14, 0, 0, 'http://yiguan2.com/uploads/adv/20181015/5612f544a4ef0e9d7ae2e190a292ab31.jpg', 1539573322),
(15, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/61b71e550e96cafe1112198ef73471e4.jpg', 1539741892),
(16, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/d65a9d5566a9246b883762591dabf5b6.jpg', 1539741904),
(17, 1, 1, 'http://yiguan2.com/uploads/article/20181017/e969beabe794086b22ee8804bf0f48fa.jpg', 1539741908),
(18, 1, 1, 'http://yiguan2.com/uploads/article/20181017/6fac98ed2416f4a12ae6f257d3784f7f.jpg', 1539741930),
(19, 1, 1, 'http://yiguan2.com/uploads/article/20181017/d99e6938f6f4d07d153776a2b3d05036.jpg', 1539741971),
(20, 1, 1, 'http://yiguan2.com/uploads/article/20181017/56ce5309c3948094b042988d43e5a1e3.png', 1539741998),
(21, 1, 1, 'http://yiguan2.com/uploads/article/20181017/794c00185d974f1d25537922c5e1748d.jpg', 1539743027),
(22, 1, 1, 'http://yiguan2.com/uploads/article/20181017/5e64e8370a9a9c5e23407ba74669e2d8.jpg', 1539743089),
(23, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/253f281e2861b68d8d22cb44005a5b09.jpg', 1539758352),
(24, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/d42c8e46571f8350cee103809c7a0c23.jpg', 1539758369),
(25, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/4b3cb64914d26331cf742b0aa73709ba.jpg', 1539758400),
(26, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/e0c321b8ece1258884b99de2346f0bef.jpg', 1539761551),
(27, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/2aecc3aee77969a18e4a1eadb3915fb0.jpg', 1539761572),
(28, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/927986e8656b539a33e7d226cf68d8d9.jpg', 1539761609),
(29, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/1d34d4e1e7c8d8758aa2b81c805cda79.jpg', 1539761707),
(30, 0, 0, 'http://yiguan2.com/uploads/adv/20181017/6866e0ac16bbf1bd21f3b814973abcd5.gif', 1539762516);

-- --------------------------------------------------------

--
-- 表的结构 `yg_menus`
--

CREATE TABLE IF NOT EXISTS `yg_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�˵�����id',
  `menu_name` varchar(255) NOT NULL COMMENT '�˵���',
  `menus_type_id` int(11) NOT NULL,
  `menu_url` text NOT NULL COMMENT '��ת����',
  `menu_icon` text NOT NULL COMMENT '�˵�iconͼ',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '�����˵�id 0Ϊһ���˵�',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '���� �ɴ�С',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '�޸�ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='�����˵���' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `yg_menus`
--

INSERT INTO `yg_menus` (`id`, `menu_name`, `menus_type_id`, `menu_url`, `menu_icon`, `pid`, `sequence`, `add_time`, `edit_time`) VALUES
(1, 'asd', 1, '12312', '21321', 0, 0, 0, 0),
(2, '第二级', 1, '1321', '31231', 1, 0, 0, 0),
(3, '第三级', 1, '2131', '3123', 2, 0, 0, 0),
(4, '这个是其他类型的导航', 2, 'sdhaskj', '2312', 0, 0, 0, 0),
(5, '改成这个名字', 1, '和改成这个链接', '', 0, 5, 1539143052, 1539143956),
(6, '测试添加', 1, '123', '', 2, 2, 1539143089, 1539144897),
(7, '测试添加2', 2, '123', '', 4, 0, 1539143098, 1539143098),
(8, '添加在试试', 1, '', '', 2, 9, 1539143305, 1539143933),
(9, '测试icon', 1, '123', 'http://yiguan2.com/uploads/menus/20181011/3e4fbf88725a6c8092f7e0ae7ee6ad08.gif', 0, 0, 1539247574, 1539250660);

-- --------------------------------------------------------

--
-- 表的结构 `yg_menus_type`
--

CREATE TABLE IF NOT EXISTS `yg_menus_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `type_name` varchar(255) NOT NULL COMMENT '������',
  `desc` text NOT NULL COMMENT '����',
  `edit_time` int(10) DEFAULT '0',
  `sequence` tinyint(3) DEFAULT '0',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='�����˵�����' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yg_menus_type`
--

INSERT INTO `yg_menus_type` (`id`, `type_name`, `desc`, `edit_time`, `sequence`, `add_time`) VALUES
(1, '首页顶部菜单', '基础菜单', 0, 0, 0),
(2, '底部菜单', '底部菜单', 0, 0, 0),
(4, '这是一个测试导航类型', '这是一个测试导航类型', 1539153491, 0, 1539153491);

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
  `edit_time` int(10) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_key` (`site_key`),
  UNIQUE KEY `site_name` (`site_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ϵͳ���ñ�' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `yg_site_config`
--

INSERT INTO `yg_site_config` (`id`, `site_key`, `site_name`, `pid`, `site_value`, `site_type`, `last_value`, `edit_time`) VALUES
(1, 'web_config', '站点配置', 0, '', 0, '', 0),
(2, 'web_name', '网站名称', 1, '一贯科技', 0, '', 1539052823),
(3, 'web_url', '网站网址', 1, '12312', 0, '', 1539052840),
(4, 'web_email', '站点邮箱', 1, '1231', 0, '123', 1539070829),
(5, 'web_title', '网站标题', 1, '123', 0, '123', 0),
(6, 'web_seo_keywords', '关键词', 1, '123', 0, '123', 0),
(7, 'web_seo_description', '网站简介', 1, '123', 0, '123', 0),
(8, 'web_phone', '联系电话', 1, '1232', 0, '123', 0),
(9, 'web_mphone', '联系手机', 1, '123', 0, '123', 0),
(10, 'web_qq', 'QQ', 1, '123', 0, '123', 0),
(11, 'web_logo', '网站logo', 1, 'http://yiguan2.com/uploads/logo/20181011/3d564e87e3b68337eb0dac097658d74a.jpg', 1, 'http://yiguan2.com/uploads/logo/20181011/fc03a8ac53759d9fb5c052e61ddeaf19.jpg', 1539250599),
(12, 'company_address', '公司地址', 1, '123', 0, '', 0),
(13, 'web_copyright', '版权信息', 1, '1233', 0, '123', 1539070963),
(14, 'web_record', '备案信息', 1, '123', 0, '', 0),
(15, 'sys_config', '系统参数', 0, '', 0, '', 0);

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
(1, 'admin', '4b6ce2f7db3cf15316614c102bb69bc4', 'd8d784', 1, 1, '0', 0, 32, '127.0.0.1', 1539741596, ''),
(2, 'test', 'f38529929f52e0884d3cb67e30b27255', '', 6, 1, '127.0.0.1', 1538289203, 0, '', 0, ''),
(3, 'test1', 'c54830f20f2d0724762a25447caf5c93', '', 2, 1, '127.0.0.1', 1538289490, 0, '', 0, ''),
(4, 'test2', '0ea50878dca20dab933e53877718c526', '', 8, 1, '127.0.0.1', 1538289551, 0, '', 0, ''),
(5, 'admin1', '28cecbc63263d48c059418f6d436c154', 'acfeb8', 8, 1, '127.0.0.1', 1538289603, 8, '127.0.0.1', 1539225705, '');

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
(1, '超级管理员', 'home,home_show,site,site_config,site_config_create,site_config_update,site_config_update_all,menus,menus_create_view,menus_create,menus_update_view,menus_update,menus_sequence,menus_del,menus_type_create,article,article_cate,article_cate_create_view,article_cate_create,article_cate_update_view,article_cate_update,article_cate_sequence,article_cate_del,article_list,article_create_view,article_create,article_create_view,article_update,article_recomm,article_deleted,goods,goods_list,order,order_list,market,market_banner_pos,market_banner_post_create_view,market_banner_post_create,market_banner_post_update_view,market_banner_post_update,market_banner_post_del,market_adv_content,market_adv_content,market_adv_create_view,market_adv_create,market_adv_update_view,market_adv_update,market_adv_sequence,market_adv_del,template,template_pc,template_wap,sys_user,sys_user_list,sys_user_create_view,sys_user_create,sys_user_update_view,sys_user_update,sys_user_del,sys_user_group,sys_user_group_create_view,sys_user_group_create,sys_user_group_update_view,sys_user_group_update,sys_user_group_update,sys_user_group_default,log,sys_user_log', 2, 1537281475, 1539570998),
(2, '超级', 'home', 0, 1538203519, 1538203519),
(3, '测试账号', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,article,article_cate,article_cate_create,order,order_list,market,market_banner_pos,template,sys_user,sys_user_list_create,log,sys_user_log', 0, 1538205451, 1538205451),
(4, '测试组', 'home,home_show,site,site_config,site_config_create,site_config_update,menus,article,article_cate,article_cate_create,order,order_list,market,market_banner_pos,template,sys_user,sys_user_list_create,log,sys_user_log', 1, 1538205706, 1538215385),
(5, '测试添加', 'home', 1, 1538206152, 1538206152),
(6, '只有主页权限的权限组（修改过的）', 'home,home_show,goods,order,template', 1, 1538206246, 1538215567),
(7, '测试组1', 'home,home_show,log,sys_user_log', 1, 1538289342, 1538299283),
(8, '测试组2', 'home,site,site_config,site_config_create,site_config_update,menus,menus_create,menus_update,menus_del,article,article_cate,article_cate_create_view,article_cate_create,sys_user,sys_user_list,sys_user_create_view,sys_user_create,sys_user_update_view,sys_user_update,sys_user_del,sys_user_group,sys_user_group_create_view,sys_user_group_create,sys_user_group_update_view,sys_user_group_update,sys_user_group_update,sys_user_group_default,log,sys_user_log', 1, 1538289519, 1539225693);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����Ա������־' AUTO_INCREMENT=481 ;

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
(135, 5, 'signIn', '用户登陆', 1538298932, '127.0.0.1'),
(136, 1, 'update', '编辑权限组：1', 1538299283, '127.0.0.1'),
(137, 1, 'update', '编辑权限组：2', 1538299292, '127.0.0.1'),
(138, 5, 'signIn', '用户登陆', 1538299295, '127.0.0.1'),
(139, 5, 'signIn', '用户登陆', 1538299374, '127.0.0.1'),
(140, 1, 'update', '编辑权限组：2', 1538299396, '127.0.0.1'),
(141, 5, 'signIn', '用户登陆', 1538299402, '127.0.0.1'),
(142, 1, 'signIn', '用户登陆', 1538301402, '127.0.0.1'),
(143, 1, 'signIn', '用户登陆', 1538301421, '127.0.0.1'),
(144, 1, 'signIn', '用户登陆', 1538875274, '127.0.0.1'),
(145, 1, 'update', '编辑管理员id: 5 信息', 1538875287, '127.0.0.1'),
(146, 1, 'signIn', '用户登陆', 1538875290, '127.0.0.1'),
(147, 1, 'signIn', '用户登陆', 1538876459, '127.0.0.1'),
(148, 1, 'signIn', '用户登陆', 1538881959, '127.0.0.1'),
(149, 1, 'signIn', '用户登陆', 1538897366, '127.0.0.1'),
(150, 1, 'signIn', '用户登陆', 1538970569, '127.0.0.1'),
(151, 1, 'signIn', '用户登陆', 1539047710, '127.0.0.1'),
(152, 1, 'update', '编辑站点网站名称配置内容：一贯科技12321', 1539049713, '127.0.0.1'),
(153, 1, 'update', '编辑站点网站名称配置内容：一贯科技12321123', 1539050094, '127.0.0.1'),
(154, 1, 'update', '编辑站点网站名称配置内容：一贯科技32', 1539050097, '127.0.0.1'),
(155, 1, 'update', '编辑站点网站名称配置内容：一贯科技32123', 1539050581, '127.0.0.1'),
(156, 1, 'update', '编辑站点 网站名称 配置内容：一贯科技32123213', 1539050638, '127.0.0.1'),
(157, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技', 1539050678, '127.0.0.1'),
(158, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技', 1539051519, '127.0.0.1'),
(159, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051519, '127.0.0.1'),
(160, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051519, '127.0.0.1'),
(161, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051519, '127.0.0.1'),
(162, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051519, '127.0.0.1'),
(163, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051519, '127.0.0.1'),
(164, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051519, '127.0.0.1'),
(165, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051519, '127.0.0.1'),
(166, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051519, '127.0.0.1'),
(167, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051545, '127.0.0.1'),
(168, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051545, '127.0.0.1'),
(169, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051545, '127.0.0.1'),
(170, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051545, '127.0.0.1'),
(171, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051545, '127.0.0.1'),
(172, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051545, '127.0.0.1'),
(173, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051545, '127.0.0.1'),
(174, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051545, '127.0.0.1'),
(175, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051545, '127.0.0.1'),
(176, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051589, '127.0.0.1'),
(177, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051589, '127.0.0.1'),
(178, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051589, '127.0.0.1'),
(179, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051589, '127.0.0.1'),
(180, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051589, '127.0.0.1'),
(181, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051589, '127.0.0.1'),
(182, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051589, '127.0.0.1'),
(183, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051589, '127.0.0.1'),
(184, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051589, '127.0.0.1'),
(185, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051601, '127.0.0.1'),
(186, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051601, '127.0.0.1'),
(187, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051601, '127.0.0.1'),
(188, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051601, '127.0.0.1'),
(189, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051601, '127.0.0.1'),
(190, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051601, '127.0.0.1'),
(191, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051601, '127.0.0.1'),
(192, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051601, '127.0.0.1'),
(193, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051601, '127.0.0.1'),
(194, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051673, '127.0.0.1'),
(195, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051673, '127.0.0.1'),
(196, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051673, '127.0.0.1'),
(197, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051673, '127.0.0.1'),
(198, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051673, '127.0.0.1'),
(199, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051673, '127.0.0.1'),
(200, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051673, '127.0.0.1'),
(201, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051673, '127.0.0.1'),
(202, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051673, '127.0.0.1'),
(203, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051716, '127.0.0.1'),
(204, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051716, '127.0.0.1'),
(205, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051716, '127.0.0.1'),
(206, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051716, '127.0.0.1'),
(207, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051716, '127.0.0.1'),
(208, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051716, '127.0.0.1'),
(209, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051716, '127.0.0.1'),
(210, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051716, '127.0.0.1'),
(211, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051716, '127.0.0.1'),
(212, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1', 1539051727, '127.0.0.1'),
(213, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io', 1539051727, '127.0.0.1'),
(214, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1233', 1539051727, '127.0.0.1'),
(215, 1, 'update', '编辑站点 “网站标题” 配置内容：21321', 1539051727, '127.0.0.1'),
(216, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539051727, '127.0.0.1'),
(217, 1, 'update', '编辑站点 “网站简介” 配置内容：12312', 1539051727, '127.0.0.1'),
(218, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539051727, '127.0.0.1'),
(219, 1, 'update', '编辑站点 “联系手机” 配置内容：123123', 1539051727, '127.0.0.1'),
(220, 1, 'update', '编辑站点 “QQ” 配置内容：123123', 1539051727, '127.0.0.1'),
(221, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1312', 1539051769, '127.0.0.1'),
(222, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1312', 1539051781, '127.0.0.1'),
(223, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io1', 1539051781, '127.0.0.1'),
(224, 1, 'update', '编辑站点 “站点邮箱” 配置内容：12331', 1539051781, '127.0.0.1'),
(225, 1, 'update', '编辑站点 “网站标题” 配置内容：213211', 1539051781, '127.0.0.1'),
(226, 1, 'update', '编辑站点 “关键词” 配置内容：1231', 1539051781, '127.0.0.1'),
(227, 1, 'update', '编辑站点 “网站简介” 配置内容：123121', 1539051781, '127.0.0.1'),
(228, 1, 'update', '编辑站点 “联系电话” 配置内容：1231', 1539051781, '127.0.0.1'),
(229, 1, 'update', '编辑站点 “联系手机” 配置内容：1231231', 1539051781, '127.0.0.1'),
(230, 1, 'update', '编辑站点 “QQ” 配置内容：1231231', 1539051781, '127.0.0.1'),
(231, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1312321', 1539051792, '127.0.0.1'),
(232, 1, 'update', '编辑站点 “网站网址” 配置内容：23456io1', 1539051792, '127.0.0.1'),
(233, 1, 'update', '编辑站点 “站点邮箱” 配置内容：12331', 1539051792, '127.0.0.1'),
(234, 1, 'update', '编辑站点 “网站标题” 配置内容：213211', 1539051792, '127.0.0.1'),
(235, 1, 'update', '编辑站点 “关键词” 配置内容：1231', 1539051792, '127.0.0.1'),
(236, 1, 'update', '编辑站点 “网站简介” 配置内容：123121', 1539051792, '127.0.0.1'),
(237, 1, 'update', '编辑站点 “联系电话” 配置内容：1231', 1539051792, '127.0.0.1'),
(238, 1, 'update', '编辑站点 “联系手机” 配置内容：1231231', 1539051792, '127.0.0.1'),
(239, 1, 'update', '编辑站点 “QQ” 配置内容：1231231', 1539051792, '127.0.0.1'),
(240, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技1312321', 1539051799, '127.0.0.1'),
(241, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技', 1539052069, '127.0.0.1'),
(242, 1, 'update', '编辑站点 “网站网址” 配置内容：123', 1539052072, '127.0.0.1'),
(243, 1, 'update', '编辑站点 “站点邮箱” 配置内容：123', 1539052074, '127.0.0.1'),
(244, 1, 'update', '编辑站点 “网站标题” 配置内容：123', 1539052075, '127.0.0.1'),
(245, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539052077, '127.0.0.1'),
(246, 1, 'update', '编辑站点 “网站简介” 配置内容：123', 1539052079, '127.0.0.1'),
(247, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539052081, '127.0.0.1'),
(248, 1, 'update', '编辑站点 “联系手机” 配置内容：123', 1539052082, '127.0.0.1'),
(249, 1, 'update', '编辑站点 “QQ” 配置内容：123', 1539052084, '127.0.0.1'),
(250, 1, 'update', '编辑站点 “公司地址” 配置内容：123', 1539052085, '127.0.0.1'),
(251, 1, 'update', '编辑站点 “版权信息” 配置内容：123', 1539052087, '127.0.0.1'),
(252, 1, 'update', '编辑站点 “备案信息” 配置内容：123', 1539052089, '127.0.0.1'),
(253, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技', 1539052101, '127.0.0.1'),
(254, 1, 'update', '编辑站点 “网站网址” 配置内容：123', 1539052101, '127.0.0.1'),
(255, 1, 'update', '编辑站点 “站点邮箱” 配置内容：123', 1539052101, '127.0.0.1'),
(256, 1, 'update', '编辑站点 “网站标题” 配置内容：123', 1539052101, '127.0.0.1'),
(257, 1, 'update', '编辑站点 “关键词” 配置内容：123', 1539052101, '127.0.0.1'),
(258, 1, 'update', '编辑站点 “网站简介” 配置内容：123', 1539052101, '127.0.0.1'),
(259, 1, 'update', '编辑站点 “联系电话” 配置内容：123', 1539052101, '127.0.0.1'),
(260, 1, 'update', '编辑站点 “联系手机” 配置内容：123', 1539052101, '127.0.0.1'),
(261, 1, 'update', '编辑站点 “QQ” 配置内容：123', 1539052101, '127.0.0.1'),
(262, 1, 'update', '编辑站点 “联系电话” 配置内容：1232', 1539052218, '127.0.0.1'),
(263, 1, 'update', '编辑站点 “网站logo” 配置内容：12321321', 1539052613, '127.0.0.1'),
(264, 1, 'update', '编辑站点 “网站logo” 配置内容：12321321123', 1539052625, '127.0.0.1'),
(265, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技12', 1539052757, '127.0.0.1'),
(266, 1, 'update', '编辑站点 “网站名称” 配置内容：', 1539052796, '127.0.0.1'),
(267, 1, 'update', '编辑站点 “网站网址” 配置内容：', 1539052803, '127.0.0.1'),
(268, 1, 'update', '编辑站点 “网站名称” 配置内容：一贯科技', 1539052824, '127.0.0.1'),
(269, 1, 'update', '编辑站点 “网站网址” 配置内容：12312', 1539052840, '127.0.0.1'),
(270, 1, 'update', '修改“栏目分类2”文章栏目排序', 1539068319, '127.0.0.1'),
(271, 1, 'update', '修改“栏目分类3”文章栏目排序', 1539068348, '127.0.0.1'),
(272, 1, 'update', '修改“普通栏目”文章栏目排序', 1539068646, '127.0.0.1'),
(273, 1, 'update', '修改“栏目分类1”文章栏目排序', 1539068653, '127.0.0.1'),
(274, 1, 'insert', '添加文章栏目：测试添加栏目', 1539070096, '127.0.0.1'),
(275, 1, 'insert', '添加文章栏目：测试添加多级', 1539070118, '127.0.0.1'),
(276, 1, 'insert', '添加文章栏目：测试添加多级栏目', 1539070129, '127.0.0.1'),
(277, 1, 'insert', '添加文章栏目：测试添加多级栏目', 1539070141, '127.0.0.1'),
(278, 1, 'update', '修改“测试添加多级栏目”文章栏目排序', 1539070165, '127.0.0.1'),
(279, 1, 'insert', '添加文章栏目：多级栏目内的排序测试用', 1539070200, '127.0.0.1'),
(280, 1, 'insert', '添加文章栏目：多级栏目内的排序测试用2', 1539070207, '127.0.0.1'),
(281, 1, 'update', '修改“多级栏目内的排序测试用”文章栏目排序', 1539070211, '127.0.0.1'),
(282, 1, 'update', '修改“多级栏目内的排序测试用2”文章栏目排序', 1539070217, '127.0.0.1'),
(283, 1, 'update', '修改“第三级”文章栏目排序', 1539070797, '127.0.0.1'),
(284, 1, 'update', '修改“多级栏目内的排序测试用2”文章栏目排序', 1539070804, '127.0.0.1'),
(285, 1, 'update', '修改“测试添加多级栏目”文章栏目排序', 1539070810, '127.0.0.1'),
(286, 1, 'update', '编辑站点 “站点邮箱” 配置内容：1231', 1539070829, '127.0.0.1'),
(287, 1, 'update', '初始化超级管理员权限配置', 1539070871, '127.0.0.1'),
(288, 1, 'update', '初始化超级管理员权限配置', 1539070944, '127.0.0.1'),
(289, 1, 'update', '编辑站点 “版权信息” 配置内容：1233', 1539070963, '127.0.0.1'),
(290, 1, 'signIn', '用户登陆', 1539071175, '127.0.0.1'),
(291, 1, 'update', '修改“栏目分类3”文章栏目排序', 1539071202, '127.0.0.1'),
(292, 1, 'update', '编辑文章栏目：多级栏目内的排序测试用2', 1539071678, '127.0.0.1'),
(293, 1, 'update', '编辑文章栏目：测试添加多级', 1539071685, '127.0.0.1'),
(294, 1, 'update', '编辑文章栏目：多级栏目内的排序测试用', 1539071719, '127.0.0.1'),
(295, 1, 'update', '编辑文章栏目：多级栏目内的排序测试用2', 1539071731, '127.0.0.1'),
(296, 1, 'signIn', '用户登陆', 1539072056, '127.0.0.1'),
(297, 1, 'update', '编辑管理员id: 5 信息', 1539072136, '127.0.0.1'),
(298, 1, 'update', '编辑权限组：测试组2', 1539072150, '127.0.0.1'),
(299, 5, 'signIn', '用户登陆', 1539072170, '127.0.0.1'),
(300, 1, 'signIn', '用户登陆', 1539072207, '127.0.0.1'),
(301, 1, 'update', '编辑权限组：测试组2', 1539072218, '127.0.0.1'),
(302, 5, 'signIn', '用户登陆', 1539072230, '127.0.0.1'),
(303, 5, 'insert', '添加文章栏目：231', 1539072236, '127.0.0.1'),
(304, 1, 'signIn', '用户登陆', 1539072253, '127.0.0.1'),
(305, 1, 'update', '注销管理员账号：admin1', 1539072546, '127.0.0.1'),
(306, 1, 'insert', '添加文章栏目：用来测试删除的', 1539073748, '127.0.0.1'),
(307, 1, 'update', '初始化超级管理员权限配置', 1539073818, '127.0.0.1'),
(308, 1, 'signIn', '用户登陆', 1539073820, '127.0.0.1'),
(309, 1, 'del', '删除文章栏目：231', 1539074934, '127.0.0.1'),
(310, 1, 'insert', '添加文章栏目：有文章栏目删除', 1539075124, '127.0.0.1'),
(311, 1, 'del', '删除文章栏目：普通栏目', 1539075267, '127.0.0.1'),
(312, 1, 'insert', '添加文章栏目：123', 1539075307, '127.0.0.1'),
(313, 1, 'del', '删除文章栏目：123', 1539075311, '127.0.0.1'),
(314, 1, 'insert', '添加文章栏目：撒旦', 1539075346, '127.0.0.1'),
(315, 1, 'del', '删除文章栏目：撒旦', 1539075352, '127.0.0.1'),
(316, 1, 'insert', '添加文章栏目：熬上', 1539075373, '127.0.0.1'),
(317, 1, 'del', '删除文章栏目：熬上', 1539075376, '127.0.0.1'),
(318, 1, 'update', '修改“我要换上级”文章栏目排序', 1539078961, '127.0.0.1'),
(319, 1, 'update', '编辑文章栏目：有文章栏目删除', 1539078965, '127.0.0.1'),
(320, 1, 'insert', '添加文章栏目：3', 1539078970, '127.0.0.1'),
(321, 1, 'del', '删除文章栏目：3', 1539078973, '127.0.0.1'),
(322, 1, 'update', '修改“测试添加多级”文章栏目排序', 1539079013, '127.0.0.1'),
(323, 1, 'insert', '添加文章栏目：123', 1539079208, '127.0.0.1'),
(324, 1, 'update', '编辑文章栏目：123', 1539079212, '127.0.0.1'),
(325, 1, 'del', '删除文章栏目：1233', 1539079215, '127.0.0.1'),
(326, 1, 'signIn', '用户登陆', 1539079318, '127.0.0.1'),
(327, 1, 'signIn', '用户登陆', 1539134952, '127.0.0.1'),
(328, 1, 'insert', '添加导航菜单：21321321', 1539143052, '127.0.0.1'),
(329, 1, 'insert', '添加导航菜单：测试添加', 1539143089, '127.0.0.1'),
(330, 1, 'insert', '添加导航菜单：测试添加2', 1539143098, '127.0.0.1'),
(331, 1, 'insert', '添加导航菜单：添加在试试', 1539143305, '127.0.0.1'),
(332, 1, 'update', '编辑导航菜单：添加在试试', 1539143933, '127.0.0.1'),
(333, 1, 'update', '编辑导航菜单：21321321', 1539143957, '127.0.0.1'),
(334, 1, 'insert', '添加导航菜单：加你妹啊', 1539143975, '127.0.0.1'),
(335, 1, 'update', '编辑导航菜单：加你妹啊', 1539143986, '127.0.0.1'),
(336, 1, 'update', '初始化超级管理员权限配置', 1539144339, '127.0.0.1'),
(337, 1, 'signIn', '用户登陆', 1539144340, '127.0.0.1'),
(338, 1, 'update', '修改“我要换上级”文章栏目排序', 1539144345, '127.0.0.1'),
(339, 1, 'update', '修改“测试添加多级栏目”文章栏目排序', 1539144349, '127.0.0.1'),
(340, 1, 'update', '修改“改成这个名字”导航排序', 1539144885, '127.0.0.1'),
(341, 1, 'update', '编辑导航菜单：测试添加', 1539144897, '127.0.0.1'),
(342, 1, 'update', '修改“测试添加”导航排序', 1539144902, '127.0.0.1'),
(343, 1, 'update', '修改“添加在试试”导航排序', 1539144906, '127.0.0.1'),
(344, 1, 'insert', '添加导航菜单：我是用来删除测试用的', 1539145100, '127.0.0.1'),
(345, 1, 'del', '删除导航：我是用来删除测试用的', 1539145106, '127.0.0.1'),
(346, 1, 'insert', '添加导航菜单：用来删除的', 1539145136, '127.0.0.1'),
(347, 1, 'del', '删除导航：用来删除的', 1539145141, '127.0.0.1'),
(348, 1, 'signIn', '用户登陆', 1539145608, '127.0.0.1'),
(349, 1, 'insert', '添加导航菜单：用来删除啊', 1539145641, '127.0.0.1'),
(350, 1, 'del', '删除导航：用来删除啊', 1539145654, '127.0.0.1'),
(351, 1, 'insert', '添加导航类型：123', 1539153441, '127.0.0.1'),
(352, 1, 'insert', '添加导航类型：这是一个测试导航类型', 1539153491, '127.0.0.1'),
(353, 1, 'del', '删除导航：我改过父级了', 1539154387, '127.0.0.1'),
(354, 1, 'signIn', '用户登陆', 1539158491, '192.168.0.110'),
(355, 1, 'signIn', '用户登陆', 1539158718, '127.0.0.1'),
(356, 1, 'signIn', '用户登陆', 1539158780, '192.168.0.110'),
(357, 1, 'update', '初始化超级管理员权限配置', 1539159230, '127.0.0.1'),
(358, 1, 'signIn', '用户登陆', 1539159232, '127.0.0.1'),
(359, 1, 'insert', '添加广告位：测试添加位置', 1539161684, '127.0.0.1'),
(360, 1, 'insert', '添加广告位：测试添加位置', 1539162660, '127.0.0.1'),
(361, 1, 'insert', '编辑广告位：测试添加位置', 1539162812, '127.0.0.1'),
(362, 1, 'insert', '编辑广告位：测试添加位置', 1539162826, '127.0.0.1'),
(363, 1, 'insert', '编辑广告位：测试添加位置2', 1539162834, '127.0.0.1'),
(364, 1, 'update', '初始化超级管理员权限配置', 1539163494, '127.0.0.1'),
(365, 1, 'signIn', '用户登陆', 1539163503, '127.0.0.1'),
(366, 1, 'insert', '编辑广告位：测试添加位置23', 1539163508, '127.0.0.1'),
(367, 1, 'insert', '编辑广告位：测试添加位置23', 1539163512, '127.0.0.1'),
(368, 1, 'del', '删除广告位：测试添加位置2332', 1539163811, '127.0.0.1'),
(369, 1, 'del', '删除广告位：测试添加位置', 1539163844, '127.0.0.1'),
(370, 1, 'del', '删除广告位：首页轮播', 1539163860, '127.0.0.1'),
(371, 1, 'insert', '添加广告位：这里是测试广告位', 1539164496, '127.0.0.1'),
(372, 1, 'insert', '添加广告位：首页广告', 1539165598, '127.0.0.1'),
(373, 1, 'insert', '编辑广告位：首页广告', 1539166072, '127.0.0.1'),
(374, 1, 'signIn', '用户登陆', 1539223165, '127.0.0.1'),
(375, 1, 'signIn', '用户登陆', 1539224657, '127.0.0.1'),
(376, 1, 'update', '编辑管理员id: 5 信息', 1539225542, '127.0.0.1'),
(377, 1, 'update', '初始化超级管理员权限配置', 1539225638, '127.0.0.1'),
(378, 1, 'update', '初始化超级管理员权限配置', 1539225662, '127.0.0.1'),
(379, 1, 'signIn', '用户登陆', 1539225665, '127.0.0.1'),
(380, 1, 'update', '编辑权限组：测试组2', 1539225693, '127.0.0.1'),
(381, 5, 'signIn', '用户登陆', 1539225705, '127.0.0.1'),
(382, 1, 'signIn', '用户登陆', 1539225814, '127.0.0.1'),
(383, 1, 'insert', '添加广告位：测试图片天机', 1539243425, '127.0.0.1'),
(384, 1, 'insert', '添加广告位：测试图片添加', 1539243446, '127.0.0.1'),
(385, 1, 'insert', '添加广告位：天', 1539243635, '127.0.0.1'),
(386, 1, 'insert', '添加广告位：啊啊', 1539243739, '127.0.0.1'),
(387, 1, 'insert', '添加广告位：添加测试', 1539243784, '127.0.0.1'),
(388, 1, 'insert', '添加广告位：最后一次', 1539243855, '127.0.0.1'),
(389, 1, 'del', '删除广告位：最后一次', 1539244396, '127.0.0.1'),
(390, 1, 'insert', '添加广告位：最后一次啦啦', 1539244414, '127.0.0.1'),
(391, 1, 'insert', '编辑广告位：最后一次啦啦', 1539244551, '127.0.0.1'),
(392, 1, 'insert', '编辑广告位：最后一次啦啦', 1539244558, '127.0.0.1'),
(393, 1, 'insert', '编辑广告位：最后一次啦啦', 1539244567, '127.0.0.1'),
(394, 1, 'insert', '编辑广告位：最后一次啦啦', 1539244583, '127.0.0.1'),
(395, 1, 'insert', '添加广告位：首页轮播广告位', 1539244717, '127.0.0.1'),
(396, 1, 'insert', '编辑广告位：首页轮播广告位', 1539245912, '127.0.0.1'),
(397, 1, 'update', '编辑站点 “网站logo” 配置内容：http://yiguan2.com/uploads/logo/20181011/0e3243edb8a8e2d8860a2a61fa9cb3d5.jpg', 1539246899, '127.0.0.1'),
(398, 1, 'update', '编辑站点 “网站logo” 配置内容：http://yiguan2.com/uploads/logo/20181011/b712ec05ee2e2cf7bcf0a87907cc466b.jpg', 1539246914, '127.0.0.1'),
(399, 1, 'insert', '添加导航菜单：测试icon', 1539247574, '127.0.0.1'),
(400, 1, 'update', '编辑导航菜单：测试icon', 1539247721, '127.0.0.1'),
(401, 1, 'update', '编辑导航菜单：测试icon', 1539247761, '127.0.0.1'),
(402, 1, 'update', '编辑站点 “网站logo” 配置内容：http://yiguan2.com/uploads/logo/20181011/fc03a8ac53759d9fb5c052e61ddeaf19.jpg', 1539248976, '127.0.0.1'),
(403, 1, 'update', '编辑站点 “网站logo” 配置内容：http://yiguan2.com/uploads/logo/20181011/3d564e87e3b68337eb0dac097658d74a.jpg', 1539250599, '127.0.0.1'),
(404, 1, 'insert', '编辑广告位：首页轮播广告位', 1539250634, '127.0.0.1'),
(405, 1, 'update', '编辑导航菜单：测试icon', 1539250660, '127.0.0.1'),
(406, 1, 'signIn', '用户登陆', 1539253309, '127.0.0.1'),
(407, 1, 'signIn', '用户登陆', 1539309903, '127.0.0.1'),
(408, 1, 'signIn', '用户登陆', 1539312426, '127.0.0.1'),
(409, 1, 'update', '初始化超级管理员权限配置', 1539314918, '127.0.0.1'),
(410, 1, 'signIn', '用户登陆', 1539314920, '127.0.0.1'),
(411, 1, 'signIn', '用户登陆', 1539567808, '127.0.0.1'),
(412, 1, 'insert', '添加 首页轮播广告位 广告', 1539569942, '127.0.0.1'),
(413, 1, 'insert', '添加 首页轮播广告位 广告', 1539569988, '127.0.0.1'),
(414, 1, 'update', '初始化超级管理员权限配置', 1539570679, '127.0.0.1'),
(415, 1, 'signIn', '用户登陆', 1539570682, '127.0.0.1'),
(416, 1, 'insert', '添加 首页轮播广告位 广告', 1539570937, '127.0.0.1'),
(417, 1, 'signIn', '用户登陆', 1539570988, '127.0.0.1'),
(418, 1, 'update', '初始化超级管理员权限配置', 1539570998, '127.0.0.1'),
(419, 1, 'signIn', '用户登陆', 1539571000, '127.0.0.1'),
(420, 1, 'update', '编辑 首页轮播广告位 广告id:2', 1539572236, '127.0.0.1'),
(421, 1, 'update', '编辑 首页轮播广告位 广告id:2', 1539572249, '127.0.0.1'),
(422, 1, 'update', '编辑 首页轮播广告位 广告id:1', 1539572260, '127.0.0.1'),
(423, 1, 'insert', '添加 首页轮播广告位 广告', 1539573286, '127.0.0.1'),
(424, 1, 'del', '删除广告id：4', 1539573291, '127.0.0.1'),
(425, 1, 'insert', '添加 首页轮播广告位 广告', 1539573323, '127.0.0.1'),
(426, 1, 'del', '删除广告id：5', 1539573350, '127.0.0.1'),
(427, 1, 'update', '编辑 首页轮播广告位 广告id:2', 1539573506, '127.0.0.1'),
(428, 1, 'update', '编辑 首页轮播广告位 广告id:1', 1539573517, '127.0.0.1'),
(429, 1, 'update', '编辑 首页轮播广告位 广告id:3', 1539573531, '127.0.0.1'),
(430, 1, 'update', '编辑广告id： 1 排序 ', 1539573825, '127.0.0.1'),
(431, 1, 'update', '编辑 首页轮播广告位 广告id:1', 1539574536, '127.0.0.1'),
(432, 1, 'update', '编辑 首页轮播广告位 广告id:3', 1539574585, '127.0.0.1'),
(433, 1, 'update', '编辑广告id:1 排序 ', 1539574592, '127.0.0.1'),
(434, 1, 'update', '编辑广告id:2 排序 ', 1539574596, '127.0.0.1'),
(435, 1, 'update', '编辑广告id:3 排序 ', 1539574886, '127.0.0.1'),
(436, 1, 'insert', '添加广告位：测试', 1539577341, '127.0.0.1'),
(437, 1, 'insert', '添加广告位：恶趣味', 1539577352, '127.0.0.1'),
(438, 1, 'insert', '添加广告位：测试2', 1539585726, '127.0.0.1'),
(439, 1, 'insert', '编辑广告位：恶趣味', 1539586077, '127.0.0.1'),
(440, 1, 'signIn', '用户登陆', 1539655029, '127.0.0.1'),
(441, 1, 'signIn', '用户登陆', 1539741596, '127.0.0.1'),
(442, 1, 'insert', '添加文章：标题标题这里是标题', 1539759838, '127.0.0.1'),
(443, 1, 'insert', '添加文章：标题标题这里是标题', 1539759911, '127.0.0.1'),
(444, 1, 'insert', '添加文章：标题标题这里是标题', 1539760060, '127.0.0.1'),
(445, 1, 'insert', '添加文章：标题标题这里是标题', 1539760080, '127.0.0.1'),
(446, 1, 'insert', '添加文章：标题标题这里是标题', 1539760088, '127.0.0.1'),
(447, 1, 'insert', '添加文章：标题标题这里是标题', 1539760108, '127.0.0.1'),
(448, 1, 'insert', '添加文章：312321', 1539761577, '127.0.0.1'),
(449, 1, 'insert', '添加文章：312321', 1539761580, '127.0.0.1'),
(450, 1, 'insert', '添加文章：312321', 1539761585, '127.0.0.1'),
(451, 1, 'insert', '添加文章：12321', 1539761614, '127.0.0.1'),
(452, 1, 'insert', '添加文章：123213', 1539761708, '127.0.0.1'),
(453, 1, 'update', '编辑文章id：13', 1539762339, '127.0.0.1'),
(454, 1, 'update', '编辑文章id：13', 1539762354, '127.0.0.1'),
(455, 1, 'update', '编辑文章id：13', 1539762363, '127.0.0.1'),
(456, 1, 'update', '编辑文章id：13', 1539762380, '127.0.0.1'),
(457, 1, 'update', '编辑文章id：13', 1539762442, '127.0.0.1'),
(458, 1, 'update', '编辑文章id：13', 1539762448, '127.0.0.1'),
(459, 1, 'update', '编辑文章id：13', 1539762500, '127.0.0.1'),
(460, 1, 'insert', '添加文章：测试分页用额', 1539762523, '127.0.0.1'),
(461, 1, 'update', '修改文章id：1 排序', 1539763775, '127.0.0.1'),
(462, 1, 'update', '修改文章id：3 排序', 1539763779, '127.0.0.1'),
(463, 1, 'update', '修改文章id：11 排序', 1539763801, '127.0.0.1'),
(464, 1, 'update', '推荐文章：312321 文章id：11', 1539764894, '127.0.0.1'),
(465, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539764898, '127.0.0.1'),
(466, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539764900, '127.0.0.1'),
(467, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539765053, '127.0.0.1'),
(468, 1, 'update', '审核文章id：11', 1539765434, '127.0.0.1'),
(469, 1, 'update', '审核文章id：11', 1539765454, '127.0.0.1'),
(470, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539765683, '127.0.0.1'),
(471, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539765709, '127.0.0.1'),
(472, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539765729, '127.0.0.1'),
(473, 1, 'update', '设置文章id：3 不可读', 1539765735, '127.0.0.1'),
(474, 1, 'update', '设置文章id：11 可读', 1539765738, '127.0.0.1'),
(475, 1, 'update', '审核文章id：1', 1539766099, '127.0.0.1'),
(476, 1, 'update', '删除 文章id：11', 1539766150, '127.0.0.1'),
(477, 1, 'update', '恢复 文章id：11', 1539766212, '127.0.0.1'),
(478, 1, 'update', '删除 文章id：11', 1539766217, '127.0.0.1'),
(479, 1, 'update', '推荐文章：标题标题这里是标题 文章id：3', 1539766421, '127.0.0.1'),
(480, 1, 'update', '推荐文章：测试文章2 文章id：2', 1539766429, '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
