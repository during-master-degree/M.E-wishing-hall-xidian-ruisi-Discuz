<?php 
$bk['bb']['id']=array(11,22,33);
$bk['bb']['name']=array('ii','dd','oo');
//var_dump($bk['bb']);
$poststar = array();
$poststar1 = array();
$poststar2 = array();
foreach($bk['bb']['id'] as $values){
		$poststar1[]=$values;
		
	}

foreach($bk['bb']['name'] as $values){
		$poststar2[]=$values;
	}	

for($i=0;$i<count($poststar1);$i++){
		$result['id']=$poststar1[$i];
		$result['name']=$poststar2[$i];
		$poststar[]=$result;
	}	
$total_bt_items=(count($poststar1)<6)?count($poststar1):6;		
	var_dump($total_bt_items);
?>