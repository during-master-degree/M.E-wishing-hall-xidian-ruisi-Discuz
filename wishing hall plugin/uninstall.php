<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_fo')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_ai')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_kao')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_wish')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_wish_ai')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hall_wish_kao')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hallset')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('wishing_hallemot')."");
@unlink(DISCUZ_ROOT.'source/class/task/task_dsupaulsign.php');
$finish = TRUE;
?>