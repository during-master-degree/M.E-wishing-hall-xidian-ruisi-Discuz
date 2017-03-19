<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsign')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('cdb_dsu_paulsign_wish')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsignset')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsignemot')."");
@unlink(DISCUZ_ROOT.'source/class/task/task_dsupaulsign.php');
$finish = TRUE;
?>