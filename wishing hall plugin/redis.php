<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);

$redis->set('test','This is wishing_hall! Redis works!');
echo $redis->get('test');

$redis->close();
?>