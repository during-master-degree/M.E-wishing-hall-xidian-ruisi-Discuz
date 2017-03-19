<?php 
$credit=5;
$random_rewards=(3/2)*($credit)*mt_rand(0,100)/100+mt_rand(0,100)/100;

var_dump($random_rewards);
var_dump(ceil($random_rewards));

?>