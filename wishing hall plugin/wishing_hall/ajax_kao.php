<?php
/*
	wishing_hall ajax with redis By bikai[RS Team] 2013-02-15
*/
require_once('rsmysqlDB.php');
header("Content-Type:text/xml;charset=utf-8");
header("Cache-Control:no-cache");

if($_SERVER['REQUEST_METHOD']=='GET'){exit("Access Denied!");}

// if($_GET['action'] == 'checkusername') {
$redis = new redis();
$redis->connect('127.0.0.1',6379);

//read redis
$wishing_items=(int)$redis->get('items_kao');
	if($wishing_items){
		$result='';
echo '<?xml version="1.0" encoding="utf-8"?>
<root_redis>
<item>'.$wishing_items.'</item>
';
		for($i=1;$i<=$wishing_items;$i++){
				$wishes_buf=$redis->lgetrange("wishes_kao".$i,0,-1);
$result.="<wishing>
	<username>".$wishes_buf[0]."</username>
	<uid>".$wishes_buf[1]."</uid>
	<time>".$wishes_buf[2]."</time>
	<qdxq>".$wishes_buf[3]."</qdxq>
	<todaysay>".$wishes_buf[4]."</todaysay>
	<godsay>".$wishes_buf[5]."</godsay>
</wishing>
";
			}
	echo $result."</root_redis>";
	 		
	}else{//use mysql
	$result=''; 
	$conn=mysql_connect("localhost",$username,$password);
     if(!$conn){   
         die('Could not connect: '.mysql_error());
     }//else{echo "连接数据库成功!"; }   
	 
     mysql_select_db($dbname,$conn);   
     mysql_query("set names utf8");    
 //查询
     $res = mysql_query("SELECT q.uid,q.time,q.qdxq,q.todaysay,q.godsay,m.username FROM wishing_hall_wish_kao q,common_member m where q.uid=m.uid order by q.time desc limit 0,10");  
$redis->set('items_kao',mysql_num_rows($res));
echo '<?xml version="1.0" encoding="utf-8"?>
<root>
<item>'.mysql_num_rows($res).'</item>
';
	
	$redis->setTimeout('items_kao', 3);	
	$index=1;	
//	print_r(mysql_fetch_array($res));
 	while($row=mysql_fetch_array($res)){
//		foreach($row as $key=>$val){$result.="$val";}
		if($row['qdxq']=="kx_kao"){$row['qdxq']="虔诚的想上自习，并说";
		}elseif($row['qdxq']=="ng_kao"){$row['qdxq']="小声的对神说想要与美女同桌，并说";
		}elseif($row['qdxq']=="ym_kao"){$row['qdxq']="想找人给占个座位，并说";
		}elseif($row['qdxq']=="wl_kao"){$row['qdxq']="想要一份考试真题，并说";
		}elseif($row['qdxq']=="nu_kao"){$row['qdxq']="求考神保佑一定要及格，并说";
		}elseif($row['qdxq']=="ch_kao"){$row['qdxq']="向神祈求一个免挂金牌，并说";
		}elseif($row['qdxq']=="yl_kao"){$row['qdxq']="请求速速打通考霸模式，并说";
		}elseif($row['qdxq']=="shuai_kao"){$row['qdxq']="要给考神修庙建祠堂，并说";
		}
			
$result.="<wishing>
	<username>".$row['username']."</username>
	<uid>".$row['uid']."</uid>
	<time>".gmdate('Y-m-d H:i',$row["time"]+ 3600 * 8)."</time>
	<qdxq>".$row['qdxq']."</qdxq>
	<todaysay>".$row['todaysay']."</todaysay>
	<godsay>".$row['godsay']."</godsay>
</wishing>
";	
//将许愿缓存到redis中
	$redis->delete("wishes_kao".$index);
	$redis->rpush("wishes_kao".$index,$row['username']);
	$redis->rpush("wishes_kao".$index,$row['uid']);	
	$redis->rpush("wishes_kao".$index,gmdate('Y-m-d H:i',$row["time"]+ 3600 * 8));	
	$redis->rpush("wishes_kao".$index,$row['qdxq']);	
	$redis->rpush("wishes_kao".$index,$row['todaysay']);	
	$redis->rpush("wishes_kao".$index,$row['godsay']);	
	$index++;	
	}
echo $result."</root>"; 
	//mysql_free_result($res);
	mysql_close($conn);
}

$redis->close();
?>  