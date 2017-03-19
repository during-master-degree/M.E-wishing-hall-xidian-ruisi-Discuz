<?php
/*
	wishing_hall By bikai[RS Team] 2013-02-15
*/
!defined('IN_DISCUZ') && exit('Access Denied');
class plugin_wishing_hall{
	function global_usernav_extra2() {
		global $_G,$show_message,$_GET;
		$var = $_G['cache']['plugin']['wishing_hall'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$allowmem = memory('check');
		if($var['ajax_sign'] && $var['ifopen'] && !$show_message && !defined('IN_wishing_hall') && !defined('IN_wh_paulsc') && !$_GET['infloat'] && !$_G['inajax'] && $_G['uid'] && !in_array($_G['uid'],explode(",",$var['ban'])) && in_array($_G['groupid'], unserialize($var['groups']))) {
			if($allowmem && $var['mcacheopen']) $signtime = memory('get', 'wh_pualsign_'.$_G['uid']);
			if(!$signtime){
				$qiandaodb = DB::fetch_first("SELECT time FROM ".DB::table('wishing_hall')." WHERE uid='$_G[uid]'");
				$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
				if($qiandaodb){
					if($allowmem && $var['mcacheopen']) memory('set', 'wh_pualsign_'.$_G['uid'], $qiandaodb['time'], 86400);
					if($qiandaodb['time'] < $tdtime){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
						}else{
							return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
						}
					}
				}else{
					$ttps = DB::fetch_first("SELECT posts FROM ".DB::table('common_member_count')." WHERE uid='$_G[uid]'");
					if($var['mintdpost'] <= $ttps['posts']){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
						}else{
							return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
						}
					}
				}
			}else{
				if($signtime < $tdtime){
					if($var['timeopen']) {
						if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
					}else{
						return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:god_list&'.FORMHASH.'\')"><font color="red">'.lang('plugin/wishing_hall','encore_01').'</font></a> ';
					}
				}
			}
		}
		return '';
	}
	function global_footer() {
		global $_G,$show_message,$_GET;
		function wh_signtz() {
			global $_G;
			if(defined('IN_MOBILE')) {
				return '';
			}else{
				if(in_array($_G['groupid'], unserialize($_G['cache']['plugin']['wishing_hall']['autosign_ug']))){
					$nfastreplytext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['wishing_hall']['fastreplytext']);
					$fastreplytexts = explode("/hhf/", $nfastreplytext);
					return '<script type="text/javascript">showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:fo&operation=qiandao&formhash='.FORMHASH.'&qdmode=2&fastreply='.array_rand($fastreplytexts,'1').'&qdxq='.array_rand(unserialize($_G['setting']['paulsign_emot_all']),'1').'\');</script>';
				}else{
					if($_G['cache']['plugin']['wishing_hall']['ajax_sign']){
						return '<script type="text/javascript">showWindow(\'wishing_hall\', \'plugin.php?id=wishing_hall:fo&'.FORMHASH.'\');</script>';
					}else{
						dheader('Location: plugin.php?id=wishing_hall:fo');
					}
				}
			}
		}
		$var = $_G['cache']['plugin']['wishing_hall'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$allowmem = memory('check');
		if($var['ifopen'] && $var['ftopen'] && !$show_message && !defined('IN_wishing_hall') && !defined('IN_wh_paulsc') && !$_GET['infloat'] && !$_G['inajax'] && $_G['uid'] && (in_array($_G['groupid'], unserialize($var['tzgroupid'])) || in_array($_G['groupid'], unserialize($var['autosign_ug']))) && !in_array($_G['uid'],explode(",",$var['ban'])) && in_array($_G['groupid'], unserialize($var['groups']))) {
			if($allowmem && $var['mcacheopen']) $signtime = memory('get', 'wh_pualsign_'.$_G['uid']);
			if(!$signtime){
				$qiandaodb = DB::fetch_first("SELECT time FROM ".DB::table('wishing_hall')." WHERE uid='$_G[uid]'");
				$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
				if($qiandaodb){
					if($allowmem && $var['mcacheopen']) memory('set', 'wh_pualsign_'.$_G['uid'], $qiandaodb['time'], 86400);
					if($qiandaodb['time'] < $tdtime){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return wh_signtz();
						}else{
							return wh_signtz();
						}
					}
				}else{
					$ttps = DB::fetch_first("SELECT posts FROM ".DB::table('common_member_count')." WHERE uid='$_G[uid]'");
					if($var['mintdpost'] <= $ttps['posts']){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return wh_signtz();
						}else{
							return wh_signtz();
						}
					}
				}
			}else{
				if($signtime < $tdtime){
					if($var['timeopen']) {
						if(!($htime < $var['stime']) && !($htime > $var['ftime']))return wh_signtz();
					}else{
						return wh_signtz();
					}
				}
			}
		}
		return '';
	}
}
class plugin_wishing_hall_home extends plugin_wishing_hall {
	function space_profile_baseinfo_bottom() {
		global $_G,$_GET;
		$var = $_G['cache']['plugin']['wishing_hall'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		if($var['spaceopen']){
			$creditnamecn = $_G['setting']['extcredits'][$var[nrcredit]]['title'];
			$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['lvtext']);
			list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
			$qiandaodb = DB::fetch_first("SELECT * FROM ".DB::table('wishing_hall')." WHERE uid='".intval($_GET['uid'])."'");
			if($qiandaodb){
				$qtime = dgmdate($qiandaodb['time'], 'Y-m-d H:i');
				if ($qiandaodb['days'] >= '15000') {
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.Master]{$lvmastername}</b></font> .";
				} elseif ($qiandaodb['days'] >= '7500') {
					$q['lvqd'] = 15000 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.10]{$lv10name}".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.Master]{$lvmastername}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '3650') {
					$q['lvqd'] = 7500 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.9]{$lv9name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.10]{$lv10name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '2000') {
					$q['lvqd'] = 3650 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.8]{$lv8name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.9]{$lv9name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '1000') {
					$q['lvqd'] = 2000 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.7]{$lv7name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.8]{$lv8name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '600') {
					$q['lvqd'] = 1000 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.6]{$lv6name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.7]{$lv7name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '300') {
					$q['lvqd'] = 600 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.5]{$lv5name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.6]{$lv6name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '150') {
					$q['lvqd'] = 300 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.4]{$lv4name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.5]{$lv5name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '70') {
					$q['lvqd'] = 150 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.3]{$lv3name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.4]{$lv4name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '30') {
					$q['lvqd'] = 70 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.2]{$lv2name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.3]{$lv3name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				} elseif ($qiandaodb['days'] >= '1') {
					$q['lvqd'] = 30 - $qiandaodb['days'];
					$q['level'] = lang('plugin/wishing_hall','echo_11')."<font color=green><b>[LV.1]{$lv1name}</b></font>".lang('plugin/wishing_hall','echo_12')."<font color=#FF0000><b>[LV.2]{$lv2name}</b></font>".lang('plugin/wishing_hall','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/wishing_hall','echo_14');
				}
				$lastedecho = $_G['cache']['plugin']['wishing_hall']['lastedop'] ? "<p>".lang('plugin/wishing_hall','echo_17')." <b>{$qiandaodb['lasted']}</b> ".lang('plugin/wishing_hall','echo_5')."</p>" : '';
				$q['if']= $qiandaodb['time']< $tdtime ? "<span class=gray>".lang('plugin/wishing_hall','echo_1')."</span>" : "<font color=green>".lang('plugin/wishing_hall','echo_2')."</font>";
				return "<div class='pbm mbm bbda c'><h2 class='mbn'>".lang('plugin/wishing_hall','echo_3')."</h2><p>".lang('plugin/wishing_hall','echo_4')." <b>{$qiandaodb['days']}</b> ".lang('plugin/wishing_hall','echo_5')."</p>".$lastedecho."<p>".lang('plugin/wishing_hall','echo_6')." <b>{$qiandaodb['mdays']}</b> ".lang('plugin/wishing_hall','echo_5')."</p><p>".lang('plugin/wishing_hall','echo_7')." <font color=#ff00cc>{$qtime}</font></p><p>".lang('plugin/wishing_hall','echo_15')."{$creditnamecn} <font color=#ff00cc><b>{$qiandaodb['reward']}</b></font> {$_G[setting][extcredits][$var[nrcredit]]['unit']}".lang('plugin/wishing_hall','echo_16')."{$creditnamecn} <font color=#ff00cc><b>{$qiandaodb['lastreward']}</b></font> {$_G[setting][extcredits][$var[nrcredit]]['unit']}.</p><p>{$q['level']}</p><p>".lang('plugin/wishing_hall','echo_8')."{$q['if']}".lang('plugin/wishing_hall','echo_9')."</p></div>";
			}else{
				return "<div class='pbm mbm bbda c'><h2 class='mbn'>".lang('plugin/wishing_hall','echo_3')."</h2><p>".lang('plugin/wishing_hall','echo_10')."</p></div>";
			}
		}else{
			return "";
		}
	}
}
class plugin_wishing_hall_forum extends plugin_wishing_hall {
	function viewthread_postbottom_output(){
		global $_G,$postlist,$_GET;
		$authorid_pd = $postlist[$_G["forum_firstpid"]]["authorid"];
		$var = $_G['cache']['plugin']['wishing_hall'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$lang['classn_03'] = lang('plugin/wishing_hall','classn_03');
		$lang['classn_04'] = lang('plugin/wishing_hall','classn_04');
		$lang['classn_05'] = lang('plugin/wishing_hall','classn_05');
		$lang['classn_06'] = lang('plugin/wishing_hall','classn_06');
		$lang['classn_07'] = lang('plugin/wishing_hall','classn_07');
		$lang['classn_08'] = lang('plugin/wishing_hall','classn_08');
		$lang['classn_09'] = lang('plugin/wishing_hall','classn_09');
		$lang['classn_10'] = lang('plugin/wishing_hall','classn_10');
		$open = $_G['cache']['plugin']['wishing_hall']['tidphopen'];
		if($open){
			$qdtype = $_G['cache']['plugin']['wishing_hall']['qdtype'];
			if($qdtype == 2){
				$qdtidnumber = $_G['cache']['plugin']['wishing_hall']['tidnumber'];
			} elseif($qdtype == 3){
				$stats = DB::fetch_first("SELECT qdtidnumber FROM ".DB::table('wishing_hallset')." WHERE id='1'");
				$qdtidnumber = $stats['qdtidnumber'];
			}else{
				$qdtidnumber = 0;
			}
			if(($qdtidnumber == $_GET['tid']) && $authorid_pd){
				$pnum = $_G['cache']['plugin']['wishing_hall']['tidpnum'];
				$nrcredit = $_G['cache']['plugin']['wishing_hall']['nrcredit'];
				$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['wishing_hall']['lvtext']);
				list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
				$query = DB::query("SELECT q.days,q.time,q.uid,q.lastreward,m.username FROM ".DB::table('wishing_hall')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and q.time > {$tdtime} ORDER BY q.time LIMIT 0,{$pnum}");
				$mrcs = array();
				$i = 1;
				while($mrc = DB::fetch($query)) {
					$mrc['time'] = dgmdate($mrc['time'], 'Y-m-d H:i');
					if ($mrc['days'] >= '15000') {
			  			$mrc['level'] = "[LV.Master]{$lvmastername}";
					} elseif ($mrc['days'] >= '7500') {
			  			$mrc['level'] = "[LV.10]{$lv10name}";
					} elseif ($mrc['days'] >= '3650') {
			  			$mrc['level'] = "[LV.9]{$lv9name}";
					} elseif ($mrc['days'] >= '2000') {
			  			$mrc['level'] = "[LV.8]{$lv8name}";
					} elseif ($mrc['days'] >= '1000') {
			  			$mrc['level'] = "[LV.7]{$lv7name}";
					} elseif ($mrc['days'] >= '600') {
			  			$mrc['level'] = "[LV.6]{$lv6name}";
					} elseif ($mrc['days'] >= '300') {
			  			$mrc['level'] = "[LV.5]{$lv5name}";
					} elseif ($mrc['days'] >= '150') {
			  			$mrc['level'] = "[LV.4]{$lv4name}";
					} elseif ($mrc['days'] >= '70') {
			  			$mrc['level'] = "[LV.3]{$lv3name}";
					} elseif ($mrc['days'] >= '30') {
			  			$mrc['level'] = "[LV.2]{$lv2name}";
					} elseif ($mrc['days'] >= '1') {
			  			$mrc['level'] = "[LV.1]{$lv1name}";
					}
			 		$mrcs[$i++] = $mrc;
				}
				include template('wishing_hall:sign_list');
				return array(0=>$return);
			}else{
				return array();
			}
		}else{
		  return array();
		}
	}
	function viewthread_sidetop_output() {
		global $postlist,$_G,$_GET;
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$open = $_G['cache']['plugin']['wishing_hall']['sidebarmode'];
		$lastedop = $_G['cache']['plugin']['wishing_hall']['lastedop'];
		if(empty($_GET['tid']) || !is_array($postlist) || !$open) return array();
		$emots = unserialize($_G['setting']['paulsign_emot_all']);
		$pids=array_keys($postlist);
		$authorids=array();
		foreach($postlist as $pid=>$pinfo){
			$authorids[]=$pinfo['authorid'];
		}
		$authorids = array_unique($authorids);
		$authorids = array_filter($authorids);
		$authorids = dimplode($authorids);
		if($authorids == '') return array();
		$uidlists = DB::query("SELECT uid,days,lasted,qdxq,time,todaysay FROM ".DB::table('wishing_hall')." WHERE uid IN($authorids) and time>{$tdtime}-3600*24");
		$days = array();
		$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['wishing_hall']['lvtext']);
		list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
		while($mrc = DB::fetch($uidlists)) {
			$days[$mrc['uid']]['days'] = $mrc['days'];
			$days[$mrc['uid']]['uids'] = $mrc['uid'];
			if(!array_key_exists($mrc['qdxq'],$emots)) {
				$mrc['qdxq'] = end(array_keys($emots));
			}
			$days[$mrc['uid']]['qdxq'] = $mrc['qdxq'];
			$days[$mrc['uid']]['todaysay'] = $mrc['todaysay'];
			$days[$mrc['uid']]['time'] = dgmdate($mrc['time'], 'u');
			if ($lastedop) $days[$mrc['uid']]['lasted'] = $mrc['lasted'];
			if ($mrc['days'] >= '15000') {
				$days[$mrc['uid']]['level'] = "[LV.Master]{$lvmastername}";
			} elseif ($mrc['days'] >= '7500') {
			  	$days[$mrc['uid']]['level'] = "[LV.10]{$lv10name}";
			} elseif ($mrc['days'] >= '3650') {
			  	$days[$mrc['uid']]['level'] = "[LV.9]{$lv9name}";
			} elseif ($mrc['days'] >= '2000') {
			  	$days[$mrc['uid']]['level'] = "[LV.8]{$lv8name}";
			} elseif ($mrc['days'] >= '1000') {
			  	$days[$mrc['uid']]['level'] = "[LV.7]{$lv7name}";
			} elseif ($mrc['days'] >= '600') {
			  	$days[$mrc['uid']]['level'] = "[LV.6]{$lv6name}";
			} elseif ($mrc['days'] >= '300') {
			  	$days[$mrc['uid']]['level'] = "[LV.5]{$lv5name}";
			} elseif ($mrc['days'] >= '150') {
			  	$days[$mrc['uid']]['level'] = "[LV.4]{$lv4name}";
			} elseif ($mrc['days'] >= '70') {
			  	$days[$mrc['uid']]['level'] = "[LV.3]{$lv3name}";
			} elseif ($mrc['days'] >= '30') {
			  	$days[$mrc['uid']]['level'] = "[LV.2]{$lv2name}";
			} elseif ($mrc['days'] >= '1') {
			  	$days[$mrc['uid']]['level'] = "[LV.1]{$lv1name}";
			}
			$days[$mrc['uid']]['qdxqzw'] = $emots[$mrc['qdxq']]['name'];
			$days[] = $mrc;
		}
		$echoq = array();
		foreach($postlist as $key => $val) {
			if($days[$postlist[$key][authorid]][days]) {
				$lastedecho = $lastedop ? '<p>'.lang('plugin/wishing_hall','classn_12').': '.$days[$postlist[$key][authorid]][lasted].' '.lang('plugin/wishing_hall','classn_02').'</p>' : '';
				if($open == '2')$echoonce = '<div class="qdsmile"><li><center>'.lang('plugin/wishing_hall','ta_mind').'</center><table><tr><th>'.$days[$postlist[$key][authorid]][time].'<br /><font size="-1" color="#FF7600">TA对神说</font>:<br />'.cnString($days[$postlist[$key][authorid]][todaysay],62).'</th><th><img src="source/plugin/wishing_hall/img/emot/'.$days[$postlist[$key][authorid]][qdxq].'.gif"></th></tr></table></li></div>';//<font size="5px">'.$days[$postlist[$key][authorid]][qdxqzw].'</font>
				
				$master_fo=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_fo')." ORDER BY reward desc");
				$master_ai=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_ai')." ORDER BY reward desc");
				$master_kao=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_kao')." ORDER BY reward desc");
				$master_shui=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_shui')." ORDER BY reward desc");
				$master_bt=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_bt')." ORDER BY reward desc");
				$master_miao=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_miao')." ORDER BY reward desc");
				$master_offer=DB::fetch_first("SELECT uid FROM ".DB::table('wishing_hall_offer')." ORDER BY reward desc");
if($days[$postlist[$key][authorid]][uids]==$master_fo['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">佛堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_ai['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">爱神堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_kao['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">考神堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_miao['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">喵神堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_offer['uid']){$echoonce.='<p style="text-align:center; font-size:22px; color:#f00; font-weight:bold;">offer堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_shui['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">水神堂堂主</p>';}
if($days[$postlist[$key][authorid]][uids]==$master_bt['uid']){$echoonce.='<p style="text-align:center; font-size:24px; color:#f00; font-weight:bold;">BT堂堂主</p>';}
				
				$echoonce .= '<p>'.lang('plugin/wishing_hall','classn_01').': '.$days[$postlist[$key][authorid]][days].' '.lang('plugin/wishing_hall','classn_02').'</p>'.$lastedecho.'<p>'.$days[$postlist[$key][authorid]][level].'</p>';
			} else {
				$echoonce = '<p>'.lang('plugin/wishing_hall','classn_13').'</p>';
			}
			$echoq[] = $echoonce;
			$echoonce = '';
		}
		return $echoq;
	}
}
function cnString($str,$len)
{
   $tmpstr = "";
   for($i = 0; $i < $len; $i++) {
       if(ord(substr($str, $i, 1)) > 0xa0) {
           $tmpstr .= substr($str, $i, 2);
           $i++;
       } else
           $tmpstr .= substr($str, $i, 1);
   }
   return $tmpstr;
}
?>