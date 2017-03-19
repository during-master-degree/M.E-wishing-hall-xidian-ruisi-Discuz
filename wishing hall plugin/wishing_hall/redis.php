<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);

$redis->set('test','This is wishing_hall! Redis works!');
echo $redis->get('test');

$redis->close();

	echo "---sendrolon---";
	$sendrolon = memory('get','sendrolon');
	var_dump($sendrolon);
	echo "---top10infos---";
	$top10infos = $sendrolon['top10infos'];
	var_dump($top10infos);
?>