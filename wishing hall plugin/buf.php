<?php 
$credit=10;
$random_rewards=(($credit)*mt_rand(0,100)/100+mt_rand(0,100)/100)*30;

var_dump($random_rewards);
var_dump(ceil($random_rewards));

?>