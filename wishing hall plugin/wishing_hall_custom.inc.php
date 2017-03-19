<?php
/*
	wishing_hall bikai[RS Team] 2013-02-15
*/
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
loadcache('pluginlanguage_script');
$lang = $_G['cache']['pluginlanguage_script']['wishing_hall'];
	if(!submitcheck('emotsubmit')) {

			$emotechos = '';
			$query = DB::query("SELECT * FROM ".DB::table('wishing_hallemot')." ORDER BY displayorder");
			while($emot = DB::fetch($query)) {
				$emotechos .= showtablerow('', array('class="td25"', 'class="td28"'), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$emot[id]\">",
					"<input type=\"text\" class=\"txt\" size=\"2\" name=\"displayorder[$emot[id]]\" value=\"$emot[displayorder]\">",
					"<input type=\"text\" class=\"txt\" size=\"5\" name=\"god_id[$emot[id]]\" value=\"$emot[god_id]\">",
					"<input type=\"text\" class=\"txt\" size=\"5\" name=\"price[$emot[id]]\" value=\"$emot[price]\">",
					"<input type=\"text\" class=\"txt\" size=\"5\" name=\"qdxq[$emot[id]]\" value=\"$emot[qdxq]\">",
					"<input type=\"text\" class=\"txt\" size=\"10\" name=\"name[$emot[id]]\" value=\"$emot[name]\"><img src=\"source/plugin/wishing_hall/img/emot/$emot[qdxq].gif\" />"
				), TRUE);
			}

		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '<input type="text" class="txt" size="2" name="newdisplayorder[]" value="0">', 'td28'],
			[1, '<input type="text" class="txt" size="15" name="newgod_id[]">'],
			[1, '<input type="text" class="txt" size="15" name="newprice[]">'],
			[1, '<input type="text" class="txt" size="15" name="newqdxq[]">'],
			[1, '<input type="text" class="txt" size="15" name="newname[]">'],
		],
	];
</script>
EOT;

		showformheader("plugins&operation=config&identifier=wishing_hall&pmod=sign_custom&submit=1");
		showtableheader('Tribute Custom By [Wishing hall]bikai');
		showsubtitle(array('', $lang['custom_01'], $lang['custom_14'], $lang['custom_15'], $lang['custom_02'], $lang['custom_03']));
		echo $emotechos;
		echo '<tr><td></td><td colspan="4"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$lang['custom_04'].'</a></div></td></tr>';
		showsubmit('emotsubmit', $lang['custom_05'], $lang['custom_06']);

		showtablefooter();
		showformfooter();

	} else {
		if($_G['adminid']!=='1' || $_GET['formhash']!==FORMHASH)cpmsg($lang['custom_07'], '', 'error');
		if($ids = dimplode($_GET['delete'])) {
			DB::query("DELETE FROM ".DB::table('wishing_hallemot')." WHERE id IN ($ids)");
		}

		if(is_array($_GET['qdxq'])) {
			foreach($_GET['qdxq'] as $id => $val) {
				DB::update('wishing_hallemot', array(
					'displayorder' => $_GET['displayorder'][$id],
                    'god_id' => $_GET['god_id'][$id],
                    'price' => $_GET['price'][$id],
					'qdxq' => $_GET['qdxq'][$id],
					'name' => $_GET['name'][$id],
				), "id='$id'");
			}
		}

		if(is_array($_GET['newqdxq'])) {
			foreach($_GET['newqdxq'] as $key => $value) {
				$newqdxq1 = trim($value);
				if (preg_match("/[^A-Za-z]/",$newqdxq1) || strlen($newqdxq1) > 5) cpmsg($lang['custom_08'], '', 'error');
				$newname1 = trim($_GET['newname'][$key]);
				if (strlen($newname1) > 20) cpmsg($lang['custom_08'], '', 'error');
                
                $god_id1 = $_GET['newgod_id'][$key];
				if (preg_match("/[^0-9]/",$god_id1) || strlen($god_id1) < 1) cpmsg($lang['custom_12'], '', 'error');
                $price1 = $_GET['newprice'][$key];
				if (preg_match("/[^0-9]/",$price1)|| strlen($price1) < 1) cpmsg($lang['custom_13'], '', 'error');
                
				if($newqdxq1 && $newname1) {
					$query = DB::query("SELECT id FROM ".DB::table('wishing_hallemot')." WHERE qdxq='$newqdxq1' LIMIT 1");
					if(DB::num_rows($query)) {
						cpmsg($lang['custom_09'], '', 'error');
					}
					$data = array(
						'displayorder' => $_GET['newdisplayorder'][$key],
                        'god_id' => $god_id1,
                        'price' => $price1,
						'qdxq' => $newqdxq1,
						'name' => $newname1,
					);
					DB::insert('wishing_hallemot', $data);
				} elseif($newqdxq1 && !$newname1) {
					cpmsg($lang['custom_10'], '', 'error');
				}elseif($newqdxq1 && !$god_id1) {
					cpmsg($lang['custom_16'], '', 'error');
				}
			}
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

		cpmsg($lang['custom_11'], '', 'succeed');

	}
?>