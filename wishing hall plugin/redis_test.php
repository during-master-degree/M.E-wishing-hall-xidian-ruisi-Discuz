<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);
echo "佛";
$wishing_items=(int)$redis->get('items');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes'.$i,0,-1));
}

echo "爱神";
$wishing_items=(int)$redis->get('items_ai');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_ai'.$i,0,-1));
}

echo "考神";
$wishing_items=(int)$redis->get('items_kao');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_kao'.$i,0,-1));
}

echo "喵神";
$wishing_items=(int)$redis->get('items_miao');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_miao'.$i,0,-1));
}

echo "offer神";
$wishing_items=(int)$redis->get('items_offer');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_offer'.$i,0,-1));
}

echo "水神";
$wishing_items=(int)$redis->get('items_shui');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_shui'.$i,0,-1));
}

echo "BT神";
$wishing_items=(int)$redis->get('items_bt');
var_dump($wishing_items);
for($i=1;$i<=$wishing_items;$i++){
var_dump($redis->lgetrange('wishes_bt'.$i,0,-1));
}
$redis->close();
?>

	