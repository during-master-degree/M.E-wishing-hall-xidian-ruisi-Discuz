<?php
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
$query = DB::query("SELECT uid FROM ".DB::table('wishing_hall'));
$mrcs = array();
while($mrc = DB::fetch($query)) {
	$mrc['exist']= DB::fetch_first("SELECT uid FROM ".DB::table('common_member_count')." WHERE uid='$mrc[uid]'");
	if(!$mrc['exist']) DB::delete('wishing_hall',"uid = '$mrc[uid]'");
	$mrcs[] = $mrc;
}
cpmsg("Data has been Cleaned!", '', 'succeed');
?>