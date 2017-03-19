<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);
$wishing_items=(int)$redis->get('items');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes'.$i,0,-1));
}

for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_ai'.$i,0,-1));
}

for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_kao'.$i,0,-1));
}
$redis->close();
?>

	