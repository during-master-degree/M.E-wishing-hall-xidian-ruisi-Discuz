<?php
/*
	wishing_hall By bikai[RS] 2013-03-10
*/
/*
注释用到6
完整删除的变量：
plopen
qddesc
ftopen
tzgroupid
mintdpost
rewardlistopen
xxkxsz
plgroups
ajax_sign
autosign_ug
lastedop
*/

!defined('IN_DISCUZ') && exit('Access Denied');
define('IN_wishing_hall', '1');
define("NOROBOT", TRUE);
$navtitle = "爱神-许愿堂";
$var = $_G['cache']['plugin']['wishing_hall'];
$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
loadcache('pluginlanguage_script');
$lang = $_G['cache']['pluginlanguage_script']['wishing_hall'];
$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['lvtext']);
$nfastreplytext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['fastreplytext_ai']);
$njlmain =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['jlmain']);
list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
$fastreplytexts = explode("/hhf/", $nfastreplytext);
$_G['setting']['switchwidthauto']=0;//关闭宽窄屏切换
$extreward = explode("/hhf/", $njlmain);
$extreward_num = count($extreward);
//$jlxgroups = unserialize($var['jlxgroups']);
$groups = unserialize($var['groups']);

//$plgroups = unserialize($var['plgroups']);
//$plgroups2 = unserialize($var['plgroups']);
//$plgroups = dimplode($plgroups);

//$credit = mt_rand($var['mincredit'],$var['maxcredit']);
$read_ban = explode(",",$var['ban']);
$post = DB::fetch_first("SELECT posts FROM ".DB::table('common_member_count')." WHERE uid='$_G[uid]'");
$qiandaodb = DB::fetch_first("SELECT * FROM ".DB::table('wishing_hall')." WHERE uid='$_G[uid]'");
$qiandaodb_in_ai = DB::fetch_first("SELECT * FROM ".DB::table('wishing_hall_ai')." WHERE uid='$_G[uid]'");
$stats = DB::fetch_first("SELECT * FROM ".DB::table('wishing_hallset')." WHERE id='2'");
$qddb = DB::fetch_first("SELECT time FROM ".DB::table('wishing_hall')." ORDER BY time DESC limit 0,1");
$lastmonth=dgmdate($qddb['time'], 'm',$var['tos']);
$nowmonth=dgmdate($_G['timestamp'], 'm',$var['tos']);
$emots = unserialize($_G['setting']['paulsign_emot_ai']);
if($nowmonth!=$lastmonth){
	DB::query("UPDATE ".DB::table('wishing_hall')." SET mdays=0 WHERE uid");
}
function sign_msg($msg, $treferer = '') {
	global $_G;
	if(defined('IN_MOBILE')) {
		include template('wishing_hall:float');
		dexit();
	}else{
		include template('wishing_hall:float');
		dexit();
	}
}
if(empty($_G['uid'])) showmessage('to_login', 'member.php?mod=logging&action=login', array(), array('showmsg' => true, 'login' => 1));
if(!$var['ifopen'] && $_G['adminid'] != 1) showmessage($var['plug_clsmsg'], 'index.php');
/*************4 S******************
if($var['plopen'] && $plgroups) {
	$query = DB::query("SELECT groupid, grouptitle FROM ".DB::table('common_usergroup')." WHERE groupid IN ($plgroups)");
	$mccs = array();
	while($mcc = DB::fetch($query)){
		$mccs[] = $mcc;
	}
}
*************4 E******************/
if($_GET['operation'] == '') {	
/*************7 S first vister & master & rank*****/	
$firstvister = DB::fetch_first("SELECT m.username,q.todaysay,q.godsay FROM ".DB::table('wishing_hall_wish_ai')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and time >= {$tdtime} ORDER BY q.time");
	if($firstvister){
		$firstvister="<li><span class='xi2 xg1'>".$firstvister['username']."</li><li style=' text-align:left;'><span style='color:#F00;'>心愿：</span>".$firstvister['todaysay']."</li><li style=' text-align:left;'><span style='color:#F00;'>爱神说：</span>".$firstvister['godsay']."</li>";	
	}else{
	 	$firstvister="<li><span class='xi2 xg1'>今天还没有人许愿</li>";	
	}	

$goodpeople = DB::fetch_first("SELECT m.username,q.todaysay,q.godsay FROM ".DB::table('wishing_hall_wish_ai')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and qdxq = 'shuai_ai' ORDER BY q.time desc");
	if($goodpeople){
		$goodpeople="<li><span class='xi2 xg1'>".$goodpeople['username']."</li><li style=' text-align:left;'><span style='color:#F00;'>心愿：</span>".$goodpeople['todaysay']."</li><li style=' text-align:left;'><span style='color:#F00;'>爱神说：</span>".$goodpeople['godsay']."</li>";	
	}else{
	 	$goodpeople="<li><span class='xi2 xg1'>本庙久经风雨，几近坍塌。</li>";	
	}
		
$master=DB::fetch_first("SELECT m.username,q.todaysay,q.godsay FROM ".DB::table('wishing_hall_ai')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid ORDER BY reward desc");	
	if($master){
		$master="<li><span class='xi2 xg1'>".$master['username']."</li><li style=' text-align:left;'><span style='color:#F00;'>心愿：</span>".$master['todaysay']."</li><li style=' text-align:left;'><span style='color:#F00;'>爱神说：</span>".$master['godsay']."</li>";	
	}else{
	 	$master="<li><span class='xi2 xg1'>本庙暂无堂主</li>";	
	}
	
$sql_rank="SELECT m.username,q.reward,q.uid FROM ".DB::table('wishing_hall_ai')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid ORDER BY reward desc LIMIT 0,8";	
$query = DB::query($sql_rank);
	$rank = array();
	while($rank = DB::fetch($query)) {
		
	$ranks[] = $rank;
	}	
/*************7 E first vister & master & rank*****/
/**********6 S***********
	if($_GET['operation'] == 'month'){
		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall_wish')." WHERE time >= {$tdtime}");
		$page = max(1, intval($_GET['page']));
		$start_limit = ($page - 1) * 10;
		$multipage = multi($num, 10, $page, "plugin.php?id=wishing_hall:sign&operation={$_GET[operation]}");
	} elseif($_GET['operation'] == 'zdyhz' || $_GET['operation'] == 'rewardlist'){
	} 

	elseif($_GET['operation'] == '' && $var['qddesc']){
		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall')." WHERE time >= {$tdtime}");
		$page = max(1, intval($_GET['page']));
		$start_limit = ($page - 1) * 10;
		$multipage = multi($num, 10, $page, "plugin.php?id=wishing_hall:sign&operation={$_GET[operation]}");
	} 

	else {
***********6 E*********/		
//		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall_ai')."");
//		$page = max(1, intval($_GET['page']));
//		$start_limit = ($page - 1) * 10;
//		$multipage = multi($num, 10, $page, "plugin.php?id=wishing_hall:ai&operation={$_GET[operation]}");
//	}
/*****5 S*******
	if($_GET['operation'] == 'zong'){
		$sql = "SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid ORDER BY q.days desc LIMIT $start_limit, 10";
	} elseif ($_GET['operation'] == 'month') {
		$sql = "SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND q.mdays != 0 ORDER BY q.mdays desc LIMIT $start_limit, 10";
	} elseif($_GET['operation'] == 'zdyhz'){
		if(in_array($_GET['qdgroupid'], $plgroups2)) {
			$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN($_GET[qdgroupid])");
			$page = max(1, intval($_GET['page']));
			$start_limit = ($page - 1) * 10;
			$multipage = multi($num, 10, $page, "plugin.php?id=wishing_hall:sign&operation={$_GET[operation]}", 0);
			$sql = "SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN($_GET[qdgroupid]) ORDER BY q.time desc LIMIT $start_limit, 10";
		} else {
			$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN($plgroups)");
			$page = max(1, intval($_GET['page']));
			$start_limit = ($page - 1) * 10;
			$multipage = multi($num, 10, $page, "plugin.php?id=wishing_hall:sign&operation={$_GET[operation]}", 0);
			$sql = "SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN($plgroups) ORDER BY q.time desc LIMIT $start_limit, 10";
		}
	} elseif ($var['rewardlistopen'] && $_GET['operation'] == 'rewardlist') {
		$sql = "SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,q.reward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid ORDER BY q.reward desc LIMIT 0, 10";
	} elseif ($_GET['operation'] == '') {

		if($var['qddesc']) {
			$sql = "SELECT q.time,q.qdxq,q.uid,q.todaysay,q.godsay,m.username FROM ".DB::table('wishing_hall_wish')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and q.time >= {$tdtime} ORDER BY q.time LIMIT $start_limit, 10";
		} else {
*/			
			$sql = "SELECT q.time,q.qdxq,q.uid,q.todaysay,q.godsay,m.username FROM ".DB::table('wishing_hall_wish_ai')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid ORDER BY q.time desc LIMIT 0, 10";
/*		}

	}
*******5 E******/
	$query = DB::query($sql);
	$mrcs = array();
	$xy_id_num=1;
	$has_items=0;
	while($mrc = DB::fetch($query)) {
		$mrc['if']= $mrc['time']<$tdtime ? "<span class=gray>".$lang['tdno']."</span>" : "<font color=green>".$lang['tdyq']."</font>";
		$mrc['time'] = dgmdate($mrc['time'], 'Y-m-d H:i');
		$mrc['xy_id']="xy_id".$xy_id_num;
		$mrc['god_id']="god_id".$xy_id_num;
		$xy_id_num++;
		!$qd['qdxq'] && $qd['qdxq']=end(array_keys($emots));
		
		if($mrc['qdxq']=="kx_ai"){$mrc['qdxq']="虔诚的想要听取神的教诲，并说";
		}elseif($mrc['qdxq']=="ng_ai"){$mrc['qdxq']="给神磕了个大大的响头，并说";
		}elseif($mrc['qdxq']=="ym_ai"){$mrc['qdxq']="给神上了一炷香，并说";
		}elseif($mrc['qdxq']=="wl_ai"){$mrc['qdxq']="给神献上鲜花，并说";
		}elseif($mrc['qdxq']=="nu_ai"){$mrc['qdxq']="给神敬上一个摩提，并说";
		}elseif($mrc['qdxq']=="ch_ai"){$mrc['qdxq']="给神敬上一杯酒，并说";
		}elseif($mrc['qdxq']=="yl_ai"){$mrc['qdxq']="给神献上巧克力，并说";
		}elseif($mrc['qdxq']=="shuai_ai"){$mrc['qdxq']="要给爱神修庙建祠堂，并说";
		}
		$mrcs[] = $mrc;
		$has_items=1;
	}
	for($j=$xy_id_num;$j<=10;$j++){/*1*/
		$mrc['xy_id']="xy_id".$j;			
		$mrc['god_id']="god_id".$j;
		$mrcs[] = $mrc;
	}
	$emotquery = DB::query("SELECT count,name FROM ".DB::table('wishing_hallemot')." WHERE god_id='2' ORDER BY count desc LIMIT 0, 5");
	$emottops = array();
	while($emottop = DB::fetch($emotquery)) {
		$emottops[] = $emottop;
	}
} elseif($_GET['operation'] == 'ban') {
	if($_GET['formhash'] != FORMHASH) {
		showmessage('undefined_action', NULL);
	}
	if($_G['adminid'] == 1) {
		DB::query("UPDATE ".DB::table('wishing_hall_wish_ai')." SET todaysay='{$lang['ban_01']}' WHERE uid='".intval($_GET['banuid'])."'");
		DB::query("UPDATE ".DB::table('wishing_hall_ai')." SET todaysay='{$lang['ban_01']}' WHERE uid='".intval($_GET['banuid'])."'");
		showmessage("{$lang['ban_02']}", dreferer());
	} else {
		showmessage("{$lang['ban_03']}", dreferer());
	}
} elseif($_GET['operation'] == 'qiandao') {
	if($_GET['formhash'] != FORMHASH) {
		showmessage('undefined_action', NULL);
	}

	if($var['timeopen']) {
		if ($htime < $var['stime']) {
			sign_msg("{$lang['ts_timeearly1']}{$var[stime]}{$lang['ts_timeearly2']}");
		} elseif ($htime > $var['ftime']) {
			sign_msg($lang['ts_timeov']);
		}
	}
	if(!in_array($_G['groupid'], $groups)) sign_msg($lang['ts_notallow']);
/*************3 S******************/
//	if($var['mintdpost'] > $post['posts']) sign_msg("{$lang['ts_minpost1']}{$var[mintdpost]}{$lang['ts_minpost2']}");
//	if($qiandaodb['time']>$tdtime) sign_msg($lang['ts_yq']);
/*************3 E******************/	
	
	if(in_array($_G['uid'],$read_ban)) sign_msg($lang['ts_black']);	
	if(!array_key_exists($_GET['qdxq'],$emots)) sign_msg($lang['ts_xqnr']);
	if(!$var['sayclose']){
		if($_GET['qdmode']=='1'){
			$todaysay= dhtmlspecialchars($_GET['todaysay']);
			if($todaysay=='') sign_msg($lang['ts_nots']);
			if(strlen($todaysay) > 990) sign_msg($lang['ts_ovts']);
			if(strlen($todaysay) < 10) sign_msg($lang['ts_syts']);
			if (!preg_match("/[^A-Za-z0-9.,]/",$todaysay)) sign_msg($lang['ts_saywater']);
			$illegaltest = censormod($todaysay);
			if($illegaltest) {
				sign_msg($lang['ts_illegaltext']);
			}
		} elseif ($_GET['qdmode']=='2') {
			$todaysay = $fastreplytexts[$_GET['fastreply']];
		} elseif($_GET['qdmode']=='3') {
			$todaysay = "{$lang['wttodaysay']}";
		}
	}else{
		$todaysay = "{$lang['wttodaysay']}";
	}
	if($var['lockopen']){
		while(discuz_process::islocked('wishing_hall_ai', 5)){
			usleep(100000);
		}
	}
/*	if(in_array($_G['groupid'], $jlxgroups) && $var['jlx'] !== '0') {
		$credit = $credit * $var['jlx'];
	}
	
	if(($tdtime - $qiandaodb['time']) < 86400 && $var['lastedop'] && $qiandaodb['lasted'] !== '0'){
		$randlastednum = mt_rand($var['lastednuml'],$var['lastednumh']);
		$randlastednum = sprintf("%03d", $randlastednum);
		$randlastednum = '0.'.$randlastednum;
		$randlastednum = $randlastednum * $qiandaodb['lasted'];
		$credit = round($credit*(1+$randlastednum));
	}
*/
		$num1= DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall')." WHERE time >= {$tdtime}");
	if(!$num1){
		DB::query("UPDATE ".DB::table('wishing_hall')." SET todaytimes=0");//今天先将所有用户许愿次数清零
	}
	$num_items=DB::result_first("SELECT todaytimes FROM ".DB::table('wishing_hall')." WHERE uid='$_G[uid]'");
	if($num_items>=$var['wishingnum']){sign_msg("每天只允许许愿".$var['wishingnum']."次哦，明天再来吧");}
		
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('wishing_hall_wish_ai')." WHERE time >= {$tdtime}");
	if(!$qiandaodb['uid']) {
		DB::query("INSERT INTO ".DB::table('wishing_hall')." (uid,time) VALUES ('$_G[uid]',$_G[timestamp])");
		DB::query("INSERT INTO ".DB::table('wishing_hall_ai')." (uid,reward) VALUES ('$_G[uid]','0')");
	}elseif(!$qiandaodb_in_ai['uid']){
		DB::query("INSERT INTO ".DB::table('wishing_hall_ai')." (uid,reward) VALUES ('$_G[uid]','0')");
		}
/************1 S*******************	
		if($_GET[qdxq]=='kx'){
		$credit=0;
	}else if($_GET[qdxq]=='ng'){
		$credit=20;
	}else if($_GET[qdxq]=='ym'){
		$credit=40;
	}else if($_GET[qdxq]=='wl'){
		$credit=50;
	}else if($_GET[qdxq]=='nu'){
		$credit=60;
	}else if($_GET[qdxq]=='ch'){
		$credit=70;
	}else if($_GET[qdxq]=='fd'){
		$credit=200;
	}else if($_GET[qdxq]=='yl'){
		$credit=800;
	}else if($_GET[qdxq]=='shuai'){
		$credit=1000;
	}
*********************************/	
	$credit=DB::result_first("SELECT price FROM ".DB::table('wishing_hallemot')." WHERE qdxq='$_GET[qdxq]' and god_id=2");
	$jinbi=getuserprofile('extcredits5');	
	if($jinbi<$credit){
		sign_msg($lang['ts_yq']);
	}
/*************1 E******************/	
$godword=mt_rand(0,count($fastreplytexts)-1);
/*************************
	if(($tdtime - $qiandaodb['time']) < 86400 && $var['lastedop']){
		DB::query("UPDATE ".DB::table('wishing_hall')." SET days=days+1,mdays=mdays+1,time='$_G[timestamp]',qdxq='$_GET[qdxq]',todaysay='$todaysay',reward=reward+{$credit},lastreward='$credit',lasted=lasted+1 WHERE uid='$_G[uid]'");
	} else {
*************************/
	$random_rewards=ceil(($credit/200)*mt_rand(0,100)/100+mt_rand(0,100)/100);
	updatemembercount($_G['uid'], array( "extcredits8"=> $random_rewards));
			
		DB::query("UPDATE ".DB::table('wishing_hall')." SET days=days+1,mdays=mdays+1,time='$_G[timestamp]',qdxq='$_GET[qdxq]',todaysay='$todaysay',godsay='$fastreplytexts[$godword]',chip_up=chip_up+{$credit},character_award=character_award+{$random_rewards},lastreward='$credit',lasted='1' WHERE uid='$_G[uid]'");
DB::query("UPDATE ".DB::table('wishing_hall_ai')." SET todaysay='$todaysay',godsay='$fastreplytexts[$godword]',reward=reward+{$credit} WHERE uid='$_G[uid]'");		
//	}
/*************2 S******************/
DB::query("INSERT INTO ".DB::table('wishing_hall_wish_ai')." (uid,time,qdxq,todaysay,godsay) VALUES ('$_G[uid]',$_G[timestamp],'$_GET[qdxq]','$todaysay','$fastreplytexts[$godword]')");
	$credit_munt=-$credit;
	updatemembercount($_G['uid'], array("extcredits5" => $credit_munt));


/*************2 E******************/	
	
	$another_vip = '';
	if(@include_once DISCUZ_ROOT.'./source/plugin/dsu_kkvip/extend/sign.api.php'){
		$rewarddays = intval($rewarddays);
		$growupnum = intval($growupnum);
		if($rewarddays || $growupnum) $another_vip=lang('plugin/wishing_hall', 'another_vip', array('rewarddays' => $rewarddays, 'growupnum' => $growupnum));
	}
	require_once libfile('function/post');
	require_once libfile('function/forum');
	if($var['sync_say'] && $_GET['qdmode'] =='1') {
		$setarr = array(
			'uid' => $_G['uid'],
			'username' => $_G['username'],
			'dateline' => $_G['timestamp'],
			'message' => $todaysay.$lang['fromsign'],
			'ip' => $_G['clientip'],
			'status' => 0,
		);
		$doid = DB::insert('home_doing', $setarr, 1);
		$setarr2 = array(
			'appid' => '',
			'icon' => 'doing',
			'uid' => $_G['uid'],
			'username' => $_G['username'],
			'dateline' => $_G['timestamp'],
			'title_template' => lang('feed', 'feed_doing_title'),
			'title_data' => daddslashes(serialize(dstripslashes(array('message'=>$todaysay.$lang['fromsign'])))),
			'body_template' => '',
			'body_data' => '',
			'id' => $doid,
			'idtype' => 'doid'
		);
		DB::insert('home_feed', $setarr2, 1);
	}
	if($var['sync_follow'] && $_GET['qdmode']=='1' && $_G['setting']['followforumid']) {
		$tofid = $_G['setting']['followforumid'];
		DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, displayorder, digest, special, attachment, moderated, highlight, closed, status, isgroup) VALUES ('$tofid', '0', '0', '0', '0', '0', '$_G[username]', '$_G[uid]', '$todaysay', '$_G[timestamp]', '$_G[timestamp]', '$_G[username]', '0', '0', '0', '0', '1', '1', '1', '512', '0')");
		$synctid = DB::insert_id();
		$syncpid = insertpost(array('fid' => $tofid,'tid' => $synctid,'first' => '1','author' => $_G['username'],'authorid' => $_G['uid'],'subject' => $todaysay,'dateline' => $_G['timestamp'],'message' => $todaysay,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
		updatepostcredits('+', $_G['uid'], 'post', $_G['setting']['followforumid']);
		$synclastpost = "$tid\t".addslashes($todaysay)."\t$_G[timestamp]\t$_G[username]";
		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$synclastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='$_G[setting][followforumid]'", 'UNBUFFERED');
		$feedcontent = array(
			'tid' => $synctid,
			'content' => $todaysay,
		);
		C::t('forum_threadpreview')->insert($feedcontent);
		$followfeed = array(
			'uid' => $_G['uid'],
			'username' => $_G['username'],
			'tid' => $synctid,
			'note' => '',
			'dateline' => TIMESTAMP
		);
		C::t('home_follow_feed')->insert($followfeed, true);
		C::t('common_member_count')->increase($_G['uid'], array('feeds'=>1));
	}
	if($var['sync_sign'] && $_G['group']['maxsigsize']) {
		$signhtml = cutstr(strip_tags($todaysay.$lang['fromsign']), $_G['group']['maxsigsize']);
		DB::update('common_member_field_forum', array('sightml'=>$signhtml), "uid='$_G[uid]'");
	}
	if($num <= ($extreward_num - 1) ) {
		list($exacr,$exacz) = explode("|", $extreward[$num]);
		$psc = $num+1;
		if($exacr && $exacz) updatemembercount($_G['uid'], array($exacr => $exacz));
	}
		if($var['qdtype'] == '2') {
			$thread = DB::fetch_first("SELECT * FROM ".DB::table('forum_thread')." WHERE tid='$var[tidnumber]'");
			$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
			if($num >=0 && ($num <= ($extreward_num - 1)) && $exacr && $exacz) {
				$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$psc}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			} else {
				$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_09]}{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}.{$another_vip}[/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			}
			$pid = insertpost(array('fid' => $thread['fid'],'tid' => $var['tidnumber'],'first' => '0','author' => $_G['username'],'authorid' => $_G['uid'],'subject' => '','dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
			DB::query("UPDATE ".DB::table('forum_thread')." SET lastposter='$_G[username]', lastpost='$_G[timestamp]', replies=replies+1 WHERE tid='$var[tidnumber]' AND fid='$thread[fid]'", 'UNBUFFERED');
			updatepostcredits('+', $_G['uid'], 'reply', $thread['fid']);
			$lastpost = "$thread[tid]\t".addslashes($thread['subject'])."\t$_G[timestamp]\t$_G[username]";
			DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$lastpost', posts=posts+1, todayposts=todayposts+1 WHERE fid='$thread[fid]'", 'UNBUFFERED');
			$tidnumber = $var['tidnumber'];
		} elseif($var['qdtype'] == '3') {
			if($num=='0' || $stats['qdtidnumber'] == '0') {
				$subject=str_replace(array('{m}','{d}','{y}','{bbname}','{author}','{godname}'),array(dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos']),$_G['setting']['bbname'],$_G['username'],"爱神堂"),$var['title_thread']);
				$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
				if($exacr && $exacz) {
					$message = "[quote][size=2][color=dimgray]{$lang[tsn_10]}[/color][url={$_G[siteurl]}plugin.php?id=wishing_hall:ai][color=darkorange]{$lang[tsn_11]}[/color][/url][color=dimgray]{$lang[tsn_12]}[/color][/size][/quote][quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$lang[tsn_13]}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
				} else {
					$message = "[quote][size=2][color=dimgray]{$lang[tsn_10]}[/color][url={$_G[siteurl]}plugin.php?id=wishing_hall:ai][color=darkorange]{$lang[tsn_11]}[/color][/url][color=dimgray]{$lang[tsn_12]}[/color][/size][/quote][quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$lang[tsn_13]}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
				}
				DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, displayorder, digest, special, attachment, moderated, highlight, closed, status, isgroup) VALUES ('$var[fidnumber]', '0', '0', '0', '$var[qdtypeid]', '0', '$_G[username]', '$_G[uid]', '$subject', '$_G[timestamp]', '$_G[timestamp]', '$_G[username]', '0', '0', '0', '0', '1', '1', '1', '0', '0')");
				$tid = DB::insert_id();
				DB::query("UPDATE ".DB::table('wishing_hallset')." SET qdtidnumber = '$tid' WHERE id='2'");
				$pid = insertpost(array('fid' => $var['fidnumber'],'tid' => $tid,'first' => '1','author' => $_G['username'],'authorid' => $_G['uid'],'subject' => $subject,'dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
				$expiration = $_G['timestamp'] + 86400;
				DB::query("INSERT INTO ".DB::table('forum_thread')."mod (tid, uid, username, dateline, action, expiration, status) VALUES ('$tid', '$_G[uid]', '$_G[username]', '$_G[timestamp]', 'EHL', '$expiration', '1')");
				DB::query("INSERT INTO ".DB::table('forum_thread')."mod (tid, uid, username, dateline, action, expiration, status) VALUES ('$tid', '$_G[uid]', '$_G[username]', '$_G[timestamp]', 'CLS', '0', '1')");
				updatepostcredits('+', $_G['uid'], 'post', $var['fidnumber']);
				$lastpost = "$tid\t".addslashes($subject)."\t$_G[timestamp]\t$_G[username]";
				DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$lastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='$var[fidnumber]'", 'UNBUFFERED');
				$tidnumber = $tid;
			} else {
				$tidnumber = $stats['qdtidnumber'];
				$thread = DB::fetch_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid='$tidnumber'");
				$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
				if($num >=1 && ($num <= ($extreward_num - 1)) && $exacr && $exacz) {
					$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$psc}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
				} else {
					$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_09]}{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
				}
				$pid = insertpost(array('fid' => $var['fidnumber'],'tid' => $tidnumber,'first' => '0','author' => $_G['username'],'authorid' => $_G['uid'],'subject' => '','dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
				DB::query("UPDATE ".DB::table('forum_thread')." SET lastposter='$_G[username]', lastpost='$_G[timestamp]', replies=replies+1 WHERE tid='$tidnumber' AND fid='$var[fidnumber]'", 'UNBUFFERED');
				updatepostcredits('+', $_G['uid'], 'reply', $var['fidnumber']);
				$lastpost = "$tidnumber\t".addslashes($thread['subject'])."\t$_G[timestamp]\t$_G[username]";
				DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$lastpost', posts=posts+1, todayposts=todayposts+1 WHERE fid='$var[fidnumber]'", 'UNBUFFERED');
			}
		}
	if(memory('check')) memory('set', 'wh_pualsign_'.$_G['uid'], $_G['timestamp'], 86400);
	if($num ==0) {
		if($stats['todayq'] > $stats['highestq']) DB::query("UPDATE ".DB::table('wishing_hallset')." SET highestq='$stats[todayq]' WHERE id='2'");
		DB::query("UPDATE ".DB::table('wishing_hallset')." SET yesterdayq='$stats[todayq]',todayq=1 WHERE id='2'");
		DB::query("UPDATE ".DB::table('wishing_hallemot')." SET count=0 WHERE god_id='2'");
		DB::query("DELETE from ".DB::table('wishing_hall_wish_ai')." where time<{$tdtime}-3600*24");//删除前天及以前的记录
	} else {
		DB::query("UPDATE ".DB::table('wishing_hallset')." SET todayq=todayq+1 WHERE id='2'");
	}
	DB::query("UPDATE ".DB::table('wishing_hallemot')." SET count=count+1 WHERE qdxq='$_GET[qdxq]'");
	DB::query("UPDATE ".DB::table('wishing_hall')." SET todaytimes=todaytimes+1 WHERE uid='$_G[uid]'");
	if($var['lockopen']) discuz_process::unlock('wishing_hall_ai');
/************************	
	if($var['tzopen']) {
		if($exacr && $exacz) {
			sign_msg("{$lang[tsn_14]}{$lang[tsn_03]}{$lang[tsn_04]}{$psc}{$lang[tsn_15]}{$lang[tsn_06]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]} {$lang[tsn_16]} {$_G[setting][extcredits][$exacr][title]} {$exacz} {$_G[setting][extcredits][$exacr][unit]}.".$another_vip,"forum.php?mod=redirect&tid={$tidnumber}&goto=lastpost#lastpost");
		} else {
			sign_msg("{$lang[tsn_18]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]}.".$another_vip,"forum.php?mod=redirect&tid={$tidnumber}&goto=lastpost#lastpost");
		}
	} else {
*************************/		
		if($exacr && $exacz) {
			sign_msg("{$lang[tsn_14]}{$lang[tsn_03]}{$lang[tsn_04]}{$psc}{$lang[tsn_15]}{$lang[tsn_06]} 筹码 {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]} {$lang[tsn_16]} 人品 {$random_rewards} {$_G[setting][extcredits][$exacr][title]} {$exacz} {$_G[setting][extcredits][$exacr][unit]}.".$another_vip,"plugin.php?id=wishing_hall:ai");
		} else {
			sign_msg("{$lang[tsn_18]} 人品 {$random_rewards} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]}.".$another_vip,"plugin.php?id=wishing_hall:ai");
		}
//	}
}
if ($qiandaodb['days'] >= '15000') {
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.Master]{$lvmastername}</b></font> .";
} elseif ($qiandaodb['days'] >= '7500') {
	$q['lvqd'] = 15000 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.10]{$lv10name}{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.Master]{$lvmastername}</b></font> .";
} elseif ($qiandaodb['days'] >= '3650') {
	$q['lvqd'] = 7500 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.9]{$lv9name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.10]{$lv10name}</b></font> .";
} elseif ($qiandaodb['days'] >= '2000') {
	$q['lvqd'] = 3650 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.8]{$lv8name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.9]{$lv9name}</b></font> .";
} elseif ($qiandaodb['days'] >= '1000') {
	$q['lvqd'] = 2000 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.7]{$lv7name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.8]{$lv8name}</b></font> .";
} elseif ($qiandaodb['days'] >= '600') {
	$q['lvqd'] = 1000 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.6]{$lv6name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.7]{$lv7name}</b></font> .";
} elseif ($qiandaodb['days'] >= '300') {
	$q['lvqd'] = 600 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.5]{$lv5name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.6]{$lv6name}</b></font> .";
} elseif ($qiandaodb['days'] >= '150') {
	$q['lvqd'] = 300 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.4]{$lv4name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.5]{$lv5name}</b></font> .";
} elseif ($qiandaodb['days'] >= '70') {
	$q['lvqd'] = 150 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.3]{$lv3name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.4]{$lv4name}</b></font> .";
} elseif ($qiandaodb['days'] >= '30') {
	$q['lvqd'] = 70 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.2]{$lv2name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.3]{$lv3name}</b></font> .";
} elseif ($qiandaodb['days'] >= '1') {
	$q['lvqd'] = 30 - $qiandaodb['days'];
	$q['level'] = "{$lang['level']}<font color=green><b>[LV.1]{$lv1name}</b></font>{$lang['level2']} <font color=#FF0000><b>{$q['lvqd']}</b></font> {$lang['level3']} <font color=#FF0000><b>[LV.2]{$lv2name}</b></font> .";
}
$q['if']= $qiandaodb['time']<$tdtime ? "<span class=gray>".$lang['tdno']."</span>" : "<font color=green>".$lang['tdyq']."</font>";
$qtime = dgmdate($qiandaodb['time'], 'Y-m-d H:i');
$navigation = $lang['name'];
$navtitle = "$navigation";
$signBuild = 'Ver 2.0 For X2.5!<br>&copy; <a href="http://scl.xidian.edu.cn/" target="_blank">毕凯</a>';
if($_G['inajax']){
	include template('wishing_hall:ajaxsign');
}else{
	include template('wishing_hall:ai');
}
?>