<?php
/**
 *  插件的安装文件, 默认名字为 install.php , 安装新插件的时候会自动执行 
 *  或者是可以通过修改 XML 文件来实现
 **/

/** 防止非法引用 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/** 注意这里的数据库表前缀是 cdb_ , 系统会自动替换成当前的数据库前缀 */
$sql = <<<EOF

DROP TABLE IF EXISTS cdb_sample;
CREATE TABLE cdb_sample (
  `uid` mediumint(8) unsigned NOT NULL,
  `username` varchar(15) NOT NULL DEFAULT '',
  `logindata` varchar(255) NOT NULL DEFAULT '',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `lastswitch` int(10) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`,`username`),
  KEY `username` (`username`)
) TYPE=MyISAM;

EOF;

/** 实现 SQL ddl 语句 */
runquery($sql);

/** 注意这里, 必须把 $finish 设为 TRUE , 提示系统说安装已经结束, 否则会出现白屏!! */
$finish = TRUE;

