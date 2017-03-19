<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!$row = DB::fetch_first("SHOW COLUMNS FROM ".DB::table('wishing_hall')." LIKE 'lasted'")) {
	DB::query("ALTER TABLE ".DB::table('wishing_hall')." ADD lasted int(5) NOT NULL DEFAULT '0'");
}
$query3 = DB::query("SHOW TABLES LIKE '".DB::table('wishing_hallemot')."'");
if(DB::num_rows($query3) <= 0){
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_wishing_hallemot`;
CREATE TABLE IF NOT EXISTS `cdb_wishing_hallemot` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `qdxq` varchar(5) NOT NULL,
  `count` int(6) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_wishing_hallemot` (`id`, `displayorder`, `qdxq`, `count`, `name`) VALUES
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
(24, 24, 3, 1000, 'shuai_kao', '$installlang[mb_qb9]');
EOF;
runquery($sql);
}
$cacheechos = array();
$cacheechokeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." ORDER BY displayorder");
while($cacheecho = DB::fetch($queryc)) {
	$cacheechos[$cacheecho['qdxq']] = $cacheecho;
	$cacheechokeys[] = $cacheecho['qdxq'];

}
C::t('common_setting')->update('paulsign_emot', $cacheechos);
updatecache('setting');
$finish = TRUE;
?>