<?php
if(!defined('IN_ADMINCP')) exit('Access Denied');
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_wishing_hall`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall` (
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `days` int(5) NOT NULL DEFAULT '0',
  `lasted` int(5) NOT NULL DEFAULT '0',
  `mdays` int(5) NOT NULL DEFAULT '0',
  `reward` int(12) NOT NULL DEFAULT '0',
  `lastreward` int(12) NOT NULL DEFAULT '0',
  `qdxq` varchar(20) NOT NULL,
  `todaytimes` int(5) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `time` (`time`)
) ENGINE=MyISAM;
INSERT INTO `cdb_wishing_hall` (`uid`, `time`, `days`, `lasted`, `mdays`, `reward`) VALUES (1, 1, 0, 0, 0, 0);

DROP TABLE IF EXISTS `cdb_wishing_hall_fo`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_fo` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_ai`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_ai` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_kao`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_kao` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_shui`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_shui` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_offer`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_offer` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_miao`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_miao` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_bt`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_bt` (
  `uid` int(10) unsigned NOT NULL,
  `reward` int(12) NOT NULL DEFAULT '0',
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS `cdb_wishing_hall_wish`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_ai`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_ai` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_kao`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_kao` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_offer`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_offer` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_shui`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_shui` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_miao`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_miao` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hall_wish_bt`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hall_wish_bt` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `qdxq` varchar(20) NOT NULL,
  `todaysay` varchar(1000) NOT NULL,
  `godsay` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cdb_wishing_hallset`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hallset` (
  `id` int(10) unsigned NOT NULL,
  `todayq` int(10) NOT NULL DEFAULT '0',
  `yesterdayq` int(10) NOT NULL DEFAULT '0',
  `highestq` int(10) NOT NULL DEFAULT '0',
  `qdtidnumber` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_wishing_hallset` (id, todayq, yesterdayq, highestq, qdtidnumber) VALUES ('1', '0', '0', '0', '0'),('2', '0', '0', '0', '0'),('3', '0', '0', '0', '0'),('4', '0', '0', '0', '0'),('5', '0', '0', '0', '0'),('6', '0', '0', '0', '0'),('7', '0', '0', '0', '0');

DROP TABLE IF EXISTS `cdb_wishing_hallemot`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hallemot` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `god_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `qdxq` varchar(20) NOT NULL,
  `count` int(6) NOT NULL DEFAULT '0',
  `name` varchar(26) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_wishing_hallemot` (`id`, `displayorder`, `god_id`, `price`, `qdxq`, `name`) VALUES
(1, 1, 1, 0, 'kx', '$installlang[mb_qb1]'),
(2, 2, 1, 20, 'ng', '$installlang[mb_qb2]'),
(3, 3, 1, 40, 'ym', '$installlang[mb_qb3]'),
(4, 4, 1, 50, 'wl', '$installlang[mb_qb4]'),
(5, 5, 1, 60, 'nu', '$installlang[mb_qb5]'),
(6, 6, 1, 80, 'ch', '$installlang[mb_qb6]'),
(7, 7, 1, 200, 'yl', '$installlang[mb_qb8]'),
(8, 8, 1, 1000, 'shuai', '$installlang[mb_qb9]'),
(9, 9, 2, 0, 'kx_ai', '$installlang[mb_qb1]'),
(10, 10, 2, 20, 'ng_ai', '$installlang[mb_qb2]'),
(11, 11, 2, 40, 'ym_ai', '$installlang[mb_qb3]'),
(12, 12, 2, 50, 'wl_ai', '$installlang[mb_qb4]'),
(13, 13, 2, 60, 'nu_ai', '$installlang[mb_qb5]'),
(14, 14, 2, 80, 'ch_ai', '$installlang[mb_qb6]'),
(15, 15, 2, 200, 'yl_ai', '$installlang[mb_qb8]'),
(16, 16, 2, 1000, 'shuai_ai', '$installlang[mb_qb9]'),
(17, 17, 3, 0, 'kx_kao', '$installlang[mb_qb10]'),
(18, 18, 3, 20, 'ng_kao', '$installlang[mb_qb11]'),
(19, 19, 3, 40, 'ym_kao', '$installlang[mb_qb12]'),
(20, 20, 3, 50, 'wl_kao', '$installlang[mb_qb13]'),
(21, 21, 3, 60, 'nu_kao', '$installlang[mb_qb14]'),
(22, 22, 3, 80, 'ch_kao', '$installlang[mb_qb15]'),
(23, 23, 3, 200, 'yl_kao', '$installlang[mb_qb16]'),
(24, 24, 3, 1000, 'shuai_kao', '$installlang[mb_qb9]'),
(25, 25, 4, 0, 'kx_offer', '$installlang[mb_qb1]'),
(26, 26, 4, 20, 'ng_offer', '$installlang[mb_qb2]'),
(27, 27, 4, 40, 'ym_offer', '$installlang[mb_qb3]'),
(28, 28, 4, 50, 'wl_offer', '$installlang[mb_qb4]'),
(29, 29, 4, 60, 'nu_offer', '$installlang[mb_qb5]'),
(30, 30, 4, 80, 'ch_offer', '$installlang[mb_qb6]'),
(31, 31, 4, 200, 'yl_offer', '$installlang[mb_qb8]'),
(32, 32, 4, 1000, 'shuai_offer', '$installlang[mb_qb9]'),
(33, 33, 5, 0, 'kx_miao', '$installlang[mb_qb1]'),
(34, 34, 5, 20, 'ng_miao', '$installlang[mb_qb2]'),
(35, 35, 5, 40, 'ym_miao', '$installlang[mb_qb3]'),
(36, 36, 5, 50, 'wl_miao', '$installlang[mb_qb4]'),
(37, 37, 5, 60, 'nu_miao', '$installlang[mb_qb5]'),
(38, 38, 5, 80, 'ch_miao', '$installlang[mb_qb6]'),
(39, 39, 5, 200, 'yl_miao', '$installlang[mb_qb8]'),
(40, 40, 5, 1000, 'shuai_miao', '$installlang[mb_qb9]'),
(41, 41, 6, 0, 'kx_shui', '$installlang[mb_qb1]'),
(42, 42, 6, 20, 'ng_shui', '$installlang[mb_qb2]'),
(43, 43, 6, 40, 'ym_shui', '$installlang[mb_qb3]'),
(44, 44, 6, 50, 'wl_shui', '$installlang[mb_qb4]'),
(45, 45, 6, 60, 'nu_shui', '$installlang[mb_qb5]'),
(46, 46, 6, 80, 'ch_shui', '$installlang[mb_qb6]'),
(47, 47, 6, 200, 'yl_shui', '$installlang[mb_qb8]'),
(48, 48, 6, 1000, 'shuai_shui', '$installlang[mb_qb9]'),
(49, 49, 7, 0, 'kx_bt', '$installlang[mb_qb1]'),
(50, 50, 7, 20, 'ng_bt', '$installlang[mb_qb2]'),
(51, 51, 7, 40, 'ym_bt', '$installlang[mb_qb3]'),
(52, 52, 7, 50, 'wl_bt', '$installlang[mb_qb4]'),
(53, 53, 7, 60, 'nu_bt', '$installlang[mb_qb5]'),
(54, 54, 7, 80, 'ch_bt', '$installlang[mb_qb6]'),
(55, 55, 7, 200, 'yl_bt', '$installlang[mb_qb8]'),
(56, 56, 7, 1000, 'shuai_bt', '$installlang[mb_qb9]');
EOF;
runquery($sql);
$cacheechos = array();
$cacheechokeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='1' ORDER BY displayorder");
while($cacheecho = DB::fetch($queryc)) {
	$cacheechos[$cacheecho['qdxq']] = $cacheecho;
	$cacheechokeys[] = $cacheecho['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_fo', $cacheechos);

$cacheechosai = array();
$cacheechoaikeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='2' ORDER BY displayorder");
while($cacheechoai = DB::fetch($queryc)) {
	$cacheechosai[$cacheechoai['qdxq']] = $cacheechoai;
	$cacheechoaikeys[] = $cacheechoai['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_ai', $cacheechosai);

$cacheechoskao = array();
$cacheechokaokeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='3' ORDER BY displayorder");
while($cacheechokao = DB::fetch($queryc)) {
	$cacheechoskao[$cacheechokao['qdxq']] = $cacheechokao;
	$cacheechokaokeys[] = $cacheechokao['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_kao', $cacheechoskao);

$cacheechosshui = array();
$cacheechoshuikeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='6' ORDER BY displayorder");
while($cacheechoshui = DB::fetch($queryc)) {
	$cacheechosshui[$cacheechoshui['qdxq']] = $cacheechoshui;
	$cacheechoshuikeys[] = $cacheechoshui['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_shui', $cacheechosshui);

$cacheechosoffer = array();
$cacheechoofferkeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='4' ORDER BY displayorder");
while($cacheechooffer = DB::fetch($queryc)) {
	$cacheechosoffer[$cacheechooffer['qdxq']] = $cacheechooffer;
	$cacheechoofferkeys[] = $cacheechooffer['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_offer', $cacheechosoffer);

$cacheechosmiao = array();
$cacheechomiaokeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='5' ORDER BY displayorder");
while($cacheechomiao = DB::fetch($queryc)) {
	$cacheechosmiao[$cacheechomiao['qdxq']] = $cacheechomiao;
	$cacheechomiaokeys[] = $cacheechomiao['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_miao', $cacheechosmiao);

$cacheechosbt = array();
$cacheechobtkeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." WHERE god_id='7' ORDER BY displayorder");
while($cacheechobt = DB::fetch($queryc)) {
	$cacheechosbt[$cacheechobt['qdxq']] = $cacheechobt;
	$cacheechobtkeys[] = $cacheechobt['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_bt', $cacheechosbt);

$cacheechosall = array();
$cacheechoallkeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." ORDER BY displayorder");
while($cacheechoall = DB::fetch($queryc)) {
	$cacheechosall[$cacheechoall['qdxq']] = $cacheechoall;
	$cacheechoallkeys[] = $cacheechoall['qdxq'];

}
C::t('common_setting')->update('paulsign_emot_all', $cacheechosall);
updatecache('setting');
$finish = TRUE;
?>